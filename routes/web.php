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
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read');

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

    // ──────────────────────────────────────────────────────────────
    // ESPACE TECHNICIEN — accessible au rôle technicien
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:technicien')->prefix('technicien')->name('technicien.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TechnicienController::class, 'dashboard'])->name('dashboard');
        
        // Véhicules (Read-only)
        Route::get('/vehicules', [TechnicienController::class, 'vehiculesIndex'])->name('vehicules.index');
        Route::get('/vehicules/{vehicule}', [TechnicienController::class, 'vehiculesShow'])->name('vehicules.show');
        
        // Maintenances (CRUD complet)
        Route::get('/maintenances', [TechnicienController::class, 'maintenancesIndex'])->name('maintenances.index');
        Route::get('/maintenances/create', [TechnicienController::class, 'maintenancesCreate'])->name('maintenances.create');
        Route::post('/maintenances', [TechnicienController::class, 'maintenancesStore'])->name('maintenances.store');
        Route::get('/maintenances/{maintenance}', [TechnicienController::class, 'maintenancesShow'])->name('maintenances.show');
        Route::get('/maintenances/{maintenance}/edit', [TechnicienController::class, 'maintenancesEdit'])->name('maintenances.edit');
        Route::put('/maintenances/{maintenance}', [TechnicienController::class, 'maintenancesUpdate'])->name('maintenances.update');
        Route::delete('/maintenances/{maintenance}', [TechnicienController::class, 'maintenancesDestroy'])->name('maintenances.destroy');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE MANAGER — accessible au rôle manager
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        
        // Modules (Lecture seule)
        Route::get('/vehicules', [ManagerController::class, 'vehiculesIndex'])->name('vehicules.index');
        Route::get('/vehicules/{vehicule}', [ManagerController::class, 'vehiculesShow'])->name('vehicules.show');
        
        Route::get('/chauffeurs', [ManagerController::class, 'chauffeursIndex'])->name('chauffeurs.index');
        Route::get('/chauffeurs/{chauffeur}', [ManagerController::class, 'chauffeursShow'])->name('chauffeurs.show');
        
        Route::get('/voyages', [ManagerController::class, 'voyagesIndex'])->name('voyages.index');
        Route::get('/voyages/{id}', [ManagerController::class, 'voyagesShow'])->name('voyages.show');
        
        Route::get('/maintenances', [ManagerController::class, 'maintenancesIndex'])->name('maintenances.index');
        Route::get('/maintenances/{maintenance}', [ManagerController::class, 'maintenancesShow'])->name('maintenances.show');
        
        Route::get('/documents', [ManagerController::class, 'documentsIndex'])->name('documents.index');
        Route::get('/documents/{document}', [ManagerController::class, 'documentsShow'])->name('documents.show');
        
        Route::get('/recettes', [ManagerController::class, 'recettesIndex'])->name('recettes.index');
        Route::get('/recettes/{recette}', [ManagerController::class, 'recettesShow'])->name('recettes.show');
        
        Route::get('/rapports', [ManagerController::class, 'rapportsIndex'])->name('rapports.index');
        Route::get('/rapports/{rapport}', [ManagerController::class, 'rapportsShow'])->name('rapports.show');
        
        Route::get('/audits', [ManagerController::class, 'auditsIndex'])->name('audits.index');
        Route::get('/audits/{id}', [ManagerController::class, 'auditsShow'])->name('audits.show');
        
        Route::get('/users', [ManagerController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/{id}', [ManagerController::class, 'usersShow'])->name('users.show');
    });

    // ──────────────────────────────────────────────────────────────
    // ESPACE GESTIONNAIRE — accessible au rôle gestionnaire
    // ──────────────────────────────────────────────────────────────
    Route::middleware('role:gestionnaire')->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [GestionnaireController::class, 'dashboard'])->name('dashboard');
        
        // Chauffeurs (CRUD)
        Route::get('/chauffeurs', [GestionnaireController::class, 'chauffeursIndex'])->name('chauffeurs.index');
        Route::get('/chauffeurs/create', [GestionnaireController::class, 'chauffeursCreate'])->name('chauffeurs.create');
        Route::post('/chauffeurs', [GestionnaireController::class, 'chauffeursStore'])->name('chauffeurs.store');
        Route::get('/chauffeurs/{chauffeur}', [GestionnaireController::class, 'chauffeursShow'])->name('chauffeurs.show');
        Route::get('/chauffeurs/{chauffeur}/edit', [GestionnaireController::class, 'chauffeursEdit'])->name('chauffeurs.edit');
        Route::put('/chauffeurs/{chauffeur}', [GestionnaireController::class, 'chauffeursUpdate'])->name('chauffeurs.update');
        Route::delete('/chauffeurs/{chauffeur}', [GestionnaireController::class, 'chauffeursDestroy'])->name('chauffeurs.destroy');

        // Documents (CRUD)
        Route::get('/documents', [GestionnaireController::class, 'documentsIndex'])->name('documents.index');
        Route::get('/documents/create', [GestionnaireController::class, 'documentsCreate'])->name('documents.create');
        Route::post('/documents', [GestionnaireController::class, 'documentsStore'])->name('documents.store');
        Route::get('/documents/{document}', [GestionnaireController::class, 'documentsShow'])->name('documents.show');
        Route::get('/documents/{document}/edit', [GestionnaireController::class, 'documentsEdit'])->name('documents.edit');
        Route::put('/documents/{document}', [GestionnaireController::class, 'documentsUpdate'])->name('documents.update');
        Route::delete('/documents/{document}', [GestionnaireController::class, 'documentsDestroy'])->name('documents.destroy');

        // Vehicules (CRUD)
        Route::get('/vehicules', [GestionnaireController::class, 'vehiculesIndex'])->name('vehicules.index');
        Route::get('/vehicules/create', [GestionnaireController::class, 'vehiculesCreate'])->name('vehicules.create');
        Route::post('/vehicules', [GestionnaireController::class, 'vehiculesStore'])->name('vehicules.store');
        Route::get('/vehicules/{vehicule}', [GestionnaireController::class, 'vehiculesShow'])->name('vehicules.show');
        Route::get('/vehicules/{vehicule}/edit', [GestionnaireController::class, 'vehiculesEdit'])->name('vehicules.edit');
        Route::put('/vehicules/{vehicule}', [GestionnaireController::class, 'vehiculesUpdate'])->name('vehicules.update');
        Route::delete('/vehicules/{vehicule}', [GestionnaireController::class, 'vehiculesDestroy'])->name('vehicules.destroy');

        // Maintenances (Read-only)
        Route::get('/maintenances', [GestionnaireController::class, 'maintenancesIndex'])->name('maintenances.index');
        Route::get('/maintenances/{maintenance}', [GestionnaireController::class, 'maintenancesShow'])->name('maintenances.show');
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

    }); // End check.role

});
