<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Enums\EnumResponse;
use App\DiabeticPatient;

class NotificationMovilController extends Controller
{
    public function updateToken(Request $request){
        try{
            $user = \Auth::user()->diabeticPatient;
            if ($request->has('device_token')) {
                $user->device_token = $request->input('fcm_token');
                $user->save();
            }
            $data = [
                'message' => __('response.accepted')
            ];
            return bodyResponseRequest(EnumResponse::SUCCESS, $data);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function notification(Request $request){
        try{
            $fcmTokens = DiabeticPatient::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            \Larafirebase::withTitle('title')
                ->withBody('boby')
                ->sendMessage($fcmTokens);
            $data = [
                'message' => __('response.accepted')
            ];
            return bodyResponseRequest(EnumResponse::SUCCESS, $data);
        }catch(\Exception $e){
            return $e;
        }
    }
}
