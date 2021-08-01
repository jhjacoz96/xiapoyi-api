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
            
            $model = Publication::orderBy('id', 'desc')->get();;
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
            $folder = 'image/publication';
            if ($data['image_mini'] != "null") {
                // $model->assingImageMini($data['image_mini']);
                $image = $data['image_mini']->getRealPath();
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $model->image()->create([
                   'url' => $c['url'],
                   'public_id' => $c['public_id'],
                ]);
            }
            if ($data["type_resource"] == 'image') {
                $image = $data['resource'];
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $resource = Resource::create([
                    "type_resource" => $data['type_resource'],
                    "url"  => $c["url"],
                    "publication_id" => $model["id"],
                ]);
                // $resources = $resource->assingResource($data['resource']);
                $resources = $resource->image()->create([
                   'url' => $c['url'],
                   'public_id' => $c['public_id'],
                ]);
            } else if ($data["type_resource"] == 'document') {
                $r = $data['resource'];
                /*$publicId = \Str::random(4) . $data['resource']->getClientOriginalName();
                \Cloudder::upload(
                    $image,
                    $publicId,
                    [
                        "resource_type" => "raw",
                        "folder" => $folder
                    ],
                    []
                );
                $c = \Cloudder::getResult();
                /*\Cloudder::rename($c["public_id"], 'hola'.$publicId, [
                        "folder" => $folder
                    ]);*/
                $nombre = \Str::random(4). $r->getClientOriginalName();
                $ruta = public_path().'/imagenPublication';
                $r->move($ruta , $nombre);
                
                $c['url']='/imagenPublication/'.$nombre;

                $resource = Resource::create([
                    "type_resource" => $data['type_resource'],
                    "url"  => $c['url'],
                    "publication_id" => $model["id"],
                ]);
                // $resources = $resource->assingResource($data['resource']);
                $resources = $resource->image()->create([
                   'url' => $c['url']
                ]);
            } else {
                 $resource = Resource::create([
                    'type_resource' => $data['type_resource'],
                    'url'  => $data['resource'],
                    'publication_id' => $model["id"],
                ]);
            }

            $modell = Publication::with('filterTwoPublication', 'filterOnePublication', 'filterThreePublication', 'resource')->find($model->id);

            /*$q = Suscription::with("filterOnePublication");
                !empty($modell["filter_three_publication_id"]) ?  $suscription = $q->where("filter_three_publication_id", $modell["filter_three_publication_id"])->orWhereNull("filter_three_publication_id") : "";
                $suscription = $q->where("filter_two_publication_id", $modell["filter_two_publication_id"]);
                $suscription = $q->orWhereNull("filter_two_publication_id");
                $suscription = $q->where("filter_one_publication_id", $modell["filter_one_publication_id"]);
                $suscription = $q->orWhereNull("filter_one_publication_id");
                $suscription = $q->get();
                
            foreach ($suscription as $key => $value) {
                $datosMensaje = [
                    "suscriptor" => $value,
                    "publicacion" => $modell,
                ];
                Mail::send('correos.publicacion', $datosMensaje,function($mensaje) use($value){
                    $mensaje->to($value["correo"])->subject('Nueva publicacion - KA-THANI');
                });
            }*/

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
            $folder = 'image/publication';
            if  ($data['image_mini'] != "null") {
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $data->image->url = $c['url'];
                $data->image->public_id = $c['public_id'];
                $data->push();
            }
            // $model->assingImageMini($data['image_mini']);
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
            $folder = 'image/publication';
            \Cloudder::destroyImage($model->image->public_id, ['folder' => $folder]);
            $model->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}