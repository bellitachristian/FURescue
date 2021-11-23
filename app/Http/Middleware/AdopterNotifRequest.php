<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Adopter;
use App\Models\Admin;
use App\Notifications\AdopterReactivationRequest;
use DB;

class AdopterNotifRequest
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
        $adopt = Adopter::first();
        if(is_null($adopt)){

        }
        else{
            $type = 'App\Notifications\AdopterReactivationRequest'; 
            $adopter = Adopter::where('reactivation_request','sentRequest')->count();
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0 && $adopter > 0){
                $adopters = Adopter::where('reactivation_request','sentRequest')->get();
                foreach($adopters as $adopter){
                    $notif = array();
                    $notif = [
                        'request' => $adopter->fname.' is requesting for reactivation of account',
                        'check' =>' check it now'
                    ];
                   Admin::find(1)->notify( new AdopterReactivationRequest($notif));
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
