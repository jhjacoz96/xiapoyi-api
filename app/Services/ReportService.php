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

class ReportService {

    function __construct()
    {

    }
   
    public function fileFamilyIndex ($request) {
        try {
            $q = FileFamily::with("zone");
                             (count($request["zone"]) > 0)           ? $model = $q->whereIn("zone_id", $request["zone"]) : "";
                             (count($request["culturalGroup"]) > 0)  ? $model = $q->whereIn("cultural_group_id", $request["culturalGroup"]) : "";
                             (count($request["levelTotalRisk"]) > 0) ? $model = $q->whereIn("level_total_id", $request["levelTotalRisk"]) : "";
                             !empty($request["startDate"]) && 
                             !empty($request["endDate"])            ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                             $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
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
                             !empty($request["gender"])          ? $model = $q->where("gender_id", $request["gender"]) : "";
                             ($request["vaccine"] != null)       ? $model = $q->where("vacunacion", $request["vaccine"]) : "";
                             ($request["pregnant"] != null)      ? $model = $q->where("embarazo", $request["pregnant"]) : "";
                             !empty($request["startDate"]) && 
                             !empty($request["endDate"])         ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                             $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
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
                            ($request["embarazo"] === true)                ? $model = $q->whereHas("member", function ($query) use($request) {
                                $query->where("embarazo", $request["embarazo"]);
                            })->whereNull("observacion_parto") : "";
                            ($request["embarazo"] === false)               ? $model = $q->whereHas("member", function ($query) use($request) {
                                $query->where("embarazo", $request["embarazo"]);
                            })->whereNotNull("observacion_parto") : "";
                            !empty($request["startDate"]) &&
                            !empty($request["endDate"])                    ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                            $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function fileClinicalNeonatologyIndex ($request) {
        try {
            $q = FileClinicalNeonatology::with('member');
                            (count($request["gestacion"]) > 0)             ? $model = $q->whereHas("pregnant", function($query) use($request) {
                                $query->whereIn("descripcion_gestacion", $request["gestacion"]);
                            }) : "";
                            !empty($request["peso"]) ? $model = $q->whereBetween("peso", [$request["peso"][0], $request["peso"][1]]) : "";
                            !empty($request["gender"]) ? $model = $q->whereHas("member", function($query) use($request) {
                                $query->where("gender_id", $request["gender"]);
                            }) : "";
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
                            !empty($request["gender"])           ? $model = $q->whereHas("member", function ($query) use($request) {
                                $query->where("gender_id", $request["gender"]);
                            }) : "";

                           !empty($request["alertTreatment"]) ? $model = $q->whereHas("patientTreatment", function ($query) use($request, $days1, $days2, $days3) {
                                $query->whereDoesntHave("registerTreatment", function ($query) use($request, $days1, $days2, $days3) {
                                    if ($request["alertTreatment"] == 1) $query->whereDate("fecha","=", $days1);
                                    else if ($request["alertTreatment"] == 2) $query->whereDate("fecha",[$days1, $days2]);
                                    else if ($request["alertTreatment"] == 3) $query->whereDate("fecha", [$days1, $days3]);
                                });
                            }) : "";

                           !empty($request["startDate"]) &&
                           !empty($request["endDate"])        ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";

                            $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }


}