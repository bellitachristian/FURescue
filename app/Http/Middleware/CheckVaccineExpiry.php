<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VaccineHistory;
use App\Models\DewormHistory;
use App\Models\AnimalShelter;
use App\Models\AllocateVaccine;
use App\Models\AllocateDeworming;
use App\Models\Animals;
use App\Notifications\ApproveProofPayment;
use Carbon\Carbon;


class CheckVaccineExpiry
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
        //$now ='2022-03-12';
        $checkanimal = Animals::where(function($query) use($shelter){
                                $query-> where('shelter_id', $shelter->id)
                                        ->orWhere('owner_id',$shelter->id);
                            })
                            ->count();
        if($checkanimal > 0){
            $checkvaccine = AllocateVaccine::whereHas('animals')->where('status','Active')->count();
            if($checkvaccine > 0){
                $vaccine = AllocateVaccine::whereHas('animals')->where('status','Active')->get();
                foreach($vaccine as $active){
                    if($active->vac_expiry_date == $now){
                        $approvedproof = [
                            'shelter_name' => $active->vaccine->vac_name.' of '.$active->animals->name.' is now expired ',
                            'promo' => ' You can check it in your pet book',
                        ];
                        AnimalShelter::find($shelter->id)->notify(new ApproveProofPayment($approvedproof));
                        $active->status ="Inactive";
                        $active->update();
                        $vachistory = VaccineHistory::where('animal_id',$active->animals->id)->first();
                        $vachistory->stats = 'Inactive';
                        $vachistory->update();
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
