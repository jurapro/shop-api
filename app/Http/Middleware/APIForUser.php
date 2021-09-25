<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class APIForUser
{
    public function handle($request, Closure $next)
    {
        $user_token = $request->bearerToken();
        $user = User::where('user_token', $user_token)->first();

        if ($user)
        {
            return $next($request);
        }

        return response()->json([
            'error' =>[
                'code'=>403,
                'message'=>'Forbidden for you',
            ]
        ])->setStatusCode(403);
    }
}
