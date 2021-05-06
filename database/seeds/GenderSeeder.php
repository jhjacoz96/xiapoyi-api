<?php

use Illuminate\Database\Seeder;
use App\Gender;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = ['Masculino', 'Femenino'];
        foreach ($genders as $gender) {
            Gender::create(['nombre' => $gender]);
        }
    }
}
