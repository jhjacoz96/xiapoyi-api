<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function Employees () {
        return $this->hasMany('App\Employee', 'type_employee_id', 'id');
    }
}
