<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'pregunta' => $this->pregunta,
            'respuesta' =>$this->respuesta ?? null,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'type_comment_id' => $this->type_comment_id,
            'typeComment' => $this->typeComment,
            'created_at' => $this->created_at,

        ];
    }
}
