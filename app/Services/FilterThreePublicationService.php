<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\FilterThreePublication;

class FilterThreePublicationService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = FilterThreePublication::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = FilterThreePublication::create($data);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function indexFilter($id) {
        try {
            DB::beginTransaction();
            $model = FilterThreePublication::where('filter_two_publication_id', $id)->get();
            if(!$model) return null;
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $model = FilterThreePublication::find($id);
            if(!$model) return null;
            $model->update($data);
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
            $model = FilterThreePublication::find($id);
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
            $model = FilterThreePublication::find($id);
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