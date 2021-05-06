<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Zone;
use App\Province;
use App\Canton;

class ZoneService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Zone::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function provinceFind () {
        try {
            
            $model = Province::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function cantonFind ($id) {
        try {
            
            $model = Canton::where("province_id", $id)->get();
            if(!$model) return null;
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function zoneFind ($id) {
        try {
            
            $model = Zone::where("canton_id", $id)->get();
            if(!$model) return null;
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Zone::create($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = Zone::find($id);
            if(!$model) return null;
            $model->update($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = Zone::find($id);
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function delete ($id) {
        try {
            DB::beginTransaction();
            $model = Zone::find($id);
            if(!$model) return null;
            $model->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}