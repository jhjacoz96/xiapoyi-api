<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\GroupAge;

class GroupAgeService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = GroupAge::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = GroupAge::create([
                "name" => $data["name"],
                "description" => $data["description"],
                "rank" => $data["rank"],
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
            $model = GroupAge::find($id);
            if(!$model) return null;
            $model->update([
              "name" => $data["name"],
              "description" => $data["description"],
              "rank" => $data["rank"],l
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
            $model = GroupAge::find($id);
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
            $model = GroupAge::find($id);
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