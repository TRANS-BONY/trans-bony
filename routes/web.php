<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\VoyageController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\RapportController;

/*
|--------------------------------------------------------------------------
| PAGE D'ACCUEIL → LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| APRÈS LOGIN → DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','active'])->group(function(){

Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // MODULES - Role/Permission protected
Route::middleware('permission:gerer vehicules')->group(function () {
        Route::resource('admin/vehicules', VehiculeController::class)->names('admin.vehicules');
    });

Route::middleware('permission:gerer chauffeurs')->group(function () {
        Route::resource('admin/chauffeurs', ChauffeurController::class)->names('admin.chauffeurs');
    });

Route::middleware('permission:gerer voyages')->group(function () {
        Route::get('/admin/voyages/events', [VoyageController::class, 'events'])->name('admin.voyages.events');
        Route::put('/admin/voyages/{voyage}/move', [VoyageController::class, 'move'])->name('admin.voyages.move');
        Route::resource('admin/voyages', VoyageController::class)->names('admin.voyages');
    });

Route::middleware('permission:gerer maintenance')->group(function () {
        Route::resource('admin/maintenances', MaintenanceController::class)->names('admin.maintenances');
    });

Route::middleware('permission:gerer documents')->group(function () {
        Route::resource('admin/documents', DocumentController::class)->names('admin.documents');
        Route::get('admin/documents/{document}/download', [DocumentController::class, 'download'])->name('admin.documents.download');
    });

Route::middleware('permission:gerer finances')->group(function () {
        Route::resource('admin/recettes', RecetteController::class)->names('admin.recettes');
    });

Route::middleware('permission:voir rapports')->group(function () {
        Route::get('/admin/rapports', [RapportController::class,'index'])->name('admin.rapports.index');
        Route::get('/admin/rapports/pdf', [RapportController::class,'exportPDF'])
            ->name('admin.rapports.pdf');
        Route::get('/admin/rapports/excel', [RapportController::class,'exportExcel'])
            ->name('admin.rapports.excel');
    });

    // Notifications accessible to all auth
    Route::get('/notifications', function(){
        return response()->json([
            'count' => \App\Models\Audit::count()
        ]);
    });

    // Admin only - Audits
Route::middleware('role:admin')->group(function () {
        Route::resource('admin/audits', \App\Http\Controllers\AuditController::class)->names('admin.audits');
    });

    // Admin only - Users
Route::middleware('role:admin')->group(function () {
        Route::resource('admin/users', \App\Http\Controllers\UserController::class)->names('admin.users');
    });

    // Profile for all authenticated users
    Route::redirect('/profile', '/profile/edit');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

});
