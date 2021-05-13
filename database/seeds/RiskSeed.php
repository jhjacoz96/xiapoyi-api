<?php

use Illuminate\Database\Seeder;
use App\Risk;
use App\RiskClassification;
use App\LevelRisk;
use App\LevelTotal;
class RiskSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classificationRisks = [
        	[
        		"name" => "Riesgos biológicos"
        	],
        	[
        		"name" => "Riesgos sanitarios"
        	],
        	[
        		"name" => "Riesgos socio-económicos"
        	],
        ];

        foreach ($classificationRisks as $value) {
        	RiskClassification::create($value);
        }

        $risks = [
        	[
        		"name" => "Personas con vacunación incompleta",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Personas  con malnutrición",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Personas con enfermedades de impacto",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Embarazadas con problemas",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Personas con discapacidad",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Personas con problemaas mentales",
        		"risk_classification_id" => 1
        	],
        	[
        		"name" => "Consume de agua insegura",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Personas  con malnutricion",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Mala eliminacion de basura y excretas",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Mala eliminacion de desehos liquidos",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Impacto ecologico por industrias",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Animales intra domicialarios",
        		"risk_classification_id" => 2
        	],
        	[
        		"name" => "Pobreza",
        		"risk_classification_id" => 3
        	],
        	[
        		"name" => "Desempleo o empleo informal del jefe de familia",
        		"risk_classification_id" => 3
        	],
        	[
        		"name" => "Analfabetismo del padre o la madre",
        		"risk_classification_id" => 3
        	],
        	[
        		"name" => "Desestructuracion  Familiar",
        		"risk_classification_id" => 3
        	],
        	[
        		"name" => "Violencia / Alcoholismo /Drogadiccion",
        		"risk_classification_id" => 3
        	],
        	[
        		"name" => "Hacinamiento",
        		"risk_classification_id" => 3
        	]
        ];

        foreach ($risks as $value) {
        	Risk::create($value);
        }*/

        $levelRisks = [
        	[
        		"name" => "Sin riesgo",
        		"value" => 0,
        		"color" => "green"
        	],
        	[
        		"name" => "Riesgo muy bajo",
        		"value" => 1,
        		"color" => "yellow"
        	],
        	[
        		"name" => "Riesgo bajo",
        		"value" => 2,
        		"color" => "orange"
        	],
        	[
        		"name" => "Riesgo moderado",
        		"value" => 3,
        		"color" => "pink"
        	],
        	[
        		"name" => "Riesgo alto",
        		"value" => 4,
        		"color" => "red"
        	]
        ];
        foreach ($levelRisks as $value) {
          LevelRisk::create($value);
        }

         $levelTotals = [
        	[
        		"name" => "Sin riesgo",
        		"rank" => "[0,0]",
        		"color" => "green"
        	],
        	[
        		"name" => "Riesgo bajo",
        		"rank" => "[1,14]",
        		"color" => "orange"
        	],
        	[
        		"name" => "Riesgo medio",
        		"rank" => "[15,34]",
        		"color" => "pink"
        	],
        	[
        		"name" => "Riesgo alto",
        		"rank" => "[35,72]",
        		"color" => "red"
        	]
        ];
        foreach ($levelTotals as $value) {
          LevelTotal::create($value);
        }
    }
}
