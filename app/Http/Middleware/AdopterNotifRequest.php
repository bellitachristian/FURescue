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
            $adopters = Adopter::where('reactivation_request','sentRequest')->get();
            $type = 'App\Notifications\AdopterReactivationRequest'; 
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0){
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
    }
}
