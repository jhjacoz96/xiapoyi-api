<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\CulturalGroup;

class CulturalGroupService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = CulturalGroup::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = CulturalGroup::create([
                "name" => $data["name"],
                "description" => $data["description"],
            ]);
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
            $model = CulturalGroup::find($id);
            if(!$model) return null;
            $model->update([
              "name" => $data["name"],
              "description" => $data["description"],
            ]);
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
            $model = CulturalGroup::find($id);
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
            $model = CulturalGroup::find($id);
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