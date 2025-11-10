<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProductionClientController extends Controller
{
    public function showProjectname(Request $request, Project $project)
    {
        // Reuse Admin's computed view model/data, but render in Production layout
        $admin = app(\App\Http\Controllers\ProjectController::class);
        $adminView = $admin->show($request, $project);
        $data = method_exists($adminView, 'getData') ? $adminView->getData() : ['project' => $project];
        return view('production.projectInfo', $data);
    }
}
