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
        $this->call(ParameterFileSedeer::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CantonSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RiskSeed::class);
    }
}
