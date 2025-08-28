<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\Client;
use App\Models\User;
use App\Models\Project;
use App\Models\Accessory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class ProjectManagementController extends Controller
{
    // Function to house all data that the project page needs
    public function index()
    {
        $adminId = Auth::id();

        // 👇 Reusable closure to count unread comments per project
        $withUnreadComments = function ($query) use ($adminId) {
            $query->withCount([
                'views as unread_by_admin' => function ($subQuery) use ($adminId) {
                    $subQuery->where('user_id', $adminId);
                }
            ]);
        };

        // Showing data based on project stage, including unread comments
        $measurements = Project::with(['measurement', 'comments' => $withUnreadComments])
            ->where('current_stage', 'measurement')
            ->orderBy('created_at', 'desc')
            ->get();

        $designs = Project::with(['design', 'comments' => $withUnreadComments])
            ->where('current_stage', 'design')
            ->orderBy('created_at', 'desc')
            ->get();

        $installations = Project::with(['installation', 'comments' => $withUnreadComments])
            ->where('current_stage', 'installation')
            ->orderBy('created_at', 'desc')
            ->get();

        $productions = Project::with(['production', 'comments' => $withUnreadComments])
            ->where('current_stage', 'production')
            ->orderBy('created_at', 'desc')
            ->get();
$projects=Project::all();

        $clients = Client::all();
        $techSupervisors = User::where('role', 'tech_supervisor')->get();
 // all tech supervisors, assigned or not
    $supervisors = User::where('role', 'tech_supervisor')
        ->select('id', 'name', 'profile_pic')
        ->orderBy('name')
        ->get();

        return view('admin.ProjectManagement', compact(
            'measurements',
            'designs',
            'installations',
            'productions',
            'clients',
            'techSupervisors',
            'supervisors',
            'projects'
        ));
    }

    public function create()
    {
        return view('admin.ProjectManagement.create');
    }

    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }

    //testing

public function store(Request $request)
{
    // 1) Validate
    $validated = $request->validate([
        // Project
        'project.client_id' => ['required','exists:clients,id'],
        'project.name'      => ['required','string','max:150'],

        // Product (required per your rule)
        'product.name'                 => ['required','string','max:150'],
        'product.product_type'         => ['nullable','string','max:80'],
        'product.type_of_finish'       => ['nullable','string','max:80'],
        'product.finish_color_hex'     => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_finish_image'  => ['nullable','image','max:4096'],
        'product.glass_door_type'      => ['nullable','string','max:80'],
        'product.worktop_type'         => ['nullable','string','max:80'],
        'product.worktop_color_hex'    => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_worktop_image' => ['nullable','image','max:4096'],
        'product.sink_top_type'        => ['nullable','string','max:80'],
        'product.handle'               => ['nullable','string','max:80'],
        'product.sink_color_hex'       => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_sink_image'    => ['nullable','image','max:4096'],
        'product.notes'                => ['nullable','string'],

        // Accessories
        'accessories'   => ['nullable','array'],
        'accessories.*' => ['integer','exists:accessories,id'],
    ]);

    // 2) Split payloads (IMPORTANT)
    $projectData = $validated['project'];
    $productData = $validated['product'] ?? [];

    return DB::transaction(function () use ($request, $projectData, $productData) {
        // Defaults
        $projectData['status']        = $projectData['status']        ?? 'ON_GOING';
        $projectData['booked_status'] = $projectData['booked_status'] ?? 'UNBOOKED';

        // 3) Create Project only from projectData
        $project = \App\Models\Project::create($projectData);

        // 4) Prepare Product
        $productData['project_id'] = $project->id;

        // Uploads -> map to *_path columns
        $dir = "projects/{$project->id}";
        if ($request->hasFile('product.sample_finish_image')) {
            $productData['sample_finish_image_path'] =
                $request->file('product.sample_finish_image')->store($dir, 'public');
        }
        if ($request->hasFile('product.sample_worktop_image')) {
            $productData['sample_worktop_image_path'] =
                $request->file('product.sample_worktop_image')->store($dir, 'public');
        }
        if ($request->hasFile('product.sample_sink_image')) {
            $productData['sample_sink_image_path'] =
                $request->file('product.sample_sink_image')->store($dir, 'public');
        }

        // 5) Create Product (now includes 'name')
        $product = \App\Models\Product::create($productData);

        // 6) Attach Accessories (if any)
        $ids = collect($request->input('accessories', []))->filter()->unique()->values();
        if ($ids->isNotEmpty()) {
            $product->accessories()->attach(
                $ids->mapWithKeys(fn($id) => [$id => ['quantity' => 1]])
            );
        }

        // Done
        return redirect()
            ->route('admin.ProjectManagement', $project->id)
            ->with('success', 'Project & Product created successfully.');
    });
}



    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         // Project
    //         'project.client_id'              => ['required','exists:clients,id'],
    //         'project.name'                   => ['required','string','max:150'],
    //         // 'project.status'                 => ['nullable','in:COMPLETED,ON_GOING,IN_REVIEW'],
    //         // 'project.current_stage'          => ['nullable','in:MEASUREMENT,DESIGN,PRODUCTION,INSTALLATION'],
    //         // 'project.booked_status'          => ['nullable','in:UNBOOKED,BOOKED'],
    //         // 'project.estimated_budget'       => ['nullable','numeric'],
    //         // 'project.admin_id'               => ['nullable','exists:users,id'],
    //         // 'project.tech_supervisor_id'     => ['nullable','exists:users,id'],
    //         // 'project.designer_id'            => ['nullable','exists:users,id'],
    //         // 'project.production_officer_id'  => ['nullable','exists:users,id'],
    //         // 'project.installation_officer_id'=> ['nullable','exists:users,id'],

    //         // Product
    //         'product.name'                 => ['required','string','max:150'],
    //         'product.product_type'         => ['nullable','string','max:80'],
    //         'product.type_of_finish'       => ['nullable','string','max:80'],
    //         'product.finish_color_hex'     => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_finish_image'  => ['nullable','image','max:4096'],
    //         'product.glass_door_type'      => ['nullable','string','max:80'],
    //         'product.worktop_type'         => ['nullable','string','max:80'],
    //         'product.worktop_color_hex'    => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_worktop_image' => ['nullable','image','max:4096'],
    //         'product.sink_top_type'        => ['nullable','string','max:80'],
    //         'product.handle'               => ['nullable','string','max:80'],
    //         'product.sink_color_hex'       => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_sink_image'    => ['nullable','image','max:4096'],
    //         'product.notes'                => ['nullable','string'],

    //         // Accessories (optional)
    //         'accessories'                  => ['nullable','array'],
    //         'accessories.*'                => ['integer','exists:accessories,id'],
    //     ]);

    //     $project = Project::create($validated);

    //     return response()->json($project); // Laravel will return it as JSON
    // }

    public function accstore(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required','string','max:150'],
            'category'   => ['required','string','max:80'],
            'length_mm'  => ['nullable','numeric'],
            'width_mm'   => ['nullable','numeric'],
            'height_mm'  => ['nullable','numeric'],
            'diameter_mm'=> ['nullable','numeric'],
            'size'       => ['nullable','string','max:80'],
            'notes'      => ['nullable','string'],
        ]);

        $accessory = Accessory::create($data);

        return response()->json($accessory);
    }

    //for the add project page
    // public function addproject()
    // {
    //     $project=Project::all();
    //     return view('admin.addproject', compact('project'));
    // }
    public function addProject()
    {
        return view('admin.addproject', [
            'clients'       => Client::orderBy('firstname')->get(['id','firstname']),
            'productTypes'  => ['Kitchen','Wardrobe','TV Unit','Vanity'],
            'finishTypes'   => ['Matte','Gloss','Textured'],
            'glassTypes'    => ['Smoked','Clear','Frosted','Mirror','Tinted Bronze'],
            'worktopTypes'  => ['Quartz','Granite','Laminate','Solid Wood'],
            'sinkTopTypes'  => ['Undermount + Quartz','Topmount + Granite','Integrated Solid Surface'],
            'handleTypes'   => ['Handle-less','Bar Handle','Knob','Edge Pull'],
            // 'appliances'    => Accessory::where('category','Appliance')->latest()->take(10)->get(['id','name','category']),
            'appliances'    => \App\Models\Accessory::latest()->take(10)->get(['id','name','category']),

            'users'         => User::select('id','name')->get(),


        ]);
    }

    // Looping through table for records to push to the project blade
    public function project_stage()
    {
        $measurements = Project::with('measurement')
            ->where('current_stage', 'measurement')
            ->orderBy('created_at', 'desc')
            ->get();

        $designs = Project::with('design')
            ->where('current_stage', 'design')
            ->get();

        $installations = Project::with('installation')
            ->where('current_stage', 'installation')
            ->get();

        return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.ProjectManagement.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }



    public function assignSupervisor(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'tech_supervisor_id' => 'required|exists:users,id',
    ]);

    // Find project and assign supervisor
    $project = Project::findOrFail($request->project_id);
    $project->tech_supervisor_id = $request->tech_supervisor_id;
    $project->save();

    return redirect()->back()->with('success', 'Tech Supervisor assigned successfully!');
}



}
