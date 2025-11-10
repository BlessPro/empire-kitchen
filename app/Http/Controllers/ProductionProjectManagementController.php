<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;

class ProductionProjectManagementController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stageData = $this->loadStageData($userId);

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

        return view('production.ProjectManagement', [
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

    private function loadStageData(int $userId, ?string $search = null, ?string $location = null): array
    {
        $withUnreadComments = function ($query) use ($userId) {
            $query->withCount([
                'views as unread_by_admin' => function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
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
}
