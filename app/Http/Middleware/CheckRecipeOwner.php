<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRecipeOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $recipe = Recipe::find($request->route('recipe'));

        if (!$recipe || $recipe->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
