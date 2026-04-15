<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\SidebarComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * Registers the SidebarComposer to inject live DB counts
     * (véhicules, chauffeurs, voyages, maintenances, documents…)
     * into every view that uses the app layout.
     */
    public function boot(): void
    {
        // Share sidebar stats with every view (authenticated pages)
        View::composer('*', SidebarComposer::class);
    }
}
