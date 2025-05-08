<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ReportsandAnalytics extends Controller
{
    //
    public function index()
    {     
         $statusCounts = [
        'Pending' => Project::where('status', 'pending')->count(),
        'Ongoing' => Project::where('status', 'in progress')->count(),
        'Completed' => Project::where('status', 'completed')->count(),
    ];

    // return redirect()->route('admin.ReportsandAnalytics')->with('success', 'Report sent successfully.');

        $projects = Project::orderBy('created_at','desc')->paginate(10); // fetch paginated projects
        // return view('admin/dashboard', compact(['latestProjectWithAllDates','projects']));
        return view('admin.ReportsandAnalytics', compact('projects','statusCounts'));
    }

    
    public function create()
    {
        return view('admin.ReportsandAnalytics.create');
    }
    public function edit($id)
    {
        return view('admin.ReportsandAnalytics.edit', compact('id'));
    }
    public function show($id)
    {
        return view('admin.ReportsandAnalytics.show', compact('id'));
    }
    public function destroy($id)
    {
        // Logic to delete the project
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Project deleted successfully.');
    }
    public function store(Request $request)
    {
        // Logic to store the project
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Project created successfully.');
    }
    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Project updated successfully.');
    }
    public function generateReport(Request $request)
    {
        // Logic to generate the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report generated successfully.');
    }
    public function downloadReport(Request $request)
    {
        // Logic to download the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report downloaded successfully.');
    }
    public function viewReport(Request $request)
    {
        // Logic to view the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report viewed successfully.');
    }
    public function deleteReport(Request $request)
    {
        // Logic to delete the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report deleted successfully.');
    }
    public function filterReport(Request $request)
    {
        // Logic to filter the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report filtered successfully.');
    }
    public function exportReport(Request $request)
    {
        // Logic to export the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report exported successfully.');
    }
    public function importReport(Request $request)
    {
        // Logic to import the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report imported successfully.');
    }
    public function scheduleReport(Request $request)
    {
        // Logic to schedule the report
        return redirect()->route('admin.ReportsandAnalytics.index')->with('success', 'Report scheduled successfully.');
    }

    // public function status(Request $request)
    // {
    //     // Logic to send the report
    //     $statusCounts = [
    //         'Pending' => Project::where('status', 'pending')->count(),
    //         'Ongoing' => Project::where('status', 'ongoing')->count(),
    //         'Completed' => Project::where('status', 'completed')->count(),
    //     ];
    
    //     return redirect()->route('admin.ReportsandAnalytics')->with('success', 'Report sent successfully.');
    // }
}
