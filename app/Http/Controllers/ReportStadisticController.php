<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\Pathology;
use App\Member;
use App\GroupAge;
use App\Risk;
use App\LevelRisk;
use App\LevelTotal;
use App\FileFamily;
use App\Zone;
use App\DiabeticPatient;

class ReportStadisticController extends Controller
{
     public function dashboard()
    {
        try {
            $pathologies = pathology::All();
            $namePathology = [];
            $cantPathology = [];
            foreach ($pathologies as $key => $value) {
            	$namePathology[] = $value['name'];  

            	$cantPathology[] = Member::whereHas('pathologies', function ($query) use($value) {
            			$query->where('name', $value["name"]);
            	})->count();
   	
            }

            $groupAges = GroupAge::All();
            $nameGroupAge = [];
            $cantGroupAge = [];
            foreach ($groupAges as $key => $value) {
                $nameGroupAge[] = $value["name"];
                $cantGroupAge[] = Member::where('gender_id', 2)
                    ->has('pregnant')
                    ->where('group_age_id', $value["id"])
                    ->count();
            }

            // $risks = Risk::All();
            // $levelRisk = LevelRisk::All();
            // $nivelRisk = [];
            // foreach ($levelRisk as $key => $value) {
            //     $nivelRisk[] = [
            //         "name" => $value["name"],
            //         "data" => [],
            //     ];
            // }
            // $nameRisk = [];
            // $cantRisk = [];
            // foreach ($risks as $key => $value) {
            //     $nameRisk[] = $value["name"];
            //     $nivelRisk["data"] = FileFamily::where('');
            // }


            $levelRisk = LevelTotal::All();
            $nivelRisk = [];
            $colorRisk = [];
            foreach ($levelRisk as $key => $value) {

                $nivelRisk[] = [
                    "name" => $value["name"],
                    "data" => [],
                    "color" => $value["color"],
                ];
                $colorRisk[] = $value["color"];
            }

            $zones = Zone::All();
            $nameZone = [];
            $cantMember = [];
            foreach ($zones as $key => $value) {
                $nameZone[] = $value["name"];

                foreach ($levelRisk as $key => $v) {
                    $cant = FileFamily::where('zone_id', $value["id"])->where('level_total_id', $v["id"])->count();
                    $nivelRisk[$key]["data"] = [
                        $cant
                    ];
                }

             }

            $data = [
            	"estadisticaPatologias" => [
            		"patologias" =>  $namePathology,
            		"cantidades" => $cantPathology,
                ],
                "estadisticaEmbarazadas" => [
                    "grupoEdades" =>  $nameGroupAge,
                    "cantidades" =>  $cantGroupAge,
                ],
                "estadisticasRiesgos" => [
                    "parroquias" => $nameZone,
                    "nivelRiesgo" => $nivelRisk,
                    "color" => $colorRisk,
                ],
                "cantidadFichasFamiliares" => FileFamily::count(),
                "cantidadEmbarazadas" => Member::where('embarazo', 1)->where('gender_id', 2)->count(),
                "cantidadDiabeticos" => DiabeticPatient::count(),
            ];



            return bodyResponseRequest(EnumResponse::ACCEPTED,  $data);
        } catch (Exception $e) {
            return $e;
        }
    }
}
