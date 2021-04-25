<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach (Resource::supported() as $permission) {
        //     Permission::create($permission);
        // }
        $permissions = [
            ['name' => 'maestros', 'description' => 'Maestros'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
