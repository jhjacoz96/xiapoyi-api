<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DiabeticPatientStoreRequest;
use App\Http\Requests\DiabeticPatientUpdateRequest;
use App\Http\Requests\RegisterGlucosaRequest;
use App\Http\Requests\RegisterWeightRequest;
use App\Utils\Enums\EnumResponse;
use App\DiabeticPatient;
use App\RegisterGlucose;
use App\RegisterwWight;
use App\Http\Resources\RegisterGlucoseResource;
use App\Http\Resources\RegisterWightResource;
use App\Http\Resources\DiabeticPatientResource;
use App\Http\Resources\PatientTreatmentResource;
use App\Http\Resources\ActivityTreatmentResource;
use App\Http\Resources\RegisterTreatmentResource;
use App\Http\Resources\MemberDiabeticPatientResource;
use App\Http\Resources\MemberResource;
use App\Services\DiabeticPatientService;
use Carbon\Carbon;

class DiabeticPatientController extends Controller
{
    function __construct(DiabeticPatientService $_DiabeticPatientService)
    {
        $this->service = $_DiabeticPatientService;
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
            $data = MemberDiabeticPatientResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }
    public function indexRegisterGlucose($id)
    {
        try {
            $model = $this->service->indexRegisterGlucose($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = RegisterGlucoseResource::collection($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function indexRegisterWeight($id)
    {
        try {
            $model = $this->service->indexRegisterWeight($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = RegisterWightResource::collection($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function indexTreatment()
    {
        try {
            $model = $this->service->indexTreatment();
            $data = PatientTreatmentResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e; 
        }
    }

    public function continueTreatment(Request $request)
    {
        try {
            $model = $this->service->continueTreatment($request);
            $data = new PatientTreatmentResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function indexRegisterTreatment()
    {
        try {
            $model = $this->service->indexRegisterTreatment();
            $data = PatientTreatmentResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

     public function indexActivity()
    {
        try {
            $model = $this->service->indexActivity();
            $data = ActivityTreatmentResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e; 
        }
    }

    public function continueActivity(Request $request)
    {
        try {
            $model = $this->service->continueActivity($request);
            $data = new ActivityTreatmentResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function indexRegisterActivity()
    {
        try {
            $model = $this->service->indexRegisterActivity();
            $data = ActivityTreatmentResource::collection($model);
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
    public function store(Requret $request) {
      try {
        // $data = $request->validated();
        $model = $this->service->store($request);
        $data = new DiabeticPatientResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }

    public function registerGlucose(Request $request) {
      try {
        // $data = $request->validated();
        $model = $this->service->registerGlucose($request);
        $data = new RegisterGlucoseResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }
    
    public function registerWeight(Request $request) {
      try {
        // $data = $request->validated();
        $model = $this->service->registerWeight($request);
        $data = new RegisterWightResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }

    // movil //-----------------------------------------------

    public function dashboardMovil () {
      try {
        $user = \Auth::user()->diabeticPatient;
        $data = [
            "pesoActual" => $user->peso,
            "altura" => $user->altura, 
            "glucosaActual" => $user->nivel_glusemia,
        ];
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }

    public function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    public function stadististicGlucose () {
      try {
        /* mo_dia=$this->getUltimoDiaMes($request["ano"],$request["mes"]);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($request["ano"]."-".$request["mes"]."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($request["ano"]."-".$request["mes"]."-".$ultimo_dia) ); */

        $user = \Auth::user()->diabeticPatient;
        $glucosa = RegisterGlucose::whereHas('diabeticPatient', function($query) use($user) {
                $query->where('diabetic_patient_id', $user["id"]);
        })->latest()->take(10)->pluck('nivel_glusemia');
        $fecha = RegisterGlucose::whereHas('diabeticPatient', function($query) use($user) {
                $query->where('diabetic_patient_id', $user["id"]);
        })->latest()->take(10)->pluck('fecha');
        $fecha = $fecha->map(function ($query) {
            return Carbon::parse($query)->format('d/m/Y');
        });
        $data = [
            "glucosa" => $glucosa,
            "fecha" => $fecha, 
        ];
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return $e;
      }
    }

    public function stadististicWeight (Request $request) {
      try {
        $user = \Auth::user()->diabeticPatient;
        $peso = RegisterwWight::whereHas('diabeticPatient', function($query) use($user) {
                $query->where('diabetic_patient_id', $user["id"]);
        })->latest()->take(10)->pluck('peso');
        $fecha = RegisterwWight::whereHas('diabeticPatient', function($query) use($user) {
                $query->where('diabetic_patient_id', $user["id"]);
        })->latest()->take(10)->pluck('fecha');
        $fecha = $fecha->map(function ($query) {
            return Carbon::parse($query)->format('d/m/Y');
        });
        $data = [
            "glucosa" => $peso,
            "fecha" => $fecha, 
        ];
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return $e;
      }
    }

    public function registerGlucoseMovil(RegisterGlucosaRequest $request) {
      try {
        $data = $request->validated();
        $model = $this->service->registerGlucoseMovil($data);
        $data = new RegisterGlucoseResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }
    
    public function registerWeightMovil(RegisterWeightRequest $request) {
      try {
        $data = $request->validated();
        $model = $this->service->registerWeightMovil($data);
        $data = new RegisterWightResource($model);
        return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
      } catch (\Exception $e) {
        return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
      }
    }

    public function indexRegisterGlucoseMovil()
    {
        try {
            $model = $this->service->indexRegisterGlucoseMovil();
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = RegisterGlucoseResource::collection($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    public function indexRegisterWeightMovil()
    {
        try {
            $model = $this->service->indexRegisterWeightMovil();
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = RegisterWightResource::collection($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
        }
    }

    // movil //-----------------------------------------------

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
                $data = new DiabeticPatientResource($model);
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
                $data = new DiabeticPatientResource($model);
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
