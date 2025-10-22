<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Measurement;
use App\Models\Design;
use App\Models\Installation;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class techAssignDesignersController extends Controller
{
    //
//           public function index(){
//     $projects = Project::with(['client','designer'])
//         ->where('tech_supervisor_id', Auth::id())
//         ->orderByDesc('created_at')
//         ->paginate(10);

//     return view('tech.AssignDesigners', compact('projects'));
// }


public function index()
{
    $projects = \App\Models\Project::with([
            'client',
            'designer.employee', // <-- add this
        ])
        ->where('tech_supervisor_id', \Illuminate\Support\Facades\Auth::id())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('tech.AssignDesigners', compact('projects'));
}

public function showDesignerAssignment()
{
    $projects = Project::with(['client','designer'])
        ->where('tech_supervisor_id', Auth::id())
        ->orderByDesc('created_at')
        ->paginate(10);

    // Try to join designers -> employees using whatever link your schema actually has.
    $q = User::where('role', 'designer');

    $haveUsersEmail     = Schema::hasColumn('users', 'email');
    $haveEmployeesEmail = Schema::hasColumn('employees', 'email');

    $haveUsersEmpId     = Schema::hasColumn('users', 'employee_id');   // common pattern
    $haveEmpStaffId     = Schema::hasColumn('employees', 'staff_id');  // you have this column

    $haveEmpUserId      = Schema::hasColumn('employees', 'user_id');   // sometimes exists

    // We will always return a collection with unified aliases:
    // user_id, emp_name, emp_avatar
    if ($haveEmpUserId) {
        // Best: employees.user_id -> users.id
        $designers = $q->leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->get([
                'users.id as user_id',
                'employees.name as emp_name',
                'employees.avatar_path as emp_avatar',
            ]);
    } elseif ($haveUsersEmail && $haveEmployeesEmail) {
        // Join via email if both tables have it
        $designers = $q->leftJoin('employees', 'employees.email', '=', 'users.email')
            ->get([
                'users.id as user_id',
                'employees.name as emp_name',
                'employees.avatar_path as emp_avatar',
            ]);
    } elseif ($haveUsersEmpId && $haveEmpStaffId) {
        // Join users.employee_id -> employees.staff_id (common mapping)
        $designers = $q->leftJoin('employees', 'employees.staff_id', '=', 'users.employee_id')
            ->get([
                'users.id as user_id',
                'employees.name as emp_name',
                'employees.avatar_path as emp_avatar',
            ]);
    } else {
        // Fallback: no reliable join columns. Fetch designers and try to enrich in PHP by email/staff if possible.
        $designers = $q->get(['id as user_id']); // minimal

        // Try to build a map from employees we can use (email or staff_id)
        $employees = Employee::get(['id','name','avatar_path','email','staff_id']);

        // If users has email, map by email; if users has employee_id, map by staff_id
        $usersHaveEmail = $haveUsersEmail;
        $usersHaveEmpId = $haveUsersEmpId;

        $empByEmail   = $employees->whereNotNull('email')->keyBy('email');
        $empByStaffId = $employees->whereNotNull('staff_id')->keyBy('staff_id');

        // Enrich each row with best guesses (keeps alias shape)
        $designers = $designers->map(function ($row) use ($usersHaveEmail, $usersHaveEmpId, $empByEmail, $empByStaffId) {
            $row->emp_name   = null;
            $row->emp_avatar = null;

            if ($usersHaveEmail && property_exists($row, 'email') && $row->email) {
                if ($e = $empByEmail->get($row->email)) {
                    $row->emp_name   = $e->name;
                    $row->emp_avatar = $e->avatar_path;
                }
            } elseif ($usersHaveEmpId && property_exists($row, 'employee_id') && $row->employee_id) {
                if ($e = $empByStaffId->get($row->employee_id)) {
                    $row->emp_name   = $e->name;
                    $row->emp_avatar = $e->avatar_path;
                }
            }
            return $row;
        });
    }

    // Normalize avatar URLs now (so Blade can stay simple)
    $designers = $designers->map(function ($d) {
        $path = $d->emp_avatar;
        if ($path) {
            $d->emp_avatar = Str::startsWith($path, ['http://','https://'])
                ? $path
                : Storage::url($path);
        } else {
            $d->emp_avatar = asset('images/avatar-placeholder.png');
        }
        return $d;
    });

    return view('tech.AssignDesigners', compact('projects','designers'));
}




public function showDesignerAssignment_old()
{
    $projects = Project::with(['client','designer'])
        ->where('tech_supervisor_id', Auth::id())
        ->orderByDesc('created_at')
        ->paginate(10);

    // Base users query
    $userCols = ['id']; // always
    if (Schema::hasColumn('users', 'name'))   $userCols[] = 'name';
    if (Schema::hasColumn('users', 'email'))  $userCols[] = 'email';
    if (Schema::hasColumn('users', 'employee_id')) $userCols[] = 'employee_id';

    $designers = User::where('role', 'designer')->get($userCols);

    // Pull employees once
    $empCols = ['id','name','avatar_path'];
    if (Schema::hasColumn('employees', 'email'))    $empCols[] = 'email';
    if (Schema::hasColumn('employees', 'user_id'))  $empCols[] = 'user_id';
    if (Schema::hasColumn('employees', 'staff_id')) $empCols[] = 'staff_id';

    $employees = Employee::get($empCols);

    // Build lookup maps for whichever link exists
    $empByUserId  = collect();
    $empByEmail   = collect();
    $empByStaffId = collect();

    if (in_array('user_id', $empCols))  $empByUserId  = $employees->whereNotNull('user_id')->keyBy('user_id');
    if (in_array('email', $empCols))    $empByEmail   = $employees->whereNotNull('email')->keyBy('email');
    if (in_array('staff_id', $empCols)) $empByStaffId = $employees->whereNotNull('staff_id')->keyBy('staff_id');

    $usersHaveEmail     = in_array('email', $userCols, true);
    $usersHaveEmployeeId= in_array('employee_id', $userCols, true);

    // Enrich designers with employee info + final display fields
    $designers = $designers->map(function ($u) use (
        $empByUserId, $empByEmail, $empByStaffId, $usersHaveEmail, $usersHaveEmployeeId
    ) {
        $emp = null;
        if ($empByUserId->isNotEmpty()) {
            $emp = $empByUserId->get($u->id);
        } elseif ($usersHaveEmail && $empByEmail->isNotEmpty() && !empty($u->email)) {
            $emp = $empByEmail->get($u->email);
        } elseif ($usersHaveEmployeeId && $empByStaffId->isNotEmpty() && !empty($u->employee_id)) {
            $emp = $empByStaffId->get($u->employee_id);
        }

        // Final display fields
        $displayName = $emp->name ?? $u->name ?? '—';

        $path = $emp->avatar_path ?? null;
        $avatarUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : asset('images/avatar-placeholder.png');

        // Return a simple data object for Blade
        return (object)[
            'user_id'      => $u->id,
            'display_name' => $displayName,
            'avatar_url'   => $avatarUrl,
        ];
    });

    return view('tech.AssignDesigners', compact('projects','designers'));
}


// public function assignDesigner(Request $request)
// {
//     $request->validate([
//         'project_id' => 'required|exists:projects,id',
//         'designer_id' => 'required|exists:users,id',
//         'design_date' => 'required|date'
//     ]);

//     // Save to the Project table
//     $project = Project::find($request->project_id);
//     $project->designer_id = $request->designer_id;
//     $project->current_stage = 'design';
//     $project->save();

//     // Save to the Design table
//     $design = new Design();
//     $design->project_id = $request->project_id;
//     $design->design_date = $request->design_date;
//     $design->save();

//     return redirect()->back()->with('success', 'Designer and design date assigned successfully!');
// }

public function assignDesigner(Request $request)
{
    $validated = $request->validate([
        'project_id'  => ['required','exists:projects,id'],
        'designer_id' => ['required','exists:users,id'], // keep simple while testing
        'design_date' => ['required','date'],
    ]);

    $project = Project::findOrFail($validated['project_id']);

    DB::transaction(function () use ($project, $validated) {
        // Allow same designer on many projects
        $project->forceFill([
            'designer_id'   => $validated['designer_id'],
            'current_stage' => 'design',
        ])->save();

        // Only dedupe per (project, date)
        Design::firstOrCreate(
            [
                'project_id'  => $project->id,
                'design_date' => Carbon::parse($validated['design_date'])->toDateString(),
            ],
            []
        );
    });

    return back()->with('success','Designer and design date assigned successfully!');
}





public function assignDesigner_old(Request $request)
{
    $validated = $request->validate([
        'project_id'  => ['required','exists:projects,id'],
        'designer_id' => [
            'required',
            Rule::exists('users','id')->where(fn($q) => $q->where('role','designer')),
        ],
        'design_date' => ['required','date'],
    ]);

    $project    = Project::findOrFail($validated['project_id']);
    $designDate = Carbon::parse($validated['design_date'])->toDateString();

    DB::transaction(function () use ($project, $validated, $designDate) {
        // 1) Set designer on the project (this does NOT prevent same designer on other projects)
        $project->update([
            'designer_id'   => $validated['designer_id'],
            'current_stage' => 'design',
        ]);

        // 2) Create a design row for this project/date (dedupe per project+date only)
        Design::firstOrCreate(
            ['project_id' => $project->id, 'design_date' => $designDate],
            [] // extra fillable fields go here if any
        );
    });

    return back()->with('success', 'Designer and design date assigned successfully!');
}



public function list_newold(Request $request)
{
    $currentProjectId = (int) $request->query('project_id');

    // Pull designers (users.role = 'designer')
    $userCols = ['id','role'];
    foreach (['name','email','employee_id'] as $col) {
        if (Schema::hasColumn('users', $col)) $userCols[] = $col;
    }
    $users = User::whereRaw('LOWER(role) = ?', ['designer'])->get($userCols);

    // Pull employees
    $empCols = ['id','name','avatar_path'];
    foreach (['email','user_id','staff_id'] as $col) {
        if (Schema::hasColumn('employees', $col)) $empCols[] = $col;
    }
    $employees = Employee::get($empCols);

    // Build possible link maps
    $empByUserId  = in_array('user_id', $empCols)  ? $employees->whereNotNull('user_id')->keyBy('user_id')   : collect();
    $empByEmail   = in_array('email', $empCols)    ? $employees->whereNotNull('email')->keyBy('email')       : collect();
    $empByStaffId = in_array('staff_id', $empCols) ? $employees->whereNotNull('staff_id')->keyBy('staff_id') : collect();

    $usersHaveEmail      = in_array('email', $userCols, true);
    $usersHaveEmployeeId = in_array('employee_id', $userCols, true);

    // Normalize rows for UI (ONLY id, name, avatar_url)
    $rows = $users->map(function ($u) use ($empByUserId, $empByEmail, $empByStaffId, $usersHaveEmail, $usersHaveEmployeeId) {
        $emp = null;

        if ($empByUserId->isNotEmpty()) {
            $emp = $empByUserId->get($u->id);
        }
        if (!$emp && $usersHaveEmail && $empByEmail->isNotEmpty() && !empty($u->email)) {
            $emp = $empByEmail->get($u->email);
        }
        if (!$emp && $usersHaveEmployeeId && $empByStaffId->isNotEmpty() && !empty($u->employee_id)) {
            $emp = $empByStaffId->get($u->employee_id);
        }

        $name = $emp->name ?? $u->name ?? '—';
        $path = $emp->avatar_path ?? null;
        $avatarUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : asset('images/avatar-placeholder.png');

        return [
            'id'         => (int) $u->id,
            'name'       => $name,
            'avatar_url' => $avatarUrl,
        ];
    })->values();

    return response()->json($rows);
}






    public function list_old(Request $request)
    {
        $currentProjectId = (int) $request->query('project_id');

        // Pull designers (users.role = 'designer')
        $userCols = ['id','role'];
        foreach (['name','email','employee_id'] as $col) {
            if (Schema::hasColumn('users', $col)) $userCols[] = $col;
        }
        $users = User::where('role','designer')->get($userCols);

        // Pull employees
        $empCols = ['id','name','avatar_path'];
        foreach (['email','user_id','staff_id'] as $col) {
            if (Schema::hasColumn('employees', $col)) $empCols[] = $col;
        }
        $employees = Employee::get($empCols);

        // Build possible link maps
        $empByUserId  = in_array('user_id', $empCols)  ? $employees->whereNotNull('user_id')->keyBy('user_id')   : collect();
        $empByEmail   = in_array('email', $empCols)    ? $employees->whereNotNull('email')->keyBy('email')       : collect();
        $empByStaffId = in_array('staff_id', $empCols) ? $employees->whereNotNull('staff_id')->keyBy('staff_id') : collect();

        $usersHaveEmail      = in_array('email', $userCols, true);
        $usersHaveEmployeeId = in_array('employee_id', $userCols, true);

        // Current assignments (designer_id → some project)
        $assignments = Project::whereNotNull('designer_id')
            ->get(['id','name','designer_id'])
            ->groupBy('designer_id')
            ->map(fn($g) => $g->first());

        // Normalize rows for UI
        $rows = $users->map(function ($u) use ($empByUserId, $empByEmail, $empByStaffId, $usersHaveEmail, $usersHaveEmployeeId, $assignments, $currentProjectId) {
            $emp = null;

            if ($empByUserId->isNotEmpty()) {
                $emp = $empByUserId->get($u->id);
            }
            if (!$emp && $usersHaveEmail && $empByEmail->isNotEmpty() && !empty($u->email)) {
                $emp = $empByEmail->get($u->email);
            }
            if (!$emp && $usersHaveEmployeeId && $empByStaffId->isNotEmpty() && !empty($u->employee_id)) {
                $emp = $empByStaffId->get($u->employee_id);
            }

            $name = $emp->name ?? $u->name ?? '—';
            $path = $emp->avatar_path ?? null;
            $avatarUrl = $path
                ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
                : asset('images/avatar-placeholder.png');

            $assigned = $assignments->get($u->id);
            if ($assigned && (int)$assigned->id === $currentProjectId) {
                $assigned = null; // current project doesn't count as "already assigned elsewhere"
            }

            return [
                'id'         => (int) $u->id,
                'name'       => $name,
                'avatar_url' => $avatarUrl,
                'assigned_project' => $assigned ? ['id'=>(int)$assigned->id, 'name'=>$assigned->name] : null,
            ];
        })->values();

        return response()->json($rows);
    }



    public function list(Request $request)
{
    // Load designers + employee in one go (case-insensitive role match)
    $designers = User::with('employee')
        ->whereRaw('LOWER(role) = ?', ['designer'])
        ->get();

    // Build a map of the latest project per designer (current assignment)
    // If you want "latest design event" instead, swap to the designs table and order by design_date/created_at.
    $latestByDesigner = Project::whereNotNull('designer_id')
        ->select('id','name','designer_id','created_at')
        ->orderBy('designer_id')
        ->orderByDesc('created_at')
        ->get()
        ->groupBy('designer_id')
        ->map(fn($g) => $g->first()); // newest project for that designer

    $rows = $designers->map(function ($u) use ($latestByDesigner) {
        // Name priority: Employee.name -> User.name -> "—"
        $name = optional($u->employee)->name ?? $u->name ?? '—';

        // Avatar priority: Employee.avatar_path -> placeholder
        $path = optional($u->employee)->avatar_path;
        $avatarUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : asset('images/avatar-placeholder.png'); // ensure this file exists

        // Latest project for this designer (if any)
        $lp = $latestByDesigner->get($u->id);

        return [
            'id'             => (int) $u->id,
            'name'           => $name,
            'avatar_url'     => $avatarUrl,
            'latest_project' => $lp ? ['id' => (int) $lp->id, 'name' => $lp->name] : null,
        ];
    })->values();

    return response()->json($rows);
}
}
