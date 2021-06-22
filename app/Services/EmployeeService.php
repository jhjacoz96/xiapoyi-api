<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Employee;
use App\TypeDocument;
use Illuminate\Support\Facades\Mail;
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

    public function updateAvatar ($data) {
        try {
            DB::beginTransaction();
            $employee = \Auth::user()->Employee;
            $image = $data['image']->getRealPath();
            /*$nombre = 'image_perfil_'.$image->getClientOriginalName();
            $ruta = public_path().'/imagePerfil';
           $image->move($ruta , $nombre);
            $url['url']='/imagePerfil/'.$nombre;*/
            $folder = 'image/perfil';
            \Cloudder::upload($image, null, ['folder' => $folder], []);
            $c = \Cloudder::getResult();
            if ($employee->image) {
               \Cloudder::destroyImage($employee->image->public_id, ['folder' => $folder]);
               $employee->image->url = $c['url'];
               $employee->image->public_id = $c['public_id'];
               $employee->image->save();
            } else {
               $employee->image()->create([
                   'url' => $c['url'],
                   'public_id' => $c['public_id'],
                ]);
            }
            DB::commit();
            return  $employee;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }


    public function store ($data) {
        try {
            DB::beginTransaction();
            $password = \Str::random(10);
            $modelUser = User::create([
                "email" => $data["email"],
                'password' => bcrypt($password),
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
            $datosMensaje = [
                "usuario" => $modelEmployee,
                "email" => $modelUser->email,
                "password" =>  $password,
            ];
            Mail::send('correos.registroEmpleado', $datosMensaje,function($mensaje) use($modelUser){
                $mensaje->to($modelUser["email"])->subject('Registro - KA-THANI');
            });
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
            if (isset($data["province_id"])) $modelEmployee->province_id  = $data["province_id"] ?? null;
            if (isset($data["name"])) $modelEmployee->name = $data["name"] ?? null;
            if (isset($data["phone"])) $modelEmployee->phone = $data["phone"] ?? null;
            if (isset($data["type_document_id"])) $modelEmployee->type_document_id = $data["type_document_id"] ?? null;
            if (isset($data["document"])) $modelEmployee->document = $data["document"] ?? null;
            if (isset($data["gender_id"])) $modelEmployee->gender_id  = $data["gender_id"] ?? null;
            if (isset($data["canton_id"])) $modelEmployee->canton_id = $data["canton_id"] ?? null;
            if (isset($data["address"])) $modelEmployee->address = $data["address"] ?? null;
            if (isset($data["type_employee_id"])) $modelEmployee->type_employee_id = $data["type_employee_id"] ?? null;
            if (isset($data["specialty_id"])) $modelEmployee->specialty_id = $data["specialty_id"] ?? null;

            $modelEmployee->save();
            if (!empty($data['role_id'])) {
                $user = User::find($modelEmployee->user_id);
               $user->assignRole($data['role_id']);
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