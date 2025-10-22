<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Product;
use App\Models\PhaseTemplate;
use App\Models\ProjectPhase;
use Carbon\Carbon;
use Illuminate\Support\Str;                  // ★ NEW
use Illuminate\Support\Facades\Schema;       // ★ NEW
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
 use App\Models\Accessory;
use Illuminate\Validation\Rule;
use App\Models\AccessoryType;
use App\Models\Comment;
use App\Models\CommentView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // --- IGNORE ---
use Illuminate\Support\Facades\Storage;      // ★ NEW


//created on 2025-04-23
// app/Http/Controllers/ProjectController.php
class ProjectController extends Controller
{
    use AuthorizesRequests;

//     public function index()

// {
//     $projects = Project::paginate(15); // fetch paginated projects

//     return view('admin/ProjectManagement', compact('projects'));
// }



public function show(Request $request, Project $project)
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

    // --- Resolve selected product (via ?product_id=, else first) ---
    $allProducts = $project->products->sortBy('id')->values();
    $selectedId  = (int) $request->query('product_id', optional($allProducts->first())->id);
    $selected    = $allProducts->firstWhere('id', $selectedId) ?? $allProducts->first();

    // --- PHASES: from phase_templates (active), overlay project_phases state ---
    $currentProductType = optional($selected)->product_type; // can be null
    $templates = PhaseTemplate::query()
        ->where('is_active', 1)
        // ->when($currentProductType, fn($q, $pt) => $q->where('product_type', $pt))
        ->orderBy('default_sort_order')
        ->get(['id','name','default_sort_order']);

    $rowsByTemplateId = $project->projectPhases->keyBy('phase_template_id');

    $phases = $templates->map(function ($tpl) use ($rowsByTemplateId) {
        $row = $rowsByTemplateId->get($tpl->id);
        return [
            'template_id'      => $tpl->id,
            'name'             => $tpl->name,
            'sort_order'       => $row->sort_order ?? $tpl->default_sort_order,
            'done'             => (bool)($row->is_checked ?? false),
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

    // ---------- ★ NEW helpers ----------
    $toUrl = function (?string $path) {
        if (!$path) return null;
        return Str::startsWith($path, ['http://','https://'])
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
    // ---------- ★ /helpers ----------

    // --- MEDIA: project-level, split into Measurements & Designs (★ normalized items) ---
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
            'name'         => $p->name ?: ('Product #'.$p->id),
            'product_type' => $p->product_type,
            'active'       => $selected && $p->id === $selected->id,
        ];
    })->all();

    // --- Build the View Model (ALWAYS provide all keys your Blade reads) ---
    $sel = $selected; // alias

    $vm = (object) [

        'id' => (int) $project->id,
        // Header
        'name'          => $project->name ?? '—',
        'install_date'  => ($sel?->installed_at
                                ? $sel->installed_at->toDateString()
                                : ($project->due_date ? $project->due_date->toDateString() : null)), // Blade should show 'TBD' if null
        'client_name'   => trim(implode(' ', array_filter([
                              $project->client->title ?? null,
                              $project->client->firstname ?? null,
                              $project->client->lastname ?? null,
                          ]))) ?: '—',
        'location_text' => $project->location ?? '—',

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

        // ---------- ★ Product-driven sections (adds image_url; keeps your existing keys) ----------
        'selected_product_type' => $sel->product_type ?? '—', // ← single string for the chip

        'productTypes'  => [ $sel->product_type ?? '—' ], // keep for backward-compat if you still loop this
        'finish'        => [
            'label'     => $sel->type_of_finish ?? '—',
            'color'     => $sel->finish_color_hex ?? null,
            'image_url' => $toUrl($sel->sample_finish_image_path ?? null), // ← NEW
        ],
        'glass_door_type' => $sel->glass_door_type ?? '—',
        'worktop'       => [
            'label'         => $sel->worktop_type ?? '—',
            'color'         => $sel->worktop_color_hex ?? null,
            'thumbnail_url' => $sel->sample_worktop_image_path ?? null,      // keep existing
            'image_url'     => $toUrl($sel->sample_worktop_image_path ?? null), // ← NEW normalized URL
        ],
        'sink_tap'      => [
            'bowl'      => $sel->sink_top_type ?? '—',
            'color'     => $sel->sink_color_hex ?? null,
            'handle'    => $sel->handle ?? '—',
            'image_url' => $toUrl($sel->sample_sink_image_path ?? null), // ← NEW
        ],
        // ---------- ★ /Product-driven ----------

        // Accessories (UI says "Appliances")
        'appliances' => $appliances,

        // Media — project-level buckets (★ normalized items)
        'media' => [
            'measurement' => $measurementMedia,
            'designs'     => $designMedia,
        ],

        // Meta
        '__meta' => [
            'project_id' => (int) $project->id,
        ],
    ];

    return view('admin.projectInfo', ['project' => $vm]);
}



public function updateType(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_type' => ['required','string','max:100'],
        ]);

        $product->update(['product_type' => $data['product_type']]);

        return response()->json([
            'ok'           => true,
            'product_type' => $product->product_type,
            'product_id'   => (int) $product->id,
        ]);
    }
// app/Http/Controllers/Admin/ProjectController.php

public function updateProductFinish(Request $request, Product $product)
    {
        $data = $request->validate([
            'type_of_finish'         => ['required','string','max:100'],
            'finish_color_hex'       => ['nullable','regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'sample_finish_image'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB
        ]);

        // Handle image upload if present
        $path = $product->sample_finish_image_path;
        if ($request->hasFile('sample_finish_image')) {
            $path = $request->file('sample_finish_image')
                ->store('products/finishes', 'public'); // ensure public disk is configured
        }

        $product->update([
            'type_of_finish'            => $data['type_of_finish'],
            'finish_color_hex'          => $data['finish_color_hex'] ?? null,
            'sample_finish_image_path'  => $path,
        ]);

        // Normalize URL for immediate UI update
        $imageUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : null;

        return response()->json([
            'ok'         => true,
            'product_id' => (int) $product->id,
            'finish'     => [
                'label'     => $product->type_of_finish ?? '—',
                'color'     => $product->finish_color_hex ?? null,
                'image_url' => $imageUrl,
            ],
        ]);
    }

    public function updateProductGlassDoor(Request $request, Product $product)
    {
        // If you have a fixed set, replace with Rule::in([...])
        $data = $request->validate([
            'glass_door_type' => ['required','string','max:100'],
        ]);

        $product->update(['glass_door_type' => $data['glass_door_type']]);

        return response()->json([
            'ok'              => true,
            'product_id'      => (int) $product->id,
            'glass_door_type' => $product->glass_door_type ?? '—',
        ]);
    }


     public function updateProductWorktop(Request $request, Product $product)
    {
        $data = $request->validate([
            'worktop_type'            => ['required','string','max:100'],
            'worktop_color_hex'       => ['nullable','regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'sample_worktop_image'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        // handle image upload if provided
        $path = $product->sample_worktop_image_path;
        if ($request->hasFile('sample_worktop_image')) {
            $path = $request->file('sample_worktop_image')->store('products/worktops', 'public');
        }

        $product->update([
            'worktop_type'             => $data['worktop_type'],
            'worktop_color_hex'        => $data['worktop_color_hex'] ?? null,
            'sample_worktop_image_path'=> $path,
        ]);

        // normalize URL for live UI update
        $imageUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : null;

        return response()->json([
            'ok'         => true,
            'product_id' => (int) $product->id,
            'worktop'    => [
                'label'     => $product->worktop_type ?? '—',
                'color'     => $product->worktop_color_hex ?? null,
                'image_url' => $imageUrl,
            ],
        ]);
    }

public function updateProductSinkTap(Request $request, Product $product)
    {
        $data = $request->validate([
            'sink_top_type'      => ['required','string','max:100'],
            'handle'             => ['required','string','max:100'],
            'sink_color_hex'     => ['nullable','regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'sample_sink_image'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        // upload image if provided
        $path = $product->sample_sink_image_path;
        if ($request->hasFile('sample_sink_image')) {
            $path = $request->file('sample_sink_image')->store('products/sinks', 'public');
        }

        $product->update([
            'sink_top_type'           => $data['sink_top_type'],
            'handle'                  => $data['handle'],
            'sink_color_hex'          => $data['sink_color_hex'] ?? null,
            'sample_sink_image_path'  => $path,
        ]);

        $imageUrl = $path
            ? (Str::startsWith($path, ['http://','https://']) ? $path : Storage::url($path))
            : null;

        return response()->json([
            'ok'         => true,
            'product_id' => (int) $product->id,
            'sink_tap'   => [
                'bowl'      => $product->sink_top_type ?? '—',
                'handle'    => $product->handle ?? '—',
                'color'     => $product->sink_color_hex ?? null,
                'image_url' => $imageUrl,
            ],
        ]);
    }


public function togglePhase(Request $request, Project $project, PhaseTemplate $template)
{
    $data = $request->validate([
        'checked' => ['required','boolean'],
    ]);

    ProjectPhase::updateOrCreate(
        ['project_id' => $project->id, 'phase_template_id' => $template->id],
        [
            'is_checked' => (bool) $data['checked'],
            'checked_by' => $request->user()?->id,
            'checked_at' => now(),
        ]
    );

    // project-level denominator (no product filter)
    $templateIds = PhaseTemplate::where('is_active', 1)->pluck('id');
    $total = $templateIds->count();

    $done = ProjectPhase::where('project_id', $project->id)
        ->where('is_checked', 1)
        ->whereIn('phase_template_id', $templateIds)
        ->count();

    $pct = $total > 0 ? (int) round(($done / $total) * 100) : 0;

    return response()->json(['done'=>$done,'total'=>$total,'pct'=>$pct]);
}




    /**
     * Return data to boot Edit/Add modals:
     * - items: current product->accessories (pivot payload)
     * - catalog: all accessories (id, name)
     * - types: { accessory_id: [values...] }
     * - sizes: fixed list (UI select)
     */
    public function listProductAccessories(Product $product)
    {
        // Existing attached items (for Edit modal / optional for Add)
        $items = $product->accessories
            ->map(function ($a) {
                return [
                    'accessory_id' => (int) $a->id,
                    'name'         => (string) ($a->name ?? 'Accessory'),
                    'size'         => $a->pivot->size ?? null,
                    'type'         => $a->pivot->type ?? null,
                    'quantity'     => is_null($a->pivot->quantity) ? null : (int) $a->pivot->quantity,
                    'notes'        => $a->pivot->notes ?? null,
                ];
            })->values()->all();

        // Catalog (names only)
        $catalog = Accessory::query()
            ->orderBy('name')
            ->get(['id','name'])
            ->map(fn($a) => ['id' => (int)$a->id, 'name' => (string)$a->name])
            ->values()->all();

        // Types by accessory_id
        $types = AccessoryType::query()
            ->select(['accessory_id','value'])
            ->get()
            ->groupBy('accessory_id')
            ->map(fn($g) => $g->pluck('value')->values()->all())
            ->all();

        // Fixed sizes list (not DB-backed)
        $sizes = [
            '45cm x 40cm','50cm x 70cm','54cm x 40cm',
            '60cm x 66cm','70cm x 34cm','80cm x 55cm','90cm x 88cm'
        ];

        return response()->json([
            'ok'      => true,
            'items'   => $items,
            'catalog' => $catalog,
            'types'   => $types,
            'sizes'   => $sizes,
        ]);
    }

    /**
     * BULK update/delete existing product accessories (Edit modal).
     * Payload: { items: [{ accessory_id, size?, type?, quantity?, notes?, _deleted?bool }] }
     */
    public function bulkUpdateProductAccessories(Request $request, Product $product)
{
    $pid = $product->getKey(); // capture the ID, not the model

    $data = $request->validate([
        'items'                => ['required','array'],
        'items.*.accessory_id' => ['required','integer', Rule::exists('accessories','id')],
        'items.*.size'         => ['nullable','string','max:100'],
        'items.*.type'         => ['nullable','string','max:100'],
        'items.*.quantity'     => ['nullable','integer','min:0'],
        'items.*.notes'        => ['nullable','string','max:500'],
        'items.*._deleted'     => ['sometimes','boolean'],
    ]);

    // Validate type membership if accessory defines types
    $ids = collect($data['items'])->pluck('accessory_id')->unique()->all();
    $typeMap = AccessoryType::whereIn('accessory_id', $ids)->get()
        ->groupBy('accessory_id')
        ->map(fn($g) => $g->pluck('value')->all())
        ->all();

    foreach ($data['items'] as $row) {
        $allowed = $typeMap[$row['accessory_id']] ?? [];
        if (!empty($allowed) && !empty($row['type']) && !in_array($row['type'], $allowed, true)) {
            return response()->json(['ok' => false, 'message' => 'Invalid type for the selected accessory.'], 422);
        }
    }

    DB::transaction(function () use ($pid, $data) {
        $pivot = DB::table('product_accessories');

        foreach ($data['items'] as $row) {
            $aid   = (int) $row['accessory_id'];
            $where = ['product_id' => $pid, 'accessory_id' => $aid];

            if (!empty($row['_deleted'])) {
                $pivot->where($where)->delete();
                continue;
            }

            // Only update rows that exist; (this edit modal is not for creating new links)
            $exists = $pivot->where($where)->exists();

            if ($exists) {
                $payload = [
                    'size'       => $row['size']     ?? null,
                    'type'       => $row['type']     ?? null,
                    'quantity'   => $row['quantity'] ?? null,
                    'notes'      => $row['notes']    ?? null,
                    'updated_at' => now(),
                ];
                $pivot->where($where)->update($payload);
            }
        }
    });

    // Return fresh list to rebuild the front grid
    $fresh = Product::with('accessories')->findOrFail($pid)
        ->accessories->map(function ($a) {
            return [
                'accessory_id' => (int) $a->id,
                'name'         => (string) ($a->name ?? 'Accessory'),
                'size'         => $a->pivot->size ?? null,
                'type'         => $a->pivot->type ?? null,
                'quantity'     => is_null($a->pivot->quantity) ? null : (int) $a->pivot->quantity,
                'notes'        => $a->pivot->notes ?? null,
            ];
        })->values()->all();

    return response()->json(['ok' => true, 'items' => $fresh]);
}

    /**
     * ATTACH new accessories to product (Add modal).
     * Payload: { items: [{ accessory_id, size(required from fixed list), type?, quantity?, notes? }] }
     */
    public function attachProductAccessories(Request $request, Product $product)
    {
        $sizes = [
            '45cm x 40cm','50cm x 70cm','54cm x 40cm',
            '60cm x 66cm','70cm x 34cm','80cm x 55cm','90cm x 88cm'
        ];

        $data = $request->validate([
            'items'                => ['required','array','min:1'],
            'items.*.accessory_id' => ['required','integer', Rule::exists('accessories','id')],
            'items.*.size'         => ['required','string', Rule::in($sizes)],
            'items.*.type'         => ['nullable','string','max:100'],
            'items.*.quantity'     => ['nullable','integer','min:0'],
            'items.*.notes'        => ['nullable','string','max:500'],
        ]);

        $ids     = collect($data['items'])->pluck('accessory_id')->unique()->all();
        $typeMap = AccessoryType::whereIn('accessory_id', $ids)->get()
            ->groupBy('accessory_id')->map(fn($g) => $g->pluck('value')->all())->all();

        foreach ($data['items'] as $row) {
            $allowed = $typeMap[$row['accessory_id']] ?? [];
            if (!empty($allowed)) {
                if (empty($row['type']) || !in_array($row['type'], $allowed, true)) {
                    return response()->json(['ok'=>false,'message'=>'Invalid or missing type for the selected accessory.'], 422);
                }
            }
        }

        DB::transaction(function () use ($product, $data) {
            foreach ($data['items'] as $row) {
                $payload = [
                    'size'     => $row['size'],
                    'type'     => $row['type'] ?? null,
                    'quantity' => $row['quantity'] ?? null,
                    'notes'    => $row['notes'] ?? null,
                ];
                $exists = $product->accessories()->where('accessory_id', $row['accessory_id'])->exists();
                $exists
                    ? $product->accessories()->updateExistingPivot($row['accessory_id'], $payload, true)
                    : $product->accessories()->attach($row['accessory_id'], $payload);
            }
        });

        $fresh = $product->fresh('accessories')->accessories->map(function ($a) {
            return [
                'accessory_id' => (int) $a->id,
                'name'         => (string) ($a->name ?? 'Accessory'),
                'size'         => $a->pivot->size ?? null,
                'type'         => $a->pivot->type ?? null,
                'quantity'     => is_null($a->pivot->quantity) ? null : (int) $a->pivot->quantity,
                'notes'        => $a->pivot->notes ?? null,
            ];
        })->values()->all();

        return response()->json(['ok'=>true,'items'=>$fresh]);
    }

    /**
     * Create a new accessory + optional type options (csv).
     * Payload: { name, types_csv? }
     * Returns: { id, name, types[] }
     */
    public function Accstore(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required','string','max:150', Rule::unique('accessories','name')],
            'types_csv' => ['nullable','string','max:500'],
        ]);

        $acc = Accessory::create([
            'name'       => $data['name'],
            'category'   => null,
            'length_mm'  => null,
            'width_mm'   => null,
            'height_mm'  => null,
            'diameter_mm'=> null,
            'size'       => null,
            'notes'      => null,
            'is_active'  => true,
        ]);

        $types = collect(preg_split('/\s*,\s*/', $data['types_csv'] ?? '', -1, PREG_SPLIT_NO_EMPTY))
            ->unique()->values()->all();

        if (!empty($types)) {
            foreach ($types as $t) {
                AccessoryType::firstOrCreate([
                    'accessory_id' => $acc->id,
                    'value'        => $t
                ]);
            }
        }

        return response()->json([
            'id'    => $acc->id,
            'name'  => $acc->name,
            'types' => $types,
        ]);
    }


// GET /projects/{project}/comments?limit=25&after_id=&before_id=
    public function index(Request $request, Project $project)
    {

        $this->authorize('view', $project);

        $limit    = (int) min(max($request->integer('limit', 25), 1), 100);
        $afterId  = $request->integer('after_id');
        $beforeId = $request->integer('before_id');

        $q = Comment::with([
                'user:id,name,employee_id,profile_pic,role',
                'user.employee:id,user_id,full_name,photo_path'
            ])
            ->where('project_id', $project->id)
            ->when($afterId,  fn($qq) => $qq->where('id', '>', $afterId))
            ->when($beforeId, fn($qq) => $qq->where('id', '<', $beforeId))
            ->orderBy('id', 'asc'); // stable append

        // For initial load (no after/before), return latest page
        if (!$afterId && !$beforeId) {
            $lastId = Comment::where('project_id', $project->id)->max('id');
            // If there are many, fetch the last N efficiently
            $q->when($lastId, fn($qq) => $qq->where('id', '>', max(0, $lastId - 1000))); // soft window
        }

        $rows = $q->limit($limit)->get();

        // compute has_more flags
        $hasMoreBefore = false;
        $hasMoreAfter  = false;
        if ($rows->count()) {
            $minId = $rows->min('id');
            $maxId = $rows->max('id');
            $hasMoreBefore = Comment::where('project_id', $project->id)->where('id','<',$minId)->exists();
            $hasMoreAfter  = Comment::where('project_id', $project->id)->where('id','>',$maxId)->exists();
        }

        $me = Auth::id();
        $payload = $rows->map(fn($c) => $this->serialize($c, $me));

        return response()->json([
            'ok' => true,
            'comments' => $payload,
            'has_more_before' => $hasMoreBefore,
            'has_more_after'  => $hasMoreAfter,
        ]);
    }

    // POST /projects/{project}/comments
    public function store_old(Request $request, Project $project)
    {
        $this->authorize('view', $project); // or dedicated policy 'comment'

        $data = $request->validate([
            'comment' => ['required','string','max:5000'],
        ]);

        $c = Comment::create([
            'project_id' => $project->id,
            'user_id'    => Auth::id(),
            'comment'    => $data['comment'],
        ])->load([
            'user:id,name,employee_id,profile_pic,role',
            'user.employee:id,user_id,full_name,photo_path'
        ]);

        // Mark the author's own comment as seen by them
        CommentView::firstOrCreate([
            'comment_id' => $c->id,
            'user_id'    => Auth::id(),
        ]);

        return response()->json(['ok'=>true,'comment'=>$this->serialize($c, Auth::id())], 201);
    }

    public function store(Request $request, Project $project)
{
    $this->authorize('update', $project);

    $request->validate([
        'comment' => 'required|string|max:2000',
    ]);

    $comment = new Comment();
    $comment->project_id = $project->id;
    $comment->user_id = Auth::id();
    $comment->body = $request->input('comment');
    $comment->save();

    // load user relationship so Alpine gets user details
    $comment->load(['user:id,name,profile_pic,role']);

    // return structured payload
    return response()->json([
        'ok' => true,
        'comment' => [
            'id'         => $comment->id,
            'body'       => $comment->body,
            'created_at' => $comment->created_at->toISOString(),
            'user'       => [
                'id'     => $comment->user->id,
                'name'   => $comment->user->name,
                'avatar' => $comment->user->profile_pic ? asset('storage/'.$comment->user->profile_pic) : null,
                'role'   => $comment->user->role,
            ],
        ],
    ]);
}


    // POST /projects/{project}/comments/seen  { comment_ids: [1,2,...] }
    public function markSeen(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $ids = collect($request->input('comment_ids', []))
            ->filter(fn($x) => is_numeric($x))
            ->map(fn($x) => (int)$x)
            ->unique()
            ->values();

        if ($ids->isEmpty()) return response()->json(['ok'=>true]);

        $userId = Auth::id();

        // Ensure all belong to the project (avoid cross-project leakage)
        $validIds = Comment::where('project_id', $project->id)
            ->whereIn('id', $ids)->pluck('id');

        $now = now();
        $insert = $validIds->map(fn($cid) => [
            'comment_id' => $cid,
            'user_id'    => $userId,
            'created_at' => $now,
            'updated_at' => $now,
        ])->values()->all();

        // Upsert (unique user_id+comment_id)
        CommentView::upsert($insert, ['user_id','comment_id'], ['updated_at']);

        return response()->json(['ok'=>true]);
    }

    // GET /projects/{project}/comments/unread_count
    public function unreadCount(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $userId = Auth::id();
        $count = DB::table('comments as c')
            ->where('c.project_id', $project->id)
            ->whereNotExists(function($q) use ($userId) {
                $q->select(DB::raw(1))
                  ->from('comment_views as v')
                  ->whereColumn('v.comment_id', 'c.id')
                  ->where('v.user_id', $userId);
            })
            ->count();

        return response()->json(['ok'=>true,'unread'=>$count]);
    }

    // DELETE /comments/{comment}  (owner/admin)
    public function destroy(Comment $comment)
    {
        $project = $comment->project;
        $this->authorize('delete', $comment); // define policy or use a gate

        $comment->delete();
        return response()->json(['ok'=>true]);
    }

    // -------- serializer for FE --------
    private function serialize(Comment $c, int $me): array
    {
        $u = $c->user;
        $emp = $u?->employee;

        $name = $emp?->full_name ?: $u?->name ?: 'User';
        $avatar = $emp?->photo_path ?: $u?->profile_pic ?: null;

        return [
            'id'         => (int)$c->id,
            'project_id' => (int)$c->project_id,
            'body'       => (string)$c->comment,
            'created_at' => $c->created_at?->toIso8601String(),
            'is_own'     => $u && $u->id === $me,
            'user' => [
                'id'     => (int)($u?->id ?? 0),
                'name'   => $name,
                'avatar' => $avatar,
                'role'   => $u?->role,
            ],
        ];
    }



public function commentsIndex(Request $request, Project $project)
{
    $limit    = (int) min(max($request->integer('limit', 25), 1), 100);
    $afterId  = $request->integer('after_id');
    $beforeId = $request->integer('before_id');

    $q = Comment::with([
            // do NOT request 'name' if your users table doesn't have it
            'user:id,employee_id,profile_pic,role',
            'user.employee:id,user_id,full_name,photo_path'
        ])
        ->where('project_id', $project->id)
        ->when($afterId,  fn($qq) => $qq->where('id', '>', $afterId))
        ->when($beforeId, fn($qq) => $qq->where('id', '<', $beforeId))
        ->orderBy('id', 'asc');

    if (!$afterId && !$beforeId) {
        $lastId = Comment::where('project_id', $project->id)->max('id');
        $q->when($lastId, fn($qq) => $qq->where('id', '>', max(0, $lastId - 1000)));
    }

    $rows = $q->limit($limit)->get();

    $hasMoreBefore = false;
    $hasMoreAfter  = false;
    if ($rows->count()) {
        $minId = $rows->min('id');
        $maxId = $rows->max('id');
        $hasMoreBefore = Comment::where('project_id', $project->id)->where('id','<',$minId)->exists();
        $hasMoreAfter  = Comment::where('project_id', $project->id)->where('id','>',$maxId)->exists();
    }

    // Build payload explicitly (no dependency on users.name)
    $payload = $rows->map(function ($c) {
        $u = $c->user;
        $emp = $u?->employee;

        $displayName = $emp?->full_name
            ?? (property_exists($u, 'name') ? $u->name : 'User #'.$u->id);

        $avatar = $emp?->photo_path
            ?: ($u?->profile_pic ?: null);

        return [
            'id'         => (int) $c->id,
            'project_id' => (int) $c->project_id,
            'body'       => (string) $c->comment, // your column is 'comment'
            'created_at' => optional($c->created_at)->toIso8601String(),
            'user'       => [
                'id'     => (int) ($u?->id ?? 0),
                'name'   => $displayName,
                'avatar' => $avatar ? (str_starts_with($avatar,'http') ? $avatar : Storage::url($avatar)) : null,
                'role'   => $u?->role,
            ],
        ];
    })->values();

    return response()->json([
        'ok' => true,
        'comments' => $payload,
        'has_more_before' => $hasMoreBefore,
        'has_more_after'  => $hasMoreAfter,
    ]);
}

public function commentsIndex_old(Request $request, Project $project)
{
    // If you have policies, keep this. For quick test, comment it out:
    $this->authorize('view', $project);

    $limit    = (int) min(max($request->integer('limit', 25), 1), 100);
    $afterId  = $request->integer('after_id');
    $beforeId = $request->integer('before_id');

    $q = Comment::with([
            'user:id,employee_id,profile_pic,role',
            'user.employee:id,usename,photo_path'
        ])
        ->where('project_id', $project->id)
        ->when($afterId,  fn($qq) => $qq->where('id', '>', $afterId))
        ->when($beforeId, fn($qq) => $qq->where('id', '<', $beforeId))
        ->orderBy('id', 'asc');

    if (!$afterId && !$beforeId) {
        $lastId = Comment::where('project_id', $project->id)->max('id');
        $q->when($lastId, fn($qq) => $qq->where('id', '>', max(0, $lastId - 1000)));
    }

    $rows = $q->limit($limit)->get();

    $hasMoreBefore = false;
    $hasMoreAfter  = false;
    if ($rows->count()) {
        $minId = $rows->min('id');
        $maxId = $rows->max('id');
        $hasMoreBefore = Comment::where('project_id', $project->id)->where('id','<',$minId)->exists();
        $hasMoreAfter  = Comment::where('project_id', $project->id)->where('id','>',$maxId)->exists();
    }

    $me = Auth::id();
    $payload = $rows->map(fn($c) => $this->serializeComment($c, $me));

    return response()->json([
        'ok' => true,
        'comments' => $payload,
        'has_more_before' => $hasMoreBefore,
        'has_more_after'  => $hasMoreAfter,
    ]);
}

public function commentsStore(Request $request, Project $project)
{
    // For quick test, you can remove this line, but restore it once policies are fixed
    // $this->authorize('update', $project);

    $data = $request->validate([
        'comment' => ['required','string','max:5000'],
    ]);

    $me = Auth::id();

    $row = Comment::create([
        'project_id' => $project->id,
        'user_id'    => $me,
        'comment'    => $data['comment'],
    ]);

// BEFORE (broken): selects users.profile_pic and employees.user_id (doesn't exist)
$row->load([
    // 'user:id,employee_id,profile_pic,role',
    // 'user.employee:id,user_id,name,photo_path'
]);

// AFTER (fixed):
$row->load([
    'user:id,employee_id,role',
    // IMPORTANT: employees has 'id' (PK), not 'user_id'
    // include every column you will use in the response/UI
    'user.employee:id,name,designation,avatar_path'
]);


    // author has "seen" their own comment
    CommentView::firstOrCreate([
        'user_id'    => $me,
        'comment_id' => $row->id,
    ]);

    // return response()->json([
    //     'ok'      => true,
    //     'comment' => $this->serializeComment($row, $me),
    // ]);

    // Example mapping inside controller or API Resource
$comment = $row; // your Comment model instance after ->load()

return [
    'id' => $comment->id,
    'body' => $comment->body,
    'created_at' => $comment->created_at,
    'created_for_humans' => optional($comment->created_at)->diffForHumans(),

    'user' => [
        'id' => $comment->user?->id,
        'role' => $comment->user?->role,

        // Pulling person info from the linked employee:
        'name' => $comment->user?->employee?->name,
        'designation' => $comment->user?->employee?->designation,

        // Use the accessor; falls back to placeholder
        'avatar_url' => $comment->user?->employee?->avatar_url,
    ],
];

}

public function commentsMarkSeen(Request $request, Project $project)
{
    // $this->authorize('view', $project);

    $ids = array_unique(array_filter((array)($request->input('comment_ids') ?? [])));
    $me  = Auth::id();
    if (!$ids) return response()->json(['ok'=>true]);

    $existIds = Comment::where('project_id', $project->id)
        ->whereIn('id', $ids)->pluck('id')->all();

    $now = now();
    $insert = [];
    foreach ($existIds as $id) {
        $insert[] = [
            'user_id'    => $me,
            'comment_id' => $id,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    if ($insert) {
        CommentView::upsert($insert, ['user_id','comment_id'], ['updated_at']);
    }

    return response()->json(['ok'=>true]);
}

public function commentsUnreadCount(Request $request, Project $project)
{
    // $this->authorize('view', $project);

    $me = Auth::id();

    $unread = Comment::where('project_id', $project->id)
        ->where('user_id','<>',$me)
        ->whereDoesntHave('views', fn($q) => $q->where('user_id',$me))
        ->count();

    return response()->json(['ok'=>true,'unread'=>$unread]);
}

/** OPTIONAL: delete (owner/admin) */
public function commentsDestroy(Comment $comment)
{
    // $this->authorize('delete', $comment);
    $comment->delete();
    return response()->json(['ok'=>true]);
}

/** Helper to shape response for FE */
protected function serializeComment(Comment $c, $meId)
{
    $u   = $c->user;
    $emp = $u?->employee;

    $displayName = $emp?->name
        ?: ($u?->name ?? 'User'); // will work even if users.name doesn’t exist

    $avatar = $emp?->photo_path
        ? Storage::url($emp->photo_path)
        : ($u?->profile_pic ? Storage::url($u->profile_pic) : url('/images/avatar-placeholder.png'));

    return [
        'id'         => (int) $c->id,
        'project_id' => (int) $c->project_id,
        'body'       => (string) ($c->comment ?? ''),
        'created_at' => optional($c->created_at)->toIso8601String(),
        'is_own'     => (int)$c->user_id === (int)$meId,
        'user'       => [
            'id'     => (int) ($u->id ?? 0),
            'name'   => $displayName,
            'avatar' => $avatar,
            'role'   => $u->role ?? null,
        ],
    ];
}

}

