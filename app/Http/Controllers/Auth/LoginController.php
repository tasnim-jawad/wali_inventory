<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->input('email') && !$request->input('password')) {
            return response()->json(
                [
                    'status' => 'validation_error',
                    'errors' => [
                        'email' => "This email field is required",
                        'password' => "This password field is required",
                    ]
                ],
                422
            );
        }

        if (!$request->input('email')) {
            return response()->json(
                [
                    'status' => 'validation_error',
                    'errors' => [
                        'email' => "This email field is required",
                    ]
                ],
                422
            );
        }

        if (!$request->input('password')) {
            return response()->json(
                [
                    'status' => 'validation_error',
                    'errors' => [
                        'password' => "This password field is required",
                    ]
                ],
                422
            );
        }

        $check_auth_user = User::where('email', $request->email)->first();

        if ($check_auth_user && Hash::check($request->password, $check_auth_user->password)) {
            auth()->login($check_auth_user);
            DB::table('oauth_access_tokens')->where("user_id", $check_auth_user->id)->update(['revoked' => 1]);
            $data['access_token'] = $check_auth_user->createToken('accessToken')->accessToken;
            $data['user'] = $check_auth_user;
            return response()->json($data, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry,user not found'], 404);
        }
    }

    public function check_user()
    {
        // dd("checker check in login controller",auth()->check());
        if (auth()->check()) {
            return response()->json(
                auth()->user()
            , 200);
        }

        return response()->json([""],403);
    }

    public function logout()
    {
        if (auth()->check()) {
            // DB::table('oauth_access_tokens')->where("user_id", auth()->user()->id)->update(['revoked' => 1]);
            $token = auth()->user()->token();
            $token->revoke();

            return response()->json([
                'status' => 'success',
                'result' => 'logout Successful'
            ], 200);

        }
        return response()->json(['status' => 'error', 'result' => 'User not authenticated'], 401);
    }
}
