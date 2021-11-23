<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Notifications\DonationNotif;
use App\Models\Donation;
use App\Models\AnimalShelter;
use DB;

class DonationCheckNotif
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
        $checkdonor = Donation::first();
        if(empty($checkdonor)){

        }
        else{
            $donors = Donation::where('status','pending')->get();
            $type = 'App\Notifications\DonationNotif'; 
            $checknotif = DB::table('notifications')->where('type',$type)->count();
            if($checknotif == 0){
                foreach($donors as $donor){
                    $notif = array();
                    $notif = [
                        'donation' => $donor->donor_fname.' '.$donor->donor_lname.' sent a donation',
                        'check' =>' please check it now'
                    ];
                    $check = AnimalShelter::where('id',$donor->animal_shelter)->count();
                    if($check>0){
                        AnimalShelter::find($donor->animal_shelter)->notify( new DonationNotif($notif));
                    }
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
