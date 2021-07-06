<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidationQuestionRequest;
use App\Http\Requests\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Services\PermissionService;
use App\Models\Sanctum\PersonalAccessToken;
use App\Http\Resources\UserResource;
use App\Http\Resources\MemberResource;
use App\Utils\Enums\EnumResponse;
use App\DiabeticPatient;
use App\Member;

class AuthController extends Controller
{

    function __construct(PermissionService $_PermissionService)
    {
        $this->service = $_PermissionService;
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            $data = [
                'message' => __('auth.failed') 
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
        $user = $request->user();
        if ((count($user->roles) <= 0) && empty($user->typeEmployee)) {
             $data = [
                'message' => __('auth.not_permissions') 
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
		     'title' => 'OK',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
            'permissions' => $this->service->index(),
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function loginDiabetic(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            $data = [
                'message' => __('auth.failed') 
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
        $user = User::where('email', $request["email"])->has('DiabeticPatient')->first();
        if (!empty($user)) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

                return response()->json([
                 'title' => 'OK',
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'member' => new MemberResource($user->diabeticPatient->member),
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        } else {
             $data = [
                'message' => __('auth.failed') 
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function forgot(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);
            $data = User::where('email', $request["email"])->first();
            if (empty($data)) {
                $data = [
                    'message' => __('auth.valid_user') 
                ];
                return bodyResponseRequest(EnumResponse::UNAUTHORIZED, $data);
            }
            $token = \Str::random(10);
            \DB::table('password_resets')->insert([
                'email' => $request["email"],
                'token' => $token,
            ]);
            $dataEmail =  ['token' => $token];
            Mail::send('auth.forgot',$dataEmail, function ($message) use($request) {
                $message->to($request["email"])->subject('Cambie su contraseña - KA-THANI');
            });
            /* $data = [
              'message' => __('password.sent'),
            ];*/
            return bodyResponseRequest( EnumResponse::ACCEPTED, $data);

        } catch (\Exception $e) {
            return $e;
        }
        
    }

    public function reset () {
        $request = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string',
            'password_confirm' => 'required|string|same:password'
        ]);

        $passwordReset = \DB::table("password_resets")->where("token",$request["token"])->first();
        if (empty($passwordReset)) {
             $data = [
                'message' => __('passwords.token') 
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
        $model = User::where("email", $request["email"])->first();
        if (empty($model)) {
            $data = [
              'message' => __('auth.valid_user'),
            ];
            return bodyResponseRequest( EnumResponse::UNAUTHORIZED, $data);
        }
        $model->password = \Hash::make($request["password"]);
        $model->save();
        return bodyResponseRequest(EnumResponse::ACCEPTED, $model);
    }
}
