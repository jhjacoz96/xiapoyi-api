<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FilterOnePublication extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name'
    ];

    public function filterTwoPublications () {
        return $this->hasMany('App\FilterTwoPublication', 'filter_one_publication_id', 'id');
    }
}
