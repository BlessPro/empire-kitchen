<?php

use App\Http\Controller\DashboardController as ControllerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\SalesController;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // Ensure this class exists in the specified namespace
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Models\Project;
use App\Http\Controllers\ClientManagementController;
use App\Http\Controllers\ProjectManagementController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\Inbox;
use App\Http\Controllers\ReportsandAnalytics;
use App\Http\Controllers\ScheduleInstallationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\techClientController;
use App\Http\Controllers\techProjectManagementController;
use App\Http\Controllers\techReportsandAnalyticsController;
use App\Http\Controllers\techScheduleMeasurementController;
use App\Http\Controllers\techSettingsController;
use App\Http\Controllers\techInboxController;
use App\Http\Controllers\TechAssignDesignersController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\TechDashboardController;

use App\Http\Controllers\RoleMiddleware;

Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


    //profile route
    Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Navigation with admin login

    // Admin Route
    //navigating with admin login

    // for the client management
    Route::get('/admin/ClientManagement', [ClientManagementController::class, 'index'])->name('admin.ClientManagement');
    //for saving the client
    Route::post('/clients/store', [ClientManagementController::class, 'store'])->name('clients.store');
    //for handling client projects


    //for the project info

    Route::get('/admin/projects/{project}/info2', [ClientManagementController::class, 'showProjectname'])->name('admin.projects.info');
    Route::get('/admin/projects/{project}/info', [ClientManagementController::class, 'showProjectname'])->name('admin.clients.projects');

    //deleting project from the dashboard
    Route::delete('admin/dashboard/projects/{id}', [ProjectManagementController::class, 'destroy'])->name('projects.destroy');
    //storing comment

    Route::post('/admin/projects/{project}/comments', [CommentController::class, 'store'])->name('project.comment.store');


    // Route::post('/clients', [ClientManagementController::class, 'store'])->name('clients.store');
    Route::get('/admin/settings', [Settings::class, 'showUsers'])->name('admin.Settings')->middleware('auth');

   //for the edit pop up

    Route::get('/admin/update/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/admin/settings/', [UserController::class, 'UpdateLoggedUser'])->name('admin.settings.update');
    //for rditing logged user
    Route::post('/admin/ScheduleInstallation/{id}', [ScheduleInstallationController::class, 'update'])->name('admin.ScheduleInstallation.update');


    //delete user
    Route::delete('admin/dashboard/user/{id}', [settings::class, 'destroy'])->name('settings.destroy');

    //storing the user
    Route::post('/users', [settings::class, 'store'])->name('users.store');

    //storing comment
    Route::get('/admin/Inbox', [InboxController::class, 'index'])->name('admin.Inbox')->middleware('auth');

    // For the MessageSending
    Route::middleware(['auth'])->group(function () {
    Route::get('/inbox/{userId?}', [InboxController::class, 'index'])->name('inbox');
    Route::post('/inbox/send', [InboxController::class, 'sendMessage'])->name('inbox.send');
    Route::get('/inbox/fetch/{userId}', [InboxController::class, 'fetchMessages'])->name('inbox.fetch');
});


    Route::get('/admin/ReportsandAnalytics', [ReportsandAnalytics::class, 'index'])->name('admin.ReportsandAnalytics')->middleware('auth');
    Route::get('/admin/ScheduleInstallation', [ScheduleInstallationController::class, 'index'])->name('admin.ScheduleInstallation')->middleware('auth');

    //navigating with tech user login
    // Route::get('/tech/dashboard', [TechController::class, 'index'])->middleware('role:tech_supervisor');
    // Route::get('/tech/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard');
    // Route::get('/tech/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard')->middleware('auth');

//     Route::middleware(['auth', 'verified'])->prefix('tech')->group(function () {
//     Route::get('/tech/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard');
// });

    //navigate tech tabs page
    Route::get('/tech/ClientManagement', [techClientController::class, 'index'])->name('tech.ClientManagement');
    Route::get('/tech/ProjectManagement', [techProjectManagementController::class, 'index'])->name('tech.ProjectManagement');
    Route::get('/tech/ReportsandAnalytics', [techReportsandAnalyticsController::class, 'index'])->name('tech.ReportsandAnalytics');
    Route::get('/tech/ScheduleMeasurement', [techScheduleMeasurementController::class, 'index'])->name('tech.ScheduleMeasurement');
    Route::get('/tech/Settings', [techSettingsController::class, 'index'])->name('tech.Settings');
    Route::get('/tech/Inbox', [techInboxController::class, 'index'])->name('tech.Inbox');
    Route::get('/tech/AssignDesigners', [techAssignDesignersController::class, 'index'])->name('tech.AssignDesigners');
    // updating the users profile pic only
    Route::post('/tech/settings/profile-pic', [UserController::class, 'updateProfilePic'])->name('tech.settings.profile_pic');

     // For the MessageSending
    Route::middleware(['auth'])->group(function () {
    Route::get('/tech/inbox/{userId?}', [techInboxController::class, 'index'])->name('tech.inbox');
    Route::post('/tech/inbox/send', [techInboxController::class, 'sendMessage'])->name('tech.inbox.send');
    Route::get('/tech/inbox/fetch/{userId}', [techInboxController::class, 'fetchMessages'])->name('tech.inbox.fetch');
});

    //for the viewing the client projects
    Route::get('/tech/projects/{project}/info', [techClientController::class, 'showProjectname'])->name('tech.projects.info');
    // comments
    Route::post('/tech/projects/{project}/comments', [CommentController::class, 'store'])->name('techproject.comment.store');

    Route::get('tech/ClientManagement', [techClientController::class, 'clientProjects'])->name('tech.ClientManagement');

    //for the tech account tab on the settings page
    Route::post('/tech/settings/update', [settings::class, 'update'])->name('tech.settings.update');
    //for the create management page
    Route::get('tech/CreateMeasurement', [MeasurementController::class, 'StoreCreateMeasurement'])->name('tech.CreateMeasurement');
    // for saving the measurement
    // Route::post('/measurements', [MeasurementController::class, 'store'])->name('measurements.store');

    Route::post('/tech/measurements/store', [MeasurementController::class, 'store'])->name('tech.measurements.store');
   // Route::get('/tech/ReportsandAnalytics', [techReportsandAnalyticsController::class, 'showMeasurementProjects'])->name('tech.ReportsandAnalytics');
    Route::get('tech/ReportsandAnalytics', [techReportsandAnalyticsController::class, 'reportsAndAnalytics'])->name('tech.ReportsandAnalytics');
    //for assigning a Designer// Show the assignment page
    Route::get('tech/AssignDesigners', [techAssignDesignersController::class, 'showDesignerAssignment'])->name('tech.AssignDesigners');

    // Assign designer to project
    Route::post('tech/AssignDesigners', [techAssignDesignersController::class, 'assignDesigner'])->name('assign.designer');
    Route::get('/tech/ScheduleMeasurement/events', [techScheduleMeasurementController::class, 'calendarEvents'])->name('tech.ScheduleInstallations.events');

    // Route::post('/tech/assign-designer', [ProjectController::class, 'assignDesigner'])->name('assign.designer');

    Route::middleware(['auth', 'verified'])->prefix('tech')->group(function () {
    Route::get('/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard');
    });

// Route::get('/measurements/create', [MeasurementController::class, 'create'])->name('measurements.create');



    //navigating with Designer user login


    Route::get('/designer/dashboard', [DesignerController::class, 'index'])->middleware('role:designer');
       //navigating with tech accountant login

    Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->middleware('role:accountant');
        //navigating with sales accountant  user login

    Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware(middleware: 'RoleMiddleware:sales_accountant');

    // Route::get('/admin/bick', [DashboardController::class, 'dashboard']);
    //displayinig the users on the settings page

    // Route::get('/admin/ProjectManagement',   [ProjectManagementController::class, 'index'])->name('admin.ProjectManagement');
    Route::get('/admin/ProjectManagement', [ProjectManagementController::class, 'index'])->name('admin.ProjectManagement');

    //for the looping card on the project management page

    Route::post('/projects', [ProjectManagementController::class, 'store'])->name('projects.store');

    //using ajax to load the the client and tech supervisor into the pop up
    // Route::get('/admin/ProjectManagement/form-data', [ProjectManagementController::class, 'getFormData']);

    //For the report and analytics page
    Route::get('/admin/ReportandAnalytics',   [ProjectManagementController::class, 'index'])->name('admin.ReportandAnalytics');

    // for scheduling the installation on admin level
//     // API route for FullCalendar events
// Route::get('/api/calendar/events', [InstallationController::class, 'calendarEvents']);

// // Web route to store a new installation
// Route::post('/installation', [InstallationController::class, 'store'])->name('installation.store');

// Route::prefix('admin')->group(function () {
// });

// Route::post('/admin/ScheduleInstallation/store', [InstallationController::class, 'store'])->name('admin.ScheduleInstallation.store');

    Route::post('installations/store', [InstallationController::class, 'store'])->name('installation.store');


// Route::post('admin/installations/store', [InstallationController::class, 'store'])->name('admin.installation.store');
Route::get('/installations/events', [InstallationController::class, 'calendarEvents'])->name('installation.events');

Route::get('/api/projects/by-client/{client}', function ($clientId) {
    return \App\Models\Project::where('client_id', $clientId)
        ->where('current_stage', '<>', 'installation') // only those not yet installed
        ->get(['id', 'name']);
});
// Route::prefix('admin')->group(function () {
//     Route::delete('/installations/{id}', [InstallationController::class, 'destroy']);
// });

    Route::delete('/admin/ScheduleInstallation/{id}', [InstallationController::class, 'destroy']);


Route::put('/installations/{id}', [InstallationController::class, 'update']);
// Route::delete('/installations/{id}', [InstallationController::class, 'destroy']);

    Route::get('/admin/Dashboard2',  [ProjectController::class, 'index'])->name('admin.Dashboard2');
// to filter
});

// Route::get('/admin/projects/filter', [AdminController::class, 'filter'])->name('projects.filter');


require __DIR__.'/auth.php';
