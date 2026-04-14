<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Gestionnaire
        $gestionnaire = User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestion@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $gestionnaire->assignRole('gestionnaire');

        // Agent
        $agent = User::create([
            'name' => 'Agent Voyage',
            'email' => 'agent@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $agent->assignRole('agent');

        // Technicien
        $technicien = User::create([
            'name' => 'Technicien',
            'email' => 'tech@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $technicien->assignRole('technicien');

        // Comptable
        $comptable = User::create([
            'name' => 'Comptable',
            'email' => 'compta@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $comptable->assignRole('comptable');

        // Manager
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@transbony.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $manager->assignRole('manager');
    }
}

