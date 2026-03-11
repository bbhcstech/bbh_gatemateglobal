<?php

use App\Http\Controllers\ProfileController;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PatrolController;
use App\Http\Controllers\SecurityGuardController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\DomesticHelpController;

 use App\Http\Controllers\VisitorPreapprovalController;
 use App\Http\Controllers\VisitorLogController;
use App\Http\Controllers\VendorVisitController;
use App\Http\Controllers\HelpRatingController;
use App\Http\Controllers\HelpAttendanceController;
use App\Http\Controllers\HelpPaymentController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ParkingController;

// routes/web.php
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SecurityAlertController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CabPreapprovalController;

use App\Http\Controllers\CabEntryController;
use App\Http\Controllers\DeliveryPreapprovalController;

use App\Http\Controllers\DeliveryEntryController;

Route::get('/get-resident-by-visitor/{id}', [App\Http\Controllers\VisitorPreapprovalController::class, 'getResident']);
Route::get('/visitor-log-details/{id}',
    [VisitorLogController::class, 'visitorDetails']);

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('verify-otp');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


 Route::get('/getparking/{flat_id}', [ResidentController::class, 'getParking']);
Route::get('/getfloors/{tower}', [ResidentController::class, 'getFloors']);
Route::get('/getflats/{floor}', [ResidentController::class, 'getFlats']);






  Route::resource('admin/complaints', ComplaintController::class);



// // web.php
// Route::PUT('complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])
//      ->name('complaints.updateStatus')
//      ->middleware('auth');

// Complaints Management Routes
Route::prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/', [App\Http\Controllers\ComplaintController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\ComplaintController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\ComplaintController::class, 'store'])->name('store');
    Route::get('/archived', [App\Http\Controllers\ComplaintController::class, 'archived'])->name('archived');
    Route::get('/all-residents', [App\Http\Controllers\ComplaintController::class, 'allResidents'])->name('all-residents');
    Route::get('/{id}', [App\Http\Controllers\ComplaintController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\ComplaintController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\ComplaintController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\ComplaintController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/status', [App\Http\Controllers\ComplaintController::class, 'updateStatus'])->name('update-status');
    Route::post('/{id}/confirm-resolution', [App\Http\Controllers\ComplaintController::class, 'confirmResolution'])->name('confirm-resolution');
    Route::post('/bulk-delete', [App\Http\Controllers\ComplaintController::class, 'bulkDelete'])->name('bulk-delete');
    Route::post('/bulk-status', [App\Http\Controllers\ComplaintController::class, 'bulkStatusUpdate'])->name('bulk-status');
});

Route::middleware('auth')->group(function () {

    /* ================= RESIDENT ================= */



    Route::get('/cab',
        [CabPreapprovalController::class,'index']
    )->name('cab.index');

    Route::get('/cab/create',
        [CabPreapprovalController::class,'create']
    )->name('cab.create');

    Route::post('/cab/store',
        [CabPreapprovalController::class,'store']
    )->name('cab.store');


    Route::resource('delivery', DeliveryPreapprovalController::class);



Route::middleware('auth')->group(function () {

    Route::get('/residents/{id}/profile', [App\Http\Controllers\ResidentController::class, 'show'])
    ->name('residents.profile')
    ->middleware('auth');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 PROFILE PICTURE ROUTE — FIXED
    Route::match(['post', 'patch'], '/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');

    // Notification Settings
    Route::patch('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');

    // Family Members Routes
    Route::post('/profile/family', [FamilyMemberController::class, 'store'])->name('profile.family.store');
    Route::get('/profile/family/{id}/edit', [FamilyMemberController::class, 'edit'])->name('profile.family.edit');
    Route::put('/profile/family/{id}', [FamilyMemberController::class, 'update'])->name('profile.family.update');
    Route::delete('/profile/family/{id}', [FamilyMemberController::class, 'destroy'])->name('profile.family.destroy');

    // Pets Routes
    Route::post('/profile/pets', [PetController::class, 'store'])->name('profile.pets.store');
    Route::get('/profile/pets/{id}/edit', [PetController::class, 'edit'])->name('profile.pets.edit');
    Route::put('/profile/pets/{id}', [PetController::class, 'update'])->name('profile.pets.update');
    Route::delete('/profile/pets/{id}', [PetController::class, 'destroy'])->name('profile.pets.destroy');

    // Vehicles Routes
    Route::post('/profile/vehicles', [VehicleController::class, 'store'])->name('profile.vehicles.store');
    Route::get('/profile/vehicles/{id}/edit', [VehicleController::class, 'edit'])->name('profile.vehicles.edit');
    Route::put('/profile/vehicles/{id}', [VehicleController::class, 'update'])->name('profile.vehicles.update');
    Route::delete('/profile/vehicles/{id}', [VehicleController::class, 'destroy'])->name('profile.vehicles.destroy');
});





/* ================= SECURITY ================= */



Route::get('/cab/entry', [CabEntryController::class, 'index'])->name('cab.entry.list');
Route::post('/cab/entry/{id}', [CabEntryController::class, 'entry'])
    ->name('cab.entry.mark');

Route::post('/cab/exit/{id}', [CabEntryController::class, 'exit'])
    ->name('cab.exit.mark');


Route::get('delivery/{id}/entry', [DeliveryEntryController::class, 'entry'])
    ->name('delivery.entry');

Route::get('delivery/{id}/exit', [DeliveryEntryController::class, 'exit'])
    ->name('delivery.exit');
Route::get('delivery-entry', [DeliveryEntryController::class, 'index'])
    ->name('delivery.entry.index');


Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');

    Route::get('/alerts', [SecurityAlertController::class, 'index'])->name('alerts.index');

    Route::post('/alerts/store', [SecurityAlertController::class, 'store'])->name('alerts.store');

    Route::post('/alerts/resolve/{id}', [SecurityAlertController::class, 'resolve'])->name('alerts.resolve');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::post('/notifications/read/{id}', [NotificationController::class, 'markRead'])->name('notifications.read');
Route::get('parking', [ParkingController::class, 'index'])->name('parking.index');
Route::post('parking/store', [ParkingController::class, 'store'])->name('parking.store');

Route::get('get-floors/{tower}', [ParkingController::class, 'getFloors']);
Route::get('get-flats/{floor}', [ParkingController::class, 'getFlats']);

Route::delete('parking/{id}', [ParkingController::class, 'destroy'])->name('parking.destroy');


Route::resource('pets', PetController::class);

// Route::resource('pets', PetController::class);
// Route::get('pets/archived', [PetController::class, 'archived'])->name('pets.archived');
// Route::post('pets/bulk-delete', [PetController::class, 'bulkDelete'])->name('pets.bulk-delete');
// Route::post('pets/bulk-restore', [PetController::class, 'bulkRestore'])->name('pets.bulk-restore');
// Route::put('pets/{id}/restore', [PetController::class, 'restore'])->name('pets.restore');
// Route::delete('pets/{id}/force-delete', [PetController::class, 'forceDelete'])->name('pets.force-delete');
// Route::patch('pets/{id}/vaccination', [PetController::class, 'updateVaccination'])->name('pets.vaccination');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Pet Management Routes
    Route::prefix('pets')->name('pets.')->group(function () {
        // Fixed routes (no parameters) - MUST come first
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::get('/archived', [PetController::class, 'archived'])->name('archived');
        Route::get('/create', [PetController::class, 'create'])->name('create');
        Route::get('/all-residents', [PetController::class, 'allResidents'])->name('all-residents');

        // Routes with parameters - MUST come after fixed routes
        Route::get('/archived/{id}', [PetController::class, 'archivedShow'])->name('archived-show');
        Route::get('/{pet}', [PetController::class, 'show'])->name('show');
        Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('edit');
        Route::post('/', [PetController::class, 'store'])->name('store');
        Route::put('/{pet}', [PetController::class, 'update'])->name('update');
        Route::delete('/{pet}', [PetController::class, 'destroy'])->name('destroy');
        Route::put('/{pet}/restore', [PetController::class, 'restore'])->name('restore');
        Route::delete('/{pet}/force-delete', [PetController::class, 'forceDelete'])->name('force-delete');
        Route::patch('/{pet}/status', [PetController::class, 'toggleStatus'])->name('status');
        Route::post('/bulk-delete', [PetController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [PetController::class, 'bulkRestore'])->name('bulk-restore');
        Route::patch('/{id}/toggle-dangerous', [PetController::class, 'toggleDangerous'])->name('toggle-dangerous');
    }); // <-- This closing brace was missing!

    // Resident profile route
    Route::get('/resident/profile/{id}', [App\Http\Controllers\ResidentController::class, 'profile'])->name('residents.profile');
});

// ===========================================
// HELP ATTENDANCE ROUTE
// ===========================================
Route::get('/help-attendance', [HelpAttendanceController::class, 'index'])
    ->name('help.attendance.index');

// ===========================================
// FAMILY MEMBERS ROUTES - Protected by Auth
// ===========================================
Route::middleware(['auth'])->group(function () {

    // ===========================================
    // BASIC CRUD ROUTES (no parameters)
    // ===========================================

    // LIST family members (with search)
    Route::get('/family-members', [FamilyMemberController::class, 'index'])
        ->name('family-members.index');

    // SEARCH residents (AJAX)
    Route::get('/family-members/search', [FamilyMemberController::class, 'searchResidents'])
        ->name('family-members.search');

  Route::get('/family-members/create', [FamilyMemberController::class, 'create'])
    ->name('family-members.create');

    // STORE new family member
    Route::post('/family-members', [FamilyMemberController::class, 'store'])
        ->name('family-members.store');

    // ===========================================
    // FIXED ROUTES (no parameters) - MUST come BEFORE parameter routes
    // ===========================================

    // ALL RESIDENTS FAMILIES ROUTE
   Route::get('/family-members/all-residents', [FamilyMemberController::class, 'allResidents'])->name('family-members.all-residents');

    // ARCHIVED ROUTES - Place these BEFORE any {parameter} routes
    Route::get('/family-members/archived', [FamilyMemberController::class, 'archived'])
        ->name('family-members.archived');

    Route::get('/family-members/archived/{id}', [FamilyMemberController::class, 'archivedShow'])
        ->name('family-members.archived-show');

    // ===========================================
    // PARAMETER ROUTES - MUST come AFTER all fixed routes
    // ===========================================

    // SHOW specific family member
    Route::get('/family-members/{familyMember}', [FamilyMemberController::class, 'show'])
        ->name('family-members.show');

    // EDIT form
    Route::get('/family-members/{familyMember}/edit', [FamilyMemberController::class, 'edit'])
        ->name('family-members.edit');

    // UPDATE family member
    Route::put('/family-members/{familyMember}', [FamilyMemberController::class, 'update'])
        ->name('family-members.update');

    // DELETE family member (soft delete/archive)
    Route::delete('/family-members/{familyMember}', [FamilyMemberController::class, 'destroy'])
        ->name('family-members.destroy');

    // RESTORE soft deleted family member
    Route::put('/family-members/{id}/restore', [FamilyMemberController::class, 'restore'])
        ->name('family-members.restore');

    // FORCE DELETE permanently
    Route::delete('/family-members/{id}/force-delete', [FamilyMemberController::class, 'forceDelete'])
        ->name('family-members.force-delete');

    // BULK OPERATIONS
    Route::post('/family-members/bulk-delete', [FamilyMemberController::class, 'bulkDelete'])
        ->name('family-members.bulk-delete');

    Route::post('/family-members/bulk-restore', [FamilyMemberController::class, 'bulkRestore'])
        ->name('family-members.bulk-restore');

    Route::delete('/family-members/bulk-force-delete', [FamilyMemberController::class, 'bulkForceDelete'])
        ->name('family-members.bulk-force-delete');
});

// ===========================================
// API ROUTES (if you need separate API endpoints)
// ===========================================
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/residents/search', [FamilyMemberController::class, 'searchResidents'])
        ->name('api.residents.search');
});

// ===========================================
// RESOURCE ROUTE (Alternative - does same as above)
// ===========================================
// Route::resource('family-members', FamilyMemberController::class)->middleware('auth');




    Route::get('/help-attendance/create', [HelpAttendanceController::class, 'create'])
    ->name('help.attendance.create');

Route::post('/help-attendance', [HelpAttendanceController::class, 'store'])
    ->name('help.attendance.store');

Route::get('/help-payments', [HelpPaymentController::class, 'index'])
    ->name('help.payments.index');

     Route::get('/create', [HelpPaymentController::class, 'create'])
        ->name('help.payments.create');

    Route::post('/store', [HelpPaymentController::class, 'store'])
        ->name('help.payments.store');

Route::get('/help-ratings', [HelpRatingController::class, 'index'])
    ->name('help.ratings.index');

/* Optional CRUD for ratings */
 Route::resource('help-ratings', HelpRatingController::class);

   Route::resource('vendor-visits', VendorVisitController::class);

   Route::resource('visitor-preapproval', VisitorPreapprovalController::class);
   Route::delete('/visitor-preapproval/{id}',
    [VisitorPreapprovalController::class, 'destroy']
)->name('visitor-preapproval.destroy');


Route::put(
    'visitor-preapproval/{id}/approve',
    [VisitorPreapprovalController::class, 'approve']
)->name('visitor-preapproval.approve');


    Route::post('visitor-entry', [VisitorLogController::class,'entry'])
    ->name('visitor.entry');

Route::post('visitor-exit/{id}', [VisitorLogController::class,'exit'])
    ->name('visitor.exit');

    Route::get('visitor-logs', [VisitorLogController::class, 'index'])
    ->name('visitor-logs.index');


Route::resource('domestic-helps', DomesticHelpController::class);

   Route::get('towers/create', [TowerController::class, 'create'])->name('towers.create');
Route::post('towers/store-dynamic', [TowerController::class, 'storeDynamic'])->name('towers.store.dynamic');

Route::get('towers/{tower}/edit', [TowerController::class, 'edit'])
    ->name('towers.edit');

Route::put('towers/{tower}', [TowerController::class, 'update'])
    ->name('towers.update');

Route::delete('towers/{tower}', [TowerController::class, 'destroy'])
    ->name('towers.destroy');

Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
Route::post('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');



    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/creates', [UserController::class, 'creates'])->name('users.creates');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{user}/toggle', [UserController::class, 'toggleStatus'])
        ->name('users.toggle');
      Route::resource('amenities', AmenityController::class)
        ->only(['index','create','store','destroy','update']);
        Route::get('/amenities/{id}/edit', [AmenityController::class, 'edit'])->name('amenities.edit');


Route::patch('amenities/{id}/status', [AmenityController::class, 'status'])
     ->name('amenities.status');

 Route::get('amenities/{id}', [AmenityController::class, 'show'])
    ->name('amenities.show');

Route::get('security-guards/{id}/toggle', [SecurityGuardController::class,'toggle'])->name('security-guards.toggle');
Route::get('security-guards/{id}/reset', [SecurityGuardController::class,'resetPassword'])->name('security-guards.reset');
  Route::get('security-guards/{id}/show', [SecurityGuardController::class, 'show'])->name('security-guards.show');

    Route::delete('security-guards/{id}/delete', [SecurityGuardController::class, 'destroy'])
        ->name('security-guards.destroy');

    Route::post('/admin/patrols/{patrol}/status',
    [PatrolController::class, 'changeStatus']
)->name('patrols.changeStatus');


    Route::get('/security-guards', [SecurityGuardController::class, 'index'])
        ->name('security-guards.index');
     Route::get('/security-guards/create', [SecurityGuardController::class, 'create'])
        ->name('security-guards.create');

    Route::post('/security-guards', [SecurityGuardController::class, 'store'])
        ->name('security-guards.store');


        Route::get('/security-guards/{id}/edit', [SecurityGuardController::class, 'edit'])
        ->name('security-guards.edit');

    Route::put('/security-guards/{id}', [SecurityGuardController::class, 'update'])
        ->name('security-guards.update');

     Route::resource('patrols', \App\Http\Controllers\PatrolController::class)
        ->only(['index', 'create', 'store']);

        Route::get('patrols/{id}/show', [PatrolController::class, 'show'])
        ->name('patrols.show');

    Route::get('patrols/{id}/edit', [PatrolController::class, 'edit'])
        ->name('patrols.edit');

    Route::put('patrols/{id}/update', [PatrolController::class, 'update'])
        ->name('patrols.update');

    Route::delete('patrols/{id}/delete', [PatrolController::class, 'destroy'])
        ->name('patrols.destroy');

    /* ============= VEHICLE ROUTES (FIXED) ============= */
    // Archive & Restore Routes - MUST come before resource

        // ALL RESIDENTS VEHICLES ROUTE - MAKE SURE THIS LINE EXISTS
         Route::get('/vehicles/all-residents', [VehicleController::class, 'allResidents'])->name('vehicles.all-residents');
    Route::get('/vehicles/archived', [VehicleController::class, 'archived'])->name('vehicles.archived');
    Route::put('/vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
    Route::delete('/vehicles/{id}/force-delete', [VehicleController::class, 'forceDelete'])->name('vehicles.force-delete');
     // Show archived vehicle details
    Route::get('/archived/{id}', [VehicleController::class, 'archivedShow'])->name('archived.show');

    // Bulk force delete vehicles (admin only)
    Route::delete('/vehicles/bulk-force-delete', [VehicleController::class, 'bulkForceDelete'])->name('vehicles.bulk-force-delete');

    // Status Routes
    Route::patch('/vehicles/{id}/status', [VehicleController::class, 'toggleStatus'])->name('vehicles.status');

    // Bulk Operations
    Route::post('/vehicles/bulk-delete', [VehicleController::class, 'bulkDelete'])->name('vehicles.bulk-delete');
    Route::post('/vehicles/bulk-restore', [VehicleController::class, 'bulkRestore'])->name('vehicles.bulk-restore');



    // Resource Route - This creates all CRUD routes automatically
    Route::resource('vehicles', VehicleController::class);




    Route::resource('residents', ResidentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


  Route::prefix('visitors')->name('visitors.')->group(function () {

        Route::get('/', [VisitorController::class, 'index'])->name('index');
        Route::get('/create', [VisitorController::class, 'create'])->name('create');
        Route::post('/store', [VisitorController::class, 'store'])->name('store');
        Route::get('/{visitor}/edit', [VisitorController::class, 'edit'])->name('edit');
        Route::put('/{visitor}', [VisitorController::class, 'update'])->name('update');
        Route::delete('/{visitor}', [VisitorController::class, 'destroy'])->name('destroy');

        Route::post('/{id}/approve', [VisitorController::class, 'approve'])
    ->name('approve');

    });
});






// Front Controller
Route::get('/', [FrontendController::class, 'index'])->name('home');


Route::get('/logout', function () {
    Session::forget('auth_id'); // Remove auth_id from session
    return redirect()->route('home');
})->name('logout');

require __DIR__.'/auth.php';
