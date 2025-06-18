<?php

use App\Http\Controller\DashboardController as ControllerDashboardController;
use App\Http\Controllers\accountantCategoryController;
use App\Http\Controllers\deisgnerNavigation;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\accountantDashboardController;
use App\Http\Controllers\AccountantInboxController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DesignerNavigationController;
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
use App\Http\Controllers\designerAssignDesigners;
use App\Http\Controllers\DesignerDashboardController;
use App\Http\Controllers\DesignerInboxController;
use App\Http\Controllers\DesignerUserController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\UserController;
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
use App\Http\Controllers\designerProjectDesignController;
use App\Http\Controllers\DesignerTimeManagementController;
use App\Http\Controllers\DesignerUploadController;
use App\Http\Controllers\AccountantInvoiceController;
use App\Http\Controllers\accountantSettingsController;
use App\Http\Controllers\accountantExpensesController;
use App\Http\Controllers\accountantPayController;
use App\Http\Controllers\accountantPaymentController;
use App\Http\Controllers\accountantProjectFinancialController;
use App\Http\Controllers\accountantReportsController;
use Illuminate\Http\Request;

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
    Route::middleware(['auth', 'verified'])->prefix('tech')->group(function () {
    Route::get('/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard');
    });


    //navigating with sales accountant  user login
    Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware(middleware: 'RoleMiddleware:sales_accountant');
    //displayinig the users on the settings page
    Route::get('/admin/ProjectManagement', [ProjectManagementController::class, 'index'])->name('admin.ProjectManagement');
    //for the looping card on the project management page
    Route::post('/projects', [ProjectManagementController::class, 'store'])->name('projects.store');
    //For the report and analytics page
    Route::get('/admin/ReportandAnalytics',   [ProjectManagementController::class, 'index'])->name('admin.ReportandAnalytics');
    // for scheduling the installation on admin level
    Route::get('/designer/AssignedProjects', [DesignerNavigationController::class, 'AssignedProjects'])->name('designer.AssignedProjects')->middleware('auth');
    // Route::get('/designer/ProjectDesign', [DesignerNavigationController::class, 'ProjectDesign'])->name('designer.ProjectDesign')->middleware('auth');
    Route::get('/designer/TimeManagement', [DesignerNavigationController::class, 'TimelineManagement'])->name('designer.TimeManagement')->middleware('auth');
    Route::get('/designer/Settings', [DesignerNavigationController::class, 'Settings'])->name('designer.Settings')->middleware('auth');
    // Route::get('/designer/Inbox', [DesignerNavigationController::class, 'Inbox'])->name('designer.Inbox')->middleware('auth');
    Route::get('/designer/inbox', [DesignerInboxController::class, 'index'])->name('designer.inbox');
    // For the MessageSending
    Route::middleware(['auth'])->group(function () {
    Route::get('/designer/Inbox/{userId?}', [DesignerInboxController::class, 'index'])->name('designer.inbox');
    Route::post('/designer/Inbox/send', [DesignerInboxController::class, 'sendMessage'])->name('designer.inbox.send');
    Route::get('/designer/Inbox/fetch/{userId}', [DesignerInboxController::class, 'fetchMessages'])->name('designer.inbox.fetch');
    });
    Route::post('/desginer/settings/profile-pic', [DesignerUserController::class, 'updateProfilePic'])->name('designer.settings.profile_pic');
    // Route::get('/designer/AssignedProjects', [designerAssignDesigners::class, 'index'])->name('designer.AssignedProjects');
    //for the viewing the client projects
    Route::get('/designer/projects/{project}/info', [designerAssignDesigners::class, 'showProjectname'])->name('designer.projects.info');
    // for project design page
    // Show form
    Route::get('/designer/ProjectDesign', [designerProjectDesignController::class, 'showUploadForm'])->name('designer.ProjectDesign');

    // Handle submission
    Route::post('/designer/ProjectDesign', [designerProjectDesignController::class, 'store'])->name('design.store');
    Route::get('/designer/dashboard', [DashboardController::class, 'index'])->name('designer.dashboard');
    //handle the viewed comment
    Route::post('/comments/{comment}/mark-as-viewed', [DesignerDashboardController::class, 'markAsViewed']);

    Route::get('/designer/TimeManagement/events', [DesignerTimeManagementController::class, 'calendarEvents'])->name('designer.TimeManagement.events');
    // Route::get('/TimeManagement/events', [DesignerTimeManagementController::class, 'calendarEvents'])->name('TimeManagement.events');


Route::middleware(['auth'])->prefix('designer')->name('designer.')->group(function () {
    Route::get('/designs/viewuploads', [DesignerUploadController::class, 'index'])->name('designs.viewuploads');
    Route::get('/designs/Upload/{design}', [DesignerUploadController::class, 'show'])->name('designs.Upload');
});


    // comments
    Route::post('/designer/projects/{project}/comments', [CommentController::class, 'store'])->name('designer.project.comment.store');
    Route::get('/designer/AssignedProjects', [designerAssignDesigners::class, 'clientProjects'])->name('designer.AssignedProjects');
    Route::post('installations/store', [InstallationController::class, 'store'])->name('installation.store');
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


//navigating the accountant user role
    Route::get('/accountant/Payments', [accountantPaymentController::class, 'index'])->name('accountant.Payments');
    Route::get('/accountant/Reports&Analytics', [accountantReportsController::class, 'index'])->name('accountant.Reports&Analytics');
    Route::get('/accountant/Settings', [accountantSettingsController    ::class, 'index'])->name('accountant.Settings');
    Route::get('/accountant/Inbox', [accountantInboxController::class, 'index'])->name('accountant.Inbox');
    Route::get('/accountant/Invoice', [AccountantInvoiceController::class, 'index'])->name('accountant.Invoice');
    Route::post('/accountant/Invoice/store', [MeasurementController::class, 'store'])->name('accountant.Invoice.store');


// Route::get('/projects', function (Request $request) {
//     if (!$request->client_id) { return response()->json([]);    }
//     return Project::where('client_id', $request->client_id)
//         ->get(['id', 'name']);
// });

// Route::get('/projects', function (Request $request) {
//     if (!$request->client_id) {
//         return response()->json([]);
//     }

//     $projects = \App\Models\Project::where('client_id', $request->client_id)
//         ->get(['id', 'name']);

//     return response()->json($projects);
// });/invoices/by-client/${clientId}

// Fix: Ensure your API route is properly defined in routes/api.php
// Route::get('/projects', function (Request $request) {
//     return Project::where('client_id', $request->client_id)->get();
// });
//  Route::get('/invoices/by-client/${clientId}', [accountantInvoiceController::class, 'getByClient']);
    Route::get('/accountant/Invoice/{id}/projects', [accountantInvoiceController::class, 'getClientProjects']);
    Route::get('/accountant/Invoice', [accountantInvoiceController::class, 'index'])->name('accountant.Invoice');
    Route::post('/accountant/Invoice', [accountantInvoiceController::class, 'store'])->name('accountant.Invoice.store');
    Route::get('/accountant/Invoice/Invoiceview/{id}', [accountantInvoiceController::class, 'invoiceview'])->name('accountant.Invoice.Invoiceview');
    // Route::get('/accountant/invoice/{id}', [InvoiceController::class, 'showInvoice'])->name('accountant.invoice.show');


    // For the MessageSending
    Route::middleware(['auth'])->group(function () {
    Route::get('/accountant/Inbox/{userId?}', [AccountantInboxController::class, 'index'])->name('accountant.inbox');
    Route::post('/accountant/Inbox/send', [AccountantInboxController::class, 'sendMessage'])->name('accountant.inbox.send');
    Route::get('/accountant/Inbox/fetch/{userId}', [AccountantInboxController::class, 'fetchMessages'])->name('accountant.inbox.fetch');
    });
    Route::post('/accountant/settings/profile-pic', [accountantSettingsController::class, 'updateProfilePic'])->name('accountant.settings.profile_pic');
    Route::get('/accountant/Expenses/Category', [accountantCategoryController::class, 'index'])->name('accountant.Expenses.Category');
    Route::post('/categories', [accountantCategoryController::class, 'store'])->name('categories.store');
    Route::delete('accountant/Category/{id}', [accountantCategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/accountant/Project-Financials', [accountantProjectFinancialController    ::class, 'projectFinancials'])->name('accountant.Project-Financials');
    //storing th expense
    Route::post('/expenses', [accountantExpensesController::class, 'store'])->name('expenses.store');
    Route::get('/accountant/Expenses', [accountantExpensesController::class, 'index'])->name('accountant.Expenses');
    //for deleting the expense
    Route::delete('accountant/Expenses/{id}', [accountantExpensesController::class, 'destroy'])->name('expenses.destroy');

    //     Route::get('/accountant/update/{id}', [accountantExpensesController::class, 'edit'])->name('accountant.Expenses.edit');
    // Route::post('/accountant/Expenses/{id}', [UserController::class, 'update'])->name('accountant.Expenses.update');

    Route::get('/expenses/{expense}/edit', [accountantExpensesController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [accountantExpensesController::class, 'update'])->name('expenses.update');
    // Route::delete('admin/dashboard/user/{id}', [settings::class, 'destroy'])->name('settings.destroy');
    Route::get('/accountant/expenses/chart-data', [accountantExpensesController::class, 'getMonthlyChartData']);
    Route::get('/accountant/Payment/Pay', [accountantPayController::class, 'index'])->name('accountant.Payment.Pay');
    //for the client drop down in the project
    Route::get('/projects/by-client/{clientId}', [accountantPayController::class, 'getByClient']);
    // Route::get('/projects/by-client/{id}', [accountantPayController::class, 'getByClient']);

    // Route::get('/admin/projects/filter', [AdminController::class, 'filter'])->name('projects.filter');
    Route::post('/income/store', [accountantPayController::class, 'store'])->name('income.store');
    Route::get('/accountant/Report&Analytics/expenses-data', [accountantReportsController::class, 'getMonthlyChartData']);
    Route::get('/accountant/Report&Analytics/incomes-data', [accountantReportsController::class, 'getMonthlyIncomeChartData']);


require __DIR__.'/auth.php';
