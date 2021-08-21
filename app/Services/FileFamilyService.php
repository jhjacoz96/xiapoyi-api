<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\FileFamily;
use App\Pregnant;
use App\Pathology;
use App\Member;
use App\User;
use App\DiabeticPatient;
use App\Events\DiabeticPatientEvent;

class FileFamilyService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = FileFamily::orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function searchHistory ($history) {
         try {
            DB::beginTransaction();
            $model = FileFamily::where('numero_historia', $history)->orWhereHas('member', function($query)use($history){
                $query->where("cedula", $history);
            })->first();
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function search ($data) {
        try {
            // $filter = $data['filter'];
            $search = $data['search'];
            $model = FileFamily::where('numero_historia','like','%'.$search .'%')
                                ->orWhereHas('members', function ($query) use ($search) {
                                    $query->where('cedula', 'like','%'.$search .'%');
                                })
                                ->orWhere('numero_casa','like','%'.$search .'%')
                                ->orWhere('numero_familia','like','%'.$search .'%')
                                 ->orWhere('direccion_habitual','like','%'.$search .'%')
                                  ->orWhere('manzana','like','%'.$search .'%')
                                ->orWhereHas('CulturalGroup', function ($query) use ($search) {
                                    $query->where('name', 'like','%'.$search .'%');
                                })
                                ->orWhereHas('levelTotal', function ($query) use ($search) {
                                    $query->where('name', 'like','%'.$search .'%');
                                })
                                ->orWhereHas('zone', function ($query) use ($search) {
                                    $query->where('name', 'like','%'.$search .'%');
                                })->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function filter ($data) {
        try {
            $zones = $data["zone_id"];
            $level_totals = $data["level_total_id"];
            $pathology = $data["pathology_id"];
            $cultural_group = $data["group_cultural_id"];

            $q = FileFamily::with("zone");
                    count($zones) > 0 ? $model = $q->whereIn('zone_id', $zones) : "";
                    count($cultural_group) > 0 ? $model = $q->whereIn('cultural_group_id', $cultural_group) : "";
                    count($level_totals) > 0 ? $model = $q->whereIn('level_total_id', $level_totals) : "";
                    count($pathology) > 0 ? $model = $q->whereHas('members', function ($query) use($pathology) {
                        $query->whereHas('pathologies', function ($query) use($pathology) {
                           $query->whereIn('pathologies.id', $pathology);
                        });
                    }) : "";
                    $model = $q->orderBy('id', 'desc')->get();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();

            $f = FileFamily::All()->count();
            $model = FileFamily::create([
                "longitud" => $data["longitud"],
                "latitud" => $data["latitud"],
                "manzana" => $data["manzana"],
                "direccion_habitual" => $data["direccion_habitual"],
                "barrio" => $data["barrio"],
                "numero_familia" => $data["numero_familia"],
                "numero_historia" => $data["numero_historia"],
                "numero_telefono" => $data["numero_telefono"],
                "telefono_celular_uno" => $data["telefono_celular_uno"],
                "telefono_celular_dos" => $data["telefono_celular_dos"],
                "correo" => $data["correo"],
                "numero_casa" => $data["numero_casa"],
                "zone_id" => $data["zone_id"],
                "cultural_group_id" => $data["cultural_group_id"],
            ]);
            $validar = $data['miembros']  ?? null;
            if (!is_null($validar)) {
                $miembros = [];
                foreach ($data['miembros'] as $item) {
                    $miembros[] = [
                        "id" => $item['id'] ?? null,
                        "nombre" => $item['nombre'],
                        "apellido" => $item['apellido'],
                        "type_document_id" => $item['type_document_id'],
                        "type_blood_id" => $item['type_blood_id'] ?? null,
                        "cedula" => $item['cedula'],
                        "correo" => $item['correo'],
                        "ocupacion" => $item['ocupacion'],
                        "fecha_nacimiento" => $item['fecha_nacimiento'],
                        "vacunacion" => $item['vacunacion'],
                        "group_age_id" => $item['groupAge']['id'],
                        "salud_bucal" => $item['salud_bucal'],
                        "embarazo" => $item['embarazo'],
                        "scholarship_id" => $item['scholarship_id'],
                        "relationship_id" => $item['relationship_id'],
                        "gender_id" => $item['gender_id'],
                        "fallecido" => $item['fallecido'],
                        "file_family_id" => $model->id
                    ];
                }
                $children = $model->members;
                $miembros_items = collect($miembros);
                $deleted_ids = [];
                if (count($children) > 0) {
                    $deleted_ids = $children->filter(function ($child) use ($miembros_items) {
                        return in_array($miembros_items, $child->id);
                    })->map(function ($child) {
                        $id = $child->id;
                        $child->delete();
                        return $id;
                    });
                }
        
                

                $updates = $miembros_items->filter(function ($model) {
                    return isset($model['id']);
                })->map(function ($model) {
                    $model->members->map(function ($c) use ($model) {
                        $c->updateOrCreate([
                            'id' => $model['id'],
                          
                        ],[
                            "nombre" => $model['nombre'],
                            "apellido" => $model['apellido'],
                            "type_document_id" => $model['type_document_id'] ?? null,
                            "cedula" => $model['cedula'] ?? null,
                            "correo" => $model['correo'] ?? null,
                            "type_blood_id" => $model['type_blood_id'] ?? null,
                            "ocupacion" => $model['ocupacion'] ?? null,
                            "fecha_nacimiento" => $model['fecha_nacimiento'],
                            "group_age_id" => $model['group_age_id'],
                            "vacunacion" => $model['vacunacion'],
                            "salud_bucal" => $model['salud_bucal'],
                            "embarazo" => $model['embarazo'],
                            "scholarship_id" => $model['scholarship_id'] ?? null,
                            "relationship_id" => $model['relationship_id'],
                            "gender_id" => $model['gender_id'],
                            "fallecido" => $model['fallecido'],
                     ]);
                    });
                });

        
                $attachments = $miembros_items->filter(function ($model) {
                    return !isset($model['id']);
                })->map(function ($model) use ($deleted_ids) {
                    if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
                    return $model;
                })->toArray();
                
                // $members = $this->members()->createMany($attachments);


                foreach ($data['miembros'] as $member) {
                    $m = new  Member();
                    $m->nombre = $member['nombre'];
                    $m->apellido = $member['apellido'];
                    $m->type_document_id = $member['type_document_id'] ?? null;
                    $m->type_blood_id = $member['type_blood_id'] ?? null;
                    $m->cedula = $member['cedula'] ?? null;
                    $m->correo = $member['correo'] ?? null;
                    $m->ocupacion = $member['ocupacion'] ?? null;
                    $m->fecha_nacimiento = $member['fecha_nacimiento'];
                    $m->vacunacion = $member['vacunacion'];
                    $m->group_age_id = $member['groupAge']["id"];
                    $m->salud_bucal = $member['salud_bucal'];
                    $m->embarazo = $member['embarazo'];
                    $m->scholarship_id = $member['scholarship_id'] ?? null;
                    $m->relationship_id = $member['relationship_id'];
                    $m->gender_id = $member['gender_id'];
                    $m->fallecido = $member['fallecido'];
                    $m->file_family_id = $model->id;
                    $m->save();
                    //captar pacientes con diabetes
                    foreach ($member["patologias"] as  $pathology) {
                        $query = Pathology::find($pathology);
                        if ($query->capture) {
                            $password = \Str::random(10);
                            $user = User::create([
                                "email" => $m["correo"],
                                "password" =>  bcrypt($password)
                            ]);
                            $diabetic_patient = DiabeticPatient::create([
                                "user_id" => $user["id"],
                                "member_id" => $m["id"],
                            ]);
                            $datosMensaje = [
                                "usuario" => $m,
                                "password" =>  $password,
                            ];
                            Mail::send('correos.registroDiabetico', $datosMensaje,function($mensaje) use($m){
                                $mensaje->to($m["correo"])->subject('Registro de paciente diabético - KA-THANI');
                            });
                            $d = DiabeticPatient::with('member')->find($diabetic_patient["id"]);
                            event(new DiabeticPatientEvent($d));

                        }
                    }
                    //asignar patologias

                    $m->pathologies()->sync($member["patologias"]);

                    //asignar discapacidades

                    $m->disabilities()->sync($member["discapacidades"]);

                    //asignar mujeres embarazadas
                    if ($m['embarazo']) {
                        $prenatal = $member["prenatal"];
                        $s = new Pregnant();
                        $s->numero_historia  = $prenatal["numero_historia"];
                        $s->fum = $prenatal["fum"];
                        $s->antecedentes_patologicos = $prenatal["antecedentes_patologicos"];
                        $s->fpp = $prenatal["fpp"] ?? null;
                        $s->semana_gestacion = $prenatal["semana_gestacion"];
                        $s->gestas = $prenatal["gestas"];
                        $s->vaccine_dt = $prenatal["vaccine_dt"];
                        $s->partos = $prenatal["partos"];
                        $s->abortos = $prenatal["abortos"];
                        $s->cesarias = $prenatal["cesarias"];
                        $s->member_id = intval($m["id"]);
                         $s->employee_id = \Auth::user()->employee->id;
                        $s->save();
                    }
                }
            }
            $validar1 = $data['mortalidad']  ?? null;
            if (!is_null($validar1)) {
                $mortalidad = [];
                foreach ($data['mortalidad'] as $item) {
                    $m = Member::where('cedula',  $item["member_id"])->first();
                    $mortalidad[] = [
                        "id" => $item['id'] ?? null,
                        "nombre" => $item['nombre'],
                        "apellido" => $item['apellido'],
                        "edad" => $item["edad"],
                        "relationship_id" => $item['relationship_id'],
                        "file_famyly_id" => $model->id,
                        "fecha_fallecimiento" => $item['fecha_fallecimiento'],
                        "cause_mortality_id" => $item['cause_mortality_id'],
                        "member_id" => $m['id'],
                    ];
                }

                $model->assignMortalities($mortalidad);

            }
            $validar2 = $data['riesgos']  ?? null;
            if (!is_null($validar2)) {
                $riesgos = [];
                foreach ($data['riesgos'] as $item) {
                        $riesgos[$item["id"]] = [ "level_risk_id" => $item["level_risk_id"]];
                }
                $model->risks()->sync($riesgos);
            }
            
            $model->update([
                "total_risk" => $data["total_risk"],
                "level_total_id" => $data["level_total_id"],
            ]);
            $validar3 = $data['evaluacion']  ?? null;
            if (!is_null($validar3)) {
                foreach ($data['evaluacion'] as $item) {
                    $model->risks()->updateExistingPivot(
                        $item["id"], [
                        "compromiso_id" => $item["compromiso_id"]  ?? null,
                        "fecha_evaluacion" => $item["fecha_evaluacion"]  ?? null,
                        "fecha_programacion" => $item["fecha_programacion"]  ?? null,
                        "cumplio" => $item["cumplio"] ?? null,
                        "causas" => $item["causas"]  ?? null,
                    ]);
                }
            }

        
            $validar4 = $data['contaminacion']  ?? null;
            if (!is_null($validar4)) {
                $contaminacion = [];
                foreach ($data['contaminacion'] as $item) {
                    $contaminacion[] = [
                        "id" => $item['id'] ?? null,
                        "contamination_id" => $item['contamination_id'],
                        "cause_contamination_id" => $item['cause_contamination_id'],
                        "file_famyly_id" => $model->id
                    ];
                }
                
                $model->assignContamination($contaminacion);
            }

            $validar5 = $data['sitios_tratamiento']  ?? null;
            if (!is_null($validar5)) {
                $tratamiento = [];
                foreach ($data['sitios_tratamiento'] as $item) {
                    $tratamiento[] = [
                        "id" => $item['id'] ?? null,
                        "lugar" => $item['lugar'],
                        "file_famyly_id" => $model->id
                    ];
                }
                
                $model->assignSite($tratamiento);
            }

            $modell = FileFamily::find($model->id); 

            DB::commit();
            return  $modell;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = FileFamily::find($id);
            if(!$model) return null;

            $model->update([
                "longitud" => $data["longitud"],
                "latitud" => $data["latitud"],
                "manzana" => $data["manzana"],
                "direccion_habitual" => $data["direccion_habitual"],
                "barrio" => $data["barrio"],
                "numero_familia" => $data["numero_familia"],
                "numero_historia" => $data["numero_historia"],
                "numero_telefono" => $data["numero_telefono"],
                "numero_casa" => $data["numero_casa"],
                "zone_id" => $data["zone_id"],
                "telefono_celular_uno" => $data["telefono_celular_uno"],
                "telefono_celular_dos" => $data["telefono_celular_dos"],
                "correo" => $data["correo"],
                "cultural_group_id" => $data["cultural_group_id"],
            ]);
            $validar = $data['miembros']  ?? null;
            if (!is_null($validar)) {
                $miembros = [];
                foreach ($data['miembros'] as $item) {
                    $miembros[] = [
                        "id" => $item['id'] ?? null,
                        "nombre" => $item['nombre'],
                        "apellido" => $item['apellido'],
                        "type_document_id" => $item['type_document_id'],
                        "type_blood_id" => $item['type_blood_id'] ?? null,
                        "cedula" => $item['cedula'],
                        "correo" => $item['correo'],
                        "ocupacion" => $item['ocupacion'],
                        "fecha_nacimiento" => $item['fecha_nacimiento'],
                        "vacunacion" => $item['vacunacion'],
                        "group_age_id" => $item['groupAge']['id'],
                        "salud_bucal" => $item['salud_bucal'],
                        "embarazo" => $item['embarazo'],
                        "scholarship_id" => $item['scholarship_id'],
                        "relationship_id" => $item['relationship_id'],
                        "gender_id" => $item['gender_id'],
                        "file_family_id" => $model->id,
                        "patologias" => $item['patologias'],
                        "discapacidades" => $item['discapacidades'],
                        "prenatal" => $item['prenatal'],
                        "fallecido" => $item['fallecido'],
                        "file_family_id" => $model['id'],
                    ];
                }
                $children = $model->members;
                $miembros_items = collect($miembros);
                $deleted_ids = [];
                if (count($children) > 0) {
                    $deleted_ids = $children->filter(function ($child) use ($miembros_items) {
                        return empty($miembros_items->where('id', $child->id)->first());
                    })->map(function ($child) {
                        $id = $child->id;
                        $child->delete();
                        return $id;
                    });
                }
                
                $updates = $miembros_items->filter(function ($miembros) use($model) {
                    return isset($miembros['id']);
                })->map(function ($miembros) use ($model) {
                    $model->members->map(function ($c) use ($miembros) {
                        $c->updateOrCreate([
                            'id' => $miembros['id'],
                          
                        ],[
                            "nombre" => $miembros['nombre'],
                            "apellido" => $miembros['apellido'],
                            "type_document_id" => $miembros['type_document_id'],
                            "type_blood_id" => $miembros['type_blood_id'] ?? null,
                            "cedula" => $miembros['cedula'],
                            "correo" => $miembros['correo'],
                            "ocupacion" => $miembros['ocupacion'],
                            "fecha_nacimiento" => $miembros['fecha_nacimiento'],
                            "group_age_id" => $miembros['group_age_id'],
                            "vacunacion" => $miembros['vacunacion'],
                            "salud_bucal" => $miembros['salud_bucal'],
                            "embarazo" => $miembros['embarazo'],
                            "scholarship_id" => $miembros['scholarship_id'],
                            "relationship_id" => $miembros['relationship_id'],
                            "gender_id" => $miembros['gender_id'],
                            "file_family_id" => $miembros["file_family_id"],
                            "fallecido" => $miembros['fallecido'],
                     ]);
                    });
                });

                $attachments = $miembros_items->filter(function ($model) {
                    return !isset($model['id']);
                })->map(function ($model) use ($deleted_ids) {
                    if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
                    return $model;
                })->toArray();
                // $members = $this->members()->createMany($attachments);

                foreach ($miembros_items as $member) {
                    if (isset($member['id'])) $m = Member::find($member['id']);
                    else $m = new  Member();
                    $m->nombre = $member['nombre'];
                    $m->apellido = $member['apellido'];
                    $m->type_document_id = $member['type_document_id'];
                    $m->type_blood_id = $member['type_blood_id'];
                    $m->cedula = $member['cedula'];
                    $m->correo = $member['correo'];
                    $m->ocupacion = $member['ocupacion'];
                    $m->fecha_nacimiento = $member['fecha_nacimiento'];
                    $m->vacunacion = $member['vacunacion'];
                    $m->group_age_id = $member['group_age_id'];
                    $m->salud_bucal = $member['salud_bucal'];
                    $m->embarazo = $member['embarazo'];
                    $m->scholarship_id = $member['scholarship_id'];
                    $m->relationship_id = $member['relationship_id'];
                    $m->gender_id = $member['gender_id'];
                    $m->fallecido = $member['fallecido'];
                    $m->file_family_id = $model->id;
                    $m->save();

                    //captar pacientes con diabetes
                    foreach ($member["patologias"] as  $pathology) {
                        $query = Pathology::find($pathology);
                        $existe = DiabeticPatient::where('member_id', $m["id"])->first();
                        if ($query->capture && empty($existe)) {
                            $password = \Str::random(10);
                            $user = User::create([
                                "email" => $m["correo"],
                                "password" => bcrypt($password),
                            ]);
                            $diabetic_patient = DiabeticPatient::create([
                                "user_id" => $user["id"],
                                "member_id" => $m["id"],
                            ]);
                             $correo=$user->email;
                             $datosMensaje = [
                                "usuario" => $m,
                                "password" =>  $password,
                            ];
                            Mail::send('correos.registroDiabetico', $datosMensaje,function($mensaje) use($m){
                                $mensaje->to($m["correo"])->subject('Registro - KA-THANI');
                            });
                            $d = DiabeticPatient::with("member")->find($diabetic_patient["id"]);
                            event(new DiabeticPatientEvent($d));
                        }
                    }
                    //asignar patologias
                    $m->pathologies()->sync($member["patologias"]);

                    //asignar discapacidades

                    $m->disabilities()->sync($member["discapacidades"]);

                    //asignar mujeres embarazadas

                    if ($m['embarazo']) {
                        $prenatal = $member["prenatal"];
                        if (isset($prenatal["id"])) { 
                            $s = Pregnant::find($prenatal["id"]);
                        } else {
                            $s = new Pregnant();
                            $s->employee_id = \Auth::user()->employee->id;
                        }
                        $s->fum = $prenatal["fum"];
                        $s->antecedentes_patologicos = $prenatal["antecedentes_patologicos"];
                        $s->fpp = $prenatal["fpp"];
                        $s->semana_gestacion = $prenatal["semana_gestacion"];
                        $s->gestas = $prenatal["gestas"];
                        $s->partos = $prenatal["partos"];
                        $s->vaccine_dt = $prenatal["vaccine_dt"];
                        $s->numero_historia  = $prenatal["numero_historia"];
                        $s->abortos = $prenatal["abortos"];
                        $s->cesarias = $prenatal["cesarias"];
                        $s->member_id = intval($m["id"]);
                        $s->save();
                    }
                }
            }
            $validar1 = $data['mortalidad']  ?? null;
            if (!is_null($validar1)) {
                $mortalidad = [];
                foreach ($data['mortalidad'] as $item) {
                    $m = Member::where('cedula',  $item["member_id"])->orWhere('id',  $item["member_id"])->first();
                    $mortalidad[] = [
                        "id" => $item['id'] ?? null,
                        "nombre" => $item['nombre'],
                        "apellido" => $item['apellido'],
                        "edad" => $item["edad"],
                        "relationship_id" => $item['relationship_id'],
                        "file_famyly_id" => $model->id,
                        "fecha_fallecimiento" => $item['fecha_fallecimiento'],
                        "cause_mortality_id" => $item['cause_mortality_id'],
                        "member_id" => $m['id'],
                    ];
                }
                $model->assignMortalities($mortalidad);

            }

            $validar2 = $data['riesgos']  ?? null;
            if (!is_null($validar2)) {
                $riesgos = [];
                foreach ($data['riesgos'] as $item) {
                        $riesgos[$item["id"]] = [ "level_risk_id" => $item["level_risk_id"]];
                }
                $model->risks()->sync($riesgos);
            }
           
            $model->update([
                "total_risk" => $data["total_risk"],
                "level_total_id" => $data["level_total_id"],
            ]);
            
            $validar3 = $data['evaluacion']  ?? null;
            if (!is_null($validar3)) {
                $evolucion = [];
                foreach ($data['evaluacion'] as $item) {
                    $model->risks()->updateExistingPivot(
                        $item["id"], [
                        "compromiso_id" => $item["compromiso_id"]  ?? null,
                        "fecha_evaluacion" => $item["fecha_evaluacion"]  ?? null,
                        "fecha_programacion" => $item["fecha_programacion"]  ?? null,
                        "cumplio" => $item["cumplio"] ?? null,
                        "causas" => $item["causas"]  ?? null,
                    ]);
                }

            }


            $validar4 = $data['contaminacion']  ?? null;
            if (!is_null($validar4)) {
                $contaminacion = [];
                foreach ($data['contaminacion'] as $item) {
                    $contaminacion[] = [
                       "id" => $item['id'] ?? null,
                        "contamination_id" => $item['contamination_id'],
                        "cause_contamination_id" => $item['cause_contamination_id'],
                        "file_famyly_id" => $model->id
                    ];
                }
                $model->assignContamination($contaminacion);
            }

            $validar5 = $data['sitios_tratamiento']  ?? null;
            if (!is_null($validar5)) {
                $tratamiento = [];
                foreach ($data['sitios_tratamiento'] as $item) {
                    $tratamiento[] = [
                        "id" => $item['id'] ?? null,
                        "lugar" => $item['lugar'],
                        "file_famyly_id" => $model->id
                    ];
                }
                
                $model->assignSite($tratamiento);
            }

            $modell = FileFamily::find($model->id); 

            DB::commit();
            return  $modell;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = FileFamily::find($id);
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function verifyDocument ($data) {
        try {
            DB::beginTransaction();
            $model = Member::where('cedula', $data)->first();
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function verifyEmail ($data) {
        try {
            DB::beginTransaction();
            $model = User::where('email', $data)->first();
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
            $model = FileFamily::find($id);
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