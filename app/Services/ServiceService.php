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
            $model->view_web = false;
            $model->save();
            /*if (isset($data['image_service'])) $model->assignImage($data['image_service']);*/
            if ($data['image'] != "null") {
                $image = $data['image']->getRealPath();
                $folder = 'image/service';
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $model->image()->create([
                   'url' => $c['url'],
                   'public_id' => $c['public_id'],
                ]);
            }
            DB::commit();
            return $model;
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
            if (isset($data['view_web'])) $model->view_web = $data["view_web"];
            $model->save();
            if (isset($data['image']) && $data['image'] != "null") {
                $image = $data['image']->getRealPath();
                $folder = 'image/service';
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $model->image->url = $c["url"];
                $model->image->public_id = $c["public_id"];
                $model->push();
            }
            // $model->assignImage($data['image_service']);
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
            $model = Service::find($id);
            if(!$model) return null;
            if ($model->image->public_id) {
                $folder = 'image/service';
                \Cloudder::destroyImage($model->image->public_id, ['folder' => $folder]);
            }
            $model->delete();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}