<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidationQuestionRequest;
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
}
