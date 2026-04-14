<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        $permissions = [
            'gerer vehicules',
            'gerer chauffeurs',
            'gerer voyages',
            'gerer maintenance',
            'gerer documents',
            'gerer finances',
            'voir rapports'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Rôles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $gestionnaire = Role::firstOrCreate(['name' => 'gestionnaire']);
        $agent = Role::firstOrCreate(['name' => 'agent']);
        $technicien = Role::firstOrCreate(['name' => 'technicien']);
$comptable = Role::firstOrCreate(['name' => 'comptable']);
        $manager = Role::firstOrCreate(['name' => 'manager']);

        // Attribution permissions

        $admin->givePermissionTo(Permission::all());

$gestionnaire->givePermissionTo([
            'gerer vehicules',
            'gerer chauffeurs',
            'gerer voyages',
            'gerer maintenance',
            'gerer documents'
        ]);

        $manager->givePermissionTo([
            'gerer vehicules',
            'gerer chauffeurs',
            'gerer voyages',
            'gerer maintenance',
            'gerer documents'
        ]);

        $agent->givePermissionTo([
            'gerer chauffeurs',
            'gerer voyages'
        ]);

        $technicien->givePermissionTo([
            'gerer maintenance'
        ]);

        $comptable->givePermissionTo([
            'gerer finances',
            'voir rapports'
        ]);
    }
}
