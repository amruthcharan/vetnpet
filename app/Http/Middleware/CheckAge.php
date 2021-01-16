<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CheckAge
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
        if(env('VALUE') <> ""){
            $d = Carbon::parse(env("VALUE"));
            if($d < Carbon::now()){
                return redirect('/expired');
            }
        }
        return $next($request);
    }
}
