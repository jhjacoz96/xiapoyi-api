<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterThreePublication extends Model
{
    protected $fillable = [
        'name', 'filter_two_publication_id'
    ];

    public function filterTwoPublication () {
        return $this->belongsTo('App\FilterTwoPublication', 'filter_two_publication_id', 'id');
    }
}
