<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Employee;
use App\TypeDocument;
use App\User;
use Illuminate\Support\Facades\Auth;

class EmployeeService {

    function __construct()
    {

    }

    public function index () {
        try {
            
            $model = Employee::All();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            DB::beginTransaction();
            $modelUser = User::create([
                "email" => $data["email"],
                'password' => bcrypt('12345678'),
            ]);
            $modelEmployee = new Employee();
            $modelEmployee->province_id  = $data["province_id"];
            $modelEmployee->name = $data["name"];
            $modelEmployee->phone = $data["phone"];
            $modelEmployee->type_document_id = $data["type_document_id"];
            $modelEmployee->document = $data["document"];
            $modelEmployee->gender_id  = $data["gender_id"];
            $modelEmployee->canton_id = $data["canton_id"];
            $modelEmployee->address = $data["address"];
            $modelEmployee->user_id = $modelUser->id;
            $modelEmployee->save();
            DB::commit();
            return  $modelEmployee;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update ($data, $id) {
        try {
            DB::beginTransaction();
            $modelEmployee = Employee::find($id);
            if(!$modelEmployee) return null;
            $modelEmployee->province_id  = $data["province_id"] ?? null;
            $modelEmployee->name = $data["name"] ?? null;
            $modelEmployee->phone = $data["phone"] ?? null;
            $modelEmployee->type_document_id = $data["type_document_id"] ?? null;
            $modelEmployee->document = $data["document"] ?? null;
            $modelEmployee->gender_id  = $data["gender_id"] ?? null;
            $modelEmployee->canton_id = $data["canton_id"] ?? null;
            $modelEmployee->address = $data["address"] ?? null;
            $modelEmployee->type_employee_id = $data["type_employee_id"] ?? null;
            $modelEmployee->specialty_id = $data["specialty_id"] ?? null;

            $modelEmployee->save();
            if (!empty($data['role_id'] && !empty(\Auth::user()->roles))) {
                \Auth::user()->assignRole($data['role_id']);
            }
            DB::commit();
            return  $modelEmployee;
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
            $model = Employee::find($id);
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
            $model = Employee::find($id);
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