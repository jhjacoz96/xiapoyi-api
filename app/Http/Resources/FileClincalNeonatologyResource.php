<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Member;
use App\MemberPathology;
use App\AlterationNeonatology;
use App\PathologyNeonatalFile;
use App\PathologyNeonatology;
use App\PhatologyFamilyFile;
use App\ReflexNeonatal;

class FileClincalNeonatologyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $member = $this->member;

        $pathologies = MemberPathology::where('member_id', $member["id"])->get();
        $arrayPathologiesMother = $pathologies->map(function($query) {
            return $query->pathology_id;
        });

        $pathologyNeonatals = PathologyNeonatalFile::where('file_clinical_neonatology_id', $this->id)->get();
        $arrayPathologyNeonatal = $pathologyNeonatals->map(function($query) {
            return $query->pathology_neonatal_id;
        });

        $alterationPregnant = AlterationNeonatology::where('file_clinical_neonatology_id', $this->id)->get();
        $arrayAlterationPregnant = $alterationPregnant->map(function($query) {
            return $query->alteration_pregnant_id;
        });

        $pathologyPregnant = PathologyNeonatology::where('file_clinical_neonatology_id', $this->id)->get();
        $arrayPathologyPregnant = $pathologyPregnant->map(function($query) {
            return $query->pathology_pregnant_id;
        });

        $pathologyFather = PhatologyFamilyFile::where('file_clinical_neonatology_id', $this->id)->get();
        $arrayPathologyFather = $pathologyFather->map(function($query) {
            return $query->pathology_id;
        });

        $reflex = ReflexNeonatal::where('file_clinical_neonatology_id', $this->id)->get();
        $arrayReflex = $reflex->map(function($query) {
            return $query->reflex_id;
        });

        return [
            "nombre" => $member["nombre"],
            "apellido" => $member["apellido"],
            "fecha_nacimiento" => $member["fecha_nacimiento"],
            "gender_id" => $member["gender_id"],
            "group_age_id" => $member["group_age_id"],
            "numero_historia" => $this->numero_historia,
            "lugar_naciento" => $this->lugar_naciento,
            "pregnant_id" => $this->pregnant_id,
            "member_id" => $this->member_id,
            "type_boold_mother_id" => $this->type_boold_mother_id,
            "type_boold_father_id" => $this->type_boold_father_id,
            "edad_gestacional" => $this->edad_gestacional,
            "gestation_week_id" => $this->gestation_week_id,
            "alimentacion_neonato" => $this->alimentacion_neonato,
            "aplicacion_vitamina" => $this->aplicacion_vitamina,
            "alergina_leche_materna" => $this->alergina_leche_materna,
            "peso" => $this->peso,
            "perimetro_abdominal" => $this->perimetro_abdominal,
            "perimetro_cefalico" => $this->perimetro_cefalico,
            "perimetro_toracico" => $this->perimetro_toracico,
            "longitu_cefalo_caudal" => $this->longitu_cefalo_caudal,
            "temperatura" => $this->temperatura,
            "profilaxis" => $this->profilaxis,
            "supuración" => $this->supuración,
            "posicion" => $this->posicion,
            "estado" => $this->estado,
            "respiracion" => $this->respiracion,
            "piel" => $this->piel,
            "tonicidad" => $this->tonicidad,
            "cordon_umbilical" => $this->cordon_umbilical,
            "orina" => $this->orina,
            "deposiciones" => $this->deposiciones,
            "vomitos" => $this->vomitos,
            "coordinacion_motora" => $this->coordinacion_motora,
            "extreminades" => $this->extreminades,
            "genitales" => $this->genitales,
            "frecuencia_cardiaca" => $this->frecuencia_cardiaca,
            "esfuerzo_respiratorio" => $this->esfuerzo_respiratorio,
            "tono_muscular" => $this->tono_muscular,
            "irritabilidad" => $this->irritabilidad,
            "color_piel" => $this->color_piel,
            "total_apgar" => $this->total_apgar,
            "forma_pezon" => $this->forma_pezon,
            "textura_piel" => $this->textura_piel,
            "forma_oreja" => $this->forma_oreja,
            "tamano_tejido" => $this->tamano_tejido,
            "pliegue_plantares" => $this->pliegue_plantares,
            "total_test_capurro" => $this->total_test_capurro,
            "movimiento_taraco" => $this->movimiento_taraco,
            "tijera_intercostal" => $this->tijera_intercostal,
            "retraccion_xifoidea" => $this->retraccion_xifoidea,
            "aleteo_nasal" => $this->aleteo_nasal,
            "quejido_respiratorio" => $this->quejido_respiratorio,
            "total_escala_silverman" => $this->total_escala_silverman,
            "bcg" => $this->bcg,
            "hb" => $this->hb,
            "rotavirus" => $this->rotavirus,
            "fipv" => $this->fipv,
            "bopv" => $this->bopv,
            "pentavaliente" => $this->pentavaliente,
            "neumococo" => $this->neumococo,
            "influenza_estacionaria" => $this->influenza_estacionaria,
            "patologias_maternas" => $arrayPathologiesMother,
            "antecedentes_neonatales" => $arrayPathologyNeonatal,  
            "alteraciones_embarazo" => $arrayAlterationPregnant,
            "patologias_embarazo" =>  $arrayPathologyPregnant,
            "patologias_paternas" => $arrayPathologyFather,
            "reflejos" =>  $arrayReflex,
        ];
    }
}
