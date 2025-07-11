<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesignerUploadController extends Controller
{
    //
  
           public function allUploads()    {      
            
            $designerId = auth()->id();     
               $projects = Project::where('designer_id', $designerId)     
               ->with(['uploads' => function ($query) {  
                  $query->latest();   }])      
                        ->latest()       
                             ->get();   
                                  return view('designer.uploads.all', compact('projects'));    }    public function viewProjectUploads(Project $project)    {        $project->load('uploads');        return view('designer.uploads.view', compact('project'));    }}


           