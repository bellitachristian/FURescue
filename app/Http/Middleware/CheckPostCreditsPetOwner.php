<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PetOwner;
use App\Models\SubscriptionTransac;
use App\Models\Subscription;

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
        $credits=array();
        $transac = SubscriptionTransac::where('status','approved')->where('petowner_id',$petowner->id)->pluck('sub_id')->toArray();
        $posted = Subscription::all();
        
        //fetching the availed post credits
        foreach($posted as $subs){
            foreach($transac as $availed){
                if($subs->id == $availed){
                    $credits[]=$subs->sub_credit;
                }
            }
        }
        //explode array credits where credits being stored
        if(in_array("UNLI", $credits)){
            $totalcredits = "UNLI";  
        }
        else{
            foreach($credits as $totcredits){
                $int[] = (int)$totcredits;
                }
            if(empty($int)){
                $totalcredits = 0;
                //dd('hi');   
            }
            else{
                $credit = array_sum($int);
                $totalcredits = $credit;
                //dd('hi');
            }
        }        
        if($totalcredits == 0 && $totalcredits != "UNLI"){ 
            return back()->with('status','You have 0 post credit, subscribe to the following promos in order to get full control of the system.');
        }   
       
        return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
