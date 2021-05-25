<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FileFamilyStoreRequest;
// use App\Http\Requests\FileFamilyUpdateRequest;
use App\Utils\Enums\EnumResponse;
use App\FileFamily;
use App\Http\Resources\FileFamilyResource;
use App\Http\Resources\FileFamilyListResource;
use App\Services\FileFamilyService;

class FileFamilyController extends Controller
{
    function __construct(FileFamilyService $_FileFamilyService)
    {
        $this->service = $_FileFamilyService;
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
            $data = FileFamilyListResource::collection($model);
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
        $data = new FileFamilyResource($model);
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
    public function update(Request $request, $id)
    {
        try {
            // $data = $request->validated();
            $model = $this->service->update($request, $id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new FileFamilyResource($model);
                return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
            }
          } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.update');
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
                $data = new FileFamilyResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function search(Request $request)
    {
      try {
            $model = $this->service->search($request);
            $data = FileFamilyListResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function filter(Request $request)
    {
      try {
            $model = $this->service->filter($request);
            $data = FileFamilyListResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
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
