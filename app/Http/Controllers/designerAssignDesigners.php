<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Support\ProjectViewBuilder;

class designerAssignDesigners extends Controller
{
    // redirect to the designer dashboard
    public function index_old()
    {
        return view('designer.dashboard');
    }
    // redirect to the assigned projects page
       public function AssignedProjects()
    {
        return view('designer.AssignedProjects');
    }
    // redirect to the Project Design page
    public function ProjectDesign()
    {
        return view('designer.ProjectDesign');
    }
    // redirect to the timeline management page
    public function TimelineManagement()
    {
        return view('designer.TimelineManagement');
    }
    // redirect to the inbox page
    public function inbox()
    {
        return view('designer.inbox');
    }

    // redirect to the client management page
public function clientProjects_old()
{
    $designerId = Auth::id(); // Get the logged-in designer's ID

    $clients = Client::whereHas('projects', function ($query) use ($designerId) {
        $query->where('designer_id', $designerId); // Only projects assigned to designer
    })
    ->with(['projects' => function ($query) use ($designerId) {
        $query->where('designer_id', $designerId); // Eager-load only those projects
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(5);

    return view('designer.AssignedProjects', compact('clients'));
}




public function index(Request $request)
{
    $search   = $request->string('search')->toString();
    $location = $request->string('location')->toString();
    $status   = $request->string('status')->toString();     // new
    $clientId = $request->integer('client_id');             // new

    // For dropdowns (don’t depend on current pagination page)
    $allLocations = Client::whereNotNull('location')->distinct()->orderBy('location')->pluck('location');
    $allClients   = Client::select('id','firstname','lastname')->orderBy('firstname')->orderBy('lastname')->get();
    $allStatuses  = ['Measurement','Design','Production','Installation']; // display labels

    $clients = Client::query()
        // text search on client name
        ->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('firstname', 'like', "%{$search}%")
                   ->orWhere('lastname', 'like', "%{$search}%");
            });
        })
        // client location filter
        ->when($location, fn($q) => $q->where('location', $location))
        // choose one client explicitly
        ->when($clientId, fn($q) => $q->where('id', $clientId))
        // only clients who have projects matching status (if provided)
        ->when($status, function ($q) use ($status) {
            $q->whereHas('projects', function ($p) use ($status) {
                $p->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            });
        })
        // eager-load projects; if status chosen, only bring those projects
        ->with(['projects' => function ($p) use ($status) {
            if ($status) {
                $p->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            }
            $p->orderByDesc('created_at');
        }])
        ->orderByDesc('created_at')
        ->paginate(10)
        ->appends($request->query()); // preserve filters on pagination links

    return view('clients.index', compact('clients','allLocations','allClients','allStatuses'));
}






public function clientProjects_oold()
{
    $designerId = Auth::id();

    // $projects = Project::with([
    //         'client:id,firstname,lastname',
    //         'latestInstallation:id,project_id,install_date', // or 'installation:...' if one-to-one
    //     ])

       $projects= Project::with([
    'client:id,firstname,lastname',
    'latestInstallation' => function ($q) {
        $q->selectRaw('installations.id, installations.project_id, installations.install_date'); // or drop project_id if not needed
    },
])

        ->where('designer_id', $designerId)
        ->orderByDesc('created_at')
        ->paginate(10);


    return view('designer.AssignedProjects', compact('projects'));
}



public function clientProjects(Request $request)
{
    $designerId = Auth::id();

    // Two filter params (only these):
    $search = trim((string) $request->query('q', ''));           // client name
    $status = strtoupper((string) $request->query('status', '')); // COMPLETED | IN_REVIEW | ON_GOING

    $allowedStatuses = ['COMPLETED','IN_REVIEW','ON_GOING'];
    if (!in_array($status, $allowedStatuses, true)) {
        $status = null; // ignore invalid values
    }

    $projects = Project::with([
            'client:id,firstname,lastname',
            // keep columns fully-qualified to avoid "Column 'project_id' is ambiguous"
            'latestInstallation' => function ($q) {
                $q->selectRaw('installations.id, installations.project_id, installations.install_date');
            },
        ])
        ->where('designer_id', $designerId)
        // filter by client name (first, last, or "first last")
        ->when($search, function ($q) use ($search) {
            $q->whereHas('client', function ($cq) use ($search) {
                $cq->where('firstname', 'like', "%{$search}%")
                   ->orWhere('lastname', 'like', "%{$search}%")
                   ->orWhere(
                        DB::raw("CONCAT(COALESCE(firstname,''),' ',COALESCE(lastname,''))"),
                        'like',
                        "%{$search}%"
                   );
            });
        })
        // filter by status (case-insensitive in DB)
        ->when($status, fn($q) => $q->whereRaw('UPPER(status) = ?', [$status]))
        ->orderByDesc('created_at')
        ->paginate(10)
        ->appends($request->query()); // keep filters on pagination links

    // options for the status <select>
    $statusOptions = $allowedStatuses;

    return view('designer.AssignedProjects', compact('projects','statusOptions'));
}
public function showProjectInfo(Request $request, Project $project)
{
    $vm = ProjectViewBuilder::build($project, $request)['project'];

    return view('designer.ClientManagement.projectInfo', [
        'project' => $vm,
    ]);
}

public function showProjectname(Request $request, Project $project)
{
    $vm = ProjectViewBuilder::build($project, $request)['project'];

    return view('designer.ClientManagement.projectInfo', [
        'project' => $vm,
    ]);
}
}
