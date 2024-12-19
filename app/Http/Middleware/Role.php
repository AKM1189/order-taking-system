<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $role): Response
    {
        $user = Auth::user();
    if($user && $user->role->rolename == $role){
      return $next($request);
    }
    else if($user && $user->role->rolename == 'Manager'){
      return $next($request);
    }

    return redirect('/login');
    }
}
