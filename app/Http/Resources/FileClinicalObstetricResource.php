<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\VaccinePregnant;
use App\ExamPregnant;
use App\PsychotrophicPregnant;
use App\MemberDisability;
use App\MedicinePregnant;
use App\SenalAlarmPregnant;
class FileClinicalObstetricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $miembro = $this->member;
        $fileFamily = $miembro->fileFamily;
        $discapacidades = MemberDisability::where('member_id', $this->member_id)->get();
        $arrayDiscapacidades = $discapacidades->map(function ($query) {
            return $query->disability_id;
        });

        $psychotrophicPregnant = PsychotrophicPregnant::where('pregnant_id', $this->id)->get();
        $arrayPsychotrophicPregnant =  $psychotrophicPregnant->map(function ($query) {
            return $query->psychotrophic_id;
        });

        $vaccine = VaccinePregnant::where('pregnant_id', $this->id)->get();
        $arrayVaccine =  $vaccine->map(function ($query) {
            return $query->vaccine_id;
        });

        $exam = ExamPregnant::where('pregnant_id', $this->id)->get();
        $arrayExam =  $exam->map(function ($query) {
            return $query->exam_routine_id;
        });

        $senal= SenalAlarmPregnant::where('pregnant_id', $this->id)->get();
        $arraySenal =  $senal->map(function ($query) {
            return $query->senal_alarm_id;
        });

        return [
            "nombre" => $miembro->nombre,
            "apellido" => $miembro->apellido,
            "cedula" => $miembro->cedula,
            "type_document_id" => $miembro->typeDocument,
            "cultural_group_id" =>  $fileFamily->culturalGroup,
            "fecha_nacimiento" => $miembro->fecha_nacimiento,
            "zone_id" => $fileFamily->zone,
            "direccion_habitual" => $fileFamily->direccion_habitual,
            "scholarship_id" => $miembro->scholarship,
            "ocupacion" => $miembro->ocupacion,
            "disability_id" => $arrayDiscapacidades,
            "numero_historia" => $this->numero_historia,
            "id" => $this->id,
            "member_id" =>$this->member_id,
            "fum" => $this->fum ?? null,
            "fpp" => $this->fpp ?? null,
            "antecedentes_patologicos" => $this->antecedentes_patologicos ?? null,
            "semana_gestacion" => $this->semana_gestacion ?? null,
            "gestas" => $this->gestas ?? null,
            "partos" => $this->partos ?? null,
            "vaccine_dt" => $this->vaccine_dt ?? null,
            "abortos" => $this->abortos ?? null,
            "cesarias" => $this->cesarias ?? null,
            "type_blood_id" => $this->type_blood_id ?? null,
            "estado_civil" => $this->estado_civil ?? null,
            "vive_con" => $this->vive_con ?? null,
            "descripcion_gestacion" => $this->descripcion_gestacion ?? null,
            "antecentedes_paternos" => $this->antecentedes_paternos ?? null,
            "antecentedes_maternos" => $this->antecentedes_maternos ?? null,
            "antecentedes_prenatales" => $this->antecentedes_prenatales ?? null,
            "antecedentes_patologicos" => $this->antecedentes_patologicos ?? null,
            "medicamentos" => $this->medicamentos ?? null,
            "embarazo_planificado" => $this->embarazo_planificado ?? null,
            "causa_embarazo" => $this->causa_embarazo ?? null,
            "ayuda_violacion" => $this->ayuda_violacion ?? null,
            "ayuda_anticoceptivo" => $this->ayuda_anticoceptivo ?? null,
            "talla" => $this->talla?? null,
            "peso" => $this->peso ?? null,
            "dar_luz" => $this->dar_luz ?? null,
            "nombre_acompanate" => $this->nombre_acompanate ?? null,
            "aceptaria_formula" => $this->aceptaria_formula ?? null,
            "estimulacion_embarazo" => $this->estimulacion_embarazo ?? null,
            "administrar_hemoderivado" => $this->administrar_hemoderivado ?? null,
            "capacitacion_prenatal" => $this->capacitacion_prenatal ?? null,
            "capacitacion_epidural" => $this->capacitacion_epidural ?? null,
            "observacion_parto" => $this->observacion_parto ?? null,
            "hemorragia" => $this->hemorragia ?? null,
            "desgarro" => $this->desgarro ?? null,
            "grado_desgarro" => $this->grado_desgarro ?? null,
            "tipo_parto" => $this->tipo_parto ?? null,
            "episiorria" => $this->episiorria ?? null,
            "hemorroides" => $this->hemorroides ?? null,
            "dolor" => $this->dolor ?? null,
            "epitomia" => $this->epitomia ?? null,
            "grado_epitomia" => $this->grado_epitomia ?? null,
            "loquios" => $this->loquios ?? null,
            "involucion_uterina" => $this->involucion_uterina ?? null,
            "dolor_eva" => $this->dolor_eva ?? null,
            "educacion_lactancia" => $this->educacion_lactancia ?? null,
            "satisfaccion_lactancia" => $this->satisfaccion_lactancia ?? null,
            "score_mama_inmediato" => $this->score_mama_inmediato ?? null,
            "score_mama_mediato" => $this->score_mama_mediato ?? null,
            "educacion_paciente" => $this->educacion_paciente ?? null,
            "educacion_depresion" => $this->educacion_depresion ?? null,
            "proporcionar_telefono" => $this->proporcionar_telefono ?? null,
            "senal_alarma" => $arraySenal,
            "tratamiento" => MedicinePregnant::where('pregnant_id', $this->id)->get(),
            "telefonos" => $this->pregnantPhones,
            "vacuna" => $arrayVaccine,
            "examenes_rutinarios" => $arrayExam,
            "sustancias_sicotropicas" => $arrayPsychotrophicPregnant,
            "recomendaciones" => $this->recomendaciones ?? null,
            "created_At" => $this->created_at ?? null,
       ];
    }
}
