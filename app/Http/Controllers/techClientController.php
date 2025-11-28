<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use app\Models\Measurement;
use App\Models\Installation;
use App\Models\Design;
use App\Models\Comment;
use App\Models\PhaseTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class techClientController extends Controller
{
public function updateStatus(Request $request, Project $project)
{
    $request->validate([
        'status' => 'required|in:completed,pending,in progress,cancelled',
    ]);

    $project->status = $request->status;
    $project->save();

    return response()->json(['success' => true, 'message' => 'Status updated']);
}


public function clientProjects()
{
    $techSupervisorId = Auth::id(); // Get logged-in user's ID

    $clients = Client::whereHas('projects', function ($query) use ($techSupervisorId) {
        $query->where('tech_supervisor_id', $techSupervisorId); // only filter by supervisor
    })
    ->with(['projects' => function ($query) use ($techSupervisorId) {
        $query->where('tech_supervisor_id', $techSupervisorId)
              ->with('measurement'); // include measurement relationship
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(5); // Paginate the results

    return view('tech.ClientManagement', compact('clients'));
}


public function showProjectInfo(Project $project)
{
    $project = $this->buildProjectViewModel(request(), $project);
    return view('tech.ClientManagement.projectInfo', compact('project'));
}

public function showProjectname(Project $project)
{
    $project = $this->buildProjectViewModel(request(), $project);
    return view('tech.ClientManagement.projectInfo', compact('project'));
}

public function updateDueDate(Request $request, Project $project)
{
    $request->validate([
        'due_date' => 'required|date',
    ]);

    $project->due_date = $request->due_date;
    $project->save();

    return response()->json(['success' => true]);
}

    /**
     * Hydrate project with the same view-model data used by admin project info.
     */
    protected function buildProjectViewModel(Request $request, Project $project): Project
    {
        $project->load([
            'client',
            'products.accessories' => function ($q) {
                $q->withPivot(['size', 'type', 'quantity', 'notes']);
            },
            'projectPhases',
            'designs:id,project_id,images,created_at',
            'measurements:id,project_id,images,created_at',
            'comments.user',
        ]);

        $allProducts = $project->products->sortBy('id')->values();
        $selectedId  = (int) $request->query('product_id', optional($allProducts->first())->id);
        $selected    = $allProducts->firstWhere('id', $selectedId) ?? $allProducts->first();

        // Phase templates + current state
        $templates = PhaseTemplate::query()
            ->where('is_active', 1)
            ->orderBy('default_sort_order')
            ->get(['id', 'name', 'default_sort_order']);

        $rowsByTemplateId = $project->projectPhases->keyBy('phase_template_id');

        $phases = $templates->map(function ($tpl) use ($rowsByTemplateId) {
            $row = $rowsByTemplateId->get($tpl->id);
            return [
                'template_id'      => $tpl->id,
                'name'             => $tpl->name,
                'sort_order'       => $row->sort_order ?? $tpl->default_sort_order,
                'done'             => (bool) ($row->is_checked ?? false),
                'project_phase_id' => optional($row)->id,
            ];
        })->values();

        $total = $templates->count();
        $done  = $phases->where('done', true)->count();
        $pct   = $total > 0 ? (int) round(($done / $total) * 100) : 0;

        // Accessories (appliances) for selected product
        $appliances = optional($selected)->accessories?->map(function ($a) {
            return [
                'id'       => $a->id,
                'name'     => $a->name ?? 'Accessory',
                'size'     => $a->pivot->size ?? null,
                'type'     => $a->pivot->type ?? null,
                'quantity' => $a->pivot->quantity ?? null,
                'notes'    => $a->pivot->notes ?? null,
            ];
        })->values()->all() ?? [];

        $toUrl = function (?string $path) {
            if (!$path) return null;
            return Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : Storage::url($path);
        };

        $mapFiles = function ($paths, $uploadedAt = null) use ($toUrl) {
            return collect($paths ?? [])
                ->filter()
                ->map(function ($p) use ($toUrl, $uploadedAt) {
                    $url = $toUrl($p);
                    return [
                        'name'              => basename($p),
                        'url'               => $url,
                        'download_url'      => $url,
                        'thumb_url'         => $url,
                        'uploaded_at_label' => $uploadedAt ? Carbon::parse($uploadedAt)->format('n/j/y') : null,
                        'size_label'        => null,
                    ];
                })->values()->all();
        };

        $measurementMedia = $project->measurements
            ->flatMap(function ($m) use ($mapFiles) {
                return $mapFiles($m->images ?? [], $m->created_at ?? null);
            })
            ->values()->all();

        $designMedia = $project->designs
            ->flatMap(function ($d) use ($mapFiles) {
                return $mapFiles($d->images ?? [], $d->created_at ?? null);
            })
            ->values()->all();

        // Build per-product switcher payload (mark active)
        $project->products = $allProducts->map(function ($p) use ($selected) {
            return [
                'id'           => (int) $p->id,
                'name'         => $p->name ?: ('Product #' . $p->id),
                'product_type' => $p->product_type,
                'active'       => $selected && $p->id === $selected->id,
            ];
        });

        // Normalize finish/worktop/sink taps from selected product (if exists)
        $project->finish = [
            'label'     => optional($selected)->type_of_finish,
            'color'     => optional($selected)->finish_color_hex,
            'image_url' => $toUrl(optional($selected)->sample_finish_image_path),
        ];

        $project->worktop = [
            'label'     => optional($selected)->worktop_type,
            'color'     => optional($selected)->worktop_color_hex,
            'image_url' => $toUrl(optional($selected)->sample_worktop_image_path),
        ];

        $project->glass_door_type = optional($selected)->glass_door_type;

        $project->sink_tap = [
            'bowl'      => optional($selected)->sink_top_type,
            'handle'    => optional($selected)->handle,
            'color'     => optional($selected)->sink_color_hex,
            'image_url' => $toUrl(optional($selected)->sample_sink_image_path),
        ];

        $project->appliances = $appliances;
        $project->media = [
            'measurement' => $measurementMedia,
            'designs'     => $designMedia,
        ];
        $project->selected_product_type = optional($selected)->product_type ?? '—';
        $project->phases      = $phases;
        $project->phases_meta = [
            'total'        => $total,
            'done'         => $done,
            'pct'          => $pct,
            'product_type' => optional($selected)->product_type,
        ];

        return $project;
    }


}
