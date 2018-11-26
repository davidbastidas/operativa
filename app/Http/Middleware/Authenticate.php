<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Session;
use Closure;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */

    public function handle($request, Closure $next, ...$guards)
    {
        if (Session::has('isLogged')) {
            redirect()->route('admin.dashboard', ['id' => Session::get('adminId')]);
        }else{
            redirect('/');
        }

        return $next($request);
    }

}
