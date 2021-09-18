<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = User::where('user_token', $request->bearerToken())->first();

        $user->clearToken();

        return response()->json([
            'success' => [
                'code' => 200,
            ]
        ])->setStatusCode(200);
    }
}
