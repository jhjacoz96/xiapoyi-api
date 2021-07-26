<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'edad', 'file_famyly_id', 'relationship_id', 'fecha_fallecimiento', 'member_id', 'cause_mortality_id'
    ];

    public function fileFamily () {
       return $this->belongsTo('App\FileFamily', 'file_famyly_id', 'id');
    }
    public function member () {
       return $this->belongsTo('App\Member', 'member_id', 'id');
    }
    public function causeMortality () {
       return $this->belongsTo('App\CauseMortality', 'cause_mortality_id', 'id');
    }
    public function relationship () {
       return $this->belongsTo('App\Relationship', 'relationship_id', 'id');
    }
}
