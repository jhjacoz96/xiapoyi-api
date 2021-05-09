<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterOnePublication extends Model
{
    protected $fillable = [
        'name'
    ];

    public function filterTwoPublications () {
        return $this->hasMany('App\FilterTwoPublication', 'filter_one_publication_id', 'id');
    }
}
