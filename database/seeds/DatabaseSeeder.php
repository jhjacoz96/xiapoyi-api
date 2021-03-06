<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CantonSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(TypeDocumentSeeder::class);
        $this->call(ParameterFileSedeer::class);
        $this->call(UserSeeder::class);
    }
}
