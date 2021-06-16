<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\Relationship;
use App\PsychotrophicSubstance;
use App\GestationWeek;
use App\Scholarship;
use App\AlterationPregnant;
use App\PathologyNeonatal;
use App\PathologyPregnant;
use App\Reflex;
use App\Pathology;
use App\SenalAlarm;

class OtherParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reflexIndex()
    {
        try {
            $model = Reflex::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pathologyPregnantIndex()
    {
        try {
            $model = PathologyPregnant::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function pathologyNeonatalIndex()
    {
        try {
            $model = PathologyNeonatal::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function alterationPregnantIndex()
    {
        try {
            $model = AlterationPregnant::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function relationshipIndex()
    {
        try {
            $model = Relationship::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function psyshotrophicIndex()
    {
        try {
            $model = PsychotrophicSubstance::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function gestationWeekIndex()
    {
        try {
            $model = GestationWeek::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }
    public function scholarshipIndex()
    {
        try {
            $model = Scholarship::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }
    public function senalAlarmIndex()
    {
        try {
            $model = SenalAlarm::All();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

}
