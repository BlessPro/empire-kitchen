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




public function supervisors(Project $project): JsonResponse
    {
        // Pull all tech supervisors and the projects they supervise
        $users = User::query()
            ->where('role', 'tech_supervisor')
            ->with([
                'employee:id,name,avatar_path',
                // we'll use this to check if they’re on another project
                'techSupervisedProjects:id,tech_supervisor_id,name',
            ])
            ->orderByRaw('COALESCE((SELECT name FROM employees WHERE employees.id = users.employee_id), users.name) ASC')
            ->get(['users.id','users.name','users.employee_id']);

        $supervisors = $users->map(function (User $u) use ($project) {
            $displayName = $u->employee?->name ?? $u->name ?? '—';
            $avatarUrl   = $u->employee?->avatar_path
                ? asset('storage/'.$u->employee->avatar_path)
                : asset('images/default-avatar.png');

            $isHere = (int)$project->tech_supervisor_id === (int)$u->id;

            $other = $u->techSupervisedProjects
                ->first(fn($p) => (int)$p->id !== (int)$project->id);

            return [
                'id'                    => (int)$u->id,
                'name'                  => $displayName,
                'avatar_url'            => $avatarUrl,
                'is_assigned_here'      => $isHere,
                'assigned_elsewhere'    => (bool)$other,
                'assigned_project_name' => $other?->name,
            ];
        })->values();

        return response()->json([
            'project' => [
                'id'   => $project->id,
                'name' => $project->name,
            ],
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



    // public function supervisors(Project $project): JsonResponse
    // {
    //     // Pull all tech supervisors joined to employees for display fields
    //     $rows = User::query()
    //         ->where('role', 'tech_supervisor')
    //         ->leftJoin('employees', 'employees.id', '=', 'users.employee_id')
    //         ->orderBy(DB::raw('COALESCE(employees.name, users.name)'), 'asc')
    //         ->get([
    //             'users.id as id',
    //             DB::raw('COALESCE(employees.name, users.name) as name'),
    //             'employees.avatar_path',
    //         ]);

    //     // Build response payload
    //     $supervisors = $rows->map(function ($u) use ($project) {
    //         $avatarUrl = $u->avatar_path
    //             ? asset('storage/'.$u->avatar_path)
    //             : asset('images/default-avatar.png');

    //         // Is this user already assigned to THIS project?
    //         $isHere = (int) $project->tech_supervisor_id === (int) $u->id;

    //         // Is this user assigned to SOME OTHER project?
    //         $other = Project::query()
    //             ->where('tech_supervisor_id', $u->id)
    //             ->where('id', '!=', $project->id)
    //             ->select(['id', 'name'])
    //             ->first();

    //         return [
    //             'id'                    => (int) $u->id,
    //             'name'                  => $u->name,
    //             'avatar_url'            => $avatarUrl,
    //             'is_assigned_here'      => $isHere,
    //             'assigned_elsewhere'    => (bool) $other,
    //             'assigned_project_name' => $other?->name,
    //         ];
    //     })->values();

    //     return response()->json([
    //         'project' => [
    //             'id'   => $project->id,
    //             'name' => $project->name,
    //         ],
    //         'supervisors' => $supervisors,
    //     ]);
    // }



// public function assignSupervisor(Request $request)
// {
//     $data = $request->validate([
//         'project_id'    => ['required','exists:projects,id'],
//         'supervisor_id' => ['required','exists:users,id'],
//     ]);

//     Project::whereKey($data['project_id'])
//         ->update(['tech_supervisor_id' => $data['supervisor_id']]);

//     return back()->with('success', 'Technical supervisor assigned.');
// }


// trial
 public function index()
    {
        $adminId = Auth::id();

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

        $measurements = Project::with(array_merge($withCommon, ['measurement', 'comments' => $withUnreadComments]))
            ->whereRaw('LOWER(current_stage) = ?', ['measurement'])
            ->latest()->get();

        $designs = Project::with(array_merge($withCommon, ['design', 'comments' => $withUnreadComments]))
            ->whereRaw('LOWER(current_stage) = ?', ['design'])
            ->latest()->get();

        $installations = Project::with(array_merge($withCommon, ['installation', 'comments' => $withUnreadComments]))
            ->whereRaw('LOWER(current_stage) = ?', ['installation'])
            ->latest()->get();

        $productions = Project::with(array_merge($withCommon, ['production', 'comments' => $withUnreadComments]))
            ->whereRaw('LOWER(current_stage) = ?', ['production'])
            ->latest()->get();

        // you already used these in your view
        $projects = Project::all();
        $clients  = Client::all();

        // present, but we’ll load “assign-state” via ajax per project
        $supervisors = User::where('role', 'tech_supervisor')
            ->join('employees', 'employees.id', '=', 'users.employee_id')
            ->orderBy('employees.name')
            ->get([
                'users.id',
                DB::raw('employees.name as name'),
                DB::raw('employees.avatar_path as profile_pic'),
            ]);

        return view('admin.ProjectManagement', compact(
            'measurements', 'designs', 'installations', 'productions',
            'clients', 'projects', 'supervisors'
        ));
    }

    /**
     * JSON: tech supervisors with assigned flags relative to a project.
     */
    // public function supervisorsForProject(?Project $project = null)
    // {
    //     $projectId = $project?->id;

    //     // fetch all tech supervisors with their employee display fields
    //     $rows = User::query()
    //         ->where('role', 'tech_supervisor')
    //         ->leftJoin('employees', 'employees.id', '=', 'users.employee_id')
    //         ->leftJoin('projects as p', 'p.tech_supervisor_id', '=', 'users.id')
    //         ->groupBy('users.id', 'employees.name', 'employees.avatar_path')
    //         ->select([
    //             'users.id',
    //             DB::raw('COALESCE(employees.name, users.name) as name'),
    //             DB::raw('employees.avatar_path as avatar_path'),
    //             // If this supervisor appears on any project, pull one project name (for display)
    //             DB::raw("MAX(p.name) as any_project_name"),
    //             DB::raw("MAX(p.id)   as any_project_id"),
    //         ])
    //         ->orderBy('name')
    //         ->get();

    //     $base = url('/');

    //     $data = [
    //         'project' => [
    //             'id'   => $projectId,
    //             'name' => $project?->name,
    //         ],
    //         'supervisors' => $rows->map(function ($r) use ($projectId, $base) {
    //             $avatarUrl = $r->avatar_path
    //                 ? asset('storage/' . ltrim($r->avatar_path, '/'))
    //                 : asset('images/default-avatar.png');

    //             $isAssignedHere    = $projectId && (intval($r->any_project_id) === intval($projectId));
    //             $assignedElsewhere = $r->any_project_id && !$isAssignedHere;

    //             return [
    //                 'id'                  => (int) $r->id,
    //                 'name'                => $r->name,
    //                 'avatar_url'          => $avatarUrl,
    //                 'is_assigned_here'    => (bool) $isAssignedHere,
    //                 'assigned_elsewhere'  => (bool) $assignedElsewhere,
    //                 'assigned_project_id' => $assignedElsewhere ? (int) $r->any_project_id : null,
    //                 'assigned_project_name' => $assignedElsewhere ? $r->any_project_name : null,
    //             ];
    //         })->values(),
    //     ];

    //     return response()->json($data);
    // }

    // /**
    //  * Assign the selected tech supervisor to a project.
    //  */
    // public function assignSupervisor(Request $request)
    // {
    //     $request->validate([
    //         'project_id'        => ['required','exists:projects,id'],
    //         'supervisor_id'     => ['required','exists:users,id'],
    //     ]);

    //     $project = Project::findOrFail($request->project_id);
    //     $project->tech_supervisor_id = (int) $request->supervisor_id;
    //     $project->save();

    //     return back()->with('success', 'Tech Supervisor assigned successfully.');
    // }





    // public function index()
    // {
    //     $adminId = Auth::id();

    //     // Reusable closure to count unread comments per project (kept as-is)
    //     $withUnreadComments = function ($query) use ($adminId) {
    //         $query->withCount([
    //             'views as unread_by_admin' => function ($subQuery) use ($adminId) {
    //                 $subQuery->where('user_id', $adminId);
    //             },
    //         ]);
    //     };

    //     // Common eager-loads your FE will need for every project card/row
    //     $withCommon = [
    //         // client basic info
    //         'client:id,firstname,email,phone_number',

    //         // role assignments -> user -> employee (to show names/avatars)
    //         'admin.employee:id,name,avatar_path',
    //         'techSupervisor.employee:id,name,avatar_path',
    //         'designer.employee:id,name,avatar_path',
    //         'productionOfficer.employee:id,name,avatar_path',
    //         'installationOfficer.employee:id,name,avatar_path',

    //         // products summary (customize fields as needed)
    //         'products:id,project_id,name,product_type,type_of_finish,finish_color_hex,worktop_type,worktop_color_hex,handle,notes',
    //     ];

    //     // STAGE: MEASUREMENT
    //     $measurements = Project::with(
    //         array_merge($withCommon, [
    //             'measurement', // the stage record
    //             'comments' => $withUnreadComments, // your unread count
    //         ]),
    //     )
    //         ->whereRaw('LOWER(current_stage) = ?', ['measurement'])
    //         ->latest()
    //         ->get();

    //     // STAGE: DESIGN
    //     $designs = Project::with(array_merge($withCommon, ['design', 'comments' => $withUnreadComments]))
    //         ->whereRaw('LOWER(current_stage) = ?', ['design'])
    //         ->latest()
    //         ->get();

    //     // STAGE: INSTALLATION
    //     $installations = Project::with(array_merge($withCommon, ['installation', 'comments' => $withUnreadComments]))
    //         ->whereRaw('LOWER(current_stage) = ?', ['installation'])
    //         ->latest()
    //         ->get();

    //     // STAGE: PRODUCTION
    //     $productions = Project::with(array_merge($withCommon, ['production', 'comments' => $withUnreadComments]))
    //         ->whereRaw('LOWER(current_stage) = ?', ['production'])
    //         ->latest()
    //         ->get();

    //     // The rest of your variables
    //     $projects = Project::all();
    //     $clients = Client::all();

    //     // All tech supervisors (with display fields from employees)
    //     $techSupervisors = User::where('role', 'tech_supervisor')
    //         ->join('employees', 'employees.id', '=', 'users.employee_id')
    //         ->orderBy('employees.name')
    //         ->get(['users.id', 'users.employee_id', 'users.role', DB::raw('employees.name as name'), DB::raw('employees.avatar_path as profile_pic')]);

    //     // Same for $supervisors
    //     $supervisors = User::where('role', 'tech_supervisor')
    //         ->join('employees', 'employees.id', '=', 'users.employee_id')
    //         ->orderBy('employees.name')
    //         ->get(['users.id', DB::raw('employees.name as name'), DB::raw('employees.avatar_path as profile_pic')]);

    //     return view('admin.ProjectManagement', compact('measurements', 'designs', 'installations', 'productions', 'clients', 'techSupervisors', 'supervisors', 'projects'));
    // }


    // app/Http/Controllers/ProjectLookupController.php



    // public function index()
    // {
    //     $adminId = Auth::id();

    //     $withUnreadComments = function ($query) use ($adminId) {
    //         $query->withCount([
    //             'views as unread_by_admin' => function ($subQuery) use ($adminId) {
    //                 $subQuery->where('user_id', $adminId);
    //             },
    //         ]);
    //     };

    //     $measurements = Project::with(['measurement', 'comments' => $withUnreadComments])
    //         ->where('current_stage', 'measurement')
    //         ->latest()
    //         ->get();

    //     $designs = Project::with(['design', 'comments' => $withUnreadComments])
    //         ->where('current_stage', 'design')
    //         ->latest()
    //         ->get();

    //     $installations = Project::with(['installation', 'comments' => $withUnreadComments])
    //         ->where('current_stage', 'installation')
    //         ->latest()
    //         ->get();

    //     $productions = Project::with(['production', 'comments' => $withUnreadComments])
    //         ->where('current_stage', 'production')
    //         ->latest()
    //         ->get();

    //     $projects = Project::all();
    //     $clients  = Client::all();

    //     // All tech supervisors (for whatever list you use)
    //     // Join employees to pull display fields from employees table
    //     $techSupervisors = User::where('role', 'tech_supervisor')
    //         ->join('employees', 'employees.id', '=', 'users.employee_id')
    //         ->orderBy('employees.name')
    //         ->get([
    //             'users.id',
    //             'users.employee_id',
    //             'users.role',
    //             DB::raw('employees.name as name'),
    //             DB::raw('employees.avatar_path as profile_pic'),
    //         ]);

    //     // all tech supervisors, assigned or not (your "supervisors" variable)
    //     $supervisors = User::where('role', 'tech_supervisor')
    //         ->join('employees', 'employees.id', '=', 'users.employee_id')
    //         ->orderBy('employees.name')
    //         ->get([
    //             'users.id',
    //             DB::raw('employees.name as name'),
    //             DB::raw('employees.avatar_path as profile_pic'),
    //         ]);

    //     return view('admin.ProjectManagement', compact(
    //         'measurements',
    //         'designs',
    //         'installations',
    //         'productions',
    //         'clients',
    //         'techSupervisors',
    //         'supervisors',
    //         'projects'
    //     ));
    // }

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
        'project.due_date'             => ['nullable', 'date'],

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

    // public function store(Request $request)
    // {
    //     // 1) Validate
    //     $validated = $request->validate([
    //         // Project
    //         'project.client_id' => ['required', 'exists:clients,id'],
    //         'project.name' => ['required', 'string', 'max:150'],

    //         // Product (required per your rule)
    //         'product.name' => ['required', 'string', 'max:150'],
    //         'product.product_type' => ['nullable', 'string', 'max:80'],
    //         'product.type_of_finish' => ['nullable', 'string', 'max:80'],
    //         'product.finish_color_hex' => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_finish_image' => ['nullable', 'image', 'max:4096'],
    //         'product.glass_door_type' => ['nullable', 'string', 'max:80'],
    //         'product.worktop_type' => ['nullable', 'string', 'max:80'],
    //         'product.worktop_color_hex' => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_worktop_image' => ['nullable', 'image', 'max:4096'],
    //         'product.sink_top_type' => ['nullable', 'string', 'max:80'],
    //         'product.handle' => ['nullable', 'string', 'max:80'],
    //         'product.sink_color_hex' => ['nullable', 'regex:/^#([0-9a-fA-F]{6})$/'],
    //         'product.sample_sink_image' => ['nullable', 'image', 'max:4096'],
    //         'product.notes' => ['nullable', 'string'],

    //         // 'accessory_name' => ['required', 'string', 'max:255'],
    //         // 'accessory_size' => ['required', 'string', 'max:50'],
    //         // 'accessory_type' => ['required', 'in:Inbuilt,Freestanding'],
    //         // Accessories
    //         'accessories' => ['nullable', 'array'],
    //         'accessories.*' => ['integer', 'exists:accessories,id'],
    //     ]);
    // //     $validated['accessory_name'] = strtoupper($validated['accessory_name']);
    // // $product = Product::create($validated); // if using $fillable on Product


    //     // 2) Split payloads (IMPORTANT)
    //     $projectData = $validated['project'];
    //     $productData = $validated['product'] ?? [];

    //     return DB::transaction(function () use ($request, $projectData, $productData) {
    //         // Defaults
    //         $projectData['status'] = $projectData['status'] ?? 'ON_GOING';
    //         $projectData['booked_status'] = $projectData['booked_status'] ?? 'UNBOOKED';

    //         // 3) Create Project only from projectData
    //         $project = \App\Models\Project::create($projectData);

    //         // 4) Prepare Product
    //         $productData['project_id'] = $project->id;

    //         // Uploads -> map to *_path columns
    //         $dir = "projects/{$project->id}";
    //         if ($request->hasFile('product.sample_finish_image')) {
    //             $productData['sample_finish_image_path'] = $request->file('product.sample_finish_image')->store($dir, 'public');
    //         }
    //         if ($request->hasFile('product.sample_worktop_image')) {
    //             $productData['sample_worktop_image_path'] = $request->file('product.sample_worktop_image')->store($dir, 'public');
    //         }
    //         if ($request->hasFile('product.sample_sink_image')) {
    //             $productData['sample_sink_image_path'] = $request->file('product.sample_sink_image')->store($dir, 'public');
    //         }

    //         // 5) Create Product (now includes 'name')
    //         $product = \App\Models\Product::create($productData);

    //         // 6) Attach Accessories (if any)
    //         $ids = collect($request->input('accessories', []))->filter()->unique()->values();
    //         if ($ids->isNotEmpty()) {
    //             $product->accessories()->attach($ids->mapWithKeys(fn($id) => [$id => ['quantity' => 1]]));
    //         }

    //         // Done
    //         return redirect()->route('admin.ProjectManagement', $project->id)->with('success', 'Project & Product created successfully.');
    //     });
    // }

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

    // app/Http/Controllers/AccessoryAjaxController.php


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

    // public function assignSupervisor(Request $request)
    // {
    //     $request->validate([
    //         'project_id' => 'required|exists:projects,id',
    //         'tech_supervisor_id' => 'required|exists:users,id',
    //     ]);

    //     // Find project and assign supervisor
    //     $project = Project::findOrFail($request->project_id);
    //     $project->tech_supervisor_id = $request->tech_supervisor_id;
    //     $project->save();

    //     return redirect()->back()->with('success', 'Tech Supervisor assigned successfully!');
    // }
}
