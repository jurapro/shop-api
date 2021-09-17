<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
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

        $user = User::where('email', $request->email)
            ->where('password', $request->password)->first();

        if ($user) {
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

    public function logout(Request $request)
    {
        $user = User::where('user_token', $request->bearerToken())->first();

        if(!$user)
        {
            return response()->json([
                'error' =>
                [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ]
            ])->setStatusCode(401);
        }

        $user->user_token = null;
        $user->save();

        return response()->json([
            'data' => [
                'message' => 'logout',
            ],
        ])->setStatusCode(200);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'email' => 'unique:users',
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

        $user = new User($request->all());
        $user->setRole('user');
        $user->save();

        return [
            'data' => [
                'user_token' => $user->generateToken()
            ]
        ];
    }
}
