<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\OlderAdult;
use App\Diabetic;
use App\WebService;
use App\Subcription;
use App\Us;
use App\Zone;
use App\Contact;
use App\Publication;
use App\Image;
use App\Utils\Enums\EnumResponse;
use App\Http\Resources\ServicesWebResource;
use App\Http\Resources\OldAdultResource;
use App\Http\Resources\PublicationAllResource;
use App\Http\Resources\PublicationPaginateResource;
use App\Http\Resources\ServicesAllWebResource;
use Artisan;
use Log;
use Session;
use Illuminate\Support\Facades\Storage;

class ConfigWeb extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function publicationIndex(Request $request) {
        try {
            $model = Publication::paginate(6);
            $data = new PublicationPaginateResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function publicationSearch(Request $request) {
        try {
            $model = Publication::where('name','like','%'.$request["search"] .'%')->paginate(6);
            $data = new PublicationPaginateResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function publicationFilter(Request $request) {
         try {
            if (!empty($request["filter_one_publication_id"])) {
                if (!empty($request["type_resource"])) {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])
                    ->whereHas("resource", function ($query) use($request) {
                        $query->where("type_resource", $request["type_resource"]);
                    })
                    ->paginate(6);
                } else {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])->paginate(6);
                }
            }
            if (!empty($request["filter_two_publication_id"])) {
                 if (!empty($request["type_resource"])) {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])
                    ->where("filter_two_publication_id", $request["filter_two_publication_id"])
                    ->whereHas("resource", function ($query) use($request) {
                        $query->where("type_resource", $request["type_resource"]);
                    })
                    ->paginate(6);
                 } else {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])
                    ->where("filter_two_publication_id", $request["filter_two_publication_id"])
                    ->paginate(6); 
                 }
            }
            if (!empty($request["filter_three_publication_id"])) {
                if (!empty($request["type_resource"])) {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])
                    ->where("filter_two_publication_id", $request["filter_two_publication_id"])
                    ->where("filter_three_publication_id", $request["filter_three_publication_id"])
                   ->whereHas("resource", function ($query) use($request) {
                         $query->where("type_resource", $request["type_resource"]);
                    })
                    ->paginate(6);
                } else {
                    $model = Publication::where("filter_one_publication_id", $request["filter_one_publication_id"])
                    ->where("filter_two_publication_id", $request["filter_two_publication_id"])
                    ->where("filter_three_publication_id", $request["filter_three_publication_id"])
                    ->paginate(6);
                }
            }
            if (empty($request["filter_three_publication_id"]) && empty($request["filter_one_publication_id"]) && empty($request["filter_two_publication_id"])) {
                if (!empty($request["type_resource"])) {
                    $model = Publication::whereHas("resource", function ($query) use($request) { 
                        $query->where("type_resource", $request["type_resource"]);
                    })->paginate(6);
                } else {
                    $model = Publication::paginate(6);
                }
            }
            $data = new PublicationPaginateResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.publicationFilter');
        }
    }

    public function organizationIndex() {
        try {
            $data = Organization::with('province', 'institution', 'canton', 'image')->find(1); 
            if (!$data) {
                 $data = Organization::with('province', 'institution', 'canton', 'image')->find(3); 
            }
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function organizationFind () {
        try {
            $data = Organization::with('province', 'institution', 'canton', 'image')->get(); 
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function organizationStore(Request $request)
    {
        try {
            $o = Organization::find(1);
            $data = Organization::updateOrCreate(
            [
              'id' => $o ? 1 : 3,
            ],
            [
                'name' => $request['name'],
                'province_id' => $request['province_id'],
                'canton_id' => $request['canton_id'],
                'address' => $request['address'],
                'institution_id' => $request['institution_id'],
                'code_uo' => $request['code_uo'],
                'parroquia' => $request['parroquia'],
            ]);

            $folder = 'image/organization';
            $imagen = $request["image"];
            if ($imagen != "null") {
                \Cloudder::upload($imagen, null, ['folder' => $folder], []);
                $ruta = \Cloudder::getResult();
                if (!empty($data->image)) {
                    $data->image->url = $ruta['url'];
                    $data->image->public_id = $ruta['public_id'];
                    $data->push();
                } else {
                    $data->image()->create([
                       'url' => $ruta['url'],
                       'public_id' => $ruta['public_id'],
                    ]);

                }
            }
            $data = Organization::with('image')->find($data["id"]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function upIndex() {
        try {

            $data = Us::find(1);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function upStore(Request $request)
    {
        try {
            $id = 1;
            if (!empty($request['description1']) || !empty($request['description2']))  {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ],
                    [
                    'description1' => $request['description1'],
                    'description2' => $request['description2'],
                ]);
            }

            if (!empty($request['mission']))  {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ],
                    [
                    'mission' => $request['mission'],
                ]);
            }

            if (!empty($request['vision']))  {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ],
                    [
                    'vision' => $request['vision'],
                ]);
            }

            if (!empty($request['objective']))  {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ],
                    [
                    'objective' => $request['objective'],
                ]);
            }

            if (!empty($request['value']))  {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ],
                    [
                    'value' => $request['value'],
                ]);
            }

            $folder = 'image/web';
            if ($request->file('image_mission')) {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ]
                );
                $imagenMission = $request->file('image_mission');
                \Cloudder::upload($imagenMission, null, ['folder' => $folder], []);
                $rutaMission = \Cloudder::getResult();
                if (!empty($data->image_mission)) {
                   $data->image_mission = $rutaMission['url'];
                } else {
                   $m = $data->image()->create([
                       'url' => $rutaMission['url'],
                       'public_id' => $rutaMission['public_id'],
                    ]);
                    $data->image_mission = $m->url;
                }
                $data->save();
                /*$nombreMission = 'image_mission'.$imagenMission->getClientOriginalName();
                $rutaMission = public_path().'/imagenWeb';
                $imagenMission->move($rutaMission , $nombreMission);
                
                $urlImagenMission['url']='/imagenWeb/'.$nombreMission;
                if (!empty($data->image_mission)) {
                    $data->image_mission = $urlImagenMission['url'];
                } else {
                    $m = $data->image()->create($urlImagenMission);
                    $data->image_mission = $m->url;
                }*/
            }
            if ($request->file('image_vision')) {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ]
                );
                $imagenVision = $request->file('image_vision');
                \Cloudder::upload($imagenVision, null, ['folder' => $folder], []);
                $rutaVision = \Cloudder::getResult();
                /*$nombreVision = 'image_vision'.$imagenVision->getClientOriginalName();
                $rutavVision = public_path().'/imagenWeb';
                $imagenVision->move($rutavVision , $nombreVision);
                $urlImagenVision['url']='/imagenWeb/'.$nombreVision;*/

                if (!empty($data->image_vision)) {
                    $data->image_vision = $rutaVision['url'];
                } else {
                    $v = $data->image()->create([
                       'url' => $rutaVision['url'],
                       'public_id' => $rutaVision['public_id'],
                    ]);
                    $data->image_vision = $v->url;
                }
                $data->save();
            }
            if ($request->file('image_objective')) {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ]
                );
                $imagenObjetive = $request->file('image_objective');
                \Cloudder::upload($imagenObjetive, null, ['folder' => $folder], []);
                $rutaObjetive = \Cloudder::getResult();
                /*$imagenObjetive = $request->file('image_objective');
                $nombreObjetive = 'image_objective'.$imagenObjetive->getClientOriginalName();
                $rutaObjetive = public_path().'/imagenWeb';
                $imagenObjetive->move($rutaObjetive , $nombreObjetive);
                
                $urlImagenObjetive['url']='/imagenWeb/'.$nombreObjetive;*/
                if (!empty($data->image_objetive)) {
                    $data->image_objective = $rutaObjetive['url'];
                } else {
                    $o = $data->image()->create([
                       'url' => $rutaObjetive['url'],
                       'public_id' => $rutaObjetive['public_id'],
                    ]);
                    $data->image_objective = $o->url;
                }
                $data->save();
            }
            if ($request->file('image_value')) {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ]
                );
                $imagenValue = $request->file('image_value');
                \Cloudder::upload($imagenValue, null, ['folder' => $folder], []);
                $rutaValue = \Cloudder::getResult();
                if (!empty($data->image_value)) {
                    $data->image_value = $rutaValue['url'];
                } else {
                   $v = $data->image()->create([
                       'url' => $rutaValue['url'],
                       'public_id' => $rutaValue['public_id'],
                    ]);
                   $data->image_value = $v->url;
                }
                $data->save();
            }
            if ($request->file('image_us')) {
                $data = Us::updateOrCreate(
                    [
                      'id' => $id,
                    ]
                );
                $imagenUs = $request->file('image_us');
                \Cloudder::upload($imagenUs, null, ['folder' => $folder], []);
                $rutaUs = \Cloudder::getResult();

                if (!empty($data->image_us)) {
                    $data->image_us = $rutaUs['url'];
                } else {
                   $u = $data->image()->create([
                       'url' => $rutaUs['url'],
                       'public_id' => $rutaUs['public_id'],
                    ]);
                   $data->image_us = $u->url;
                }
                $data->save();
            }
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function serviceIndex() {
        try {
            $zoneWeb = WebService::find(1);
            $data = new ServicesWebResource($zoneWeb);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function serviceAllIndex() {
        try {
            $zoneWeb = WebService::find(1);
            $data = new ServicesAllWebResource($zoneWeb);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function serviceStore(Request $request)
    {
        try {
            $id = 1;
            $data = WebService::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'description1' => $request['description1'],
                'description2' => $request['description2'],
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function diabeticIndex() {
        try {
            $data = Diabetic::with('image')->find(1);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function diabeticStore(Request $request)
    {
        try {
            $id = 1;
            $data = Diabetic::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'title' => $request['title'],
                'description1' => $request['description1'],
                'description2' => $request['description2'],
            ]);

            if ($request['image'] != 'null') {
                $folder = 'image/web';
                $imagenDiabetic = $request['image'];
                \Cloudder::upload($imagenDiabetic, null, ['folder' => $folder], []);
                $rutaDiabetic = \Cloudder::getResult();
                if (!empty($data->image)) {
                    $data->image->url = $rutaDiabetic['url'];
                    $data->push();
                } else {
                    $data->image()->create([
                       'url' => $rutaDiabetic['url'],
                       'public_id' => $rutaDiabetic['public_id'],
                    ]);
                }
            }

            $data = Diabetic::with('image')->find(1);

            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function olderAdultIndex() {
        try {
            $data = OlderAdult::find(1);
            $data1 = new OldAdultResource($data);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data1);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function olderAdultAllIndex() {
        try {
            $data = OlderAdult::find(1);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function olderAdultStore(Request $request)
    {
        try {
            $id = 1;
            $data = OlderAdult::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'title' => $request['title'],
                'description1' => $request['description1'],
                'description2' => $request['description2'],
                'show' => $request['show']
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function dowloandFile (Request $request) {
        try {
            /* $file=public_path().$request["resource"];
            $header=array(
                'Content-Type: application/xlsx',
            );
            return \Response::download($file,"productos.xlsx",$header);*/
             $file_path = $request["resource"];
             $extension = explode('.', $file_path);
             $extension = end($extension);
             $header=array(
                "Content-Type: application/" . $extension,
            );
            return  \Storage::disk('public')->download($file_path, "recurso." . $extension, $header);
            /*$folder = 'image/publication';
            $c = \Cloudder::privateDownloadUrl (
                "sample",
                "jpg",
                [
                    "resource_type" => "image",
                    "attachment" => true
                ]
            );
            return $c;*/
        } catch (Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.dowloandFile');
        }
    }

    public function subcriptionIndex() {
        try {
            $data = Subcription::find(1);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function subcriptionStore(Request $request)
    {
        try {
            $id = 1;
            $data = Subcription::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'description1' => $request['description1'],
                'description2' => $request['description2'],
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function contactIndex() {
        try {
            $data = Contact::find(1);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function contactStore(Request $request)
    {
        try {
            $id = 1;
            $data = Contact::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'description1' => $request['description1'],
                'description2' => $request['description2'],
                'email' => $request['email'],
                'descripcion_phone1' => $request['descripcion_phone1'],
                'descripcion_phone2' => $request['descripcion_phone2'],
                'phone1' => $request['phone1'],
                'pone2' => $request['pone2'],
                'twitter' => $request['twitter'],
                'facebook' => $request['facebook'],
                'instagram' => $request['instagram'],
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function downloadApk () {
         try {
            $dir = 'dropbox';
            $file_name = 'app-debug.apk';
            $disk = Storage::disk($dir);
            $file = 'apk/'. $file_name;
            if ($disk->exists($file)) {
                $fs = Storage::disk($dir)->getDriver();
                $stream = $fs->readStream($file);
                return \Response::stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    "Content-Type" => $fs->getMimetype($file),
                    "Content-Length" => $fs->getSize($file),
                    "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
                ]);
            } else {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }   
        } catch (Exception $e) {
            return $e;   
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
