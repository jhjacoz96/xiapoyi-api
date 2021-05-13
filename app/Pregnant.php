<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregnant extends Model
{
    protected $fillable = [
        'fum', 'fpp', 'antecedentes_patologicos', 'semana_gestacion', 'gestas', 'partos', 'abortos', 'cesarias', 'member_id',
    ];

    public function member () {
        return $this->hasOne('App\Member','member_id', 'id');
    }

    public function vaccineDts () {
        return  $this->belongsToMany('App\VaccineDt','pregnant_vaccines','pregnant_id','vaccine_dt_id');
    } 
}
