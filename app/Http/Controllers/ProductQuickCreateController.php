<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AccessoryType;

class ProductQuickCreateController extends Controller
{
    //


  
    public function store(Request $r)
    {
        // control the allowed product types here
        $allowedTypes = ['Kitchen','Wardrobe','Bathroom','TV Unit','Office'];

        $data = $r->validate([
            'project_id'   => ['required','exists:projects,id'],
            'product_type' => ['required', Rule::in($allowedTypes)],
            'name'         => ['nullable','string','max:120'],
            
        ]);

        $product = Product::create([
            'project_id'         => $data['project_id'],
            'name'               => $data['name'] ?? ($data['product_type'].' Product'),
            'product_type'       => $data['product_type'],
            // set any defaults you like; everything else can be set in Step 2+
        ]);

        // send them straight to step 2 of the wizard
        $next = route('admin.addproduct', ['product' => $product->id]);

        return response()->json(['ok' => true, 'next_url' => $next], 201);
    }



    public function edit(Product $product, Request $request)
    {
        $product->load('project');

        // read-only basics come from the existing product + its project
        $currentStep = max(2, (int) $request->query('step', 2)); // land on Step 2 by default

        // reuse your option lists (match your addProject() names)
        $productTypes  = ['Kitchen', 'Wardrobe', 'TV Unit', 'Vanity']; // shown read-only here
        $finishTypes   = ['Matte', 'Gloss', 'Textured'];
        $glassTypes    = ['Smoked', 'Clear', 'Frosted', 'Mirror', 'Tinted Bronze'];
        $worktopTypes  = ['Quartz', 'Granite', 'Laminate', 'Solid Wood'];
        $sinkTopTypes  = ['Undermount + Quartz', 'Topmount + Granite', 'Integrated Solid Surface'];
        $handleTypes   = ['Handle-less', 'Bar Handle', 'Knob', 'Edge Pull'];

        // top accessories/users lists—adjust to your needs
        $appliances = \App\Models\Accessory::latest()->take(10)->get(['id','name','category']);
        $users      = \App\Models\User::select('id','employee_id')->get();

        return view('admin.addproduct', compact(
            'product','currentStep',
            'productTypes','finishTypes','glassTypes','worktopTypes','sinkTopTypes','handleTypes',
            'appliances','users'
        ));
    }


public function update(Product $product, Request $request)
    {
        $product->load('project');

        // 1) Validate only editable fields for steps 2+
        $validated = $request->validate([
            // Project deadline (mapped to project.due_date)
            'product.deadline'              => ['nullable','date'],

            // Finish
            'product.type_of_finish'        => ['nullable','string','max:80'],
            'product.finish_color_hex'      => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_finish_image'   => ['nullable','image','max:4096'],

            // Glass
            'product.glass_door_type'       => ['nullable','string','max:80'],

            // Worktop
            'product.worktop_type'          => ['nullable','string','max:80'],
            'product.worktop_color_hex'     => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_worktop_image'  => ['nullable','image','max:4096'],

            // Sink & Tap
            'product.sink_top_type'         => ['nullable','string','max:120'],
            'product.handle'                => ['nullable','string','max:120'],
            'product.sink_color_hex'        => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_sink_image'     => ['nullable','image','max:4096'],

            // Notes
            'product.notes'                 => ['nullable','string'],

            // Accessories
            'accessories'                   => ['nullable','array'],
        ]);

        $productData = $validated['product'] ?? [];
        $rawRows     = $request->input('accessories', []);

        // 2) Normalize accessories rows
        $selected = collect($rawRows)->map(function ($row) {
            $row = is_array($row) ? $row : [];
            return [
                'id'   => isset($row['id']) ? (int)$row['id'] : null,
                'size' => $row['size'] ?? null,
                'type' => $row['type'] ?? null,
            ];
        })->filter(fn($r) => !empty($r['id']))->values()->all();

        // 3) Validate accessory constraints
        Validator::make(['rows' => $selected], [
            'rows'        => ['array'],
            'rows.*.id'   => ['required','exists:accessories,id'],
            'rows.*.size' => ['required','string','max:50'],
            'rows.*.type' => ['nullable','string','max:80'],
        ])->after(function ($v) use ($selected) {
            if (empty($selected)) return;

            $allowed = AccessoryType::whereIn('accessory_id', collect($selected)->pluck('id')->unique())
                ->get()
                ->groupBy('accessory_id')
                ->map(fn($g) => $g->pluck('value')->all());

            foreach ($selected as $i => $r) {
                $list = $allowed[$r['id']] ?? [];
                if (!empty($list)) {
                    if (empty($r['type']) || !in_array($r['type'], $list, true)) {
                        $v->errors()->add("rows.$i.type", 'Invalid type for the selected accessory.');
                    }
                }
            }
        })->validate();

        // 4) Update (transaction) — uploads + product fields + accessories + due_date
        DB::transaction(function () use ($request, $product, $productData, $selected) {
            // Project due_date from product.deadline
            if (!empty($productData['deadline'])) {
                $product->project->update(['due_date' => $productData['deadline']]);
                unset($productData['deadline']);
            }

            // File uploads → *_path on product
            $dir = "projects/{$product->project_id}";
            if ($request->hasFile('product.sample_finish_image')) {
                $productData['sample_finish_image_path'] = $request->file('product.sample_finish_image')->store($dir, 'public');
            }
            if ($request->hasFile('product.sample_worktop_image')) {
                $productData['sample_worktop_image_path'] = $request->file('product.sample_worktop_image')->store($dir, 'public');
            }
            if ($request->hasFile('product.sample_sink_image')) {
                $productData['sample_sink_image_path'] = $request->file('product.sample_sink_image')->store($dir, 'public');
            }

            // Don’t allow changing product_type/project here (Step 1 is read-only)
            unset($productData['project_id'], $productData['product_type'], $productData['name']);

            // Update product core fields
            $product->update($productData);

            // Sync accessories
            if (is_array($selected)) {
                $sync = [];
                foreach ($selected as $r) {
                    $sync[$r['id']] = [
                        'size'     => $r['size'],
                        'type'     => $r['type'],
                        'quantity' => 1,
                        'notes'    => null,
                    ];
                }
                $product->accessories()->sync($sync);
            }
        });

        // return back()->with('ok', 'Product saved.');
// After successful update
return redirect()
    ->route('admin.ProjectManagement', $product->project_id)
    ->with('ok', 'Product saved.');

    }


public function duplicate(Project $project, Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $project); // optional

        $new = DB::transaction(function () use ($project) {
            // --- 1) Duplicate Project ---
            $copy = $project->replicate([
                // nothing excluded; we’ll override fields below
            ]);

            // Make a unique-ish name
            $suffix = now()->format('Ymd_His');
            $copy->name          = "{$project->name} (Copy {$suffix})";
            $copy->status        = 'ON_GOING';
            $copy->booked_status = 'UNBOOKED';
            $copy->due_date      = null;

            $copy->push(); // saves project

            // Preload relations we want to clone
            $project->loadMissing([
                'products.accessories', // pivot
                'phases',               // your project_phases rows
            ]);

            // --- 2) Duplicate Products (+ accessories pivot) ---
            foreach ($project->products as $prod) {
                $prodCopy = $prod->replicate();
                $prodCopy->project_id = $copy->id;

                // (optional) tweak product name
                // $prodCopy->name = $prod->name.' (Copy)';

                $prodCopy->push();

                // Clone accessories pivot
                if ($prod->relationLoaded('accessories')) {
                    $attach = [];
                    foreach ($prod->accessories as $acc) {
                        $attach[$acc->id] = [
                            'size'     => $acc->pivot->size,
                            'type'     => $acc->pivot->type,
                            'quantity' => $acc->pivot->quantity ?? 1,
                            'notes'    => $acc->pivot->notes,
                        ];
                    }
                    if ($attach) {
                        $prodCopy->accessories()->attach($attach);
                    }
                }
            }

            // --- 3) Duplicate Project Phases but reset checks ---
            foreach ($project->phases as $pp) {
                $ppCopy = $pp->replicate([
                    // keep name, sort_order
                ]);
                $ppCopy->project_id  = $copy->id;
                $ppCopy->is_checked  = false;
                $ppCopy->checked_by  = null;
                $ppCopy->checked_at  = null;
                $ppCopy->note        = null;
                $ppCopy->save();
            }

            // Do NOT copy installations
            return $copy;
        });

        return redirect()
            ->route('admin.ProjectManagement', $new) // or admin.ProjectManagement if that’s your show route
            ->with('ok', 'Project duplicated successfully.');
    }
}
