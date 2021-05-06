<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MeasureStoreRequest;
use App\Http\Requests\MeasureUpdateRequest;
use App\Utils\Enums\EnumResponse;
use App\Measure;
use App\Http\Resources\MeasureResource;
use App\Services\MeasureService;

class MeasureController extends Controller
{
    function __construct(MeasureService $_MeasureService)
    {
        $this->service = $_MeasureService;
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
            $data = MeasureResource::collection($model);
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
    public function store(MeasureStoreRequest $request) {
      try {
        $data = $request->validated();
        $model = $this->service->store($data);
        $data = new MeasureResource($model);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeasureUpdateRequest $request, $id)
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
                $data = new MeasureResource($model);
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
                $data = new MeasureResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function destroy($id) {
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
