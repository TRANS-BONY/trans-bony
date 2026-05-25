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
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\ComptableController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AgentController;

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
Route::middleware(['auth', 'active', 'audit'])->group(function(){

    // ──────────────────────────────────────────────────────────────
    // SALLE D'ATTENTE (Pour les utilisateurs sans rôle)
    // ──────────────────────────────────────────────────────────────
    Route::get('/waiting-room', function() {
        return view('auth.waiting-room');
    })->name('waiting.room');

    Route::middleware('check.role')->group(function() {

        Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

    // MODULES - Role/Permission protected
Route::middleware('permission:gerer vehicules')->group(function () {
        Route::resource('admin/vehicules', VehiculeController::class)->names('admin.vehicules');
        Route::get('admin/carburants/pdf', [\App\Http\Controllers\CarburantController::class, 'generatePdf'])->name('admin.carburant.pdf');
        Route::resource('admin/carburants', \App\Http\Controllers\CarburantController::class)->names('admin.carburant');
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

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'readAndRedirect'])->name('notifications.read');

    // Admin only - Audits
    Route::middleware('role:admin')->group(function () {
        Route::post('admin/audits/clear', [AuditController::class, 'clear'])->name('admin.audits.clear');
        Route::get('admin/audits/user/{id}', [AuditController::class, 'userHistory'])->name('admin.audits.user');
        Route::resource('admin/audits', AuditController::class)->names('admin.audits');
    });

    // Admin only - Users
Route::middleware('role:admin')->group(function () {
        Route::resource('admin/users', UserController::class)->names('admin.users');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE COMPTABLE — accessible au rôle comptable
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:comptable')->prefix('comptable')->name('comptable.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Recettes — CRUD complet
        Route::get('/recettes',             [RecetteController::class, 'index'])->name('recettes.index');
        Route::get('/recettes/create',      [RecetteController::class, 'create'])->name('recettes.create');
        Route::post('/recettes',            [RecetteController::class, 'store'])->name('recettes.store');
        Route::get('/recettes/{recette}',   [RecetteController::class, 'show'])->name('recettes.show');
        Route::get('/recettes/{recette}/edit', [RecetteController::class, 'edit'])->name('recettes.edit');
        Route::put('/recettes/{recette}',   [RecetteController::class, 'update'])->name('recettes.update');
        Route::delete('/recettes/{recette}',[RecetteController::class, 'destroy'])->name('recettes.destroy');

        // Rapports — CRUD complet
        Route::get('/rapports',              [RapportController::class, 'index'])->name('rapports.index');
        Route::get('/rapports/create',       [RapportController::class, 'create'])->name('rapports.create');
        Route::post('/rapports',             [RapportController::class, 'store'])->name('rapports.store');
        Route::get('/rapports/pdf',          [RapportController::class, 'exportPDF'])->name('rapports.pdf');
        Route::get('/rapports/excel',        [RapportController::class, 'exportExcel'])->name('rapports.excel');
        Route::get('/rapports/{rapport}',    [RapportController::class, 'show'])->name('rapports.show');
        Route::get('/rapports/{rapport}/edit', [RapportController::class, 'edit'])->name('rapports.edit');
        Route::put('/rapports/{rapport}',    [RapportController::class, 'update'])->name('rapports.update');
        Route::delete('/rapports/{rapport}', [RapportController::class, 'destroy'])->name('rapports.destroy');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE AGENT — accessible au rôle agent
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:agent')->prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Voyages
        Route::get('/voyages', [VoyageController::class, 'index'])->name('voyages.index');
        Route::get('/voyages/create', [VoyageController::class, 'create'])->name('voyages.create');
        Route::get('/voyages/events', [VoyageController::class, 'events'])->name('voyages.events');
        Route::get('/voyages/{id}/edit', [VoyageController::class, 'edit'])->name('voyages.edit');
        Route::get('/voyages/{id}', [VoyageController::class, 'show'])->name('voyages.show');
        Route::post('/voyages', [VoyageController::class, 'store'])->name('voyages.store');
        Route::put('/voyages/{id}', [VoyageController::class, 'update'])->name('voyages.update');
        Route::put('/voyages/{id}/move', [VoyageController::class, 'move'])->name('voyages.move');
        Route::delete('/voyages/{id}', [VoyageController::class, 'destroy'])->name('voyages.destroy');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE TECHNICIEN — accessible au rôle technicien
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:technicien')->prefix('technicien')->name('technicien.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Véhicules (Read-only)
        Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules.index');
        Route::get('/vehicules/{vehicule}', [VehiculeController::class, 'show'])->name('vehicules.show');
        
        // Maintenances (CRUD complet)
        Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
        Route::get('/maintenances/create', [MaintenanceController::class, 'create'])->name('maintenances.create');
        Route::post('/maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');
        Route::get('/maintenances/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');
        Route::get('/maintenances/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
        Route::put('/maintenances/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');
        Route::delete('/maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE MANAGER — accessible au rôle manager
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Modules (Standardized Resources)
        Route::resource('vehicules', VehiculeController::class)->names('vehicules');
        Route::resource('chauffeurs', ChauffeurController::class)->names('chauffeurs');
        Route::get('/voyages/events', [VoyageController::class, 'events'])->name('voyages.events');
        Route::resource('voyages', VoyageController::class)->names('voyages');
        Route::resource('maintenances', MaintenanceController::class)->names('maintenances');
        Route::resource('documents', DocumentController::class)->names('documents');
        Route::resource('recettes', RecetteController::class)->names('recettes');
        Route::resource('rapports', RapportController::class)->names('rapports');
        Route::get('/carburant/pdf', [\App\Http\Controllers\CarburantController::class, 'generatePdf'])->name('carburant.pdf');
        Route::resource('carburant', \App\Http\Controllers\CarburantController::class)->names('carburant');
        
        // Audit & Utilisateurs
        Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
        Route::get('/audits/{id}', [AuditController::class, 'show'])->name('audits.show');
        Route::resource('users', UserController::class)->names('users');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE GESTIONNAIRE — accessible au rôle gestionnaire
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:gestionnaire')->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Chauffeurs (CRUD)
        Route::get('/chauffeurs', [ChauffeurController::class, 'index'])->name('chauffeurs.index');
        Route::get('/chauffeurs/create', [ChauffeurController::class, 'create'])->name('chauffeurs.create');
        Route::post('/chauffeurs', [ChauffeurController::class, 'store'])->name('chauffeurs.store');
        Route::get('/chauffeurs/{chauffeur}', [ChauffeurController::class, 'show'])->name('chauffeurs.show');
        Route::get('/chauffeurs/{chauffeur}/edit', [ChauffeurController::class, 'edit'])->name('chauffeurs.edit');
        Route::put('/chauffeurs/{chauffeur}', [ChauffeurController::class, 'update'])->name('chauffeurs.update');
        Route::delete('/chauffeurs/{chauffeur}', [ChauffeurController::class, 'destroy'])->name('chauffeurs.destroy');

        // Documents (CRUD)
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

        // Vehicules (CRUD)
        Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules.index');
        Route::get('/vehicules/create', [VehiculeController::class, 'create'])->name('vehicules.create');
        Route::post('/vehicules', [VehiculeController::class, 'store'])->name('vehicules.store');
        Route::get('/vehicules/{vehicule}', [VehiculeController::class, 'show'])->name('vehicules.show');
        Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class, 'edit'])->name('vehicules.edit');
        Route::put('/vehicules/{vehicule}', [VehiculeController::class, 'update'])->name('vehicules.update');
        Route::delete('/vehicules/{vehicule}', [VehiculeController::class, 'destroy'])->name('vehicules.destroy');

        // Maintenances (Read-only)
        Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
        Route::get('/maintenances/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');

        // Voyages (Read-only)
        Route::get('/voyages', [VoyageController::class, 'index'])->name('voyages.index');
        Route::get('/voyages/{id}', [VoyageController::class, 'show'])->name('voyages.show');

        // Carburant (CRUD)
        Route::get('/carburant/pdf', [\App\Http\Controllers\CarburantController::class, 'generatePdf'])->name('carburant.pdf');
        Route::resource('carburant', \App\Http\Controllers\CarburantController::class)->names('carburant');
    });

    // Profile for all authenticated users
    Route::redirect('/profile', '/profile/edit');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    }); // End check.role

});
