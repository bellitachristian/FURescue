<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PetOwner;
use App\Models\SubscriptionTransac;
use App\Models\Subscription;
use App\Notifications\ApproveProofPayment;
use Carbon\Carbon;

class CheckPetownerExpiry
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
        $currentdate = Carbon::now()->format('F d Y h:i A');
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $checktrans = SubscriptionTransac::where('petowner_id',$petowner->id)->where('status','approved')->count();
        if($checktrans > 0){ 
            $getexpiry = SubscriptionTransac::where('petowner_id',$petowner->id)->where('status','approved')->get();
            //dd($getexpiry);
            foreach($getexpiry as $expired){
                if($expired->expiry_date == $currentdate){
                    $subscription = Subscription::where('id',$expired->sub_id)->first();
                    if($subscription->sub_credit == "UNLI"){
                        $petowner->TotalCredits = "0";
                        $petowner->update();
                        $approvedproof = [
                            'shelter_name' => 'Your subscription '.$subscription->sub_name.' promo is expired',
                            'promo' => ' please choose any of the subsriptions available',
                        ];
                        PetOwner::find($petowner->id)->notify(new ApproveProofPayment($approvedproof));
                        $expired->status = "expired";
                        $expired->update();
                        return back()->with('status','Your subscription '.$subscription->sub_name.' promo has been expired');
                    }else{
                        $credits = (int)$subscription->sub_credit; 
                        $total = (int)$petowner->TotalCredits;
                        $new = $total - $credits;
                        $petowner->TotalCredits = $new;
                        $petowner->update();
                        $approvedproof = [
                            'shelter_name' => 'Your subscription '.$subscription->sub_name.' promo is expired',
                            'promo' => ' please choose any of the subsriptions available',
                        ];
                        PetOwner::find($petowner->id)->notify(new ApproveProofPayment($approvedproof));
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
