<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Publication;
use App\Employee;

class PublicationService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Publication::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) { 
        try {
            DB::beginTransaction();
            $model = Publication::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'employee_id' => Employee::where('user_id', \Auth()->user()->id)->first()->id,
                'filter_two_publication_id' => $data['filter_two_publication_id'],
                'filter_one_publication_id' => $data['filter_one_publication_id'],
                'filter_three_publication_id' => $data['filter_three_publication_id'],
            ]);
            $resources = json_decode(($data["resources"]), true);
            $model->assingImageMini($data['image_mini']);
            $resourcess = [];
            foreach ($resources as $resource) {
                if ($resource["type_resource"] == 'image') {
                    $image = $model->assingResource($resource["url"]);
                    $resourcess[] = [
                        "id" => $resource['id'] ?? null,
                        "type_resource" => $resource["type_resource"],
                        "url" => $image,
                        "publication_id" =>  $model->id,
                    ];
                } else {
                    $resourcess[] = [
                        "id" => $resource['id'] ?? null,
                        "type_resource" => $resource["type_resource"],
                        "url" => $resource["url"],
                        "publication_id" =>  $model->id,
                    ];
                }
            }
            $model->assingResources($resourcess);
            $modell = Publication::find($model->id);
            DB::commit();
            return  $modell;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
             $model = Publication::find($id);
            if(!$model) return null;

            $model = Publication::update([
                'name' => $data['name'],
                'description' => $data['description'],
                'employee_id' => Employee::where('user_id', \Auth()->user()->id)->first()->id,
                'filter_two_publication_id' => $data['filter_two_publication_id'],
                'filter_one_publication_id' => $data['filter_one_publication_id'],
                'filter_three_publication_id' => $data['filter_three_publication_id'],
            ]);
            $resources = json_decode(($data["resources"]), true);
            $model->assingImageMini($data['image_mini']);
            $resourcess = [];
            foreach ($resources as $resource) {
                if ($resource["type_resource"] == 'image') {
                    $image = $model->assingResource($resource["url"]);
                    $resourcess[] = [
                        "id" => $resource['id'] ?? null,
                        "type_resource" => $resource["type_resource"],
                        "url" => $image,
                        "publication_id" =>  $model->id,
                    ];
                } else {
                    $resourcess[] = [
                        "id" => $resource['id'] ?? null,
                        "type_resource" => $resource["type_resource"],
                        "url" => $resource["url"],
                        "publication_id" =>  $model->id,
                    ];
                }
            }
            $model->assingResources($resourcess);
            $modell = Publication::find($model->id);
            DB::commit();
            return  $modell;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = Publication::find($id);
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
            $model = Publication::find($id);
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