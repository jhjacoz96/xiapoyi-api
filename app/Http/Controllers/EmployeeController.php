<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmpoyeeStoreRequest;
use App\Http\Requests\EmpoyeeUpdateRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Utils\Enums\EnumResponse;
use App\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeShowResource;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Notification;

class EmployeeController extends Controller
{
    function __construct(EmployeeService $_EmployeeService)
    {
        $this->service = $_EmployeeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function updatePassword (UpdatePasswordRequest $request) {
      try {
          $data = $request->validated();
          $user = \Auth::user();
          if (\Hash::check($request->passwordOld, $user->password)) {
            $user->password =  \Hash::make($request->password);
            $user->save();
            $data = new EmployeeResource($user->employee);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
          } else {
            $data = [
              'message' => __('auth.password_not')
            ];
            return bodyResponseRequest(EnumResponse::UNAUTHORIZED, $data);
          }
      } catch (\Exception $e) {
        return $e;
      }
    }

    public function notifications()
    {
        try {
            $model = \Auth::user()->employee->unreadNotifications;
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function readNotifications($id)
    {
        try {
            $notifications = \Auth::user()->employee->unreadNotifications;
            foreach ($notifications as $key => $value) {
               if ($value->data["id"] == $id) {
                    $value->markAsRead();
               }
            }
            $model = \Auth::user()->employee->unreadNotifications;
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function readAllNotifications()
    {
        try {
            $model = \Auth::user()
                ->employee
                ->notifications
                ->markAsRead();
            return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function index()
    {
        try {
            $model = $this->service->index();
            $data = EmployeeResource::collection($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpoyeeStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $model = $this->service->store($data);
            $data = new EmployeeResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
          } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.store');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $model = $this->service->show($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new EmployeeResource($model);
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.show');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpoyeeUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $model = $this->service->update($data, $id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = new EmployeeResource($model);
                return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
            }
          } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.update');
          }
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        try {
            $data = $request->validated();
            $model = $this->service->updateAvatar($data);
            $data = new EmployeeResource($model);
            return bodyResponseRequest(EnumResponse::ACCEPTED, $data);
          } catch (\Exception $e) {
            return $e;
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = $this->service->delete($id);
            if (!$model) {
                $data = [
                    'message' => __('response.bad_request_long')
                ];
                return bodyResponseRequest(EnumResponse::NOT_FOUND, $data);
            } else {
                $data = [
                    'message' => __('response.successfully_deleted')
                ];
                return bodyResponseRequest(EnumResponse::SUCCESS, $data);
            }
        } catch (\Exception $e) {
            return bodyResponseRequest(EnumResponse::ERROR, $e, [], self::class . '.destroy');
        }
    }
}
