<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::check()){
            if(!Auth::user()->administrator){
                return response('Unauthorized.', 401);
            }
        }else{
            return redirect()->guest('/admin?next='.urlencode($request->url()));
        }

        return $next($request);
    }
}
