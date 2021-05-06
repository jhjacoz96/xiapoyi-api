<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Service;

class ServiceService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Service::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Service::create($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
    public function assignActivities ($data, $id) {
        try {
            $model = Service::find($data["id"]);
            if(!$model) return null;
            $validar = $data['activities']  ?? null;
            if (!is_null($validar)) {
                $activities = [];
                foreach ($data['activities'] as $item) {
                    $activities[] = [
                        "id" =>  $item["id"] ?? null,
                        "nombre" =>  $item["nombre"],
                        "service_id" => $data["id"]
                    ];
                }
                $model->assignActivities($activities);
            }
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = Service::find($id);
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
            $model = Service::find($id);
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
            $model = Service::find($id);
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