<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnimalShelter;
use App\Models\SubscriptionTransac;
use App\Models\Subscription;
use App\Notifications\ApproveProofPayment;
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
        $currentdate ='December 26 2021 02:17:12 AM';

        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $checktrans = SubscriptionTransac::where('shelter_id',$shelter->id)->where('status','approved')->count();
        if($checktrans > 0){ 
            $getexpiry = SubscriptionTransac::where('shelter_id',$shelter->id)->where('status','approved')->get();
            //dd($getexpiry);
            foreach($getexpiry as $expired){
                if($expired == $currentdate){
                    $subscription = Subscription::where('id',$expired->sub_id)->first();
                    if($subscription->sub_credit == "UNLI"){
                        $shelter->TotalCredits = "0";
                        $shelter->update();
                        $approvedproof = [
                            'shelter_name' => 'Your subscription '.$subscription->sub_name.' promo is expired',
                            'promo' => ' please choose any of the subsriptions available',
                        ];
                        AnimalShelter::find($shelter->id)->notify(new ApproveProofPayment($approvedproof));
                        $expired->status = "expired";
                        $expired->update();
                        return back()->with('status','Your subscription '.$subscription->sub_name.' promo has been expired');
                    }else{
                        $credits = (int)$subscription->sub_credit; 
                        $total = (int)$shelter->TotalCredits;
                        $new = $total - $credits;
                        $shelter->TotalCredits = $new;
                        $shelter->update();
                        $approvedproof = [
                            'shelter_name' => 'Your subscription '.$subscription->sub_name.' promo is expired',
                            'promo' => ' please choose any of the subsriptions available',
                        ];
                        AnimalShelter::find($shelter->id)->notify(new ApproveProofPayment($approvedproof));
                        $expired->status = "expired";
                        $expired->update();
                        return back()->with('status','Your subscription '.$subscription->sub_name.' promo has been expired');
                    }
                }
            }
            return $next($request);
        }
        else{
            return $next($request);
        }
    }
}
