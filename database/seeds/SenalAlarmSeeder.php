<?php

use Illuminate\Database\Seeder;
use App\SenalAlarm;

class SenalAlarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $senalAlarms = [
          'Signos de infección',
          'Cuidado de la herida por Cesárea ',
          'Cuidado de la Episiorrafia',
          'Cantidad normal de salida de loquios',
          'Cuidado de los pezones',
          'Señales de HTA',
          'Signos y síntomas de infección de las vías urinarias',
          'Signos y síntomas de infección de las vías urinarias',
          'Alimentos que debe evitar en su dieta',
         ];
        foreach ($senalAlarms as $senalAlarm) {
            SenalAlarm::create(['nombre' => $senalAlarm]);
        }
    }
}
