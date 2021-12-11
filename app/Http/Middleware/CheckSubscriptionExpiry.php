<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnimalShelter;
use App\Models\SubscriptionTransac;
use Carbon\Carbon;

class CheckSubscriptionExpiry
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
        $currentdate = Carbon::now()->format('F d, Y h:i:s A');
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $getexpiry = SubscriptionTransac::where('shelter_id',$shelter->id)->where('status','approved')->pluck('expiry_date')->toArray();
        dd($getexpiry);
        if($getexpiry == $currentdate){
            
        }else{
            return $next($request);
        }
    }
}
