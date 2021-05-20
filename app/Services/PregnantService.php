<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Pregnant;
use App\Member;

class PregnantService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Pregnant::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Pregnant::create($data);
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
            $model = Pregnant::find($id);
            if(!$model) return null;
            $model->update([
                "antecedentes_patologicos" => $data["antecedentes_patologicos"],
                "semana_gestacion" => $data["semana_gestacion"],
                "gestas" => $data["gestas"],
                "partos" => $data["partos"],
                "abortos" => $data["abortos"],
                "cesarias" => $data["cesarias"],
                "type_blood_id" => $data["type_blood_id"],
                "estado_civil" => $data["estado_civil"],
                "vive_con" => $data["vive_con"],
                "antecentedes_paternos" => $data["antecentedes_paternos"],
                "antecentedes_maternos" => $data["antecentedes_maternos"],
                "antecentedes_prenatales" => $data["antecentedes_prenatales"],
                "medicamentos" => $data["medicamentos"],
                "embarazo_planificado" => $data["embarazo_planificado"],
                "causa_embarazo" => $data["causa_embarazo"],
                "ayuda_violacion" => $data["ayuda_violacion"],
                "ayuda_anticoceptivo" => $data["ayuda_anticoceptivo"],
                "talla" => $data["talla"],
                "peso" => $data["peso"],
                "dar_luz" => $data["dar_luz"],
                "nombre_acompanate" => $data["nombre_acompanate"],
                "aceptaria_formula" => $data["aceptaria_formula"],
                "estimulacion_embarazo" => $data["estimulacion_embarazo"],
                "administrar_hemoderivado" => $data["administrar_hemoderivado"],
                "capacitacion_prenatal" => $data["capacitacion_prenatal"],
                "capacitacion_epidural" => $data["capacitacion_epidural"],
                "observacion_parto" => $data["observacion_parto"],
                "hemorragia" => $data["hemorragia"],
                "desgarro" => $data["desgarro"],
                "grado_desgarro" => $data["grado_desgarro"],
                "tipo_parto" => $data["tipo_parto"],
                "episiorria" => $data["episiorria"],
                "hemorroides" => $data["hemorroides"],
                "dolor" => $data["dolor"],
                "epitomia" => $data["epitomia"],
                "grado_epitomia" => $data["grado_epitomia"],
                "loquios" => $data["loquios"],
                "involucion_uterina" => $data["involucion_uterina"],
                "dolor_eva" => $data["dolor_eva"],
                "educacion_lactancia" => $data["educacion_lactancia"],
                "satisfaccion_lactancia" => $data["satisfaccion_lactancia"],
                "score_mama_inmediato" => $data["score_mama_inmediato"],
                "score_mama_mediato" => $data["score_mama_mediato"],
                "educacion_paciente" => $data["educacion_paciente"],
                "educacion_depresion" => $data["educacion_depresion"],
                "proporcionar_telefono" => $data["proporcionar_telefono"],
                "señal_alarma" => $data["señal_alarma"],
            ]);

            
            $validar = $data['tratamiento']  ?? null;
            if (!is_null($validar)) {
                $tratamiento = [];
                foreach ($data['tratamiento'] as $item) {
                        $tratamiento[$item["id"]] = [
                            "presentation_id" => $item["presentation_id"],
                            "measure_id" => $item["measure_id"],
                            "frequency_id" => $item["frequency_id"],
                            "dosis" => $item["dosis"],
                        ];
                }
                $model->medicines()->sync($tratamiento);
            }

            $validar1 = $data['vacuna']  ?? null;
            if (!is_null($validar1)) {
                $model->vaccines()->sync($data['vacuna']);
            }
            
            $validar2 = $data['telefonos']  ?? null;
            if (!is_null($validar2)) {
                $telefonos = [];
                foreach ($data['telefonos'] as $item) {
                    $telefonos[] = [
                        "id" => $item['id'] ?? null,
                        "nombre" => $item['nombre'],
                        "telefono" => $item['telefono'],
                        "relationship_id" => $item['relationship_id'],
                        "pregnant_id" => $model["id"],
                    ];
                }
                $model->assignPhones($telefonos);
            }

            $validar3 = $data['examenes_rutinarios']  ?? null;
            if (!is_null($validar3)) {
                $model->examRoutines()->sync($data['examenes_rutinarios']);
            }

            $validar3 = $data['sustancias_sicotropicas']  ?? null;
            if (!is_null($validar3)) {
                $model->psychotrophics()->sync($data['sustancias_sicotropicas']);
            }

            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = Pregnant::find($id);
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function check ($data) {
        try {
            DB::beginTransaction();
            $model = Pregnant::whereHas('member', function ($query) use($data) {
                $query->where('cedula', $data);
            })->first();
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
            $model = Pregnant::find($id);
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