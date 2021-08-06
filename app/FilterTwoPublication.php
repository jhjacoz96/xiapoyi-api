<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FilterTwoPublication extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'filter_one_publication_id'
    ];

    public function filterOnePublication () {
        return $this->belongsTo('App\FilterOnePublication', 'filter_one_publication_id', 'id');
    }

    public function filterThreePublications () {
        return $this->hasMany('App\FilterThreePublication', 'filter_two_publication_id', 'id');
    }
}
