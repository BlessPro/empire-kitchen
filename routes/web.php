<?php
use App\Http\Controllers\accountantCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountantInboxController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DesignerNavigationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // Ensure this class exists in the specified namespace
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientManagementController;
use App\Http\Controllers\ProjectManagementController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\ReportsandAnalytics;
use App\Http\Controllers\ScheduleInstallationController;
use App\Http\Controllers\InstallationCalendarController;
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
use App\Http\Controllers\SalesNavigationController;
use App\Http\Controllers\salesInboxController;
use App\Http\Controllers\SalesSettingsController;
use App\Http\Controllers\SalesTrackPaymentController;
use App\Http\Controllers\SalesFollowUpController;
use App\Http\Controllers\SalesClientController;
use App\Http\Controllers\salesReportsAndAnalyticsController;
use App\Http\Controllers\MeasurementScheduleController;
use App\Http\Middleware\UpdateLastSeen;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\EmployeeController;
use App\Models\Client;
use App\Http\Controllers\CostsController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\ProductQuickCreateController;
use App\Http\Controllers\ProjectWizardController;





    // // Calendar page
    // Route::get('/admin/installations/calendar', [InstallationCalendarController::class, 'index'])
    //     ->name('admin.installations.calendar');

    // // JSON feed + actions (Blade uses route() + CSRF)
    // Route::get('/admin/installations', [InstallationCalendarController::class, 'feed'])
    //     ->name('admin.installations.feed');

    // Route::post('/admin/installations', [InstallationCalendarController::class, 'store'])
    //     ->name('admin.installations.store');

    // Route::patch('/admin/installations/{installation}', [InstallationCalendarController::class, 'update'])
    //     ->name('admin.installations.update');

    // Route::delete('/admin/installations/{installation}', [InstallationCalendarController::class, 'destroy'])
    //     ->name('admin.installations.destroy');

    // Route::post('/admin/installations/{installation}/done', [InstallationCalendarController::class, 'markDone'])
    //     ->name('admin.installations.done');




Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//profile route
Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
    // Route::middleware(['auth', 'role:designer', UpdateLastSeen::class])->group(function () {
    //     Route::get('/designer/dashboard', [DesignerDashboardController::class, 'index'])
    //         ->name('designer.dashboard');
    // });
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
    Route::get('/clients', [ClientManagementController::class, 'index'])->name('clients.index'); // Ensure this route exists for listing clients

        Route::get('/admin/Employee', [EmployeeController::class, 'index'])->name('admin.employee');
// routes/web.php




Route::prefix('admin')->name('admin.')->group(function () {
    // List page (the table of employees)
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employee');

    // Create page
    Route::get('/employees/create', [EmployeeController::class, 'addemployee'])->name('addemployee');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

    // Edit page
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'editemployee'])->name('editemployee');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
});



Route::middleware(['web','auth'])->prefix('admin')->group(function () {
    Route::get('/ProjectManagement', [ProjectManagementController::class, 'index'])
        ->name('admin.ProjectManagement');


});





Route::middleware(['auth']) // your guards here
    ->prefix('admin')
    ->group(function () {
        Route::get('/projects/{project}/supervisors',
            [ProjectManagementController::class, 'supervisors']
        )->name('admin.projects.supervisors');

        // keep your assign action too
        Route::post('/projects/assign-tech',
            [ProjectManagementController::class, 'assignSupervisor']
        )->name('tech.assignSupervisor');
    });


    Route::get('/measurements', [MeasurementController::class, 'index'])
    ->name('measurements.index');

    //for handling client projects
    //handling the add employee
    Route::get('/admin/addemployee', [EmployeeController::class, 'addemployee'])->name('admin.addemployee');

    Route::get('employee/create', [EmployeeController::class, 'create'])->name('employees.create');

    Route::post('employee', [EmployeeController::class, 'store'])->name('employees.store'); // you already have this

    Route::middleware(['web', 'auth'])->group(function () {
        // Clients
        Route::get('/clients/{client}', [ClientManagementController::class, 'show'])->name('clients.show'); // View Client details

        Route::delete('/clients/{client}', [ClientManagementController::class, 'destroy'])->name('clients.destroy'); // Delete client

        // Projects (list, scoped to a client via ?client=ID)
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index'); // View Projects for a client (filter by ?client=ID)
    });
    Route::post('/projects/assign-supervisor', [ProjectManagementController::class, 'assignSupervisor'])->name('tech.assignSupervisor');

    Route::post('/accessories/store', [ProjectManagementController::class, 'accstore'])->name('accessories.store');

    Route::get('/admin/addproject', [ProjectManagementController::class, 'addProject'])->name('admin.addproject');
    //for the project info
    Route::post('/ajax/accessories', [ProjectManagementController::class, 'Accstore'])->name('accessories.ajax.store');

    Route::get('/projects/booked', [BookingsController::class, 'booked']) // JSON: booked projects
        ->name('projects.booked');

    Route::get('/projects/{project}/client', [BookingsController::class, 'client']) // JSON: {id,name}
        ->name('projects.client');

    Route::post('/projects/{project}/override-booking', [BookingsController::class, 'override'])->name('projects.override-booking');

    Route::post('/measurements', [MeasurementController::class, 'store'])->name('measurements.store');

    Route::get('/admin/projects/{project}/info2', [ClientManagementController::class, 'showProjectname'])->name('admin.projects.info');
    Route::get('/admin/projects/{client}/info', [ClientManagementController::class, 'showClientProjects'])->name('admin.clients.projects');


// // routes/web.php

// Route::get('/admin/project-info', [ProjectController::class, 'show'])
//     ->name('admin.projectInfo');
// routes/web.php
// Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
//     Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
// });


Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // tick/untick a phase for this project (AJAX)
    Route::post('/projects/{project}/phases/{template}/toggle', [ProjectController::class, 'togglePhase'])
        ->name('projects.phases.toggle');
});



// routes/web.php

// Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
//     Route::post('/products/quick-create', [ProductQuickCreateController::class, 'store'])
//         ->name('products.quickCreate');

//     // your wizard route (you likely already have something similar)
//     Route::get('/products/{product}/wizard', [ProjectWizardController::class, 'store'])
//         ->name('products.wizard');
// });


// routes/web.php


Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    // already exists; keep as-is (only change redirect line later)
    Route::post('/products/quick-create', [ProductQuickCreateController::class, 'store'])
        ->name('products.quickCreate');

    // new page to edit/continue product wizard (skip project creation)
    Route::get('/addproduct/{product}/add', [ProductQuickCreateController::class, 'edit'])
        ->name('addproduct');

    // save updates to the same product (one form or per-step, your choice)
    // Route::patch('/products/{product}', [ProductQuickCreateController::class, 'update'])
    //     ->name('products.update');

});

// routes/web.php

Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    Route::patch('/products/{product}', [ProductQuickCreateController::class, 'update'])
        ->name('products.update');
});

// routes/web.php

Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    Route::post('/projects/{project}/duplicate', [ProductQuickCreateController::class, 'duplicate'])
        ->name('projects.duplicate');
});




    //deleting project from the dashboard
    Route::delete('admin/dashboard/projects/{id}', [ProjectManagementController::class, 'destroy'])->name('projects.destroy');
    //storing comment
    Route::post('/admin/projects/{project}/comments', [CommentController::class, 'store'])->name('project.comment.store');

    // Route::post('/clients', [ClientManagementController::class, 'store'])->name('clients.store');
    Route::get('/admin/settings', [Settings::class, 'showUsers'])
        ->name('admin.Settings')
        ->middleware('auth');
    //for the edit pop up
    Route::get('/admin/update/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    // Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/admin/settings/', [UserController::class, 'UpdateLoggedUser'])->name('admin.settings.update');

    // Route::post('/admin/users/{id}', [UserController::class, 'update'])->name('admin.update');

// routes/web.php
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        Route::post('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])
            ->name('users.update');   // POST for updates
    });




    Route::post('/users', [settings::class, 'store'])->name('users.store');
    // Route::post('/userss', [Settings::class, 'settings'])->name('');







// 1
    //for rditing logged user
    Route::post('/admin/ScheduleInstallation/{id}', [InstallationController::class, 'update'])->name('admin.ScheduleInstallation.update');
    // Route::get('/TimeManagement/events', [InstallationController::class, 'calendarEvents']);
    Route::delete('/admin/Installation/{id}', [InstallationController::class, 'destroy']);


    // 2
  Route::get('/admin/ScheduleInstallation', [InstallationCalendarController::class, 'index'])
        ->name('admin.ScheduleInstallation')
        ->middleware('auth');


    //3
        //must delete installation route


    Route::delete('/admin/ScheduleInstallation/{id}', [InstallationController::class, 'destroy']);

    Route::put('/installations/{id}', [InstallationController::class, 'update']);
    // Route::delete('/installations/{id}', [InstallationController::class, 'destroy']);


// routes/web.php

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/installations/calendar', ['App\Http\Controllers\InstallationCalendarController@index'])
        ->name('installations.calendar');
});


Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    Route::get('/installations/calendar', [InstallationCalendarController::class, 'index'])
        ->name('installations.calendar');

    Route::get('/installations', [InstallationCalendarController::class, 'feed'])
        ->name('installations.feed');

    // Route::post('/installations', [InstallationCalendarController::class, 'store'])
    //     ->name('installations.store'); // NEW

    Route::patch('/installations/{installation}', [InstallationCalendarController::class, 'update'])
        ->name('installations.update'); // NEW

    Route::post('/installations/{installation}/done', [InstallationCalendarController::class, 'markDone'])
        ->name('installations.done');

    Route::delete('/installations/{installation}', [InstallationCalendarController::class, 'destroy'])
        ->name('installations.destroy');
});



Route::middleware(['web','auth'])->prefix('admin')->name('admin.')->group(function () {
    // Show the page with the simple form
    Route::get('/installations/create', [InstallationCalendarController::class, 'create'])
        ->name('installations.create');

    // Handle the form submit (save)
    Route::post('/installations', [InstallationCalendarController::class, 'store'])
        ->name('installations.store');
});


    Route::get('/TimeManagement/events', [MeasurementController::class, 'events'])->name('measurements.events');

    // Route::delete('/admin/Installation/{id}', [InstallationController::class, 'destroy']);

    //delete user
    Route::delete('admin/dashboard/user/{id}', [settings::class, 'destroy'])->name('settings.destroy');
    //storing the user
    //storing comment
    Route::get('/admin/Inbox', [InboxController::class, 'index'])
        ->name('admin.Inbox')
        ->middleware('auth');
    // For the MessageSending
    Route::middleware(['auth'])->group(function () {
        Route::get('/inbox/{userId?}', [InboxController::class, 'index'])->name('inbox');
        Route::post('/inbox/send', [InboxController::class, 'sendMessage'])->name('inbox.send');
        Route::get('/inbox/fetch/{userId}', [InboxController::class, 'fetchMessages'])->name('inbox.fetch');
    });

    Route::get('/admin/ReportsandAnalytics', [ReportsandAnalytics::class, 'index'])
        ->name('admin.ReportsandAnalytics')
        ->middleware('auth');
    Route::get('/admin/export-csv', [ReportsandAnalytics::class, 'exportCSV'])->name('admin.export-csv');



    //navigating with bookings
    Route::get('/admin/Bookings', [BookingsController::class, 'index'])
        ->name('admin.Bookings')
        ->middleware('auth');

    // Store measurement
    Route::post('/measurements', [MeasurementController::class, 'store'])->name('measurements.store');

    // routes/web.php

    Route::get('/clients/{client}/projects', function (Client $client) {
        return $client->projects()->select('id', 'name')->orderByDesc('created_at')->get();
    })->name('clients.projects');
// routes/web.php


    // Route::post('/measurements/store', [MeasurementController::class, 'store'])->name('measurements.store');
    //employee
    Route::get('/admin/Employee', [EmployeeController::class, 'index'])
        ->name('admin.Employee')
        ->middleware('auth');
    //navigate tech tabs page
    Route::get('/tech/ClientManagement', [techClientController::class, 'index'])->name('tech.ClientManagement');
    Route::get('/tech/ProjectManagement', [techProjectManagementController::class, 'index'])->name('tech.ProjectManagement');
    // Route::get('/tech/ReportsandAnalytics', [techReportsandAnalyticsController::class, 'index'])->name('tech.ReportsandAnalytics');
    //Route::get('/tech/ScheduleMeasurement', [MeasurementScheduleController::class, 'index'])->name('tech.ScheduleMeasurement');
    Route::prefix('tech/ScheduleMeasurement')->group(function () {
        Route::get('/', [MeasurementScheduleController::class, 'index'])->name('tech.ScheduleMeasurement');
        Route::get('/events', [MeasurementScheduleController::class, 'events'])->name('tech.ScheduleMeasurement.events');
        Route::post('/store', [MeasurementScheduleController::class, 'store']);
        Route::put('/{id}', [MeasurementScheduleController::class, 'update']);
        Route::delete('/{id}', [MeasurementScheduleController::class, 'destroy']);
    });

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
    //updating the status
    Route::put('/project/{project}/status', [techClientController::class, 'updateStatus'])->name('project.status.update');
    //updating the date
    Route::post('/tech/project/{project}/update-due-date', [techClientController::class, 'updateDueDate'])->name('tech.project.updateDueDate');
    // Route::post('/tech/project/{id}/update-due-date', [ProjectController::class, 'updateDueDate']);

    // comments
    Route::post('/tech/projects/{project}/comments', [CommentController::class, 'store'])->name('techproject.comment.store');

    Route::get('tech/ClientManagement', [techClientController::class, 'clientProjects'])->name('tech.ClientManagement');

    //for the tech account tab on the settings page
    Route::post('/tech/settings/update', [settings::class, 'update'])->name('tech.settings.update');
    //for the create management page
    Route::get('tech/CreateMeasurement', [MeasurementController::class, 'StoreCreateMeasurement'])->name('tech.CreateMeasurement');

    Route::post('/tech/measurements/store', [MeasurementController::class, 'store'])->name('tech.measurements.store');
    Route::get('tech/AssignDesigners', [techAssignDesignersController::class, 'index'])->name('tech.AssignDesigners');
// routes/web.php
Route::prefix('admin')->name('admin.')->middleware(['web','auth'])->group(function () {
    Route::get('/designers/list', [techAssignDesignersController::class, 'list'])
        ->name('designers.list');

    // your existing POST stays as-is:
    // Route::post('/assign-designer', [AssignDesignersController::class, 'assignDesigner'])->name('assignDesigner');
});








    // Assign designer to project
    Route::post('tech/AssignDesigners', [techAssignDesignersController::class, 'assignDesigner'])->name('assign.designer');
    Route::get('/tech/ScheduleMeasurement/events', [techScheduleMeasurementController::class, 'calendarEvents'])->name('tech.ScheduleInstallations.events');
    Route::middleware(['auth', 'verified'])
        ->prefix('tech')
        ->group(function () {
            Route::get('/dashboard', [TechDashboardController::class, 'index'])->name('tech.dashboard');
        });

    //navigating with sales accountant  user login
    Route::get('/sales/dashboard', [SalesController::class, 'index'])->middleware(middleware: 'RoleMiddleware:sales_accountant');
    //displayinig the users on the settings page
    Route::get('/admin/ProjectManagement', [ProjectManagementController::class, 'index'])->name('admin.ProjectManagement');
    //for the looping card on the project management page
    Route::post('/projects', [ProjectManagementController::class, 'store'])->name('projects.store');
    //For the report and analytics page
    Route::get('/admin/ReportandAnalytics', [ProjectManagementController::class, 'index'])->name('admin.ReportandAnalytics');
    // for scheduling the installation on admin level
    Route::get('/designer/AssignedProjects', [DesignerNavigationController::class, 'AssignedProjects'])
        ->name('designer.AssignedProjects')
        ->middleware('auth');
    // Route::get('/designer/ProjectDesign', [DesignerNavigationController::class, 'ProjectDesign'])->name('designer.ProjectDesign')->middleware('auth');
    Route::get('/designer/TimeManagement', [DesignerNavigationController::class, 'TimelineManagement'])
        ->name('designer.TimeManagement')
        ->middleware('auth');
    Route::get('/designer/Settings', [DesignerNavigationController::class, 'Settings'])
        ->name('designer.Settings')
        ->middleware('auth');
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
Route::get('/invoices/create', [designerProjectDesignController::class, 'create'])
     ->name('invoices.create');
    // Handle submission
    Route::post('/designer/ProjectDesign', [designerProjectDesignController::class, 'store'])->name('design.store');
    Route::get('/designer/dashboard', [DashboardController::class, 'index'])->name('designer.dashboard');
    //handle the viewed comment
    Route::post('/comments/{comment}/mark-as-viewed', [DesignerDashboardController::class, 'markAsViewed']);

    Route::get('/designer/TimeManagement/events', [DesignerTimeManagementController::class, 'calendarEvents'])->name('designer.TimeManagement.events');
    // Route::get('/TimeManagement/events', [DesignerTimeManagementController::class, 'calendarEvents'])->name('TimeManagement.events');

    Route::middleware(['auth'])
        ->prefix('designer')
        ->name('designer.')
        ->group(function () {
            Route::get('/designs/viewuploads', [DesignerUploadController::class, 'index'])->name('designs.viewuploads');
            Route::get('/designs/Upload/{design}', [DesignerUploadController::class, 'show'])->name('designs.Upload');
        });

    // comments
    Route::post('/designer/projects/{project}/comments', [CommentController::class, 'store'])->name('designer.project.comment.store');
    Route::get('/designer/AssignedProjects', [designerAssignDesigners::class, 'clientProjects'])->name('designer.AssignedProjects');










    Route::get('/api/projects/by-client/{client}', function ($clientId) {
        return \App\Models\Project::where('client_id', $clientId)
            ->where('current_stage', '<>', 'installation') // only those not yet installed
            ->get(['id', 'name']);
    });
    Route::middleware(['auth', UpdateLastSeen::class])
        ->prefix('designer')
        ->name('designer.')
        ->group(function () {
            Route::get('/uploads', [DesignerUploadController::class, 'allUploads'])->name('uploads');
            Route::get('/uploads/{project}', [DesignerUploadController::class, 'viewProjectUploads'])->name('upload.view');
        });













    Route::get('/admin/Dashboard2', [ProjectController::class, 'index'])->name('admin.Dashboard2');
    Route::get('/admin/projects/filter', [DashboardController::class, 'filter'])->name('admin.projects.filter');

    Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
        //navigating the accountant user role
        Route::get('/accountant/Payments', [accountantPaymentController::class, 'index'])->name('accountant.Payments');
        Route::get('/accountant/Reports&Analytics', [accountantReportsController::class, 'index'])->name('accountant.Reports&Analytics');
        Route::get('/accountant/Settings', [accountantSettingsController::class, 'index'])->name('accountant.Settings');
        Route::get('/accountant/Inbox', [accountantInboxController::class, 'index'])->name('accountant.Inbox');
        Route::get('/accountant/Invoice', [AccountantInvoiceController::class, 'index'])->name('accountant.Invoice');
        Route::post('/accountant/Invoice/store', [MeasurementController::class, 'store'])->name('accountant.Invoice.store');

        Route::get('/accountant/Invoice/{id}/projects', [accountantInvoiceController::class, 'getClientProjects']);
        Route::get('/accountant/Invoice', [accountantInvoiceController::class, 'index'])->name('accountant.Invoice');
        Route::post('/accountant/Invoice', [accountantInvoiceController::class, 'store'])->name('accountant.Invoice.store');
        Route::get('/accountant/Invoice/Invoiceview/{id}', [accountantInvoiceController::class, 'invoiceview'])->name('accountant.Invoice.Invoiceview');
        // For the MessageSending
        Route::get('/accountant/Inbox/{userId?}', [AccountantInboxController::class, 'index'])->name('accountant.inbox');
        Route::post('/accountant/Inbox/send', [AccountantInboxController::class, 'sendMessage'])->name('accountant.inbox.send');
        Route::get('/accountant/Inbox/fetch/{userId}', [AccountantInboxController::class, 'fetchMessages'])->name('accountant.inbox.fetch');
    });
    Route::get('/accountant/Bookings', [BookingsController::class, 'index2'])
        ->name('accountant.Bookings')
        ->middleware('auth');


Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')->as('accountant.')
    ->group(function () {
        Route::patch('/bookings/{project}/book',   [BookingsController::class, 'markBooked'])->name('bookings.book');
        Route::patch('/bookings/{project}/unbook', [BookingsController::class, 'markUnbooked'])->name('bookings.unbook');
    });

    Route::post('/accountant/settings/profile-pic', [accountantSettingsController::class, 'updateProfilePic'])->name('accountant.settings.profile_pic');
    Route::get('/accountant/Expenses/Category', [accountantCategoryController::class, 'index'])->name('accountant.Expenses.Category');
    Route::post('/categories', [accountantCategoryController::class, 'store'])->name('categories.store');
    Route::delete('accountant/Category/{id}', [accountantCategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/accountant/Project-Financials', [accountantProjectFinancialController::class, 'projectFinancials'])->name('accountant.Project-Financials');
    //storing th expense
    Route::post('/expenses', [accountantExpensesController::class, 'store'])->name('expenses.store');
    Route::get('/accountant/Expenses', [accountantExpensesController::class, 'index'])->name('accountant.Expenses');
    //for deleting the expense
    Route::delete('accountant/Expenses/{id}', [accountantExpensesController::class, 'destroy'])->name('expenses.destroy');
    //for editing the expense
    Route::get('/expenses/{expense}/edit', [accountantExpensesController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [accountantExpensesController::class, 'update'])->name('expenses.update');
    // Route::delete('admin/dashboard/user/{id}', [settings::class, 'destroy'])->name('settings.destroy');
    Route::get('/accountant/expenses/chart-data', [accountantExpensesController::class, 'getMonthlyChartData']);
    Route::get('/accountant/Payment/Pay', [accountantPayController::class, 'index'])->name('accountant.Payment.Pay');

    Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')->as('accountant.')
    ->group(function () {



        // fetch projects that don't have a budget (used by the wizard)
        // Route::get('/budgets/wizard', [accountantProjectFinancialController::class, 'createWizard'])->name('budgets.createWizard');
        // submit wizard
        Route::post('/budgets/wizard', [accountantProjectFinancialController::class, 'storeWizard'])->name('budgets.storeWizard');

    });

// routes/web.php

Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')->as('accountant.')
    ->group(function () {
        // Route::get('/costs',  [CostsController::class, 'create'])->name('costs.create');
        Route::post('/costs', [CostsController::class, 'store'])->name('costs.store');
         // NEW: returns only the modal body HTML for a given project_id
        Route::get('/costs/fragment', [CostsController::class, 'fragment'])->name('costs.fragment');
    });


// routes/web.php


Route::middleware(['auth','role:accountant'])
    ->prefix('accountant')->as('accountant.')
    ->group(function () {
        // Route::get   ('/budgets/{project}/edit', [BudgetsController::class, 'edit'])->name('budgets.edit');
        // Route::put   ('/budgets/{project}',      [BudgetsController::class, 'update'])->name('budgets.update');
        // Route::delete('/budgets/{project}',      [BudgetsController::class, 'destroy'])->name('budgets.destroy');

    // routes/web.php (inside accountant group)
Route::get   ('/budgets/{project}/edit', [BudgetsController::class, 'edit'])->name('budgets.edit');
Route::put   ('/budgets/{project}',      [BudgetsController::class, 'update'])->name('budgets.update');
Route::delete('/budgets/{project}',      [BudgetsController::class, 'destroy'])->name('budgets.destroy');

    });



    //for the client drop down in the project
    Route::get('/projects/by-client/{clientId}', [accountantPayController::class, 'getByClient']);
    // Route::get('/projects/by-client/{id}', [accountantPayController::class, 'getByClient']);
    // Route::get('/admin/projects/filter', [AdminController::class, 'filter'])->name('projects.filter');
    Route::post('/income/store', [accountantPayController::class, 'store'])->name('income.store');
    Route::get('/accountant/Report&Analytics/expenses-data', [accountantReportsController::class, 'getMonthlyChartData']);
    Route::get('/accountant/Report&Analytics/incomes-data', [accountantReportsController::class, 'getMonthlyIncomeChartData']);
    Route::get('/sales/ClientManagement', [salesNavigationController::class, 'ClientManagement'])->name('sales.ClientManagement');
    Route::get('/sales/TrackPayment', [salesNavigationController::class, 'TrackPayment'])->name('sales.TrackPayment');
    Route::get('/sales/ReportsandAnalytics', [salesNavigationController::class, 'ReportsandAnalytics'])->name('sales.ReportsandAnalytics');
    // For the MessageSending
    Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
        Route::get('/sales/Inbox/{userId?}', [salesInboxController::class, 'index'])->name('sales.Inbox');
        Route::post('/sales/Inbox/send', [salesInboxController::class, 'sendMessage'])->name('sales.Inbox.send');
        Route::get('/sales/Inbox/fetch/{userId}', [salesInboxController::class, 'fetchMessages'])->name('sales.Inbox.fetch');
    });

    Route::middleware(['auth', UpdateLastSeen::class])->group(function () {
        Route::get('/sales/Settings', [salesSettingsController::class, 'index'])->name('sales.Settings');
        Route::get('/sales/TrackPayment', [salesTrackPaymentController::class, 'index'])->name('sales.TrackPayment');
        Route::get('/sales/FollowupManagement', [salesFollowUpController::class, 'index'])->name('sales.FollowupManagement');
        Route::post('/sales/FollowupManagement', [salesFollowUpController::class, 'store'])->name('sales.followup.store');
        Route::get('/sales/followups/filter', [SalesFollowUpController::class, 'filter'])->name('sales.followups.filter');
        Route::get('/sales/client/{id}/projects', [salesFollowUpController::class, 'getClientProjects']);
        Route::get('/sales/ClientManagement', [salesClientController::class, 'index'])->name('sales.ClientManagement');
        Route::get('/sales/ClientManagement/filter', [salesClientController::class, 'filter'])->name('sales.ClientManagement.filter');
        Route::get('/sales/ReportsandAnalytics', [salesReportsAndAnalyticsController::class, 'index'])->name('sales.ReportsandAnalytics');
        Route::get('/sales/income/chart-data', [accountantExpensesController::class, 'getMonthlyChartData']);
        Route::post('/sales/followups/{id}/update-status', [salesReportsAndAnalyticsController::class, 'updateStatus']);
    });
});

require __DIR__ . '/auth.php';
