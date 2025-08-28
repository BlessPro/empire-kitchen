<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Product;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectWizardController extends Controller
{
    public function store(Request $request)
    {
        // ---- VALIDATION (minimal; expand later) ----
        $validated = $request->validate([
            // Project
            'project.client_id'              => ['required','exists:clients,id'],
            'project.name'                   => ['required','string','max:150'],
            'project.status'                 => ['nullable','in:COMPLETED,ON_GOING,IN_REVIEW'],
            'project.current_stage'          => ['nullable','in:MEASUREMENT,DESIGN,PRODUCTION,INSTALLATION'],
            'project.booked_status'          => ['nullable','in:UNBOOKED,BOOKED'],
            'project.estimated_budget'       => ['nullable','numeric'],
            'project.admin_id'               => ['nullable','exists:users,id'],
            'project.tech_supervisor_id'     => ['nullable','exists:users,id'],
            'project.designer_id'            => ['nullable','exists:users,id'],
            'project.production_officer_id'  => ['nullable','exists:users,id'],
            'project.installation_officer_id'=> ['nullable','exists:users,id'],

            // Product
            'product.name'                 => ['required','string','max:150'],
            'product.product_type'         => ['nullable','string','max:80'],
            'product.type_of_finish'       => ['nullable','string','max:80'],
            'product.finish_color_hex'     => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_finish_image'  => ['nullable','image','max:4096'],
            'product.glass_door_type'      => ['nullable','string','max:80'],
            'product.worktop_type'         => ['nullable','string','max:80'],
            'product.worktop_color_hex'    => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_worktop_image' => ['nullable','image','max:4096'],
            'product.sink_top_type'        => ['nullable','string','max:80'],
            'product.handle'               => ['nullable','string','max:80'],
            'product.sink_color_hex'       => ['nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'product.sample_sink_image'    => ['nullable','image','max:4096'],
            'product.notes'                => ['nullable','string'],

            // Accessories (optional)
            'accessories'                  => ['nullable','array'],
            'accessories.*'                => ['integer','exists:accessories,id'],
        ]);

        return DB::transaction(function () use ($request) {
            // Defaults
            $projectData = $request->input('project', []);
            $projectData['status']        = $projectData['status']        ?? 'ON_GOING';
            $projectData['booked_status'] = $projectData['booked_status'] ?? 'UNBOOKED';

            // 1) Create Project
            $project = Project::create($projectData);

            // 2) Create Product (one primary product at creation time)
            $productData = $request->input('product', []);
            $productData['project_id'] = $project->id;

            // Handle uploads (store in /storage/app/public/projects/{id}/)
            $dir = "projects/{$project->id}";

            if ($request->hasFile('product.sample_finish_image')) {
                $path = $request->file('product.sample_finish_image')->store($dir, 'public');
                $productData['sample_finish_image_path'] = $path;
            }
            if ($request->hasFile('product.sample_worktop_image')) {
                $path = $request->file('product.sample_worktop_image')->store($dir, 'public');
                $productData['sample_worktop_image_path'] = $path;
            }
            if ($request->hasFile('product.sample_sink_image')) {
                $path = $request->file('product.sample_sink_image')->store($dir, 'public');
                $productData['sample_sink_image_path'] = $path;
            }

            $product = Product::create($productData);

            // 3) Attach Accessories (if any) with qty=1
            $ids = collect($request->input('accessories', []))->unique()->values();
            if ($ids->isNotEmpty()) {
                $attach = $ids->mapWithKeys(fn($id) => [$id => ['quantity' => 1]]);
                $product->accessories()->attach($attach);
            }

            return redirect()
                ->route('projects.show', $project->id)
                ->with('success', 'Project & Product created successfully.');
        });
    }
}
