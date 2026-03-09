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



// web.php
Route::PUT('complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])
     ->name('complaints.updateStatus')
     ->middleware('auth');


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
    // BASIC CRUD ROUTES (Individual manual routes)
    // ===========================================

    // LIST family members (with search)
    Route::get('/family-members', [FamilyMemberController::class, 'index'])
        ->name('family-members.index');

    // SEARCH residents (AJAX)
    Route::get('/family-members/search', [FamilyMemberController::class, 'searchResidents'])
        ->name('family-members.search');

    // CREATE form - Add family member
    Route::get('/family-members/create', [FamilyMemberController::class, 'create'])
        ->name('family-members.create');

    // STORE new family member
    Route::post('/family-members', [FamilyMemberController::class, 'store'])
        ->name('family-members.store');

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

    // ===========================================
    // BULK ACTIONS ROUTES (Manual definitions)
    // ===========================================

    // BULK ARCHIVE - Archive multiple family members
    Route::post('/family-members/bulk-archive', [FamilyMemberController::class, 'bulkArchive'])
        ->name('family-members.bulk-archive');

    // BULK RESTORE - Restore multiple archived family members
    Route::post('/family-members/bulk-restore', [FamilyMemberController::class, 'bulkRestore'])
        ->name('family-members.bulk-restore');

    // BULK DELETE - Permanently delete multiple family members
    Route::post('/family-members/bulk-delete', [FamilyMemberController::class, 'bulkDelete'])
        ->name('family-members.bulk-delete');

    // ===========================================
    // ARCHIVE/RESTORE INDIVIDUAL ROUTES
    // ===========================================

    // RESTORE - Restore a single archived family member
    Route::post('/family-members/{id}/restore', [FamilyMemberController::class, 'restore'])
        ->name('family-members.restore');

    // FORCE DELETE - Permanently delete a single family member
    Route::delete('/family-members/{id}/force-delete', [FamilyMemberController::class, 'forceDelete'])
        ->name('family-members.force-delete');

    // ===========================================
    // ADDITIONAL FEATURES (if needed)
    // ===========================================

    // EXPORT - Export family members data
    Route::get('/family-members/export', [FamilyMemberController::class, 'export'])
        ->name('family-members.export');

    // BULK EMAIL - Send email to multiple family members
    Route::post('/family-members/bulk-email', [FamilyMemberController::class, 'bulkEmail'])
        ->name('family-members.bulk-email');

    // SEARCH RESIDENTS - Alternative search endpoint
    Route::get('/family-members/search-residents', [FamilyMemberController::class, 'searchResidents'])
        ->name('family-members.search-residents');
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
