<?php

namespace Modules\CrmAutoCar\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtectedRouteMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        if(Auth::user()) {
            if ( !Auth::user()->hasRole(['super-admin', 'manager'])) {
                return redirect()->route('statistiques');
            }
        }else{
            return redirect()->route('login');
        }

        return $next($request);
    }
}
