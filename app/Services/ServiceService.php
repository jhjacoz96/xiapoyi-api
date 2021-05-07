<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Service;
use App\Activity;

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
            
            $children = $model->activities;
            $activitiesItems = $data["activities"];
            $deletedIds = $children->filter(function ($child) use ($activitiesItems) {
                return !in_array($child->id, $activitiesItems);
            })->map(function ($child) {
                $id = $child->id;
                $child->update(["service_id" => null]);
                return $id;
            });
            foreach ($activitiesItems as $item) {
               $model = Activity::find($item);
               $model->update(["service_id" => $id]);
            }
            $model = Service::find($data["id"]);
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