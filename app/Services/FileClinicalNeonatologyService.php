<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\FileClinicalNeonatology;
use App\Member;
use App\Pregnant;
use App\AlterationPregnant;

class FileClinicalNeonatologyService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = FileClinicalNeonatology::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $pregnant = Pregnant::find($data["pregnant_id"]);
            $member = Member::create([
                "nombre" => $data["nombre"],
                "apellido" => $data["apellido"],
                "fecha_nacimiento" => $data["fecha_nacimiento"],
                "gender_id" => $data["gender_id"],
                "file_family_id" =>   intval($pregnant->member->fileFamily->id),
                "group_age_id" => 1,
            ]);

            $gestationWeek = GestatationWeek::where('nombre',  $pregnant['descripcion_gestacion'])->first();

            $model = FileClinicalNeonatology::create([
                'numero_historia' => $data["numero_historia"],
                'lugar_naciento' => $data["lugar_naciento"],
                'pregnant_id' => $data["pregnant_id"],
                'member_id' => $member["id"],
                'type_boold_mother_id' => $data["type_boold_mother_id"],
                'type_boold_father_id' => $data["type_boold_father_id"],
                'edad_gestacional' => $data["edad_gestacional"],
                'gestation_week_id' => $gestationWeek["id"],
                'alimentacion_neonato' => $data["alimentacion_neonato"],
                'aplicacion_vitamina' => $data["aplicacion_vitamina"],
                'alergina_leche_materna' => $data["alergina_leche_materna"],
                'peso' => $data["peso"],
                'perimetro_abdominal' => $data["perimetro_abdominal"],
                'perimetro_cefalico' => $data["perimetro_cefalico"],
                'perimetro_toracico'  =>$data["perimetro_toracico"],
                'longitu_cefalo_caudal' => $data["longitu_cefalo_caudal"],
                'temperatura' => $data["temperatura"],
                'profilaxis' => $data["profilaxis"],
                'supuración' => $data["supuración"],
                'posicion' => $data["posicion"],
                'estado' => $data["estado"],
                'respiracion' => $data["respiracion"],
                'piel'  =>$data["piel"],
                'tonicidad' => $data["tonicidad"],
                'cordon_umbilical' => $data["cordon_umbilical"],
                'orina' => $data["orina"],
                'deposiciones' => $data["deposiciones"],
                'vomitos'  =>$data["vomitos"],
                'coordinacion_motora'  =>$data["coordinacion_motora"],
                'extreminades' => $data["extreminades"],
                'genitales' => $data["genitales"],
                'frecuencia_cardiaca' => $data["frecuencia_cardiaca"],
                'esfuerzo_respiratorio' => $data["esfuerzo_respiratorio"],
                'tono_muscular' => $data["tono_muscular"],
                'irritabilidad' => $data["irritabilidad"],
                'color_piel' => $data["color_piel"],
                'total_apgar' => $data["total_apgar"],
                'forma_pezon' => $data["forma_pezon"],
                'textura_piel' => $data["textura_piel"],
                'forma_oreja' => $data["forma_oreja"],
                'tamano_tejido' => $data["tamano_tejido"],
                'pliegue_plantares' => $data["pliegue_plantares"],
                'total_test_capurro' => $data["total_test_capurro"],
                'movimiento_taraco' => $data["movimiento_taraco"],
                'tijera_intercostal'  =>$data["tijera_intercostal"],
                'retraccion_xifoidea' => $data["retraccion_xifoidea"],
                'aleteo_nasal' => $data["aleteo_nasal"],
                'quejido_respiratorio' => $data["quejido_respiratorio"],
                'total_escala_silverman'  =>$data["total_escala_silverman"],
                'bcg' => $data["bcg"],
                'hb' => $data["hb"],
                'rotavirus' => $data["rotavirus"],
                'fipv' => $data["fipv"],
                'bopv' => $data["bopv"],
                'pentavaliente' => $data["pentavaliente"],
                'neumococo' => $data["neumococo"],
                'influenza_estacionaria' => $data["influenza_estacionaria"],
            ]);

            

            $validar1 = $data['patologias_maternas']  ?? null;
            if (!is_null($validar1)) {
                $m = Member::with('pathologies')->find($pregnant->member->id);
                $m->pathologies()->sync($data["patologias_maternas"]);
            }
            
            $validar1 = $data['alteraciones_embarazo']  ?? null;
            if (!is_null($validar1)) {
                $model->alterationPregnants()->sync($data["alteraciones_embarazo"]);
            }

            $validar2 = $data['patologias_embarazo']  ?? null;
            if (!is_null($validar2)) {
                $model->pathologyPregnants()->sync($data["patologias_embarazo"]);
            }

            $validar3 = $data['antecedentes_neonatales']  ?? null;
            if (!is_null($validar3)) {
                $model->pathologyNeonatals()->sync($data["antecedentes_neonatales"]);
            }

            $validar5 = $data['patologias_paternas']  ?? null;
            if (!is_null($validar5)) {
                $model->pathologyFathers()->sync($data["patologias_paternas"]);
            }

            $validar6 = $data['reflejos']  ?? null;
            if (!is_null($validar6)) {
                $model->reflexes()->sync($data["reflejos"]);
            }


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
            $model = FileClinicalNeonatology::find($id);
            if(!$model) return null;

            $member = Member::find($model->member->id);
            if(!$member) return null;

            $pregnant = Pregnant::find($model->pregnant->id);
            if(!$pregnant) return null;

            $model->update([
                'numero_historia' => $data["numero_historia"],
                'lugar_naciento' => $data["lugar_naciento"],
                'pregnant_id' => $data["pregnant_id"],
                'member_id' => $member["id"],
                'type_boold_mother_id' => $data["type_boold_mother_id"],
                'type_boold_father_id' => $data["type_boold_father_id"],
                'edad_gestacional' => $data["edad_gestacional"],
                'gestation_week_id' => $data["gestation_week_id"],
                'alimentacion_neonato' => $data["alimentacion_neonato"],
                'aplicacion_vitamina' => $data["aplicacion_vitamina"],
                'alergina_leche_materna' => $data["alergina_leche_materna"],
                'peso' => $data["peso"],
                'perimetro_abdominal' => $data["perimetro_abdominal"],
                'perimetro_cefalico' => $data["perimetro_cefalico"],
                'perimetro_toracico'  =>$data["perimetro_toracico"],
                'longitu_cefalo_caudal' => $data["longitu_cefalo_caudal"],
                'temperatura' => $data["temperatura"],
                'profilaxis' => $data["profilaxis"],
                'supuración' => $data["supuración"],
                'posicion' => $data["posicion"],
                'estado' => $data["estado"],
                'respiracion' => $data["respiracion"],
                'piel'  =>$data["piel"],
                'tonicidad' => $data["tonicidad"],
                'cordon_umbilical' => $data["cordon_umbilical"],
                'orina' => $data["orina"],
                'deposiciones' => $data["deposiciones"],
                'vomitos'  =>$data["vomitos"],
                'coordinacion_motora'  =>$data["coordinacion_motora"],
                'extreminades' => $data["extreminades"],
                'genitales' => $data["genitales"],
                'frecuencia_cardiaca' => $data["frecuencia_cardiaca"],
                'esfuerzo_respiratorio' => $data["esfuerzo_respiratorio"],
                'tono_muscular' => $data["tono_muscular"],
                'irritabilidad' => $data["irritabilidad"],
                'color_piel' => $data["color_piel"],
                'total_apgar' => $data["total_apgar"],
                'forma_pezon' => $data["forma_pezon"],
                'textura_piel' => $data["textura_piel"],
                'forma_oreja' => $data["forma_oreja"],
                'tamano_tejido' => $data["tamano_tejido"],
                'pliegue_plantares' => $data["pliegue_plantares"],
                'total_test_capurro' => $data["total_test_capurro"],
                'movimiento_taraco' => $data["movimiento_taraco"],
                'tijera_intercostal'  =>$data["tijera_intercostal"],
                'retraccion_xifoidea' => $data["retraccion_xifoidea"],
                'aleteo_nasal' => $data["aleteo_nasal"],
                'quejido_respiratorio' => $data["quejido_respiratorio"],
                'total_escala_silverman'  =>$data["total_escala_silverman"],
                'bcg' => $data["bcg"],
                'hb' => $data["hb"],
                'rotavirus' => $data["rotavirus"],
                'fipv' => $data["fipv"],
                'bopv' => $data["bopv"],
                'pentavaliente' => $data["pentavaliente"],
                'neumococo' => $data["neumococo"],
                'influenza_estacionaria' => $data["influenza_estacionaria"],
            ]);

            

            $validar1 = $data['patologias_maternas']  ?? null;
            if (!is_null($validar1)) {
                $m = Member::with('pathologies')->find($pregnant->member->id);
                $m->pathologies()->sync($data["patologias_maternas"]);
            }
            
            $validar1 = $data['alteraciones_embarazo']  ?? null;
            if (!is_null($validar1)) {
                $model->alterationPregnants()->sync($data["alteraciones_embarazo"]);
            }

            $validar2 = $data['patologias_embarazo']  ?? null;
            if (!is_null($validar2)) {
                $model->pathologyPregnants()->sync($data["patologias_embarazo"]);
            }

            $validar3 = $data['antecedentes_neonatales']  ?? null;
            if (!is_null($validar3)) {
                $model->pathologyNeonatals()->sync($data["antecedentes_neonatales"]);
            }

            $validar5 = $data['patologias_paternas']  ?? null;
            if (!is_null($validar5)) {
                $model->pathologyFathers()->sync($data["patologias_paternas"]);
            }

            $validar6 = $data['reflejos']  ?? null;
            if (!is_null($validar6)) {
                $model->reflexes()->sync($data["reflejos"]);
            }

            $member->update([
                "nombre" => $data["nombre"],
                "apellido" => $data["apellido"],
                "fecha_nacimiento" => $data["fecha_nacimiento"],
                "gender_id" => $data["gender_id"],
                "file_family_id" =>   intval($pregnant->member->fileFamily->id),
                "group_age_id" => 1,
            ]);


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
            $model = FileClinicalNeonatology::find($id);
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
            $model = FileClinicalNeonatology::find($id);
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