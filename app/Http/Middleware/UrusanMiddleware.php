<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class UrusanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            if(null!==(session('main_urusan'))){
                return $next($request);

            }else{
                Auth::logout();
            }
            // user value cannot be found in session
        }
            return redirect('/');


    }
}
