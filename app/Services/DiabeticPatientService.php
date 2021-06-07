<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\DiabeticPatient;
use App\Medicine;
use App\RegisterGlucose;
use App\RegisterwWight;
use App\Member;
use DateTime;

class DiabeticPatientService {

    function __construct()
    {

    }

    public function index () {
        try { 
            $model = Member::has('DiabeticPatient')->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterGlucose ($id) {
        try {
            $patient = DiabeticPatient::find($id);
            if(!$patient) return null;
            $model = RegisterGlucose::where('diabetic_patient_id',  $patient["id"])->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterWeight ($id) {
        try {
            $patient = DiabeticPatient::find($id);
            if(!$patient) return null;
            $model = RegisterwWight::where('diabetic_patient_id',  $patient["id"])->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = DiabeticPatient::create($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = DiabeticPatient::find($id);
            if(!$model) return null;
            $model->update([
              "presion_arterial" => $data["presion_arterial"],
              "pulso" => $data["pulso"],
              "respiracion" => $data["respiracion"],
              "saturacion_oxigeno" => $data["saturacion_oxigeno"],
              "temperatura" => $data["temperatura"],
              "peso" => $data["peso"],
              "altura" => $data["altura"],
              "circunferencia" => $data["circunferencia"],
              "abdominal" => $data["abdominal"],
              "nivel_glusemia" => $data["nivel_glusemia"],
              "dieta" => $data["dieta"],
            ]);
            

            $glusemia = [
                "id" => $model["id"],
                "nivel_glusemia" => $model["nivel_glusemia"],
            ];
            $peso = [
                "id" => $model["id"],
                "peso" => $model["peso"],
            ];
            $this->registerGlucose($glusemia);
            $this->registerWeight($peso);
            
            $validar = $data['tratamiento_farmacologico']  ?? null;
            if (!is_null($validar)) {
                $tratamiento_farmacologico = [];
                foreach ($data['tratamiento_farmacologico'] as $item) {
                        $tratamiento_farmacologico[$item["id"]] = [
                            "dosis" => $item["dosis"],
                            "hora" => $item["hora"],
                            "measure_id" => $item["measure_id"],
                            "presentation_id" => $item["presentation_id"],
                        ];
                }
                $model->medicines()->sync($tratamiento_farmacologico);
            }

            $validar2 = $data['tratamiento_no_farmacologico']  ?? null;
            if (!is_null($validar2)) {
                $tratamiento_no_farmacologico = [];
                foreach ($data['tratamiento_no_farmacologico'] as $item) {
                    $tratamiento_no_farmacologico[] = [
                        "id" => $item['id'] ?? null,
                        "actividad" => $item['actividad'],
                        "duracion" => $item['duracion'],
                        "hora" => $item['hora'],
                        "diabetic_patient_id" => $model["id"],
                    ];
                }
                $model->assignTratamientoNoFarmacologico($tratamiento_no_farmacologico);
            }

            

            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function registerGlucose ($data) {
        try {
            DB::beginTransaction();
            $model = DiabeticPatient::find($data["id"]);
            if(!$model) return null;
            $model->update([
              "nivel_glusemia" => $data["nivel_glusemia"],
            ]);
            $date = Carbon::now()->toDateTimeString();
            $diabetic = RegisterGlucose::create([
                "fecha" => $data["fecha"]  ?? $date,
                "nivel_glusemia" => $data["nivel_glusemia"],
                "comida" => $data["comida"] ?? null,
                "diabetic_patient_id" => $model->id,
            ]);
            
            DB::commit();
            return $diabetic;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function RegisterWeight ($data) {
        try {
            DB::beginTransaction();
            $model = DiabeticPatient::find($data["id"]);
            if(!$model) return null;
            $model->update([
              "peso" => $data["peso"],
            ]);
            $date = Carbon::now()->toDateTimeString();
            $diabetic = RegisterwWight::create([
                "fecha" => $data["fecha"]  ?? $date,
                "peso" => $data["peso"],
                "diabetic_patient_id" => $model->id,
            ]);
            
            DB::commit();
            return $diabetic;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    // dibites movil //----------------------------------------

        public function registerGlucoseMovil ($data) {
        try {
            DB::beginTransaction();
            $model = \Auth::user()->diabeticPatient;
            if(!$model) return null;
            $model->update([
              "nivel_glusemia" => $data["nivel_glusemia"],
            ]);
            $date = Carbon::now()->toDateTimeString();
            $diabetic = RegisterGlucose::create([
                "fecha" => $data["fecha"]  ?? $date,
                "nivel_glusemia" => $data["nivel_glusemia"],
                "comida" => $data["comida"] ?? null,
                "diabetic_patient_id" => $model->id,
            ]);
            
            DB::commit();
            return $diabetic;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function RegisterWeightMovil ($data) {
        try {
            DB::beginTransaction();
            $model = \Auth::user()->diabeticPatient;
            if(!$model) return null;
            $model->update([
              "peso" => $data["peso"],
            ]);
            $date = Carbon::now()->toDateTimeString();
            $diabetic = RegisterwWight::create([
                "fecha" => $data["fecha"]  ?? $date,
                "peso" => $data["peso"],
                "diabetic_patient_id" => $model->id,
            ]);
            
            DB::commit();
            return $diabetic;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function indexRegisterGlucoseMovil () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            if(!$patient) return null;
            $model = RegisterGlucose::where('diabetic_patient_id',  $patient["id"])->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterWeightMovil () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            if(!$patient) return null;
            $model = RegisterwWight::where('diabetic_patient_id',  $patient["id"])->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }


        // dibites movil //----------------------------------------

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = DiabeticPatient::find($id);
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
            $model = DiabeticPatient::find($id);
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