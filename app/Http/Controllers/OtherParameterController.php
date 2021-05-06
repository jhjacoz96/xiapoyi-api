<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\Relationship;
use App\PsychotrophicSubstance;
use App\GestationWeek;
use App\Scholarship;

class OtherParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

}
