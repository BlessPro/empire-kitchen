<?php

namespace App\Support;

use App\Models\PhaseTemplate;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectPhase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectViewBuilder
{
    /**
     * Build the normalized project view model used by the shared project info partial.
     */
    public static function build(Project $project, Request $request): array
    {
        // Load everything we need (avoid N+1s)
        $project->load([
            'client',
            'products.accessories' => function ($q) {
                $q->withPivot(['size', 'type', 'quantity', 'notes']);
            },
            'projectPhases',
            'designs:id,project_id,images',
            'measurements:id,project_id,images',
        ]);

        $allProducts = $project->products->sortBy('id')->values();
        $selectedId  = (int) $request->query('product_id', optional($allProducts->first())->id);
        $selected    = $allProducts->firstWhere('id', $selectedId) ?? $allProducts->first();

        $currentProductType = optional($selected)->product_type; // can be null
        $templates = PhaseTemplate::query()
            ->where('is_active', 1)
            // ->when($currentProductType, fn($q, $pt) => $q->where('product_type', $pt))
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

        // Progress (based on templates shown)
        $total = $templates->count();
        $done  = $phases->where('done', true)->count();
        $pct   = $total > 0 ? (int) round(($done / $total) * 100) : 0;

        // --- ACCESSORIES: from selected product (product_accessory pivot), or [] ---
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

        // ---------- Helpers ----------
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
                        'name'               => basename($p),
                        'url'                => $url,
                        'download_url'       => $url, // swap to a dedicated download route if you have one
                        'thumb_url'          => $url, // good enough for images
                        'uploaded_at_label'  => $uploadedAt ? Carbon::parse($uploadedAt)->format('n/j/y') : null,
                        'size_label'         => null, // fill later if you track sizes
                    ];
                })->values()->all();
        };
        // ---------- /Helpers ----------

        // --- MEDIA: project-level, split into Measurements & Designs (normalized items) ---
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

        // --- PRODUCT SWITCHER payload (names)
        $switcher = $allProducts->map(function ($p) use ($selected) {
            return [
                'id'           => (int) $p->id,
                'name'         => $p->name ?: ('Product #' . $p->id),
                'product_type' => $p->product_type,
                'active'       => $selected && $p->id === $selected->id,
            ];
        })->all();

        $sel = $selected; // alias

        $vm = (object) [
            'id' => (int) $project->id,
            // Header
            'name'          => $project->name ?? '�?"',
            'install_date'  => ($sel?->installed_at
                ? $sel->installed_at->toDateString()
                : ($project->due_date ? $project->due_date->toDateString() : null)), // Blade should show 'TBD' if null
            'client_name'   => trim(implode(' ', array_filter([
                $project->client->title ?? null,
                $project->client->firstname ?? null,
                $project->client->lastname ?? null,
            ]))) ?: '�?"',
            'location_text' => $project->location ?? '�?"',

            // Project-level phases (and meta for progress UI)
            'phases'      => $phases->all(),
            'phases_meta' => [
                'total'        => $total,
                'done'         => $done,
                'pct'          => $pct,
                'product_type' => $currentProductType,
            ],

            // Product switcher
            'products'     => $switcher,

            // Product-driven sections
            'selected_product_type' => $sel->product_type ?? '�?"',

            'productTypes'  => [$sel->product_type ?? '�?"'],
            'finish'        => [
                'label'     => $sel->type_of_finish ?? '�?"',
                'color'     => $sel->finish_color_hex ?? null,
                'image_url' => $toUrl($sel->sample_finish_image_path ?? null),
            ],
            'glass_door_type' => $sel->glass_door_type ?? '�?"',
            'worktop'       => [
                'label'         => $sel->worktop_type ?? '�?"',
                'color'         => $sel->worktop_color_hex ?? null,
                'thumbnail_url' => $sel->sample_worktop_image_path ?? null,
                'image_url'     => $toUrl($sel->sample_worktop_image_path ?? null),
            ],
            'sink_tap'      => [
                'bowl'      => $sel->sink_top_type ?? '�?"',
                'color'     => $sel->sink_color_hex ?? null,
                'handle'    => $sel->handle ?? '�?"',
                'image_url' => $toUrl($sel->sample_sink_image_path ?? null),
            ],

            // Accessories (UI says "Appliances")
            'appliances' => $appliances,

            // Media �?" project-level buckets (normalized items)
            'media' => [
                'measurement' => $measurementMedia,
                'designs'     => $designMedia,
            ],

            // Meta
            '__meta' => [
                'project_id' => (int) $project->id,
            ],
        ];

        return ['project' => $vm];
    }
}
