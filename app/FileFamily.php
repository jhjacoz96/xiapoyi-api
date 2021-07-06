<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
USE App\Pregnant;
USE App\Member;

class FileFamily extends Model
{
    protected $fillable = [
        'manzana', 'direccion_habitual', 'barrio', 'numero_familia', 'numero_historia', 'numero_telefono', 'numero_casa', 'total_risk', 'zone_id', 'level_total_id', 'cultural_group_id', 'created_at',
    ];

    public function zone () {
        return $this->belongsTo('App\Zone', 'zone_id', 'id');
    }
    public function levelTotal () {
        return $this->belongsTo('App\LevelTotal', 'level_total_id', 'id');
    }
    public function culturalGroup () {
        return $this->belongsTo('App\CulturalGroup', 'cultural_group_id', 'id');
    }

    public function risks () {
        return  $this->belongsToMany('App\Risk','risk_files', 'file_family_id','risk_id')->withPivot('compromiso_familiar', 'compromiso_equipo', 'cumplio', 'causas', 'level_risk_id', 'id');
    }

    public function mortalities () {
        return $this->hasMany('App\Mortality', 'file_famyly_id', 'id');
    }

    public function riskFiles () {
        return $this->hasMany('App\riskFile', 'file_family_id', 'id');
    }

    public function contaminationPoints () {
        return $this->hasMany('App\ContaminationPoint', 'file_famyly_id', 'id');
    }

    public function treatmentSites () {
        return $this->hasMany('App\TreatmentSite', 'file_famyly_id', 'id');
    }

    public function members () {
        return $this->hasMany('App\Member', 'file_family_id', 'id');
    }

    public function assignMortalities (array $data) {
        $children = $this->mortalities;
        $site_items = collect($data);

        $deleted_ids = [];
        if (count($children) > 0) {
            $deleted_ids = $children->filter(function ($child) use ($site_items) {
                return empty($site_items->where('id', $child->id)->first());
            })->map(function ($child) {
                $id = $child->id;
                $child->delete();
                return $id;
            });
        }

        

        $updates = $site_items->filter(function ($model) {
            return isset($model['id']);
        })->map(function ($model) {
            $this->mortalities->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    "nombre" => $model['nombre'],
                        "apellido" => $model['apellido'],
                        "edad" => $model["edad"],
                        "causa" => $model["causa"],
                        "relationship_id" => $model['relationship_id'],
                    "file_famyly_id" => $model['file_famyly_id'],
             ]);
            });
        });


        $attachments = $site_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();

        $this->mortalities()->createMany($attachments);
    }


    public function assignContamination (array $data) {
        $children = $this->contaminationPoints;
        $site_items = collect($data);
        $deleted_ids = [];
        if (count($children) > 0) {
            $deleted_ids = $children->filter(function ($child) use ($site_items) {
                return empty($site_items->where('id', $child->id)->first());
            })->map(function ($child) {
                $id = $child->id;
                $child->delete();
                return $id;
            });
        }

        

        $updates = $site_items->filter(function ($model) {
            return isset($model['id']);
        })->map(function ($model) {
            $this->contaminationPoints->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    "tipo_contaminación" => $model['tipo_contaminación'],
                    "causas" => $model['causas'],
                    "file_famyly_id" => $model['file_famyly_id'],
             ]);
            });
        });


        $attachments = $site_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();

        $this->contaminationPoints()->createMany($attachments);
    }

    public function assignSite (array $data) {
        $children = $this->treatmentSites;
        $site_items = collect($data);
        $deleted_ids = [];
        if (count($children) > 0) {
            $deleted_ids = $children->filter(function ($child) use ($site_items) {
                return empty($site_items->where('id', $child->id)->first());
            })->map(function ($child) {
                $id = $child->id;
                $child->delete();
                return $id;
            });
        }

        

        $updates = $site_items->filter(function ($model) {
            return isset($model['id']);
        })->map(function ($model) {
            $this->treatmentSites->map(function ($c) use ($model) {
                $c->updateOrCreate([
                    'id' => $model['id'],
                  
                ],[
                    "lugar" => $model['lugar'],
                    "file_famyly_id" => $model['file_famyly_id'],
             ]);
            });
        });


        $attachments = $site_items->filter(function ($model) {
            return !isset($model['id']);
        })->map(function ($model) use ($deleted_ids) {
            if (count($deleted_ids) > 0) $model['id'] = $deleted_ids->pop();
            return $model;
        })->toArray();

        $this->treatmentSites()->createMany($attachments);
    }

}
