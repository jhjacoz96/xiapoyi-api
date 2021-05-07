<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\OlderAdult;
use App\Diabetic;
use App\WebService;
use App\Subcription;
use App\Us;
use App\Contact;
use App\Utils\Enums\EnumResponse;

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

    public function organizationIndex() {
        try {
            $data = Organization::find(1); 
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function organizationStore(Request $request)
    {
        try {
            $id = 1;
            $data = Organization::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'name' => $request['name'],
                'province_id' => $request['province_id'],
                'canton_id' => $request['canton_id'],
                'address' => $request['address']
            ]);
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
            $data = Us::updateOrCreate(
                [
                  'id' => $id,
                ],
                [
                'description1' => $request['description1'],
                'description2' => $request['description2'],
                'mission' => $request['mission'],
                'vision' => $request['vision'],
                'objective' => $request['objective'],
                'value' => $request['value'],
            ]);

            if ($request->file('image_mission')) {

                $imagenMission = $request->file('image_mission');
                $nombreMission = 'image_mission'.$imagenMission->getClientOriginalName();
                $rutaMission = public_path().'/imagenWeb';
                $imagenMission->move($rutaMission , $nombreMission);
                
                $urlImagenMission['url']='/imagenWeb/'.$nombreMission;
                $m = $data->image()->create($urlImagenMission);
                $data->image_mission = $m->url;
                $data->save();
            }
            if ($request->file('image_vision')) {
                $imagenVision = $request->file('image_vision');
                $nombreVision = 'image_vision'.$imagenVision->getClientOriginalName();
                $rutavVision = public_path().'/imagenWeb';
                $imagenVision->move($rutavVision , $nombreVision);
                
                $urlImagenVision['url']='/imagenWeb/'.$nombreVision;
                $v = $data->image()->create($urlImagenVision);

                $data->image_vision = $v->url;
                $data->save();
            }
            if ($request->file('image_objective')) {
                $imagenObjetive = $request->file('image_objective');
                $nombreObjetive = 'image_objective'.$imageObjetive->getClientOriginalName();
                $rutaObjetive = public_path().'/imagenWeb';
                $imagenObjetive->move($rutavObjetive , $nombreObjetive);
                
                $urlImagenObjetive['url']='/imagenWeb/'.$nombrObjetive;
                $o = $data->image()->create($urlImagenObjetive);
                
                $data->image_objetive = $o->url;
                $data->save();
            }
            if ($request->file('image_value')) {
                $imagenValue = $request->file('image_value');
                $nombreValue = 'image_value'.$imagenValue->getClientOriginalName();
                $rutaValue = public_path().'/imagenWeb';
                $imagenValue->move($rutaValue , $nombreValue);
                
                $urlImagenValue['url']='/imagenWeb/'.$nombreValue;
                $v = $data->image()->create($urlImagenValue);

                $data->image_value = $v->url;
                $data->save();
            }
            if ($request->file('image_us')) {
                $imagenUs = $request->file('image_us');
                $nombreUs = 'image_us'.$imagenUs->getClientOriginalName();
                $rutaUs = public_path().'/imagenWeb';
                $imagenUs->move($rutaUs , $nombreUs);
                
                $urlImagenUs['url']='/imagenWeb/'.$nombreUs;
                $u = $data->image()->create($urlImagenUs);

                $data->image_us = $u->url;
                $data->save();
            }
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function serviceIndex() {
        try {
            $data = WebService::find(1);
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
            $data = Diabetic::find(1);
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
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function olderAdultIndex() {
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
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
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
            ]);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
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
