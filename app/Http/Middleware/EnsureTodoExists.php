<?php

namespace App\Http\Middleware;

use App\Models\Todo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTodoExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todo = Todo::find($request->route('id'));

        if(!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'No todo was found!'
            ]);
        }
        return $next($request);
    }
}
