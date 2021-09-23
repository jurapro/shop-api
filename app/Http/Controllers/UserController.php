<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where($request->all())->first();
        if (!$user) {
            throw new ApiException(401, 'Authentication failed');
        }
        Auth::login($user);
        return [
            'data' => [
                'user_token' => Auth::user()->generateToken()
            ]
        ];
    }

    public function logout(Request $request)
    {
        Auth()->user()->clearToken();

        return [
            'data' => [
                'message' => 'logout',
            ],
        ];
    }

    public function signup(SignupRequest $request)
    {
        $user = User::make($request->all());
        $user->setRole('user');
        $user->save();
        return [
            'data' => [
                'user_token' => $user->generateToken()
            ]
        ];
    }
}
