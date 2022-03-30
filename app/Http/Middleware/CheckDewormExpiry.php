<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DewormHistory;
use App\Models\AnimalShelter;
use App\Models\AllocateDeworming;
use App\Models\Animals;
use App\Notifications\ApproveProofPayment;
use Carbon\Carbon;

class CheckDewormExpiry
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
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $now = Carbon::now()->format('Y-m-d');
        //$now ='2022-04-14';

        $checkanimal = Animals::where(function($query) use($shelter){
                                $query-> where('shelter_id', $shelter->id)
                                        ->orWhere('owner_id',$shelter->id);
                            })
                            ->count();
        if($checkanimal > 0){
            $checkdeworm = AllocateDeworming::whereHas('animals')->where('status','Active')->count();
            if($checkdeworm > 0){
                $deworm = AllocateDeworming::whereHas('animals')->where('status','Active')->get();
                foreach($deworm as $active){
                    if($active->dew_expiry_date == $now){
                        $approvedproof = [
                            'shelter_name' => $active->deworm->dew_name.' of '.$active->animals->name.' is now expired ',
                            'promo' => ' You can check it in your pet book',
                        ];
                        AnimalShelter::find($shelter->id)->notify(new ApproveProofPayment($approvedproof));
                        $active->status ="Inactive";
                        $active->update();
                        $dewhistory = DewormHistory::where('animal_id',$active->animals->id)->first();
                        $dewhistory->stats = 'Inactive';
                        $dewhistory->update();
                    }
                }
                return $next($request);
            }
            else{
                return $next($request);
            }
        } 
        return $next($request);  
    }
}
