<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role_id != 1) {

            $notification = array(
                'message' => 'You are not authorized !',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        return $next($request);
    }
}