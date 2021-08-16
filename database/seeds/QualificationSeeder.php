<?php

use Illuminate\Database\Seeder;
use App\QualificationQuestion;
use App\QualificationLevel;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            "¿Cómo calificarías tu experiencia al usar esta aplicación?",
            "¿Cómo consideras que ha sido la ayuda que presta la aplicación?"
        ];

        foreach ($questions as $item) {
            QualificationQuestion::create(["nombre" => $item]);
        }

        $levels = [
            [
                "nombre" => "Totalmente satisfactoria",
                "nivel" => 5,
            ],
            [
                "nombre" => "Satisfactoria",
                "nivel" => 4,
            ],
            [
                "nombre" => "Neutra",
                "nivel" => 3,
            ],
            [
                "nombre" => "Insatisfactoria",
                "nivel" => 2,
            ],
            [
                "nombre" => "Totalmente insatifactoria",
                "nivel" => 1,
            ],
        ];

        foreach ($levels as $item) {
            QualificationLevel::create(["nombre" => $item["nombre"], "nivel" => $item["nivel"]]);
        }
    }
}
