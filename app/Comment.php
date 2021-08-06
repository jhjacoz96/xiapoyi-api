<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Comment extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $fillable = [
        'pregunta',
        'respuesta',
        'nombre',
        'correo',
        'type_comment_id',
    ];

     public function typeComment () {
        return $this->belongsTo('App\TypeComment', 'type_comment_id', 'id');
    }
}
