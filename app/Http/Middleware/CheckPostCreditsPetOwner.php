<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PetOwner;

class CheckPostCreditsPetOwner
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
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();    
        if($petowner->TotalCredits == "0" && $petowner->TotalCredits != "UNLI"){ 
            return back()->with('status','You have 0 post credit, subscribe to the following promos in order to get full control of the system.');
        }   
        return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
