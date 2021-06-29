<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Pregnant;
use App\Member;
use App\SenalAlarm;
use App\Events\FileClinicalObstetricEvent;

class PregnantService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Member::has('pregnant')->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Pregnant::create([
                "numero_historia" => $data["numero_historia"],
                "employee_id" => \Auth::user()->employee->id,
                "antecedentes_patologicos" => $data["antecedentes_patologicos"],
                "semana_gestacion" => $data["semana_gestacion"],
                "gestas" => $data["gestas"],
                "recomendaciones" => $data["recomendaciones"],
                "partos" => $data["partos"],
                "abortos" => $data["abortos"],
                "descripcion_gestacion" => $data["descripcion_gestacion"],
                "cesarias" => $data["cesarias"],
                "type_blood_id" => $data["type_blood_id"],
                "fum" => $data["fum"],
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
                "descripcio_gestacion" => $data["descripcio_gestacion"],
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
                "member_id" => $data["member_id"],
                "gestation_week_id" => $data["gestation_week_id"],
            ]);

            if ($data["recomendaciones"] != '') {
                event(new FileClinicalObstetricEvent($model));
            }

            $updateMember = Member::find($model["member_id"]);

            if ($model["observacion_parto"] != '') {
                $updateMember->update([
                    "embarazo" => false,
                ]);
            } else {
                $updateMember->update([
                    "embarazo" => true,
                ]);
            }
            
            $validar = $data['tratamiento']  ?? null;
            if (!is_null($validar)) {
                $tratamiento = [];
                foreach ($data['tratamiento'] as $item) {
                        $tratamiento[$item["medicine_id"]] = [
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

             $validar7 = $data['senal_alarma']  ?? null;
            if (!is_null($validar7)) {
                $model->senalAlarms()->sync($data['senal_alarma']);
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

    public function search ($data) {
        try {
            $search = $data['search'];
            $model = Member::has('pregnant')
            /* $model = Member::whereHas('pregnant', function ($query) use($filter) {
                $query->where('embarazo', $filter['embarazo'] ?? false)
            })
            ->whereBetween('created_at', [$filter['inicio'] ?? '2010-10-10', $filter['fin'] ?? '2030-10-10']) */
            ->where('nombre','like','%'.$search .'%')
            ->orWhere('cedula','like','%'.$search .'%')
            ->orWhereHas('FileFamily', function ($query) use($search) {
                $query->where('direccion_habitual','like','%'.$search .'%')
                ->orWhere('manzana','like','%'.$search .'%')
                ->orWhereHas('CulturalGroup', function ($query) use ($search) {
                    $query->where('name', 'like','%'.$search .'%');
                })
                ->orWhereHas('Zone', function ($query) use ($search) {
                    $query->where('name', 'like','%'.$search .'%');
                });
            })
            ->orWhereHas('pregnant', function ($query) use($search) {
                $query->where('numero_historia', 'like','%'.$search .'%');
            })
            ->orderBy('id', 'desc')->get();

            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function filter ($data) {
        try {
            $group_ages = $data["group_age_id"];
            $gestacion = $data["embarazo"];
            // $semana_gestacion = $data["semana_gestacion"];
            if (count($group_ages) > 0 && !empty($gestacion)) {
                $model = Member::has('pregnant')
                    ->where('embarazo', true)
                    ->whereIn('group_age_id', $group_ages)
                    ->orderBy('id', 'desc')->get();
            } else if (count($group_ages) > 0) {
                $model = Member::has('pregnant')
                    ->whereIn('group_age_id', $group_ages)
                    ->orderBy('id', 'desc')->get();
            } else if (!empty($gestacion)) {
                 $model = Member::has('pregnant')
                    ->where('embarazo', true)
                    ->orderBy('id', 'desc')->get();
            } else {
                $model = Member::has('pregnant')
                    ->orderBy('id', 'desc')->get();
            }

            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = Pregnant::find($id);
            if(!$model) return null;

            $updateMember = Member::find($data["member_id"]);

            if ($data["recomendaciones"] != '' && $model["recomendaciones"] == '') {
                event(new FileClinicalObstetricEvent($model));
            }

            $model->update([
                "numero_historia" => $data["numero_historia"],
                "antecedentes_patologicos" => $data["antecedentes_patologicos"],
                "semana_gestacion" => $data["semana_gestacion"],
                "gestas" => $data["gestas"],
                "partos" => $data["partos"],
                "abortos" => $data["abortos"],
                "cesarias" => $data["cesarias"],
                "type_blood_id" => $data["type_blood_id"],
                 "recomendaciones" => $data["recomendaciones"],
                "fum" => $data["fum"],
                "descripcion_gestacion" => $data["descripcion_gestacion"],
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
                "gestation_week_id" => $data["gestation_week_id"],
            ]);

            if ($model["observacion_parto"] != '') {
                $updateMember->update([
                    "embarazo" => false,
                ]);
            } else {
                $updateMember->update([
                    "embarazo" => true,
                ]);
            }

            
            $validar = $data['tratamiento']  ?? null;
            if (!is_null($validar)) {
                $tratamiento = [];
                foreach ($data['tratamiento'] as $item) {
                        $tratamiento[$item["medicine_id"]] = [
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

            $validar7 = $data['senal_alarma']  ?? null;
            if (!is_null($validar7)) {
                $model->senalAlarms()->sync($data['senal_alarma']);
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
            $model = Member::where('cedula', $data)->where('gender_id', 2)->first();
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