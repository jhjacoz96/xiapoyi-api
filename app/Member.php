<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'cedula', 'correo', 'ocupacion', 'fecha_nacimiento', 'vacunacion', 'salud_bucal', 'edad', 'embarazo', 'scholarship_id', 'relationship_id', 'gender_id', 'type_document_id', 'file_famyly_id'
    ];

    public function fileFamily () {
        return $this->belognsTo('App\FileFamily', 'file_family_id', 'id');
    }

    public function scholarship () {
        return $this->belognsTo('App\Scholarship', 'scholarship_id', 'id');
    }

    public function relationship () {
        return $this->belognsTo('App\Relationship', 'relationship_id', 'id');
    }

    public function gender () {
        return $this->belognsTo('App\Gender', 'gender_id', 'id');
    }

    public function typeDocument () {
        return $this->belognsTo('App\TypeDocument', 'type_document_id', 'id');
    }

    public function disabilities () {
        return  $this->belongsToMany('App\Disability','member_disabilities','member_id','disability_id');
    }  

    public function pathologies () {
        return  $this->belongsToMany('App\Pathology','member_pathologies','member_id','pathology_id');
    }

    public function pregnant () {
        return $this->hasOne('App\Pregnant','member_id', 'id');
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
