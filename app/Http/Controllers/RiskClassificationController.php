<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RiskClassificationStoreRequest;
use App\Http\Requests\RiskClassificationUpdateRequest;
use App\Utils\Enums\EnumResponse;
use App\RiskClassification;
use App\Http\Resources\RiskClassificationResource;
use App\Services\RiskClassificationService;

class RiskClassificationController extends Controller
{
    function __construct(RiskClassificationService $_RiskClassificationService)
    {
        $this->service = $_RiskClassificationService;
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
            $data = RiskClassificationResource::collection($model);
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
    public function store(RiskClassificationStoreRequest $request) {
      try {
        $data = $request->validated();
        $model = $this->service->store($data);
        $data = new RiskClassificationResource($model);
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
    public function update(RiskClassificationUpdateRequest $request, $id)
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
                $data = new RiskClassificationResource($model);
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
                $data = new RiskClassificationResource($model);
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
