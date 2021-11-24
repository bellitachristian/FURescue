<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdoptionPayment;
use App\Models\Admin;
use App\Notifications\AdoptionPaymentNotif;
use DB;

class AdoptionPaymentReq
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
        $adopt = AdoptionPayment::first();
        if(is_null($adopt)){

        }
        else{
            $type = 'App\Notifications\AdoptionPaymentNotif'; 
            $adoption = AdoptionPayment::where('status','pending')->count();
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0 && $adoption > 0){
                $adoptions = AdoptionPayment::where('status','pending')->get();
                foreach($adoptions as $adopt){
                    $notif = array();
                    $notif = [
                        'request' => $adopt->fname.' '.$adopt->lname.' sent an adoption payment to'. $adopt->owner_id,
                        'check' =>' check it now'
                    ];
                   Admin::find(1)->notify( new AdoptionPaymentNotif($notif));
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
