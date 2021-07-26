<?php

use Illuminate\Database\Seeder;
use App\Contamination;
use App\CauseContamination;

class ContaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contamination = [
            'Hidrico',
            'Suelo',
            'Acustica',
            'Lúminica',
            'Visual',
            'Terminca',
        ];
        foreach ($contamination as $item) {
            Contamination::create(['nombre' => $item]);
        }
        $causeContamination = [
            [
                "nombre" => "Desechos residuales de industrias",
            ],
            [
                "nombre" => "Cloacas",
            ],
            [
                "nombre" => "Explotación de suelos por industrias",
            ],
            [
                "nombre" => "Actividades industriales, agrícolas y ganaderas",
            ],
            [
                "nombre" => "Contrucciones cercanas",
            ],
            [
                "nombre" => "Vecinos",
            ],
            [
                "nombre" => "Transporte",
            ],
            [
                "nombre" => "Mal diseño de alumbrados",
            ],
            [
                "nombre" => "Presencia excesiva de postes y cableado de electricidad",
            ],
            [
                "nombre" => "Abarotamiento de anuncios publicitarios",
            ],
            [
                "nombre" => "Uso del agua como sistema de refrigeración",
            ],
            [
                "nombre" => "Deforestación",
            ],
            [
                "nombre" => "Escorrentía de superficies pavimentadas",
            ],
            [
                "nombre" => "Causas naturales",
            ],
        ];
        foreach ($causeContamination as $item) {
            CauseContamination::create($item);
        }

    }
}
