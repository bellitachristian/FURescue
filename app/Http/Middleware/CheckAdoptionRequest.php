<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adoption;
use App\Models\AnimalShelter;
use App\Notifications\AdoptionNotif;
use DB;

class CheckAdoptionRequest
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
        $adopt = Adoption::first();
        if(is_null($adopt)){

        }
        else{
            $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
            $adopter = Adoption::where('status','pending')->where('owner_type',2)->where('owner_id',$shelter->id)->count();
            $type = 'App\Notifications\AdoptionNotif';  
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0 && $adopter > 0){
                $adopters = Adoption::where('status','pending')->where('owner_type',2)->where('owner_id',$shelter->id)->get();
                foreach($adopters as $adopter){
                    $notif = array();
                    $notif = [
                        'request' => $adopter->adopter->fname.' has sent an application for adoption',
                        'check' =>' please check it now'
                    ];
                   AnimalShelter::find($shelter->id)->notify( new AdoptionNotif($notif));
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
