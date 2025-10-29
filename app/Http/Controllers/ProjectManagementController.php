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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\AccessoryType;
use Illuminate\Validation\Rule;


class ProjectManagementController extends Controller
{
    // Function to house all data that the project page needs


//another trial



public function index()
    {
        $adminId = Auth::id();

        $stageData = $this->loadStageData($adminId);

        $projects = Project::all();
        $clients  = Client::all();
        $projectLocations = Project::query()
            ->select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        $supervisors = User::where('role', 'tech_supervisor')
            ->join('employees', 'employees.id', '=', 'users.employee_id')
            ->orderBy('employees.name')
            ->get([
                'users.id',
                DB::raw('employees.name as name'),
                DB::raw('employees.avatar_path as profile_pic'),
            ]);

        $techSupervisors = User::where('role', 'tech_supervisor')
            ->leftJoin('employees', 'employees.id', '=', 'users.employee_id')
            ->orderBy('employees.name')
            ->get([
                'users.id',
                'users.employee_id',
                DB::raw("COALESCE(employees.name, CONCAT('User #', users.id)) as display_name"),
                DB::raw('employees.avatar_path as avatar_path'),
            ]);

        $supervisorAssignments = Project::whereNotNull('tech_supervisor_id')
            ->pluck('name', 'tech_supervisor_id');

        return view('admin.ProjectManagement', [
            'measurements' => $stageData['measurement'],
            'designs' => $stageData['design'],
            'installations' => $stageData['installation'],
            'productions' => $stageData['production'],
            'clients' => $clients,
            'projects' => $projects,
            'projectLocations' => $projectLocations,
            'supervisors' => $supervisors,
            'techSupervisors' => $techSupervisors,
            'supervisorAssignments' => $supervisorAssignments,
        ]);
    }

    public function filterColumns(Request $request): JsonResponse
    {
        $adminId = Auth::id();

        $search = trim((string) $request->query('search', ''));
        $location = trim((string) $request->query('location', ''));

        $search = $search !== '' ? $search : null;
        $location = $location !== '' ? $location : null;

        $stageData = $this->loadStageData($adminId, $search, $location);

        return response()->json([
            'measurement' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['measurement'],
                'emptyMessage' => 'No project is currently under measurement',
            ])->render(),
            'design' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['design'],
                'emptyMessage' => 'No project is currently in design',
            ])->render(),
            'production' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['production'],
                'emptyMessage' => 'No project is currently in production',
            ])->render(),
            'installation' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['installation'],
                'emptyMessage' => 'No project is currently in installation',
            ])->render(),
            'counts' => [
                'measurement' => $stageData['measurement']->count(),
                'design' => $stageData['design']->count(),
                'production' => $stageData['production']->count(),
                'installation' => $stageData['installation']->count(),
            ],
        ]);
    }

    private function loadStageData(int $adminId, ?string $search = null, ?string $location = null): array
    {
        $withUnreadComments = function ($query) use ($adminId) {
            $query->withCount([
                'views as unread_by_admin' => function ($subQuery) use ($adminId) {
                    $subQuery->where('user_id', $adminId);
                },
            ]);
        };

        $withCommon = [
            'client:id,firstname,email,phone_number',
            'admin.employee:id,name,avatar_path',
            'techSupervisor.employee:id,name,avatar_path',
            'designer.employee:id,name,avatar_path',
            'productionOfficer.employee:id,name,avatar_path',
            'installationOfficer.employee:id,name,avatar_path',
            'products:id,project_id,name,product_type,type_of_finish,finish_color_hex,worktop_type,worktop_color_hex,handle,notes',
        ];

        $stageRelations = [
            'measurement' => 'measurement',
            'design' => 'design',
            'production' => 'production',
            'installation' => 'installation',
        ];

        return [
            'measurement' => $this->buildStageCollection('measurement', $withCommon, $withUnreadComments, $stageRelations, $search, $location),
            'design' => $this->buildStageCollection('design', $withCommon, $withUnreadComments, $stageRelations, $search, $location),
            'production' => $this->buildStageCollection('production', $withCommon, $withUnreadComments, $stageRelations, $search, $location),
            'installation' => $this->buildStageCollection('installation', $withCommon, $withUnreadComments, $stageRelations, $search, $location),
        ];
    }

    private function buildStageCollection(
        string $stage,
        array $withCommon,
        callable $withUnreadComments,
        array $stageRelations,
        ?string $search,
        ?string $location
    ) {
        $relations = $withCommon;
        if (isset($stageRelations[$stage])) {
            $relations[] = $stageRelations[$stage];
        }
        $relations['comments'] = $withUnreadComments;

        $query = Project::with($relations)
            ->whereRaw('LOWER(current_stage) = ?', [strtolower($stage)]);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($location) {
            $query->whereRaw('LOWER(location) = ?', [strtolower($location)]);
        }

        return $query->latest()->get();
    }



    public function supervisorsForProject(Project $project)
{
    // Grab all supervisors with display name/avatar
    $rows = User::query()
        ->where('role', 'tech_supervisor')
        ->leftJoin('employees', 'employees.id', '=', 'users.employee_id')
        ->select([
            'users.id',
            DB::raw('COALESCE(employees.name, users.name) as name'),
            DB::raw('employees.avatar_path as avatar_path'),
        ])
        // whether THIS project already has this supervisor
        ->addSelect([
            'assigned_here' => Project::query()
                ->selectRaw('CASE WHEN tech_supervisor_id = users.id THEN 1 ELSE 0 END')
                ->where('id', $project->id)
                ->limit(1),
        ])
        // any OTHER project using this supervisor (for the badge + name)
        ->addSelect([
            'other_project_id' => Project::query()
                ->whereColumn('tech_supervisor_id', 'users.id')
                ->where('id', '!=', $project->id)
                ->orderByDesc('updated_at')
                ->limit(1)
                ->select('id'),
        ])
        ->addSelect([
            'other_project_name' => Project::query()
                ->whereColumn('tech_supervisor_id', 'users.id')
                ->where('id', '!=', $project->id)
                ->orderByDesc('updated_at')
                ->limit(1)
                ->select('name'),
        ])
        ->orderBy('name')
        ->get();

    $supervisors = $rows->map(function ($r) use ($project) {
        $avatar = $r->avatar_path
            ? asset('storage/' . ltrim($r->avatar_path, '/'))
            : asset('images/default-avatar.png');

        $isHere   = (bool) $r->assigned_here;
        $elsewhere= $r->other_project_id && !$isHere;

        return [
            'id'                    => (int) $r->id,
            'name'                  => $r->name,
            'avatar_url'            => $avatar,
            'is_assigned_here'      => $isHere,
            'assigned_elsewhere'    => (bool) $elsewhere,
            'assigned_project_id'   => $elsewhere ? (int) $r->other_project_id : null,
            'assigned_project_name' => $elsewhere ? $r->other_project_name : null,
        ];
    })->values();

    return response()->json([
        'project'     => ['id' => $project->id, 'name' => $project->name],
        'supervisors' => $supervisors,
    ]);
}


// app/Http/Controllers/Admin/ProjectManagementController.php

//new one


public function supervisors(Project $project)
{
    $users = \App\Models\User::select('id','name')->orderBy('name')->get();

    $assignedMap = \App\Models\Project::whereIn('tech_supervisor_id', $users->pluck('id'))
        ->get(['id','name','tech_supervisor_id'])
        ->groupBy('tech_supervisor_id');

    $supervisors = $users->map(function ($u) use ($project, $assignedMap) {
        $assignedProjects = $assignedMap->get($u->id, collect());
        $isHere = (int)$project->tech_supervisor_id === (int)$u->id;
        $elsewhere = !$isHere && $assignedProjects->isNotEmpty();
        return [
            'id'                    => (int)$u->id,
            'name'                  => $u->name,
            'avatar_url'            => 'https://ui-avatars.com/api/?name='.urlencode($u->name),
            'is_assigned_here'      => $isHere,
            'assigned_elsewhere'    => $elsewhere,
            'assigned_project_name' => $elsewhere ? ($assignedProjects->first()->name ?? null) : null,
        ];
    })->values();

    return response()->json([
        'project'     => ['id' => $project->id, 'name' => $project->name],
        'supervisors' => $supervisors,
    ]);
}


    /**
     * Assign a tech supervisor to a project (the Proceed button posts here).
     */
    public function assignSupervisor()
    {
        request()->validate([
            'project_id'    => ['required','exists:projects,id'],
            'supervisor_id' => ['required','exists:users,id'],
        ]);

        $project = Project::findOrFail(request('project_id'));
        $project->tech_supervisor_id = request('supervisor_id');
        $project->save();

        return redirect()->back()->with('success','Technical Supervisor assigned.');
    }


    //end

    public function create()
    {
        return view('admin.ProjectManagement.create');
    }

    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }

    //testing

    // app/Http/Controllers/ProjectController.php (or wherever projects.store points)


public function store(Request $request)
{
    // 1) Validate core fields from the multi-step form
    $validated = $request->validate([
        // Project
        'project.client_id'   => ['required', 'exists:clients,id'],
        'project.name'        => ['required', 'string', 'max:150'],
        'project.due_date'             => ['nullable', 'date'],
        'project.location'        => ['nullable', 'string', 'max:255'],
        // Product
        'product.product_type'         => ['nullable', 'string', 'max:80'],
        'product.type_of_finish'       => ['nullable', 'string', 'max:80'],
        'product.finish_color_hex'     => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_finish_image'  => ['nullable', 'image', 'max:4096'],
        'product.glass_door_type'      => ['nullable', 'string', 'max:80'],
        'product.worktop_type'         => ['nullable', 'string', 'max:80'],
        'product.worktop_color_hex'    => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_worktop_image' => ['nullable', 'image', 'max:4096'],
        'product.sink_top_type'        => ['nullable', 'string', 'max:80'],
        'product.handle'               => ['nullable', 'string', 'max:80'],
        'product.sink_color_hex'       => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
        'product.sample_sink_image'    => ['nullable', 'image', 'max:4096'],
        'product.notes'                => ['nullable', 'string'],
        // Step 6 "Deadline" (your Blade uses product[deadline]; map to project.due_date)

        // Raw accessories array (detailed validation below)
        'accessories'                  => ['nullable','array'],
    ]);

    // 2) Split payloads
    $projectData = $validated['project'];
    $productData = $validated['product'] ?? [];

    // Map product[deadline] -> project.due_date (since Projects table has due_date)
    if (!empty($productData['deadline'])) {
        $projectData['due_date'] = $productData['deadline'];
        unset($productData['deadline']);
    }

    // 3) Normalize accessories coming from:
    // accessories[0][id], accessories[0][size], accessories[0][type], ...
    $rawRows = $request->input('accessories', []);
    $selected = collect($rawRows)
        ->map(function ($row) {
            $row = is_array($row) ? $row : [];
            return [
                'id'    => isset($row['id']) ? (int)$row['id'] : null,
                'size'  => $row['size'] ?? null,
                'type'  => $row['type'] ?? null,
                // you can extend with 'quantity'/'notes' later if you expose them in the UI
            ];
        })
        ->filter(fn($r) => !empty($r['id'])) // keep rows that actually selected an accessory
        ->values()
        ->all();

    // 4) Validate normalized accessories:
    // - id exists
    // - size required (per your UI)
    // - type required & must belong to that accessory's allowed set (if defined)
    //    (When an accessory has no types defined, we allow any/null — change if needed)
    Validator::make(['rows' => $selected], [
        'rows'        => ['array'],
        'rows.*.id'   => ['required','exists:accessories,id'],
        'rows.*.size' => ['required','string','max:50'],
        'rows.*.type' => ['nullable','string','max:80'],
    ])->after(function ($v) use ($selected) {
        if (empty($selected)) return;

        // Build map: accessory_id => [allowed type values...]
        $allowed = AccessoryType::whereIn('accessory_id', collect($selected)->pluck('id')->unique())
            ->get()
            ->groupBy('accessory_id')
            ->map(fn($g) => $g->pluck('value')->all());

        foreach ($selected as $i => $r) {
            $list = $allowed[$r['id']] ?? [];
            if (!empty($list)) {
                // If the accessory declares allowed types, enforce membership & presence
                if (empty($r['type']) || !in_array($r['type'], $list, true)) {
                    $v->errors()->add("rows.$i.type", 'Invalid type for the selected accessory.');
                }
            } else {
                // No allowed set defined for this accessory → allow empty OR any string (pick policy)
                // If you want to require a type always, uncomment next line:
                // if (empty($r['type'])) { $v->errors()->add("rows.$i.type", 'Type is required.'); }
            }
        }
    })->validate();

    // 5) Transaction: create Project, upload files, create Product, attach accessories
    return DB::transaction(function () use ($request, $projectData, $productData, $selected) {

        // Defaults for project
        $projectData['status']        = $projectData['status']        ?? 'ON_GOING';
        $projectData['booked_status'] = $projectData['booked_status'] ?? 'UNBOOKED';

        // 5a) Create Project
        $project = Project::create($projectData);

        // 5b) Prepare Product
        $productData['project_id'] = $project->id;

        // File uploads → *_path columns on Product
        $dir = "projects/{$project->id}";
        if ($request->hasFile('product.sample_finish_image')) {
            $productData['sample_finish_image_path'] = $request->file('product.sample_finish_image')->store($dir, 'public');
        }
        if ($request->hasFile('product.sample_worktop_image')) {
            $productData['sample_worktop_image_path'] = $request->file('product.sample_worktop_image')->store($dir, 'public');
        }
        if ($request->hasFile('product.sample_sink_image')) {
            $productData['sample_sink_image_path'] = $request->file('product.sample_sink_image')->store($dir, 'public');
        }

        // 5c) Create Product
        // NOTE: Your products table has `name` NOT provided by the form — if you need it, add a field in Step 0 or compute it here.
        // For now we’ll generate a simple name if missing:
        if (empty($productData['name'])) {
            $productData['name'] = $project->name . ' Product';
        }
        $product = Product::create($productData);

        // 5d) Attach accessories with size/type (quantity defaults to 1)
        if (!empty($selected)) {
            $attach = [];
            foreach ($selected as $r) {
                $attach[$r['id']] = [
                    'size'     => $r['size'],
                    'type'     => $r['type'],
                    'quantity' => 1,
                    'notes'    => null,
                ];
            }
            $product->accessories()->attach($attach);
        }

        // 5e) Done → redirect
        return redirect()
            ->route('admin.ProjectManagement', $project->id)
            ->with('success', 'Project & Product created successfully.');
    });
}



    public function Accstore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:150', Rule::unique('accessories','name')],
            'types_csv' => ['nullable','string','max:500'],
        ]);

        $acc = Accessory::create([
            'name' => $data['name'],
            'category' => null, 'length_mm'=>null,'width_mm'=>null,'height_mm'=>null,'diameter_mm'=>null,
            'size' => null, 'notes' => null, 'is_active' => true,
        ]);

        $types = collect(preg_split('/\s*,\s*/', $data['types_csv'] ?? '', -1, PREG_SPLIT_NO_EMPTY))
                 ->unique()->values()->all();

        if (!empty($types)) {
            foreach ($types as $t) {
                AccessoryType::firstOrCreate(['accessory_id' => $acc->id, 'value' => $t]);
            }
        }

        return response()->json([
            'id' => $acc->id,
            'name' => $acc->name,
            'types' => $types,
        ]);
    }


    public function accstore1(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:80'],
            'length_mm' => ['nullable', 'numeric'],
            'width_mm' => ['nullable', 'numeric'],
            'height_mm' => ['nullable', 'numeric'],
            'diameter_mm' => ['nullable', 'numeric'],
            'size' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string'],
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
            'clients' => Client::orderBy('firstname')->get(['id', 'firstname']),
            'productTypes' => ['Kitchen', 'Wardrobe', 'TV Unit', 'Vanity'],
            'finishTypes' => ['Matte', 'Gloss', 'Textured'],
            'glassTypes' => ['Smoked', 'Clear', 'Frosted', 'Mirror', 'Tinted Bronze'],
            'worktopTypes' => ['Quartz', 'Granite', 'Laminate', 'Solid Wood'],
            'sinkTopTypes' => ['Undermount + Quartz', 'Topmount + Granite', 'Integrated Solid Surface'],
            'handleTypes' => ['Handle-less', 'Bar Handle', 'Knob', 'Edge Pull'],
            // 'appliances'    => Accessory::where('category','Appliance')->latest()->take(10)->get(['id','name','category']),
            'appliances' => \App\Models\Accessory::latest()
                ->take(10)
                ->get(['id', 'name', 'category']),

            'users' => User::select('id', 'employee_id')->get(),
        ]);
    }

    // Looping through table for records to push to the project blade
    public function project_stage()
    {
        $measurements = Project::with('measurement')->where('current_stage', 'measurement')->orderBy('created_at', 'desc')->get();

        $designs = Project::with('design')->where('current_stage', 'design')->get();

        $installations = Project::with('installation')->where('current_stage', 'installation')->get();

        return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.ProjectManagement.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }


}
