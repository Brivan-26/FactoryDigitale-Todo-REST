<?php

namespace App\Http\Middleware;

use App\Models\Todo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todo = Todo::find($request->route('id'));
        if($todo->user_id != $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not the owner of this todo'
            ]);
        }

        return $next($request);
    }
}
