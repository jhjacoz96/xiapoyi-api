<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RoleService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Role::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $model = Role::create(['name' => $data['name']]);
            DB::commit();
            return  $model;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function assignPermission ($data, $id) {
        try {
            DB::beginTransaction();
            $model = Role::find($id);
            if(!$model) return null;

            $children = $model->permissions;
            $permissionsItems = $data['permissions'];
            $deletedIds = $children->filter(function ($child) use ($permissionsItems) {
                return empty($permissionsItems->where('name', $child->name)->first());
            })->map(function ($child) {
                $name = $child->name;
                $child->revokePermissionTo($child);
                return $name;
            });
           
            $model->syncPermissions($data);

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
            $model = Role::find($id);
            if(!$model) return null;
            $model->update(["name" => $data["name"]]);
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
            $model = Role::find($id);
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
            $model = Role::find($id);
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