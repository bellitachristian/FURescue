<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnimalShelter;



class CheckPostCredits
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
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        if($shelter->TotalCredits == "0" && $shelter->TotalCredits != "UNLI"){ 
            return back()->with('status','You have 0 post credit, subscribe to the following promos in order to get full control of the system.');
        }   
        return $next($request);
    }
}
