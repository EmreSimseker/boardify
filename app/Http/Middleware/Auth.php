<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Auth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('gebruiker')) {
            return redirect('/');  
        }

        return $next($request);  
    }

}
