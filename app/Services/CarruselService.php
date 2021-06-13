<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Carrusel;

class CarruselService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Carrusel::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Carrusel::create($data);
            if ($data['image']) {
                $image = $data['image']->getRealPath();
                $folder = 'image/web';
                \Cloudder::upload($image, null, ['folder' => $folder], []);
                $c = \Cloudder::getResult();
                $model->image()->create([
                   'url' => $c['url'],
                   'public_id' => $c['public_id'],
                ]);
            }
            // $model->assignImage($data['image']);
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
            $model = Carrusel::find($id);
            if(!$model) return null;
            $model->update($data);
            if ($data['image_service']) $model->assignImage($data['image']);
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
            $model = Carrusel::find($id);
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
            $model = Carrusel::find($id);
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