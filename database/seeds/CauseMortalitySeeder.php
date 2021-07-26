<?php

use Illuminate\Database\Seeder;
use App\CauseMortality;

class CauseMortalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $causeMortalitys = [
            'Cardiopatías isquémica',
            'Accidentes cerebrovascular',
            'Enfermedades pulmonar obstructiva crónica',
            'Infecciones del sistema respiratorio inferior',
            'Afecciones neonatales (nacimiento, asfixia, trauma al nacer, parto prematuro)',
            'Cánceres',
            'Enfermedades de alzheimer y otras demencias',
            'Enfermedades diarreicas',
            'Diabetes melitus',
            'Enfermedades renales',
            'Nefropatias',
        ];
        foreach ($causeMortalitys as $causeMortality) {
            CauseMortality::create(['nombre' => $causeMortality]);
        }
    }
}
