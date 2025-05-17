<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class techAssignDesignersController extends Controller
{
    //
          public function index(){
    $projects = Project::paginate(15); // fetch paginated projects

    return view('tech/AssignDesigners', compact('projects'));
}
}
