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
use App\PatientTreatment;
use App\RegisterTreatment;
use App\ActivityTreatment;
use App\RegisterActivity;
use DateTime;
use App\Events\PostGlucoseEvent;
use App\Events\TreatmentEvent;
use App\Events\ActivityEvent;

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

    public function indexTreatment () {
        try { 
            $patient = \Auth::user()->diabeticPatient;
            $model = PatientTreatment::where('diabetic_patient_id', $patient->id)->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function continueTreatment ($data) {
        try { 
            $patient = \Auth::user()->diabeticPatient;
            $model = RegisterTreatment::create([
                "patient_treatment_id" => $data["patient_treatment_id"],
                "fecha" =>  isset($data["fecha"]) ? $data["fecha"] : Carbon::now()->toDateTimeString(),
            ]);
            $treatment = PatientTreatment::find($model->patient_treatment_id);
            return $treatment;
        } catch (\Exception $e) {
            return $e;
        }
    }

     public function indexRegisterTreatment () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            $model =  PatientTreatment::where('diabetic_patient_id', $patient->id)->whereDoesntHave('registerTreatment', function ($query) {
                $query->whereDate('fecha', Carbon::now()->format('Y-m-d'));
            })->orderBy('id', 'desc')->get();

            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexActivity () {
        try { 
            $patient = \Auth::user()->diabeticPatient;
            $model = ActivityTreatment::where('diabetic_patient_id', $patient->id)->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function continueActivity ($data) {
        try {
            $patient = \Auth::user()->diabeticPatient;
            $model = RegisterActivity::create([
                "activity_treatment_id" => $data["activity_treatment_id"],
                "fecha" => Carbon::now()->toDateTimeString(),
            ]);
            $treatment = ActivityTreatment::find($data["activity_treatment_id"]);
            return $treatment;
        } catch (\Exception $e) {
            return $e;
        }
    }

     public function indexRegisterActivity () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            $model =  ActivityTreatment::where('diabetic_patient_id', $patient->id)->whereDoesntHave('registerActivity', function ($query) {
                $query->whereDate('fecha', Carbon::now()->format('Y-m-d'));
            })->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterGlucose ($id) {
        try {
            $patient = DiabeticPatient::find($id);
            if(!$patient) return null;
            $model = RegisterGlucose::where('diabetic_patient_id',  $patient["id"])
            ->orderBy('id', 'desc')
            ->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterWeight ($id) {
        try {
            $patient = DiabeticPatient::find($id);
            if(!$patient) return null;
            $model = RegisterwWight::where('diabetic_patient_id',  $patient["id"])
            ->orderBy('id', 'desc')
            ->get();
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
            $id_medicines = [];
            if (!is_null($validar)) {
                $tratamiento_farmacologico = [];
                foreach ($data['tratamiento_farmacologico'] as $item) {
                   $new = $model->patientTreatment->where("medicine_id", $item["medicine_id"])->first();
                   if (empty($new))  {
                        $id_medicines[] = $item["medicine_id"];
                    }
                    $tratamiento_farmacologico[$item["medicine_id"]] = [
                        "dosis" => $item["dosis"],
                        "hora" => $item["hora"],
                        "measure_id" => $item["measure_id"],
                        "presentation_id" => $item["presentation_id"],
                    ];

                }
                $model->medicines()->sync($tratamiento_farmacologico);
            }
            $validar2 = $data['tratamiento_no_farmacologico']  ?? null;
            $id_activities = [];
            if (!is_null($validar2)) {
                $tratamiento_no_farmacologico = [];
                foreach ($data["tratamiento_no_farmacologico"] as $item) {
                    if (!isset($item["id"])) {
                       $id_activities[] = $item["actividad"];
                    }
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
            $event = [
                "diabetic_patient" => $model,
                "id_medicines" => $id_medicines,
                "id_activities" => $id_activities,
            ];
            if (count($event["id_medicines"]) > 0) event(new TreatmentEvent($event));
             if (count($event["id_activities"]) > 0) event(new ActivityEvent($event));
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
            $calImc = $data["peso"] && $model["altura"] ? $data["peso"] / pow($model["altura"], 2) : null;
            $imc = $this->calImc($calImc);
            $model->update([
              "peso" => $data["peso"],
              "descripcion_imc" => $imc["nombre"],
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
                "hora" => $data["hora"] ?? null,
                "diabetic_patient_id" => $model->id,
            ]);

            if (
                $data["nivel_glusemia"] < 70 ||
                $data["nivel_glusemia"] > 125
            ) {
                $r = RegisterGlucose::with("diabeticPatient.member")->find($diabetic["id"]);
                event(new PostGlucoseEvent($r));
            }
            
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
            $calImc = $data["peso"] && $model["altura"] ? $data["peso"] / pow($model["altura"], 2) : null;
            $imc = $this->calImc($calImc);
            $model->update([
              "peso" => $data["peso"],
              "descripcion_imc" => $imc["nombre"],
            ]);
            $date = Carbon::now()->toDateTimeString();
            $diabetic = RegisterwWight::create([
                "fecha" => $data["fecha"]  ?? $date,
                "peso" => $data["peso"],
                "hora" => $data["hora"],
                "diabetic_patient_id" => $model->id,
            ]);
            
            DB::commit();
            return $diabetic;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function calImc ($data) {
        $c = collect([
            [
              "nombre" => 'Desnutrición', 
              "value" => [0, 18.5],
            ],
            [
              "nombre" => 'Peso normal',
              "value" => [18.6, 25],
            ],
            [
              "nombre" => 'Sobrepeso',
              "value" => [26, 30],
            ],
            [
              "nombre" => 'Obesidad',
              "value" => [31, 200],
            ]
        ]);
        $imc = $c->filter(function($query)use($data){
            return $query["value"][0] <= $data && $data <= $query["value"][1];
        })->first();
        return $imc;
    }

    public function indexRegisterGlucoseMovil () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            if(!$patient) return null;
            $model = RegisterGlucose::where('diabetic_patient_id',  $patient["id"])
            ->orderBy('id', 'desc')
            ->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function indexRegisterWeightMovil () {
        try {
            $patient = \Auth::user()->diabeticPatient;
            if(!$patient) return null;
            $model = RegisterwWight::where('diabetic_patient_id',  $patient["id"])
            ->orderBy('id', 'desc')
            ->get();
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