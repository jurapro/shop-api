<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class APIForGuest
{
    public function handle($request, Closure $next)
    {
        $user_token = $request->bearerToken();

        if ($user_token)
        {
            $user = User::where('user_token', $user_token)->first();

            if ($user)
            {
                return response()->json([
                    'error' =>[
                        'code'=>403,
                        'message'=>'Login failed',
                    ]
                ])->setStatusCode(403);
            }
        }

        return $next($request);
    }
}
