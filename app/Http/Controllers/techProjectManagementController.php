<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class techProjectManagementController extends Controller
{
    public function index()
    {
        $techId = Auth::id();

        $stageData = $this->loadStageData($techId);

        $projectLocations = Project::query()
            ->where('tech_supervisor_id', $techId)
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return view('tech.ProjectManagement', [
            'measurements' => $stageData['measurement'],
            'designs' => $stageData['design'],
            'productions' => $stageData['production'],
            'installations' => $stageData['installation'],
            'projectLocations' => $projectLocations,
        ]);
    }

    public function filterColumns(Request $request): JsonResponse
    {
        $techId = Auth::id();

        $search = trim((string) $request->query('search', ''));
        $location = trim((string) $request->query('location', ''));

        $search = $search !== '' ? $search : null;
        $location = $location !== '' ? $location : null;

        $stageData = $this->loadStageData($techId, $search, $location);

        return response()->json([
            'measurement' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['measurement'],
                'emptyMessage' => 'No project is currently under measurement',
                'projectRouteName' => 'tech.projects.info',
                'showActions' => false,
            ])->render(),
            'design' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['design'],
                'emptyMessage' => 'No project is currently in design',
                'projectRouteName' => 'tech.projects.info',
                'showActions' => false,
            ])->render(),
            'production' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['production'],
                'emptyMessage' => 'No project is currently in production',
                'projectRouteName' => 'tech.projects.info',
                'showActions' => false,
            ])->render(),
            'installation' => view('admin.partials.project-stage-cards', [
                'projects' => $stageData['installation'],
                'emptyMessage' => 'No project is currently in installation',
                'projectRouteName' => 'tech.projects.info',
                'showActions' => false,
            ])->render(),
            'counts' => [
                'measurement' => $stageData['measurement']->count(),
                'design' => $stageData['design']->count(),
                'production' => $stageData['production']->count(),
                'installation' => $stageData['installation']->count(),
            ],
        ]);
    }

    private function loadStageData(int $techId, ?string $search = null, ?string $location = null): array
    {
        $withUnread = function ($query) use ($techId) {
            $query->withCount([
                'views as unread_by_admin' => function ($subQuery) use ($techId) {
                    $subQuery->where('user_id', $techId);
                },
            ]);
        };

        $withCommon = [
            'client:id,firstname,lastname,title,email,phone_number',
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
            'measurement' => $this->buildStageCollection('measurement', $withCommon, $withUnread, $stageRelations, $techId, $search, $location),
            'design' => $this->buildStageCollection('design', $withCommon, $withUnread, $stageRelations, $techId, $search, $location),
            'production' => $this->buildStageCollection('production', $withCommon, $withUnread, $stageRelations, $techId, $search, $location),
            'installation' => $this->buildStageCollection('installation', $withCommon, $withUnread, $stageRelations, $techId, $search, $location),
        ];
    }

    private function buildStageCollection(
        string $stage,
        array $withCommon,
        callable $withUnread,
        array $stageRelations,
        int $techId,
        ?string $search,
        ?string $location
    ) {
        $relations = $withCommon;
        if (isset($stageRelations[$stage])) {
            $relations[] = $stageRelations[$stage];
        }
        $relations['comments'] = $withUnread;

        $query = Project::with($relations)
            ->where('tech_supervisor_id', $techId)
            ->whereRaw('LOWER(current_stage) = ?', [strtolower($stage)]);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($location) {
            $query->whereRaw('LOWER(location) = ?', [strtolower($location)]);
        }

        return $query->latest()->get();
    }


    // public function getFormData()
    // {
    //     $clients = Client::select('id', 'firstname', 'lastname')->get();
    //     $techSupervisors = User::where('role', 'tech_supervisor')->select('id', 'name')->get();

    //     return response()->json([
    //         'clients' => $clients,
    //         'techSupervisors' => $techSupervisors
    //     ]);
    // }



    public function create()
    {
        return view('admin.ProjectManagement.create');
    }
    public function edit($id)
    {
        return view('admin.ProjectManagement.edit', compact('id'));
    }


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'due_date' => 'required|date',
        'cost' => 'required|numeric',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        // 'admin_name' => 'required|string|max:255',
        'client_id' => 'required|exists:clients,id',
        'tech_supervisor_id' => 'required|exists:users,id',
    ]);

    Project::create([
        'name' => $request->name,
        'due_date' => $request->due_date,
        'cost' => $request->cost,
        'location' => $request->location,
        'description' => $request->description,
        'start_date' => now(), // or any other default value
        // 'admin_name' => $request->admin_id,
        'client_id' => $request->client_id,
        'tech_supervisor_id' => $request->tech_supervisor_id,
        'current_stage' => 'measurement', // if default stage is needed
    ]);

    // return response()->json(['message' => 'Project created']);
    return response()->json(['success' => true]);


}


//looping through table  for records to push to the project blade
public function project_stage()
{
    $measurements = Project::with('measurement')->where('current_stage', 'measurement')->get();
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
