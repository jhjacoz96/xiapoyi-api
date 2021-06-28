<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPathology extends Model
{
    public function pathology () {
    	return $this->belongsTo('App\Pathology', 'pathology_id');
    }
}
