<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\FileFamily;
use App\Member;

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
                             isset($request["vaccine"])         ? $model = $q->where("vacunacion", $request["vaccine"]) : "";
                             !empty($request["pregnant"])        ? $model = $q->where("embarazo", $request["pregnant"]) : "";
                             !empty($request["startDate"]) && 
                             !empty($request["endDate"])         ? $model = $q->whereBetween("created_at", [$request["startDate"], $request["endDate"]]) : "";
                             $model = $q->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

}