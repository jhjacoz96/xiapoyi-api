<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterTwoPublication extends Model
{
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
