<?php

namespace Modules\CrmAutoCar\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UtilisateurActifMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!\Auth::user()->enabled)
        {
            \Auth::logout();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
