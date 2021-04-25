<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminRolePermissions();
        $this->createMedicoRolePermissions();
    }

    private function createAdminRolePermissions()
    {
        $role = Role::findByName('Admin');
        $role->syncPermissions(Permission::all());
    }

    /**
     * Creates the permissions for the role Moderator
     */
    private function createMedicoRolePermissions()
    {
        $role = Role::findByName('Medico');
        $role->syncPermissions(Permission::where('name', 'Maestro')->first());
    }
}
