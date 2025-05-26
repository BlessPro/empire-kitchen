<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class designerAssignDesigners extends Controller
{
    // redirect to the designer dashboard
    public function index()
    {
        return view('designer.dashboard');
    }
    // redirect to the assigned projects page
       public function AssignedProjects()
    {
        return view('designer.AssignedProjects');
    }
    // redirect to the Project Design page
    public function ProjectDesign()
    {
        return view('designer.ProjectDesign');
    }
    // redirect to the timeline management page
    public function TimelineManagement()
    {
        return view('designer.TimelineManagement');
    }
    // redirect to the inbox page
    public function inbox()
    {
        return view('designer.inbox');
    }
}
