<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'phone', 'document', 'address', 'status', 'canton_id', 'user_id', 'gender_id',
        'type_document_id', 'type_employee_id', 'specialty_id',
    ];

    public function canton () {
        return $this->belongsTo('App\Canton', 'canton_id', 'id');
    }
    public function gender () {
        return $this->belongsTo('App\Gender', 'gender_id', 'id');
    }
    public function user () {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function type_document () {
        return $this->belongsTo('App\TypeDocument', 'type_document_id', 'id');
    }
    public function type_employee () {
        return $this->belongsTo('App\Type_employee', 'type_employee_id', 'id');
    }
    public function specialty () {
        return $this->belongsTo('App\Specialty', 'specialty_id', 'id');
    }
}
