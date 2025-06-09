<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design;

class DesignerTimeManagementController extends Controller
{


public function calendarEvents()
{
    $designs = Design::with('project')->get();

    $events = $designs->map(function ($design) {
        return [
            'title' => $design->project->name ?? 'No Project',
            'start' => $design->created_at,
            'end' => $design->design_date,
            'extendedProps' => [
                'notes' => $design->notes,
                'design_date' => $design->design_date,
                'project_name' => $design->project->name ?? 'No Project',
            ]
        ];
    });

    return response()->json($events);
}




// public function calendarEvents()
// {
//     $designs = Design::with('project')->get();
//     $events = $designs->map(function ($design) {
//         return [
//             'title' => $design->project->name ?? 'No Project',
//             'start' => $design->schedule_date,
//             'end' => $design->schedule_date, // FullCalendar needs both for some views
//             'extendedProps' => [
//                 'notes' => $design->notes,
//                 'design_date' => $design->design_date,
//                 'project_name' => $design->project->name ?? 'No Project',
//             ]
//         ];
//     });

//     return response()->json($events);
// }




}



