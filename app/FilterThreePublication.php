<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FilterThreePublication extends Model implements Auditable
{
	use AuditableTrait;
	
    protected $fillable = [
        'name', 'filter_two_publication_id'
    ];

    public function filterTwoPublication () {
        return $this->belongsTo('App\FilterTwoPublication', 'filter_two_publication_id', 'id');
    }
}
