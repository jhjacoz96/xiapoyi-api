<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContaminationPoint extends Model
{
    protected $fillable = [
        'contamination_id',  'cause_contamination_id', 'file_family_id'
      ];

    public function fileFamily () {
        return $this->belongsTo('App\FileFamily', 'file_family_id', 'id');
    }
    public function contamination () {
        return $this->belongsTo('App\Contamination', 'contamination_id', 'id');
    }
}
