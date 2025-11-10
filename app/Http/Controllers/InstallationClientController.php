<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class InstallationClientController extends Controller
{
    public function showProjectname(Request $request, Project $project)
    {
        // Reuse Admin's computed view model/data, but render in Installation layout
        $admin = app(\App\Http\Controllers\ProjectController::class);
        $adminView = $admin->show($request, $project);
        $data = method_exists($adminView, 'getData') ? $adminView->getData() : ['project' => $project];
        return view('installation.projectInfo', $data);
    }
}
