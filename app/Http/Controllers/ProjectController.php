<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\PhaseTemplate;
use App\Models\ProjectPhase;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Gate;
//created on 2025-04-23
// app/Http/Controllers/ProjectController.php
class ProjectController extends Controller
{
    public function index()
{
    $projects = Project::paginate(15); // fetch paginated projects

    return view('admin/ProjectManagement', compact('projects'));
}


public function projectInfo()
    {
        return view('admin.projectInfo'); // your UI lives here
    }


    // app/Http/Controllers/Admin/ProjectInfoController.php

//   public function show() {
//     // stub data to render UI 1:1 with the screenshot
//     $project = (object)[
//       'name' => "Tetteh’s Kitchen",
//       'install_date' => '2025-12-12',
//       'client_name' => 'Divine Okyere Mensah',
//       'location_text' => 'Maple Street, West Legon',
//       'project_phases' => [
//         ['name'=>'Work Order','done'=>true], ['name'=>'Setting Up (First)','done'=>true], ['name'=>'Setting up( Final)','done'=>true],
//         ['name'=>'Cutting List','done'=>true], ['name'=>'Corner Post and Finishes','done'=>true], ['name'=>'Briefing','done'=>true],
//         ['name'=>'Cutting','done'=>true], ['name'=>'Shelf Pin Holes','done'=>true], ['name'=>'Waybill / Crosscheck','done'=>true],
//         ['name'=>'Lipping and Cleaning','done'=>true], ['name'=>'Drawers','done'=>true], ['name'=>'Delivery','done'=>true],
//         ['name'=>'Profile Cutting','done'=>true], ['name'=>'Doors','done'=>false], ['name'=>'Installation','done'=>false],
//         ['name'=>'Assembly','done'=>true], ['name'=>'Hinges Holes','done'=>true], ['name'=>'Feedback from site','done'=>false],
//       ],
//       'productTypes' => ['Kitchen'],
//       'finish' => ['label'=>'High Gloss','color'=>'#9E0FFF'],
//       'glass_door_type' => 'Smoked Glass',
//       'worktop' => ['label'=>'Granite','color'=>'#9E0FFF','thumbnail_url'=>null],
//       'sink_tap' => ['bowl'=>'Double Bowl','color'=>'#9E0FFF','handle'=>'Knob'],
//       'appliances' => [
//         ['name'=>'Microwave','size'=>'30×90','type'=>'Inbuilt'],
//         ['name'=>'Oven','size'=>'45×45','type'=>'Freestanding'],
//         ['name'=>'Fridge','size'=>'110×90','type'=>'Inbuilt'],
//         ['name'=>'Washing Machine','size'=>'110×90','type'=>'Inbuilt'],
//         ['name'=>'Extractor','size'=>'45×45','type'=>'Freestanding'],
//         ['name'=>'Hob','size'=>'30×90','type'=>'Cooker'],
//         ['name'=>'Dish Washer','size'=>'110×90','type'=>'Inbuilt'],
//       ],
//       'media' => ['attachments'=>[], 'designs'=>[], 'plans'=>[]],
//     ];
//     return view('admin.projectInfo', compact('project'));
//   }


public function show(Project $project)
{
    $project->load(['client', 'products', 'projectPhases']);

    // Pick the first associated product
    $product = $project->products->sortBy('id')->first();

    // Phase templates filtered by the product's product_type (if present)
    $templates = PhaseTemplate::query()
        ->where('is_active', 1)
        ->when(optional($product)->product_type, fn($q, $pt) => $q->where('product_type', $pt))
        ->orderBy('default_sort_order')
        ->get(['id','name','default_sort_order']);

    // Existing per-project rows keyed by template FK (Path B)
    $rows = $project->projectPhases->keyBy('phase_template_id');

    $phases = $templates->map(function ($tpl) use ($rows) {
        $row = $rows->get($tpl->id);
        return [
            'template_id'       => $tpl->id,
            'name'              => $tpl->name,
            'sort_order'        => $row->sort_order ?? $tpl->default_sort_order,
            'done'              => (bool)($row->is_checked ?? false),
            'note'              => optional($row)->note,
            'checked_at'        => optional(optional($row)->checked_at)->toDateTimeString(),
            'checked_by'        => optional($row)->checked_by,
            'project_phase_id'  => optional($row)->id,
        ];
    })->values()->all();

    // Build the VM your Blade expects, using PRODUCT fields where applicable
    $vm = (object)[
        'name'          => $project->name ?? '—',
        'install_date'  => optional(optional($product)->installed_at)->toDateString()
                           ?? optional($project->due_date)->toDateString()
                           ?? now()->toDateString(),
        'client_name'   => trim(implode(' ', array_filter([
                              $project->client->title ?? null,
                              $project->client->firstname ?? null,
                              $project->client->lastname ?? null,
                          ]))) ?: '—',
        'location_text' => $project->location ?? '—',

        // phases array used by Blade
        'phases'        => $phases,

        // Product-driven bits
        'productTypes'  => [$product->product_type ?? 'Kitchen'], // simple single tag; expand later if needed

        'finish'        => [
            'label' => $product->type_of_finish ?? 'High Gloss',
            'color' => $product->finish_color_hex ?? '#9E0FFF',
            // you could surface sample_finish_image_path if needed
        ],

        'glass_door_type' => $product->glass_door_type ?? 'Smoked Glass',

        'worktop'       => [
            'label'         => $product->worktop_type ?? 'Granite',
            'color'         => $product->worktop_color_hex ?? '#9E0FFF',
            'thumbnail_url' => $product->sample_worktop_image_path ?? null,
        ],

        'sink_tap'      => [
            'bowl'   => $product->sink_top_type ?? 'Double Bowl',
            'color'  => $product->sink_color_hex ?? '#9E0FFF',
            'handle' => $product->handle ?? 'Knob',
        ],

        // leave empty until you wire a relation/table for appliances
        'appliances'    => [],

        // ditto for media
        'media'         => ['attachments'=>[], 'designs'=>[], 'plans'=>[]],
    ];

    return view('admin.projectInfo', ['project' => $vm]);
}

// public function show(\App\Models\Project $project)
// {
//     // Load what we need
//     $project->load(['client', 'projectPhases']); // projectPhases = hasMany(ProjectPhase)

//     // ---- Build phases from templates + per-project rows (Path B) ----
//     $templates = \App\Models\PhaseTemplate::query()
//         ->where('is_active', 1)
//         // if you don't have product_type on projects, remove the when() line below
//         ->when($project->product_type ?? null, fn($q,$pt) => $q->where('product_type', $pt))
//         ->orderBy('default_sort_order')
//         ->get(['id','name','default_sort_order']);

//     $rows = $project->projectPhases
//         ->keyBy('phase_template_id'); // already loaded above

//     $phases = $templates->map(function ($tpl) use ($rows) {
//         $row = $rows->get($tpl->id);
//         return [
//             'template_id'     => $tpl->id,
//             'name'            => $tpl->name,
//             'sort_order'      => $row->sort_order ?? $tpl->default_sort_order,
//             'done'            => (bool)($row->is_checked ?? false),
//             'note'            => $row->note ?? null,
//             // 'checked_at'      => optional($row->checked_at)->toDateTimeString(),
//             'checked_at' => data_get($row, 'checked_at') ? data_get($row, 'checked_at')->toDateTimeString() : null,

//             'checked_by'      => $row->checked_by ?? null,
//             'project_phase_id'=> $row->id ?? null,
//         ];
//     })->values()->all();

//     // ---- Build the view model that matches your Blade exactly ----
//     $vm = (object)[
//         'name'          => $project->name ?? '—',
//         // your Blade calls: Carbon::parse($project->install_date)...
//         // so we provide a string like 'YYYY-MM-DD' (fallback to due_date, else today)
//         'install_date'  => optional($project->due_date)->toDateString() ?? now()->toDateString(),
//         'client_name'   => trim(
//             ($project->client->title ?? '') . ' ' .
//             ($project->client->firstname ?? '') . ' ' .
//             ($project->client->lastname ?? '')
//         ) ?: '—',
//         'location_text' => $project->location ?? '—',

//         // IMPORTANT: Blade uses $project->phases
//         'phases'        => $phases,

//         // The rest are used by the Blade; give safe defaults if your DB doesn’t have them yet
//         'productTypes'  => method_exists($project, 'types')
//                             ? ($project->types()->pluck('name')->all() ?: ['Kitchen'])
//                             : ['Kitchen'],

//         'finish'        => [
//             'label' => $project->finish_label ?? 'High Gloss',
//             'color' => $project->finish_color ?? '#9E0FFF',
//         ],

//         'glass_door_type' => $project->glass_type ?? 'Smoked Glass',

//         'worktop'       => [
//             'label'         => $project->worktop_label ?? 'Granite',
//             'color'         => $project->worktop_color ?? '#9E0FFF',
//             'thumbnail_url' => $project->worktop_thumb ?? null,
//         ],

//         'sink_tap'      => [
//             'bowl'   => $project->sink_bowl   ?? 'Double Bowl',
//             'color'  => $project->sink_color  ?? '#9E0FFF',
//             'handle' => $project->tap_handle  ?? 'Knob',
//         ],

//         'appliances'    => collect(
//                                 property_exists($project, 'appliances') && $project->appliances
//                                 ? $project->appliances
//                                 : []
//                            )->map(fn($a) => [
//                                 'name' => data_get($a, 'name', '—'),
//                                 'size' => data_get($a, 'size', '—'),
//                                 'type' => data_get($a, 'type', '—'),
//                            ])->all(),

//         'media'         => [
//             'attachments' => [],
//             'designs'     => [],
//             'plans'       => [],
//         ],
//     ];

//     return view('admin.projectInfo', ['project' => $vm]);
// }







    private function buildProjectPhasesViewModel(Project $project): array
    {
        // Fetch templates for this project's product type (adjust if needed)
        $templates = PhaseTemplate::active()
            ->when($project->product_type ?? null, fn($q,$pt) => $q->where('product_type', $pt))
            ->orderBy('default_sort_order')
            ->get(['id','name','default_sort_order']);

        $rows = $project->projectPhases()
            ->get(['id','phase_template_id','is_checked','checked_by','checked_at','note','sort_order'])
            ->keyBy('phase_template_id');

        $items = [];
        foreach ($templates as $tpl) {
            $row = $rows->get($tpl->id);
            $items[] = [
                'template_id'     => $tpl->id,
                'name'            => $tpl->name,
                'sort_order'      => $row->sort_order ?? $tpl->default_sort_order,
                'done'            => (bool)($row->is_checked ?? false),
                'note'            => $row->note ?? null,
                'checked_at'      => optional($row->checked_at)->toDateTimeString(),
                'checked_by'      => $row->checked_by ?? null,
                'project_phase_id'=> $row->id ?? null,
            ];
        }

        // progress
        $total = max(1, count($items));
        $done  = collect($items)->where('done', true)->count();
        $pct   = (int) round(($done / $total) * 100);

        return compact('items','total','done','pct');
    }

    public function togglePhase(Request $r, Project $project, PhaseTemplate $template)
    {
        $data = $r->validate([
            'done' => ['required','boolean'],
            'note' => ['nullable','string','max:500'],
        ]);

        $row = ProjectPhase::firstOrNew([
            'project_id'        => $project->id,
            'phase_template_id' => $template->id,
        ]);

        // On first create, carry over a stable name & sort_order for convenience
        if (!$row->exists) {
            $row->name       = $template->name;
            $row->sort_order = $template->default_sort_order;
        }

        $row->is_checked = $data['done'];
        $row->note       = $data['note'] ?? $row->note;
        $row->checked_by = $r->user()?->id;
        $row->checked_at = $data['done'] ? Carbon::now() : null;
        $row->save();

        return response()->json(['ok' => true, 'done' => $row->is_checked]);
    }



}

