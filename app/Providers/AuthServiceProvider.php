<?php

namespace App\Providers;

use App\Models\Chauffeur;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Vehicule;
use App\Policies\VehiculePolicy;
use App\Models\Voyage;
use App\Policies\VoyagePolicy;
use App\Models\RecetteMensuelle;
use App\Policies\RecettePolicy;
use App\Models\Document;
use App\Policies\DocumentPolicy;
use App\Models\Maintenance;
use App\Policies\ChauffeurPolicy;
use App\Policies\MaintenancePolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Vehicule::class, VehiculePolicy::class);
        Gate::policy(Voyage::class, VoyagePolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
    Gate::policy(Chauffeur::class, ChauffeurPolicy::class);
        Gate::policy(Maintenance::class, MaintenancePolicy::class);
        Gate::policy(RecetteMensuelle::class, RecettePolicy::class);
    }
}

