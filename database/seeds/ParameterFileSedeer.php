<?php

use Illuminate\Database\Seeder;
use App\GestationWeek;
use App\Relationship;
use App\Scholarship;
use App\Specialty;
use App\Employee;

class ParameterFileSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gestations = [
            [
                "name" => "Pretérmino",
                "rank" => "[28,36]",
            ],
            [
                "name" => "Termino",
                "rank" => "[37,42]",
            ],
            [
                "name" => "Postérmino",
                "rank" => "[43,100]",
            ],
        ];
        foreach ($gestations as $gestation) {
            GestationWeek::create(['name' => $gestation["name"], "rank" => $gestation["name"]]);
        }

        $scholarships = [
            [
                "name" => "Sin escolaridad",
            ],
            [
                "name" => "Básica",
            ],
            [
                "name" => "Bachillerato",
            ],
            [
                "name" => "Superior",
            ],
            [
                "name" => "Especialización",
            ],
        ];
        foreach ($scholarships as $scholarship) {
            Scholarship::create(['name' => $scholarship["name"]]);
        }
        
        $relationships = [
            [
                "name" => "Esposo/a",
            ],
            [
                "name" => "Hijo/a",
            ],
            [
                "name" => "Suegro/a",
            ],
            [
                "name" => "Sobrino/a",
            ],
            [
                "name" => "Tío/a",
            ],
            [
                "name" => "Nieto/a",
            ],
            [
                "name" => "Abuelo/a",
            ],
            [
                "name" => "Bisabuelo/a",
            ],
            [
                "name" => "Bisnieto/a",
            ],
            [
                "name" => "Nuera",
            ],
            [
                "name" => "Yerno",
            ],
            [
                "name" => "Padrastro",
            ],
            [
                "name" => "Madrasdra",
            ],
            [
                "name" => "Hermanastro/a",
            ],
            [
                "name" => "Primo/a",
            ],
            [
                "name" => "Otro...",
            ],
        ];
        foreach ($relationships as $relationship) {
            Relationship::create($relationship);
        } 

        $typeDocuments = ["Ecuatoriano", "Extrajero"];
        foreach ($typeDocuments as $typeDocument) {
           TypeDocument::create(["nombre" => $typeDocument]);
        }

        $specialtys = ["Doctor", "Enfermera"];
        foreach ($specialtys as $specialty) {
            Specialty::create(["name" => $specialty]);
        }

        
    }
}
