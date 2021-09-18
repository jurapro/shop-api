<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    function __construct()
    {
        $this->model = new User();
    }

    public function signup(Request $request)
    {
        $validated_fields = Validator::make($request->all(), [
            'email' => 'required|min:1|max:120|unique:users',
            'password' => 'required|min:1|max:150'
        ]);

        if ($validated_fields->fails()) {
            return response()->json([
                'data' => [
                    'code' => 422,
                    'message' => 'unprocessable entity',
                    'errors' => $validated_fields->errors()
                ]
            ])->setStatusCode(422);
        } else {
            $user = $this->model->createUser($request->all());

            return response()->json([
                'data' => [
                    'code' => 201,
                    'user_token' => $user->generateToken()
                ]
            ])->setStatusCode(201);
        }
    }
}
