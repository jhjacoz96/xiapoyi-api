<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'cedula', 'correo', 'ocupacion', 'fecha_nacimiento', 'vacunacion', 'salud_bucal', 'edad', 'embarazo', 'scholarship_id', 'relationship_id', 'gender_id', 'type_document_id', 'file_family_id', 'group_age_id', 'created_at', 'type_blood_id', 'fallecido'
    ];
    

    public function fileFamily () {
        return $this->belongsTo('App\FileFamily', 'file_family_id', 'id');
    }

    public function typeBlood () {
        return $this->belongsTo('App\TypeBlood', 'type_blood_id', 'id');
    }

    public function scholarship () {
        return $this->belongsTo('App\Scholarship', 'scholarship_id', 'id');
    }

    public function groupAge () {
        return $this->belongsTo('App\GroupAge', 'group_age_id', 'id');
    }

    public function relationship () {
        return $this->belongsTo('App\Relationship', 'relationship_id', 'id');
    }

    public function gender () {
        return $this->belongsTo('App\Gender', 'gender_id', 'id');
    }

    public function typeDocument () {
        return $this->belongsTo('App\TypeDocument', 'type_document_id', 'id');
    }

    public function disabilities () {
        return  $this->belongsToMany('App\Disability','member_disabilities','member_id','disability_id');
    }  

    public function pathologies () {
        return  $this->belongsToMany('App\Pathology','member_pathologies','member_id','pathology_id');
    }

    public function diabeticPatient () {
        return $this->hasOne('App\DiabeticPatient','member_id', 'id');
    }

    public function pregnant () {
        return $this->hasMany('App\Pregnant','member_id', 'id');
    }
    public function fileClinicalObstetric () {
        return $this->hasOne('App\FileClinicalNeonatology','member_id', 'id');
    }

    public function assignPathologies (array $data) {
        $children = $this->pathologies;
        $patholologies_items = Collect($data);

        $deleted_ids = [];
        if (count($children) > 0) {
            $deletedIds = $children->filter(function ($child) use ($patholologies_items) {
                return in_array($patholologies_items, $child->id);
            })->map(function ($child) {
                $child->revokePermissionTo($child["name"]);
                return $child;
            });
        }

        $model->syncPermissions($patholologies_items);
    }
    
}
