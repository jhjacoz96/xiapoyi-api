<?php

use Illuminate\Database\Seeder;
use App\GestationWeek;
use App\Relationship;
use App\Scholarship;
use App\TypeDocument;
use App\Specialty;
use App\typeEmployee;
use App\Employee;
use App\Vaccine;
use App\PsychotrophicSubstance;
use App\ExamRoutine;
use App\AlterationPregnant;
use App\PathologyNeonatal;
use App\GroupAge;
use App\PathologyPregnant;
use App\Reflex;
use App\Pathology;
use App\TypeBlood;
use App\CulturalGroup;
use App\Disability;
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
                "name" => "Posmaduro",
                "rank" => "[42, 100]",
                "color" => "#2B46FC",
            ],
            [
                "name" => "A término",
                "rank" => "[37, 41]",
                "color" => "#04F528",
            ],
            [
                "name" => "Prematuro leve",
                "rank" => "[35, 36]",
                 "color" => "#F5F127",
            ],
            [
                "name" => "Prematuro moderado",
                "rank" => "[33, 34]",
                "color" => "#F5BF29",
            ],
            [
                "name" => "Prematuro extremo",
                "rank" => "[10, 32]",
                "color" => "#F55E26",
            ],
        ];
        foreach ($gestations as $gestation) {
            GestationWeek::create([
                'name' => $gestation["name"],
                "rank" => $gestation["rank"],
                "color" => $gestation["color"],
            ]);
        }

        $groupAges = [
            [
                "name" => "Bebé (0 a 1 año)",
                "rank" => "[0, 1]",
                "description" => "#2B46FC",
            ],
            [
                "name" => "Primera infancia (2 a 5 años)",
                "rank" => "[2, 5]",
                "description" => "#04F528",
            ],
            [
                "name" => "Infancia (6 a 11 años)",
                "rank" => "[6, 11]",
                 "description" => "#F5F127",
            ],
            [
                "name" => "Adolececia (12 a 18 años)",
                "rank" => "[12, 18]",
                "description" => "#F5BF29",
            ],
            [
                "name" => "Juventud (19 a 26 años)",
                "rank" => "[19, 26]",
                "description" => "#F55E26",
            ],
            [
                "name" => "Adultez (27 a 59 años)",
                "rank" => "[27, 59]",
                "description" => "#F55E26",
            ],
            [
                "name" => "Vejez (Más de 60)",
                "rank" => "[60, 200]",
                "description" => "#F55E26",
            ],
        ];
        foreach ($groupAges as $value) {
            GroupAge::create([
                'name' => $value["name"],
                "rank" => $value["rank"],
                "description" => $value["description"],
            ]);
        }

        $scholarships = [
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
                "name" => "Jefe de la familia",
            ],
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

        $specialtys = ["Neonatología", "Obstetricia"];
        foreach ($specialtys as $specialty) {
            Specialty::create(["name" => $specialty]);
        }

        $tps = ["Doctor", "Enfermera"];
        foreach ($tps as $tp) {
            TypeEmployee::create(["name" => $tp]);
        }

        $s = ["Tosferina", "Difteria ", "Tétanos "];
        foreach ($s as $ss) {
            Vaccine::create(["name" => $ss]);
        }

        $p = ["Alcohol", "Drogas ", "Tabaco", "Opiáceos"];
        foreach ($p as $pp) {
            PsychotrophicSubstance::create(["name" => $pp]);
        }

        $e = ["Hemograma/ Hto-Hb", "Urocultivo y orina completa ", "Grupo sanguíneo Rh/Coombs indirecto ", "VDRL-RPR", "VIH", "Papanicolau (Citología cervical)", "Ultrasonido (ecografía) por indicación", "Examen de Chagas en zonas endémicas"];
        foreach ($e as $ee) {
            ExamRoutine::create(["name" => $ee]);
        }

        $typeBloods = [
            "A +",
            "O +",
            "B +",
            "AB +",
            "O -",
        ];

        foreach ($typeBloods as $typeBlood) {
            TypeBlood::create(["name" => $typeBlood]);
        }

        $culturalGroups = [
            "Awá",
            "Chachi",
            "Epera",
            "Tsa'chila",
            "Manta huancavílca",
            "Karánki",
            "Natabuela",
            "Otavalo",
            "Kayambi",
            "Kitu - Kara",
            "Panzaleo",
            "Chibuelo",
            "Salasaka",
            "Kisapincha",
            "Kichua" ,
            "Waranka",
            "Puruhá",
            "Kañari",
            "Saraguro",
            "A'i Cofán",
            "Secoya",
            "Siona",
            "Huahoráni",
            "Shiwiar",
            "Zápara",
            "Achuar",
            "Mestizo",
            "Afroecuatoriano",
            "Indígena",
            "Blanco",
        ];

        foreach ($culturalGroups as $culturalGroup) {
            CulturalGroup::create(["name" => $culturalGroup]);
        }

        $alterationPregnants = [
            "Oligohidramnios",
            "Polihidramnios",
            "Retraso CIU",
        ];

        foreach ($alterationPregnants as $alterationPregnant) {
            AlterationPregnant::create(["nombre" => $alterationPregnant]);
        }

        $pathologyNeonatals = [
            "Apneas",
            "Ventilación mecanica",
            "Sindrome de dificultad respiratoria",
            "Hemorragia",
            "Sepsis",
            "Convulsiones",
            "Hipoglucemia",
            "Incompatibilidad grupo y factor",
        ];

        foreach ($pathologyNeonatals as $pathologyNeonatal) {
            PathologyNeonatal::create(["nombre" => $pathologyNeonatal]);
        }

        $pathologyPregnants = [
            "Rubeola",
            "Toxoplasmosis",
            "Citomegalovirus",
            "Pre eclampsia",
            "Eclamsia",
            "Diábetes gestacional",
            "Diábetes melitus",
        ];

        foreach ($pathologyPregnants as $pathologyPregnant) {
            PathologyPregnant::create(["nombre" => $pathologyPregnant]);
        }

        $reflexs = [
            "Reflejo de búsqueda",
            "Reflejo de succión",
            "Reflejo de Moro",
            "Reflejo tónico del cuello",
            "Reflejo de prensión",
            "Reflejo de babinski",
            "Reflejo del paso",
        ];

        foreach ($reflexs as $reflex) {
            Reflex::create(["nombre" => $reflex]);
        }

        $pathologys = [
            ["name" => "Diábetes", "capture" => true],
            ["name" => "Hipertensión", "capture" => false],
            ["name" => "Cardiovasculares", "capture" => false],
            ["name" => "Renales", "capture" => false],
            ["name" => "Cáncer", "capture" => false],
            ["name" => "Otros", "capture" => false],
        ];

        foreach ($pathologys as $pathology) {
            Pathology::create($pathology);
        }

        $disabilities = [
            "Física",
            "Visual",
            "Auditiva",
            "Intelectual".
            "Lenguaje",
            "Psicosocial",
            "Múltiple",
        ];

        foreach ($disabilities as $disability) {
            Disability::create(["name" => $disability]);
        }

    }
}
