<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PregnantStoreRequest;
use App\Http\Requests\PregnantUpdateRequest;
use App\Utils\Enums\EnumResponse;
use App\Pregnant;
use App\Member;
use App\Http\Resources\PregnantResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\MemberShowResource;
use App\Http\Resources\FileClinicalObstetricResource;
use App\Services\PregnantService;

class PregnantController extends Controller
{
    function __construct(PregnantService $_PregnantService)
    {
        $this->service = $_PregnantService;
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
            $data = MemberShowResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function indexNotNeonatology()
    {
        try {
            $model = $this->service->indexNotNeonatology();
            $data = FileClinicalObstetricResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function search(Request $request)
    {
        try {
            $model = $this->service->search($request);
            $data = FileClinicalObstetricResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function searchHistory(Request $request, $history)
    {
         try {
            $model = $this->service->searchHistory($request, $history);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data =  new FileClinicalObstetricResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function filter(Request $request)
    {
      try {
            $model = $this->service->filter($request);
            $data = FileClinicalObstetricResource::collection($model);
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
    public function store(Request $request) {
      try {
        // $data = $request->validated();
        $model = $this->service->store($request);
        $data = new FileClinicalObstetricResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return $e;
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
    public function update(Request $request, $id)
    {
        try {
            $model = $this->service->update($request, $id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new FileClinicalObstetricResource($model);
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
                $data =  new FileClinicalObstetricResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function check($cedula)
    {
        try {
            $model = $this->service->checkDocument($cedula);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
            $model = null;
            $model = $this->service->checkPregnant($cedula);
            if (!$model) {
                $data = [
                    'message' => __('response.has_pregnancy')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
            $model = null;
            $model = $this->service->checkPregnantNotNeonatology($cedula);
            if (!$model) {
                $data = [
                    'message' => __('response.has_pregnancy_not_neonatology')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
            $data = new MemberShowResource($model);
            return bodyResponseRequest(EnumResponse::SUCCESS, $data);
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function checkFile($cedula)
    {
        try {
            $model = $this->service->checkDocument($cedula);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            }
            $data = new MemberShowResource($model);
            return bodyResponseRequest(EnumResponse::SUCCESS, $data);
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
