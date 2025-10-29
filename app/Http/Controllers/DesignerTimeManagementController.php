<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerTimeManagementController extends Controller
{
    public function calendarEvents(Request $request)
    {
        $designerId = Auth::id();

        $designs = Design::with(['project.client'])
            ->whereHas('project', function ($query) use ($designerId) {
                $query->where('designer_id', $designerId);
            })
            ->whereNotNull('design_date')
            ->orderBy('design_date')
            ->get();

        $events = $designs->map(function (Design $design) {
            if (! $design->design_date) {
                return null;
            }

            $designDate = $design->design_date instanceof Carbon
                ? $design->design_date
                : Carbon::parse($design->design_date);

            $scheduleDate = $design->schedule_date ? Carbon::parse($design->schedule_date) : null;

            $startTimeLabel = null;
            if ($design->start_time) {
                try {
                    $startTimeLabel = Carbon::createFromFormat('H:i:s', $design->start_time)->format('g:i A');
                } catch (\Throwable $e) {
                    $startTimeLabel = $design->start_time;
                }
            }

            $endTimeLabel = null;
            if ($design->end_time) {
                try {
                    $endTimeLabel = Carbon::createFromFormat('H:i:s', $design->end_time)->format('g:i A');
                } catch (\Throwable $e) {
                    $endTimeLabel = $design->end_time;
                }
            }

            $projectName = $design->project->name ?? 'Project #' . $design->project_id;
            $client = optional($design->project->client);
            $clientName = trim(collect([$client?->title, $client?->firstname, $client?->lastname])->filter()->implode(' '));

            return [
                'id' => $design->id,
                'title' => $projectName,
                'start' => $designDate->toDateString(),
                'allDay' => true,
                'backgroundColor' => '#4F46E5',
                'borderColor' => '#4F46E5',
                'extendedProps' => [
                    'project_name' => $projectName,
                    'client_name' => $clientName !== '' ? $clientName : null,
                    'notes' => $design->notes,
                    'design_date_label' => $designDate->format('M j, Y'),
                    'schedule_date_label' => $scheduleDate?->format('M j, Y'),
                    'start_time_label' => $startTimeLabel,
                    'end_time_label' => $endTimeLabel,
                ],
            ];
        })->filter()->values();

        return response()->json($events);
    }
}
