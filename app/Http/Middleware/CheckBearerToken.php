<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBearerToken
{
/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request  $request
* @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
* @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
*/
public function handle(Request $request, Closure $next)
{
        $bearerToken = $request->header('Authorization');

       if (!$bearerToken || !str_starts_with($bearerToken, 'Bearer ')) {
           return response()->json(['message' => 'Unauthorized'], 401);
       }

       return $next($request);
   }
}
