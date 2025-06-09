<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    HomeController,
    ProfileController,
    AdminDashboardController,
    TeacherDashboardController,
    StudentDashboardController,
    SuperAdminDashboardController,
    UserManagementController,
    StudentMessageController,
    AtcController,
    EoiController,
    NextFormController,
    ProposalController,
    ApplicationFormController,
    AffiliationController,
    ApplicantDashboardController,
};
use App\Http\Controllers\Teacher\{
    TeacherUserController,
    TeacherMaterialController,
    TeacherMessageController,

};
use App\Http\Controllers\SuperAdmin\{
    AdminManagementController,
    SettingController,
    ReportController,
    AnnouncementController,
    BackupController,
};
use App\Http\Controllers\Admin\{
    AdminUsercontroller,
    AdminCourseController,
    AdminBatchController,
    AdminAssignmentController,
    AdminReportController,
    AdminBroadcastController,
    AdminEoiController,
    PaymentController,
};
use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    RegisteredUserController,
    PasswordResetLinkController,
    NewPasswordController,
    VerifyEmailController
};

use App\Http\Middleware\RoleMiddleware;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/contact', function (Request $request) {
    return back()->with('success', 'Thank you for contacting us!');
})->name('contact.submit');
// Public route for EOI form
Route::get('/eoi', [EoiController::class, 'create'])->name('eoi.create');
Route::post('/eoi', [EoiController::class, 'store'])->name('eoi.store');

// Maintenance mode emergency routes (must be outside auth middleware)
Route::prefix('maintenance')->group(function () {
    // API endpoint to disable maintenance mode
    Route::post('/disable', function() {
        $setting = \App\Models\Setting::where('key', 'maintenance_mode')->first();
        
        if ($setting) {
            $setting->value = '0';
            $setting->save();
            return response()->json(['success' => true, 'message' => 'Maintenance mode disabled']);
        }
        
        return response()->json(['success' => false, 'message' => 'Setting not found'], 404);
    })->name('maintenance.disable');
    
    // Web form to disable maintenance mode
    Route::get('/disable-form', function() {
        return view('maintenance.disable-form');
    })->name('maintenance.disable.form');
    
    Route::post('/disable-form', function(Request $request) {
        $setting = \App\Models\Setting::where('key', 'maintenance_mode')->first();
        
        if ($setting) {
            $setting->value = '0';
            $setting->save();
            return redirect()->route('login')->with('success', 'Maintenance mode has been disabled');
        }
        
        return back()->with('error', 'Failed to disable maintenance mode');
    });
});

// ==================== AUTHENTICATION ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [HomeController::class, 'redirectToDashboard'])->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
 // Next Form
 Route::get('/proposal-form/{eoi}', [NextFormController::class, 'create'])
 ->name('proposal-form.create');
 
 Route::post('/proposal-form/{eoi}', [NextFormController::class, 'store'])
 ->name('proposal-form.store');

 Route::get('/proposal/thank-you', [NextFormController::class, 'thankYou'])
 ->name('proposal-form.thank-you');;

 // Public routes (no auth required)
 Route::prefix('application-form')->name('application-form.')->group(function () {
    Route::get('/{proposal}/{token}', [ApplicationFormController::class, 'create'])
        ->name('create');
    
    Route::post('/{proposal}/{token}', [ApplicationFormController::class, 'store'])
        ->name('store');
    
    Route::get('/thank-you', [ApplicationFormController::class, 'thankYou'])
        ->name('thank-you');
});  
 // Public routes
 Route::get('/affiliation-form/{application}/{token}', [AffiliationController::class, 'create'])
    ->name('affiliation-form.create');

 Route::post('/affiliation-form/{application}/{token}', [AffiliationController::class, 'store'])
    ->name('affiliation-form.store');

 Route::get('/affiliation-thank-you', [AffiliationController::class, 'thankYou'])
    ->name('affiliation-form.thank-you');


// ==================== VERIFIED & ROLE-BASED DASHBOARDS ====================
Route::middleware(['auth', 'verified'])->group(function () {
    //atc
    Route::middleware([RoleMiddleware::class . ':atc']) // Remove duplicate 'auth' middleware
    ->prefix('atc')
    ->name('atc.')
    ->group(function () {
        Route::get('dashboard', [AtcController::class, 'dashboard'])->name('dashboard');
        // Add more ATC routes here as needed
    });
    // ========== ADMIN ==========
    Route::middleware([RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class)
            ->except(['show', 'create', 'store']);

        Route::post('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserManagementController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        
        Route::prefix('eois')->name('eois.')->group(function() {
            Route::get('/', [EoiController::class, 'index'])->name('index');
            Route::get('/{eoi}', [EoiController::class, 'show'])->name('show');
            Route::post('/{eoi}/status', [EoiController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{eoi}/approve', [EoiController::class, 'approve'])->name('approve');
            Route::patch('/{eoi}/reject', [EoiController::class, 'reject'])->name('reject');
        });
       
        // Proposals routes (moved outside eois group)
        Route::prefix('proposals')->name('proposals.')->group(function () {
           Route::get('/', [ProposalController::class, 'index'])->name('index');
           Route::get('/{proposal}', [ProposalController::class, 'show'])->name('show');
           Route::patch('/{proposal}/approve', [ProposalController::class, 'approve'])->name('approve');
        });

         // Application forms routes
         Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationFormController::class, 'index'])->name('index');
            Route::get('/{application}', [ApplicationFormController::class, 'show'])->name('show');
            Route::patch('/{application}/approve', [ApplicationFormController::class, 'approve'])->name('approve');
        });
        Route::prefix('affiliations')->name('affiliations.')->group(function () {
            Route::get('/', [AffiliationController::class, 'index'])->name('index');
            Route::get('/{affiliation}', [AffiliationController::class, 'show'])->name('show');
            Route::patch('/{affiliation}/approve', [AffiliationController::class, 'approve'])->name('approve');
        });
        
        Route::prefix('payments')->name('payments.')->group(function() {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/create', [PaymentController::class, 'create'])->name('create');
            Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('create-order');
            Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('verify');
            Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
            Route::get('/{payment}/invoice', [PaymentController::class, 'invoice'])->name('invoice');
        });
      
        // New routes
        // Course management routes
        Route::resource('courses', AdminCourseController::class)
            ->names([
                'index' => 'courses.index',
                'create' => 'courses.create',
                'store' => 'courses.store',
                'show' => 'courses.show',
                'edit' => 'courses.edit',
                'update' => 'courses.update',
                'destroy' => 'courses.destroy'
            ]);
        
        Route::resource('batches', AdminBatchController::class)
            ->names([
                'index' => 'batches.index',
                'create' => 'batches.create',
                'store' => 'batches.store',
                'show' => 'batches.show',
                'edit' => 'batches.edit',
                'update' => 'batches.update',
                'destroy' => 'batches.destroy'
            ]);
        
        // Add these additional routes for student assignment
        Route::prefix('batches/{batch}')->group(function () {
            Route::get('assign', [AdminBatchController::class, 'showAssignForm'])->name('batches.assign');
            Route::post('assign', [AdminBatchController::class, 'assignStudents'])->name('batches.assign.store');
            Route::delete('students/{student}', [AdminBatchController::class, 'removeStudent'])->name('batches.students.remove');
        });
            
        Route::resource('assignments', AdminAssignmentController::class)

        ->names([
            'index' => 'assignments.index',
            'create' => 'assignments.create',
            'store' => 'assignments.store',
            'show' => 'assignments.show',
            'edit' => 'assignments.edit',
            'update' => 'assignments.update',
            'destroy' => 'assignments.destroy'
        ]);
        Route::post('assignments/{assignment}/publish', [AdminAssignmentController::class, 'publish'])
            ->name('assignments.publish');

        Route::prefix('reports')
            ->name('reports.')
            ->controller(AdminReportController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('students', 'students')->name('students');
                Route::get('teachers', 'teachers')->name('teachers');
                Route::get('courses', 'courses')->name('courses');
                Route::get('export/{type}', 'export')->name('export');
            });
            
        Route::prefix('broadcasts')->name('broadcasts.')->group(function () {
            Route::get('create', [AdminBroadcastController::class, 'create'])->name('create'); // admin.broadcasts.create
            Route::post('send', [AdminBroadcastController::class, 'send'])->name('send');     // admin.broadcasts.send
            Route::get('history', [AdminBroadcastController::class, 'history'])->name('history'); // admin.broadcasts.history
        });
        
        Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class)
            ->except(['show'])
            ->names('admin.subjects');
    
    });
    
    


   // ----Applicant-----
    Route::middleware([RoleMiddleware::class . ':applicant']) // Remove duplicate 'auth' middleware
    ->prefix('applicant')
    ->name('applicant.')
    ->group(function () {
        Route::get('dashboard', [ApplicantdashboardController::class, 'dashboard'])->name('dashboard');
      /*  // Proposal Form (Next Form)
        Route::get('/proposal-form/{eoi}', [NextFormController::class, 'create'])
            ->name('proposal-form.create');
    
        Route::post('/proposal-form/{eoi}', [NextFormController::class, 'store'])
            ->name('proposal-form.store');
    
        Route::get('/proposal-thank-you', [NextFormController::class, 'thankYou'])
            ->name('proposal-form.thank-you');

        // Application Form
        Route::prefix('application-form')->name('application-form.')->group(function () {
            Route::get('/{proposal}', [ApplicationFormController::class, 'create'])
                ->name('create');
        
            Route::post('/{proposal}', [ApplicationFormController::class, 'store'])
                ->name('store');
        
            Route::get('/thank-you', [ApplicationFormController::class, 'thankYou'])
                ->name('thank-you');
        });

        // Affiliation Form
        Route::get('/affiliation-form/{application}', [AffiliationController::class, 'create'])
            ->name('affiliation-form.create');
    
        Route::post('/affiliation-form/{application}', [AffiliationController::class, 'store'])
            ->name('affiliation-form.store');
    
        Route::get('/affiliation-thank-you', [AffiliationController::class, 'thankYou'])
           ->name('affiliation-form.thank-you');*/
    });

    
    // ========== TEACHER ==========
    Route::middleware([RoleMiddleware::class . ':teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        Route::get('/messages', [TeacherMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/create', [TeacherMessageController::class, 'create'])->name('messages.create');
        Route::post('/messages', [TeacherMessageController::class, 'store'])->name('messages.store');
        
        // Student Management
        Route::get('/students', [TeacherUserController::class, 'index'])->name('students.index');
        Route::get('/students/{id}/edit', [TeacherUserController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [TeacherUserController::class, 'update'])->name('students.update');
        Route::post('/students/{id}/toggle-block', [TeacherUserController::class, 'toggleBlock'])->name('students.toggle-block');

        // Material Management
        Route::resource('materials', TeacherMaterialController::class)->except(['show']);
        Route::get('materials/{id}/download', [TeacherMaterialController::class, 'download'])->name('materials.download');
        Route::get('/materials/{id}/view', [TeacherMaterialController::class, 'view'])->name('materials.view');
        Route::get('/materials/{id}/assign', [TeacherMaterialController::class, 'assignForm'])->name('materials.assign.form');
        Route::post('/materials/{id}/assign', [TeacherMaterialController::class, 'assignToStudents'])->name('materials.assign');
        Route::get('materials/{id}/assigned-students', [TeacherMaterialController::class, 'assignedStudents'])->name('materials.assigned_students');
        Route::delete('materials/{materialId}/assigned-students/{studentId}', [TeacherMaterialController::class, 'removeStudentAssignment'])->name('materials.remove_student_assignment');
        Route::get('materials/{id}/progress', [TeacherMaterialController::class, 'progress'])->name('teacher.materials.progress');
        Route::get('/teacher/materials/progress', [App\Http\Controllers\Teacher\TeacherMaterialController::class, 'progressOverview'])->name('teacher.materials.progress.overview');
        Route::get('/materials/progress', [TeacherMaterialController::class, 'progressOverview'])->name('materials.progress.overview');
        Route::get('/teacher/materials/{id}/progress', [TeacherMaterialController::class, 'studentProgress'])->name('teacher.materials.progress.overview');
        Route::post('/student/materials/{id}/progress', [StudentDashboardController::class, 'updateProgress'])->name('student.materials.updateProgress');
        Route::post('/materials/{material}/progress', [StudentDashboardController::class, 'updateProgress'])
            ->name('materials.updateProgress');
    });

    // ========== STUDENT ==========
    Route::middleware([RoleMiddleware::class . ':student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
        Route::get('/courses/{id}/view', [StudentDashboardController::class, 'viewMaterial'])->name('courses.view');
        Route::get('/materials/{id}/view', [StudentDashboardController::class, 'view'])->name('materials.view');
        Route::get('/materials/{id}/download', [StudentDashboardController::class, 'download'])->name('materials.download');
        Route::get('/progress', [StudentDashboardController::class, 'myProgress'])->name('progress');
        Route::get('/messages', [StudentMessageController::class, 'index'])->name('messages');
        Route::post('/messages/reply', [StudentMessageController::class, 'reply'])->name('messages.reply');
    });

    // ========== SUPERADMIN ==========
    
    Route::middleware([RoleMiddleware::class . ':superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        // Always allow access to these routes even during maintenance
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/toggle-maintenance', [SettingController::class, 'toggleMaintenance'])->name('settings.toggle.maintenance');
        // Backup Routes
        Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
        Route::get('/backups/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('/backups/delete/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
        Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
        
        // Reports routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/export', [ReportController::class, 'export'])->name('export'); // <-- ADD THIS
        });
        // Announcemnens routes
        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
            Route::post('/', [AnnouncementController::class, 'store'])->name('store');
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
            Route::post('/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('toggle');
        });

         
    
        

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/toggle-block', [UserManagementController::class, 'toggleBlock'])->name('toggle-block');
            Route::post('/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Admin Management
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [AdminManagementController::class, 'index'])->name('index');
            Route::get('/create', [AdminManagementController::class, 'create'])->name('create');
            Route::post('/', [AdminManagementController::class, 'store'])->name('store');
            Route::get('/{admin}/edit', [AdminManagementController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminManagementController::class, 'update'])->name('update');
            Route::delete('/{admin}', [AdminManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{admin}/toggle-block', [AdminManagementController::class, 'toggleBlock'])->name('toggle-block');
        });
    });
    

    Route::get('/check-my-role', function() {
        if (!auth()->check()) {
            return "You're not logged in";
        }
        
        $user = auth()->user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_student' => $user->role === 'student', // Explicit check
            'announcements_count' => \App\Models\Announcement::active()
                ->where(function($q) use ($user) {
                    $q->where('visible_to', 'all')
                      ->orWhere('visible_to', $user->role);
                })
                ->count()
        ]);
    })->middleware('auth');

});