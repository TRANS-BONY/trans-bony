<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Voyage;
use App\Models\Maintenance;
use App\Models\Document;
use App\Models\RecetteMensuelle;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS (firstOrCreate to avoid duplicate)
        // Users moved to UserSeeder

        // CALL SEPARATED SEEDERS
$this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            VehiculeSeeder::class,
            ChauffeurSeeder::class,
            VoyageSeeder::class,
            MaintenanceSeeder::class,
            DocumentSeeder::class,
            RecetteSeeder::class,
        ]);
    }

}
