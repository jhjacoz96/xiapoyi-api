<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\FileFamily;
use App\Pregnant;
use App\Member;
use App\FileClinicalNeonatology;
use App\DiabeticPatient;
use App\Zone;
use App\levelTotal;
use App\CulturalGroup;
use App\Contamination;
use App\Pathology;
use App\Disability;
use App\GroupAge;
use App\Gender;
use App\GestationWeek;
use App\Medicine;

class ReportService {

    function __construct()
    {

    }
   
    public function fileFamilyIndex ($request) {
        try {
            $q = FileFamily::with("zone");
                             (count($request["zone"]) > 0)           ? $model = $q->whereIn("zone_id", $request["zone"]) : "";
                             (count($request["culturalGroup"]) > 0)  ? $model = $q->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                             (count($request["contamination"]) > 0)  ? $model = $q->whereHas('contaminationPoints', function($query)use($request){
                                 $query->whereIn('contamination_id', $request["contamination"]);
                             }) : "";
                             (count($request["levelTotalRisk"]) > 0) ? $model = $q->whereIn("level_total_id", $request["levelTotalRisk"]) : "";
                             !empty($request["startDate"]) &&   
                             !empty($request["endDate"])            ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                             $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function fileFamilyCriterion ($request) {
        $zone = Zone::whereIn('id', $request["zone"])->pluck("name")->toArray();
        $levelTotalRisk = levelTotal::whereIn('id', $request["levelTotalRisk"])->pluck("name")->toArray();
        $culturalGroup = CulturalGroup::whereIn('id', $request["culturalGroup"])->pluck("name")->toArray();
        $contamination = Contamination::whereIn('id', $request["contamination"])->pluck("nombre")->toArray();
        $data = collect([
                    "zone" => $zone,
                    "levelTotalRisk" => $levelTotalRisk,
                    "culturalGroup" => $culturalGroup,
                    "contamination" => $contamination,
                    "startDate" => $request["startDate"],
                    "endDate" => $request["endDate"],
                ]);
        return $data;
    }

    public function memberIndex ($request) {
        try {
            $q = Member::with("pathologies");
                             (count($request["disability"]) > 0) ? $model = $q->whereHas("disabilities", function($query) use($request) {
                                $query->whereIn("disabilities.id", $request["disability"]);
                             }) : "";
                             (count($request["pathology"]) > 0)  ? $model = $q->whereHas("pathologies", function($query) use($request) {
                                $query->whereIn("pathologies.id", $request["pathology"]);
                             }) : "";
                             (count($request["groupAge"]) > 0)   ? $model = $q->whereIn("group_age_id", $request["groupAge"]) : "";
                             (count($request["gender"]) > 0)          ? $model = $q->whereIn("gender_id", $request["gender"]) : "";
                             ($request["vaccine"] != null)       ? $model = $q->where("vacunacion", $request["vaccine"]) : "";
                             ($request["pregnant"] != null)      ? $model = $q->where("embarazo", $request["pregnant"]) : "";
                             !empty($request["startDate"]) && 
                             !empty($request["endDate"])         ? $model = $q->whereBetween("fecha_nacimiento", [$request["startDate"], $request["endDate"]]) : "";
                             $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function  memberCriterion ($request) {
        $pathology = Pathology::whereIn('id', $request["pathology"])->pluck("name")->toArray();
        $disability = Disability::whereIn('id', $request["disability"])->pluck("name")->toArray();
        $groupAge = GroupAge::whereIn('id', $request["groupAge"])->pluck("name")->toArray();
        $gender = gender::whereIn('id', $request["gender"])->pluck("nombre")->toArray();
        $data = collect([
                    "pathology" => $pathology,
                    "disability" => $disability,
                    "groupAge" => $groupAge,
                    "gender" => $gender,
                    "vaccine" => $request["vaccine"],
                    "startDate" => $request["startDate"] ? \Carbon\Carbon::parse($request["startDate"])->format('d/m/Y') : null,
                    "endDate" => $request["endDate"] ? \Carbon\Carbon::parse($request["endDate"])->format('d/m/Y') : null,
                ]);
        return $data;
    }

    public function fileClinicalObstetricIndex ($request) {
        try {
            
            $q = Pregnant::with('member');
                            (count($request["gestacion"]) > 0)             ? $model = $q->whereIn("descripcion_gestacion", $request["gestacion"]) : "";
                            (count($request["groupAge"]) > 0)              ? $model = $q->whereHas("member", function ($query) use($request) {
                                $query->whereIn("group_age_id", $request["groupAge"]);
                            }) : "";
                            (count($request["tipo_parto"]) > 0)            ? $model = $q->whereIn("tipo_parto", $request["tipo_parto"]) : "";
                            ($request["embarazo_planificado"] !== null)    ? $model = $q->where("embarazo_planificado", $request["embarazo_planificado"]) : "";
                            (count($request["causa_embarazo"]) > 0)        ? $model = $q->whereIn("causa_embarazo", $request["causa_embarazo"]) : "";
                            ($request["embarazo"] === true)                ? $model = $q->whereNull("recomendaciones") : "";
                            ($request["embarazo"] === false)               ? $model = $q->whereNotNull("recomendaciones") : "";
                            !empty($request["startDate"]) &&
                            !empty($request["endDate"])                    ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                            $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function  fileClinicalObstetricCriterion ($request) {
        $gestacion = GestationWeek::whereIn('name', $request["gestacion"])->pluck("name")->toArray();
        $groupAge = GroupAge::whereIn('id', $request["groupAge"])->pluck("name")->toArray();
        $data = collect([
                    "gestacion" => $gestacion,
                    "groupAge" => $groupAge,
                    "tipo_parto" => $request["tipo_parto"],
                    "embarazo_planificado" => $request["embarazo_planificado"],
                    "causa_embarazo" => $request["causa_embarazo"],
                    "embarazo" =>  $request["embarazo"],
                    "startDate" => $request["startDate"] ? \Carbon\Carbon::parse($request["startDate"])->format('d/m/Y') : null,
                    "endDate" => $request["endDate"] ? \Carbon\Carbon::parse($request["endDate"])->format('d/m/Y') : null,
                ]);
        return $data;
    }

    public function fileClinicalNeonatologyIndex ($request) {
        try {
            $q = FileClinicalNeonatology::with('member');
                            (count($request["gestacion"]) > 0)             ? $model = $q->whereHas("pregnant", function($query) use($request) {
                                $query->whereIn("descripcion_gestacion", $request["gestacion"]);
                            }) : "";
                            !empty($request["peso"]) ? $model = $q->whereBetween("peso", [$request["peso"][0], $request["peso"][1]]) : "";
                            (count($request["gender"]) > 0)  ? $model = $q->whereHas("member", function($query) use($request) {
                                $query->whereIn("gender_id", $request["gender"]);
                            }) : "";

                            (count($request['bcg']) > 0) ? $model = $q->whereIn('bcg', $request['bcg']) : "";
                            (count($request['hb']) > 0) ? $model = $q->whereIn('hb', $request['hb']) : "";
                            (count($request['rotavirus']) > 0) ? $model = $q->whereIn('rotavirus', $request['rotavirus']) : "";
                            (count($request['fipv']) > 0) ? $model = $q->whereIn('fipv', $request['fipv']) : "";
                            (count($request['bopv']) > 0) ? $model = $q->whereIn('bopv', $request['bopv']) : "";
                            (count($request['pentavaliente']) > 0) ? $model = $q->whereIn('pentavaliente', $request['pentavaliente']) : "";
                            (count($request['neumococo']) > 0) ? $model = $q->whereIn('neumococo', $request['neumococo']) : "";
                            (count($request['influenza_estacionaria']) > 0) ? $model = $q->whereIn('influenza_estacionaria', $request['influenza_estacionaria']) : "";
                            !empty($request["startDate"]) &&
                            !empty($request["endDate"])                    ? $model = $q->whereHas('member', function($query) use($request) {
                                $query->whereBetween("fecha_nacimiento", [$request["startDate"], $request["endDate"]]);
                            }) : "";
                            $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function  fileClinicalNeonatologyCriterion ($request) {
        $gestacion = GestationWeek::whereIn('name', $request["gestacion"])->pluck("name")->toArray();
        $gender = Gender::whereIn('id', $request["gender"])->pluck("nombre")->toArray();
        $data = collect([
                    "gestacion" => $gestacion,
                    "peso" => $request["peso"],
                    "gender" => $gender,
                    "bcg" => $request['bcg'],
                    "hb" => $request['hb'],
                    "rotavirus" => $request['rotavirus'],
                    "fipv" => $request['fipv'],
                    "bopv" => $request['bopv'],
                    "pentavaliente" => $request['pentavaliente'],
                    "neumococo" => $request['neumococo'],
                    "influenza_estacionaria" => $request['influenza_estacionaria'],
                    "startDate" => $request["startDate"] ? \Carbon\Carbon::parse($request["startDate"])->format('d/m/Y') : null,
                    "endDate" => $request["endDate"] ? \Carbon\Carbon::parse($request["endDate"])->format('d/m/Y') : null,
                ]);
        return $data;
    }

    public function diabeticPatientIndex ($request) {
        try {
            $now = Carbon::now();
            $days1 = $now->format("Y-m-d");
            $now = Carbon::now();
            $days2 = $now->addDay(-1)->format("Y-m-d");
            $now = Carbon::now();
            $days3 = $now->addDay(-2)->format("Y-m-d");
            $q = DiabeticPatient::with('member');
                            (count($request["groupAge"]) > 0)    ? $model =  $q->whereHas("member", function($query) use($request) {
                                $query->whereIn("group_age_id", $request["groupAge"]);
                            }) : "";
                            (count($request["pathology"]) > 0)   ? $model = $q->whereHas("member", function($query) use($request) {
                                $query->whereHas("pathologies", function ($query) use($request) {
                                    $query->whereIn("pathologies.id", $request["pathology"]);
                                });
                            }) : "";
                            (count($request["treatment"]) > 0)   ? $model = $q->whereHas("medicines", function ($query) use($request) {
                                $query->whereIn("medicines.id",$request["treatment"]);
                            }) : "";
                            count($request["gender"]) > 0       ? $model = $q->whereHas("member", function ($query) use($request) {
                                $query->whereIn("gender_id", $request["gender"]);
                            }) : "";
                            (count($request["imc"]) > 0)             ? $model = $q->whereIn("descripcion_imc", $request["imc"]) : "";

                           !empty($request["alertTreatment"]) ? $model = $q->whereHas("patientTreatment", function ($query) use($request, $days1, $days2, $days3) {
                                $query->whereDoesntHave("registerTreatment", function ($query) use($request, $days1, $days2, $days3) {
                                    if ($request["alertTreatment"] == 1) $query->whereDate("fecha","=", $days1);
                                    else if ($request["alertTreatment"] == 2) $query->whereDate("fecha",[$days1, $days2]);
                                    else if ($request["alertTreatment"] == 3) $query->whereDate("fecha", [$days1, $days3]);
                                });
                            }) : "";

                            $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function  diabeticPatientCriterion ($request) {
        $groupAge = GroupAge::whereIn('name', $request["groupAge"])->pluck("name")->toArray();
        $pathology = Pathology::whereIn('id', $request["pathology"])->pluck("name")->toArray();
        $treatment = Medicine::whereIn('id', $request["treatment"])->pluck("name")->toArray();
        $gender = Gender::whereIn('id', $request["gender"])->pluck("nombre")->toArray();
        $alertTreatment = null;
        switch ($request["alertTreatment"]) {
            case(1):
                $alertTreatment = "1 día de retrazo";
            break;
            case(2):
                $alertTreatment = "2 días de retrazo";
            break;
            case(3):
                $alertTreatment = "Más de 3 días";
            break;
            default:
                $alertTreatment = null;
        }
        $data = collect([
                    "groupAge" => $groupAge,
                    "pathology" => $pathology,
                    "treatment" => $treatment,
                    "gender" => $gender,
                    "imc" => $request["imc"],
                    "alertTreatment" => $alertTreatment,
                ]);
        return $data;
    }



}