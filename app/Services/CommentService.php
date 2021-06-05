<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Comment;
use App\TypeComment;

class CommentService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Comment::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Comment::create($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = Comment::find($id);
            if(!$model) return null;
            $model->update($data);
            $typeComment = TypeComment::find($model["type_comment_id"]);
            $datosMensaje = [
                "comentario" => $model,
                "tipoComentario" =>  $typeComment,
            ];
            Mail::send('correos.respuestaComentario', $datosMensaje,function($mensaje) use($model){
                $mensaje->to($model["correo"])->subject('Respuesta de comentario - Xiaoyi');
            });
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show ($id) {
        try {
            DB::beginTransaction();
            $model = Comment::find($id);
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function delete ($id) {
        try {
            DB::beginTransaction();
            $model = Comment::find($id);
            if(!$model) return null;
            $model->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}