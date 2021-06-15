<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterActivity extends Model
{
    protected $fillable = [
        'fecha', 'activity_treatment_id',
    ];

    public function activityTreatment () {
        return $this->belongsTo('App\ActivityTreatment', 'activity_treatment_id', 'id');
    }
}
