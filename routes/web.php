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
use App\Http\Controllers\ComptableController;

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
        Route::get('/admin/rapports/pdf', [RapportController::class,'exportPDF'])
            ->name('admin.rapports.pdf');
        Route::get('/admin/rapports/excel', [RapportController::class,'exportExcel'])
            ->name('admin.rapports.excel');
        Route::resource('admin/rapports', RapportController::class)->names('admin.rapports');
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

    // ──────────────────────────────────────────────────────────────
    // ESPACE COMPTABLE — accessible au rôle comptable
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:comptable')->prefix('comptable')->name('comptable.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [ComptableController::class, 'dashboard'])
            ->name('dashboard');

        // Recettes — CRUD complet
        Route::get('/recettes',             [ComptableController::class, 'recettesIndex'])->name('recettes.index');
        Route::get('/recettes/create',      [ComptableController::class, 'recettesCreate'])->name('recettes.create');
        Route::post('/recettes',            [ComptableController::class, 'recettesStore'])->name('recettes.store');
        Route::get('/recettes/{recette}',   [ComptableController::class, 'recettesShow'])->name('recettes.show');
        Route::get('/recettes/{recette}/edit', [ComptableController::class, 'recettesEdit'])->name('recettes.edit');
        Route::put('/recettes/{recette}',   [ComptableController::class, 'recettesUpdate'])->name('recettes.update');
        Route::delete('/recettes/{recette}',[ComptableController::class, 'recettesDestroy'])->name('recettes.destroy');

        // Rapports — CRUD complet
        Route::get('/rapports',              [ComptableController::class, 'rapportsIndex'])->name('rapports.index');
        Route::get('/rapports/create',       [ComptableController::class, 'rapportsCreate'])->name('rapports.create');
        Route::post('/rapports',             [ComptableController::class, 'rapportsStore'])->name('rapports.store');
        Route::get('/rapports/pdf',          [ComptableController::class, 'rapportsPDF'])->name('rapports.pdf');
        Route::get('/rapports/excel',        [ComptableController::class, 'rapportsExcel'])->name('rapports.excel');
        Route::get('/rapports/{rapport}',    [ComptableController::class, 'rapportsShow'])->name('rapports.show');
        Route::get('/rapports/{rapport}/edit', [ComptableController::class, 'rapportsEdit'])->name('rapports.edit');
        Route::put('/rapports/{rapport}',    [ComptableController::class, 'rapportsUpdate'])->name('rapports.update');
        Route::delete('/rapports/{rapport}', [ComptableController::class, 'rapportsDestroy'])->name('rapports.destroy');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE AGENT — accessible au rôle agent
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:agent')->prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AgentController::class, 'dashboard'])->name('dashboard');
        
        // Voyages
        Route::get('/voyages', [\App\Http\Controllers\AgentController::class, 'index'])->name('voyages');
        Route::get('/voyages/create', [\App\Http\Controllers\AgentController::class, 'create'])->name('voyages.create');
        Route::get('/voyages/events', [\App\Http\Controllers\AgentController::class, 'events'])->name('voyages.events');
        Route::get('/voyages/{id}/edit', [\App\Http\Controllers\AgentController::class, 'edit'])->name('voyages.edit');
        Route::get('/voyages/{id}', [\App\Http\Controllers\AgentController::class, 'show'])->name('voyages.show');
        Route::post('/voyages', [\App\Http\Controllers\AgentController::class, 'store'])->name('voyages.store');
        Route::put('/voyages/{id}', [\App\Http\Controllers\AgentController::class, 'update'])->name('voyages.update');
        Route::put('/voyages/{id}/move', [\App\Http\Controllers\AgentController::class, 'move'])->name('voyages.move');
        Route::delete('/voyages/{id}', [\App\Http\Controllers\AgentController::class, 'destroy'])->name('voyages.destroy');
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
