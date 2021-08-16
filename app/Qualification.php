<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'diabetic_patient_id',
    ];

    public function questions () {
        return  $this->belongsToMany('App\QualificationQuestion','question_qualifications', 'qualification_id','qualification_question_id')->withPivot('qualification_level_id', 'id');
    }

}
