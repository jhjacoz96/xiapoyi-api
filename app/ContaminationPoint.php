<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContaminationPoint extends Model
{
    protected $fillable = [
        'tipo_contaminación',  'causas', 'file_family_id'
      ];

    public function fileFamily () {
        return $this->belognsTo('App\FileFamily', 'file_family_id', 'id');
    }
}
