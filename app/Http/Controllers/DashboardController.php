<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Gate;
//created on 2025-04-23
// app/Http/Controllers/ProjectController.php

class DashboardController extends Controller
{
    //

    // public function index()
    // {
    //     $projects = Project::latest()->take(5)->get(); // or however many you want

    //     return view('admin.bick', compact('projects'));
    // }

    // public function dashboard()
    // {
    //     $latestProjectWithAllDates = Project::whereNotNull('measurement_date')
    //         ->whereNotNull('design_date')
    //         ->whereNotNull('installation_date')
    //         ->whereNotNull('production_date')
    //         ->latest()
    //         ->first();

    //     $projects = Project::with('client')->get();

    //     return view('admin.bick', compact('latestProjectWithAllDates', 'projects'));

    // }

    public function index()
{
    $projects = Project::paginate(10); // fetch paginated projects
    return view('admin.Dashboard', compact('projects'));
}


public function filter(Request $request)
{
    $status = $request->query('status');
    $projects = Project::query();

    switch ($status) {
        case 'pending':
            $projects->where('status', 'pending');
            break;
        case 'ongoing':
            $projects->where('status', 'ongoing');
            break;
        case 'completed':
            $projects->where('status', 'completed');
            break;
        case 'all':
        default:
            // no filter
            break;
    }

    $projects = $projects->latest()->get();

    return view('partials.projects-table', compact('projects'))->render();
}

    public function metrics(Request $request)
    {
        $rangeInput = $request->query('range', 'this_month');
        [$start, $end, $normalizedRange] = $this->resolveRange($rangeInput);

        $clientsQuery = Client::query();
        $projectsQuery = Project::query();
        $bookingsQuery = Project::query()->where('booked_status', 'BOOKED');

        if ($start && $end) {
            $clientsQuery->whereBetween('created_at', [$start, $end]);
            $projectsQuery->whereBetween('created_at', [$start, $end]);
            $bookingsQuery->whereBetween('updated_at', [$start, $end]);
        } elseif ($start) {
            $clientsQuery->where('created_at', '>=', $start);
            $projectsQuery->where('created_at', '>=', $start);
            $bookingsQuery->where('updated_at', '>=', $start);
        } elseif ($end) {
            $clientsQuery->where('created_at', '<=', $end);
            $projectsQuery->where('created_at', '<=', $end);
            $bookingsQuery->where('updated_at', '<=', $end);
        }

        $counts = [
            'clients'  => $clientsQuery->count(),
            'projects' => $projectsQuery->count(),
            'bookings' => $bookingsQuery->count(),
        ];

        return response()->json([
            'range'  => $normalizedRange,
            'start'  => $start?->toIso8601String(),
            'end'    => $end?->toIso8601String(),
            'counts' => $counts,
        ]);
    }

    public function pipeline()
    {
        $stageConfig = [
            'MEASUREMENT'  => ['label' => 'Measurement',  'color' => '#f97316'],
            'DESIGN'       => ['label' => 'Design',       'color' => '#2563eb'],
            'PRODUCTION'   => ['label' => 'Production',   'color' => '#f59e0b'],
            'INSTALLATION' => ['label' => 'Installation', 'color' => '#16a34a'],
        ];

        $stageCounts = Project::query()
            ->selectRaw('UPPER(COALESCE(current_stage, \'\')) as stage')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('stage')
            ->pluck('total', 'stage');

        $labels = [];
        $data   = [];
        $colors = [];

        foreach ($stageConfig as $stage => $meta) {
            $labels[] = $meta['label'];
            $data[]   = (int) ($stageCounts[$stage] ?? 0);
            $colors[] = $meta['color'];
            unset($stageCounts[$stage]);
        }

        $unassignedTotal = (int) ($stageCounts[''] ?? 0);

        $remaining = collect($stageCounts)
            ->forget('')
            ->filter();

        if ($remaining->isNotEmpty()) {
            $remaining->each(function ($count, $stage) use (&$labels, &$data, &$colors) {
                $labels[] = ucwords(strtolower(str_replace('_', ' ', $stage)));
                $data[]   = (int) $count;
                $colors[] = '#9ca3af';
            });
        }

        if ($unassignedTotal > 0) {
            $labels[] = 'Not Assigned';
            $data[]   = $unassignedTotal;
            $colors[] = '#d1d5db';
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'colors' => $colors,
            'total'  => array_sum($data),
        ]);
    }

    /**
     * Determine the start and end dates for the given range.
     *
     * @return array{0: ?Carbon, 1: ?Carbon, 2: string}
     */
    private function resolveRange(string $range): array
    {
        $now = Carbon::now();
        $normalized = match ($range) {
            '7days', '7_days', 'seven_days'            => '7days',
            'this_month', 'month', 'current_month'     => 'this_month',
            '3months', 'three_months'                  => '3months',
            '6months', 'six_months'                    => '6months',
            'year_to_date', 'ytd'                      => 'year_to_date',
            'last_year', 'previous_year'               => 'last_year',
            'all_time', 'lifetime', 'alltime'          => 'all_time',
            default                                    => 'this_month',
        };

        return match ($normalized) {
            '7days' => [
                $now->copy()->subDays(6)->startOfDay(),
                $now->copy()->endOfDay(),
                $normalized,
            ],
            'this_month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfDay(),
                $normalized,
            ],
            '3months' => [
                $now->copy()->subMonthsNoOverflow(3)->startOfDay(),
                $now->copy()->endOfDay(),
                $normalized,
            ],
            '6months' => [
                $now->copy()->subMonthsNoOverflow(6)->startOfDay(),
                $now->copy()->endOfDay(),
                $normalized,
            ],
            'year_to_date' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfDay(),
                $normalized,
            ],
            'last_year' => [
                $now->copy()->subYear()->startOfYear(),
                $now->copy()->subYear()->endOfYear(),
                $normalized,
            ],
            'all_time' => [null, null, $normalized],
        };
    }

}
