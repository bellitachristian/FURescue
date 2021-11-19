<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetOwnerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('LoggedUserPet')&&($request->path()!='User/login' && $request->path()!='Register/signup' && $request->path()!='Register/petOwner')){
            return redirect('User/login')->with('status1', 'You must be logged in');
        }
        if(session()->has('LoggedUserPet')&&($request->path()=='User/login'||$request->path()=='Register/signup'|| $request->path()=='Register/petOwner')){ 
            return back();
        }
 
        return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');    
    }
}
