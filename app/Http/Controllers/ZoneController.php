<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ZoneStoreRequest;
use App\Http\Requests\ZoneUpdateRequest;
use App\Utils\Enums\EnumResponse;
use App\Services\ZoneService;
use App\Http\Resources\ZoneResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\CantonResource;

class ZoneController extends Controller
{
    function __construct(ZoneService $_ZoneService)
    {
        $this->service = $_ZoneService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $model = $this->service->index();
            $data = ZoneResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function provinceFind()
    {
        try {
            $model = $this->service->provinceFind();
            $data = ProvinceResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function cantonFind($id)
    {
        try {
            $model = $this->service->cantonFind($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = CantonResource::collection($model);
                return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function zoneFind($id)
    {
        try {
            $model = $this->service->zoneFind($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = ZoneResource::collection($model);
                return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
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
    public function store(ZoneStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $model = $this->service->store($data);
            $data = new ZoneResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
          } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $model = $this->service->show($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new ZoneResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ZoneUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $model = $this->service->update($data, $id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new ZoneResource($model);
                return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
            }
          } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = $this->service->delete($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = [
                    'message' => __('response.successfully_deleted')
                ];
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }
}
