<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' =>[
                    'code'=>422,
                    'message'=>'Validation error',
                    'errors'=>$validator->errors()
                ]
            ])->setStatusCode(422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user and Hash::check($request['password'], $user->password)) {
            return [
                'data' => [
                    'user_token' => $user->generateToken()
                ]
            ];
        }

        return response()->json([
            'error' =>[
                'code'=>401,
                'message'=>'Authentication failed',
            ]
        ])->setStatusCode(401);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fio' =>'required',
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' =>[
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ])->setStatusCode(422);
        }

        $user = User::createUser($request);

        return response()->json([
            'data' => [
                'user_token' => $user->user_token,
            ]
        ])->setStatusCode(201);;
    }

    public function logout(Request $request)
    {
        $user_token = $request->bearerToken();
        User::where('user_token', $user_token)->update(['user_token' => NULL]);

        return response()->json([
            'data' => [
                'user_token' => 'logout',
            ]
        ]);
    }
}
