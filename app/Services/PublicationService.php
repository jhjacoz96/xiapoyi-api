<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Publication;
use App\Employee;
use App\Resource;
use App\Suscription;

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
                'employee_id' => \Auth::User()->employee->id,
                'filter_two_publication_id' => $data['filter_two_publication_id'],
                'filter_one_publication_id' => $data['filter_one_publication_id'],
                'filter_three_publication_id' => $data['filter_three_publication_id'] != "null" ? $data['filter_three_publication_id'] : null,
            ]);
            if (!empty($data['image_mini'])) $model->assingImageMini($data['image_mini']);
            if ($data["type_resource"] == 'image' || $data["type_resource"] == 'document') {
                $resource = Resource::create([
                    'type_resource' => $data['type_resource'],
                    'url'  => 'kkk',
                    'publication_id' => $model["id"],
                ]);
                $resources = $resource->assingResource($data['resource']);
                $resource->update([
                    'url'  => $resources["url"],
                ]);
            } else {
                 $resource = Resource::create([
                    'type_resource' => $data['type_resource'],
                    'url'  => $data['resource'],
                    'publication_id' => $model["id"],
                ]);
            }

            $modell = Publication::with('filterTwoPublication', 'filterOnePublication', 'filterThreePublication', 'resource')->find($model->id);
            $suscription = Suscription::All();
            foreach ($suscription as $key => $value) {    
                $datosMensaje = [
                    "suscriptor" => $value,
                    "publicacion" => $modell,
                ];
                Mail::send('correos.publicacion', $datosMensaje,function($mensaje) use($value){
                    $mensaje->to($value["correo"])->subject('Nueva publicacion - Xiaoyi');
                });
            }

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
            $model->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'employee_id' => \Auth::User()->employee->id,
                'filter_two_publication_id' => $data['filter_two_publication_id'],
                'filter_one_publication_id' => $data['filter_one_publication_id'],
                'filter_three_publication_id' => $data['filter_three_publication_id'] != "null" ? $data['filter_three_publication_id'] : null
            ]);
            if  (!empty($data['image_mini'])) $model->assingImageMini($data['image_mini']);
            /*    if (!empty($data['image_mini'])) $model->assingImageMini($data['image_mini']);
                if ($data["type_resource"] == 'image' || $data["type_resource"] == 'document') {
                    $model->resource->update([
                        'type_resource' => $data['type_resource'],
                        'url'  => 'kkk',
                        'publication_id' => $model["id"],
                    ]);
                    $resources = $resource->assingResource($data['resource']);
                    $resource->update([
                        'url'  => $resources["url"],
                    ]);
                } else {
                    $model->resource->update([
                        'type_resource' => $data['type_resource'],
                        'url'  => $data['resource'],
                        'publication_id' => $model["id"],
                    ]);
                }
            }*/
    
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