<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDisability extends Model
{
    public function disability () {
    	return $this->belongsTo('App\Disability', 'disability_id');
    }
}
