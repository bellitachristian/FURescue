<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adoption;
use App\Models\PetOwner;
use App\Notifications\AdoptionNotifPetOwner;
use DB;


class CheckAdoptionPetOwnerRequest
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
            $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
            $adopter = Adoption::where('status','pending')->where('owner_type',3)->where('owner_id',$petowner->id)->count();
            $type = 'App\Notifications\AdoptionNotifPetOwner';  
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0 && $adopter > 0){
                $adopters = Adoption::where('status','pending')->where('owner_type',3)->where('owner_id',$petowner->id)->get();
                foreach($adopters as $adopter){
                    $notif = array();
                    $notif = [
                        'request' => $adopter->adopter->fname.' has sent an application for adoption',
                        'check' =>' please check it now'
                    ];
                   PetOwner::find($petowner->id)->notify( new AdoptionNotifPetOwner($notif));
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
