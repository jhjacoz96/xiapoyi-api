<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamRoutine extends Model
{
    protected $fillable = [
        'name', 'description',
    ];
}
