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
use App\RiskFile;


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

            $groupAges = GroupAge::where('id','>=',4)->get();
            $nameGroupAge = [];
            $cantGroupAge = [];
            foreach ($groupAges as $key => $value) {
                $nameGroupAge[] = $value["name"];
                $cantGroupAge[] = Member::where('gender_id', 2)
                    ->has('pregnant')
                    ->where('group_age_id', $value["id"])
                    ->count();
            }


            $levelRisk = LevelTotal::All();
            $nivelRisk = [];
            $colorRisk = [];
            foreach ($levelRisk as $key => $value) {

                $nivelRisk[] = [
                    "name" => $value["name"],
                    "data" => [],
                    "color" => $value["color"],
                ];
            }

            $zones = Zone::All();
            $nameZone = [];
            $cantMember = [];
            foreach ($zones as $key => $value) {
                $nameZone[] = $value["name"];

                foreach ($levelRisk as $key => $v) {
                    $cant = FileFamily::where('zone_id', $value["id"])->where('level_total_id', $v["id"])->count();
                    $nivelRisk[$key]["data"][] = $cant;
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

    public function risk (Request $request) {
        $label = [];
        $cant = [];
        $model = LevelTotal::All();
        foreach ($model as $key => $value) {
           $label[] = $value["name"];
           $q = FileFamily::where("level_total_id", $value["id"]);
                count($request["culturalGroup"]) > 0 ? $result = $q->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                count($request["zone"]) > 0          ? $result = $q->whereIn("zone_id", $request["zone"]) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
            $cant[] = $result->count();
        }

        $data = [
            "label" => $label,
            "data" => $cant,
        ];
        return $data;
    }
    public function evolution (Request $request) {
        $label = [];
        $cant = [];
        $model = collect([
            [
                "name" => "Si cumplió",
                "value" => "si",
            ],
            [
                "name" => "No cumplió",
                "value" => "no",
            ],
            [
                "name" => "Cumplió parcialmente",
                "value" => "parcial",
            ]
        ]);

        foreach ($model as $key => $value) {
           $label[] = $value["name"];
           $q = FileFamily::whereHas("riskFiles", function($query) use($value) {
            $query->where("cumplio", $value["value"]);
           });
                count($request["culturalGroup"]) > 0 ? $result = $q->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                count($request["zone"]) > 0          ? $result = $q->whereIn("zone_id", $request["zone"]) : "";
                !empty($request["startDate"]) && 
                !empty($request["endDate"])          ? $result = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                 $result = $q->get();
            $cant[] = $result->count();
        }

        $data = [
            "label" => $label,
            "data" => $cant,
        ];
        return $data;
    }
}
