<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentSite extends Model
{
    protected $fillable = [
        'lugar', 'file_famyly_id'
    ];

    public function fileFamily () {
        return $this->belognsTo('App\FileFamily', 'file_family_id', 'id');
    }

    
}
