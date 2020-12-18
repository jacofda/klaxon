<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{

    public function handle($request, Closure $next)
    {
        if(session()->has('locale'))
        {
            app()->setLocale(session('locale'));
        }
        else
        {
            app()->setLocale('it');
        }

        return $next($request);
    }

}
