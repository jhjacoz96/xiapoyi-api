<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationQuestion extends Model
{
    protected $fillable = [
        'nombre',
    ];
    
    public function qualifications () {
        return  $this->belongsToMany('App\Qualification','question_qualifications', 'qualification_question_id','qualification_id')->withPivot('qualification_level_id', 'id');
    }
}
