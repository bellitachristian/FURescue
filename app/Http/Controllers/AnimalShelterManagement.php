<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalShelter;
use App\Models\Animals;
use App\Models\Deworm;
use App\Models\PetOwner;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Vaccine;
use App\Models\Receipt;
use App\Models\ValidDocuments;
use App\Models\Adoption;
use App\Models\AdoptionPolicy;
use App\Models\AllocateVaccine;
use App\Models\AdoptionFee;
use App\Models\AdoptionSlip;
use App\Models\AdoptionPayment;
use App\Models\Adopter_Notif;
use App\Models\Admin;
use App\Models\Type;
use App\Models\Requestadoption;
use App\Models\Feedback;
use App\Models\Post;
use App\Models\Breed;
use App\Models\PetBook;
use App\Models\VaccineHistory;
use App\Models\DewormHistory;
use App\Models\AnimalMasterList;
use App\Models\AllocateDeworming;
use App\Models\UploadedPhotos;
use App\Models\Usertype;
use App\Models\Subscription;
use App\Models\SubscriptionTransac;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Mail\ApproveReactivation;
use App\Notifications\ApproveReactivationNotif;
use App\Notifications\ConfirmReactivationNotif;
use App\Notifications\RejectRequestNotif;
use App\Notifications\ApproveRequest;
use App\Notifications\SuccessAdoption;
use App\Notifications\ApproveRejectShelterNotif;
use App\Notifications\Checkproofsubscriptionpayment;
use App\Notifications\ApproveProofPayment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class AnimalShelterManagement extends Controller
{
    function vaccine_dewormView(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
          'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
          'vac'=> DB::select("select *from vaccine where shelter_id='$shelter->id'"),
          'deworm'=> DB::select("select *from deworm where shelter_id='$shelter->id'"),
          'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.Vaccine & Deworm.Vaccine',$data);
    }
    function ViewVaccineHistory(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> DB::select("select *from animals  where shelter_id ='$shelter->id'"),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'apply'=> DB::table('allocatevaccine')
                   -> join('animals','allocatevaccine.animal_id',"=",'animals.id')
                   -> join('vaccine','allocatevaccine.vac_id',"=",'vaccine.id')
                   -> where('animals.shelter_id', $shelter->id)
                   -> get()
          );
           return view('AnimalShelter.Vaccine & Deworm.VaccineHistory',$data);
    }

    function ViewDewormHistory(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> DB::select("select *from animals  where shelter_id ='$shelter->id'"),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'apply'=> DB::table('allocatedeworm')
                   -> join('animals','allocatedeworm.animal_id',"=",'animals.id')
                   -> join('deworm','allocatedeworm.dew_id',"=",'deworm.id')
                   -> where('animals.shelter_id', $shelter->id)
                   -> get()
          );
           return view('AnimalShelter.Vaccine & Deworm.DewormHistory',$data);
    }

    function animal_view(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> DB::select("select *from animals  where shelter_id ='$shelter->id' and status ='Available'"),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
            'count'=>Animals::where('owner_id',$shelter->id)->count(),
          );
          return view('AnimalShelter.AnimalManagement.Animal',$data);
    }

    function AddVaccine(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $vaccine = new Vaccine;
        $vaccine->vac_name = $req->vac_name;
        $vaccine->vac_desc = $req->desc;
        $vaccine->shelter_id = $shelter->id;
        $vaccine->save();
        return redirect()->back()->with('status','Vaccine Added Successfully');
    }

    function EditVaccine(Request $req, $id){
       $vaccine = $req->vac_name;
       $description = $req->desc;
       DB::update("update vaccine set vac_name = '$vaccine', vac_desc ='$description' where id ='$id'");
       return redirect()->back()->with('status','Vaccine Updated Successfully');
    }

    function DeleteVaccine($id){
        DB::delete("delete from vaccine where id='$id'");
        return redirect()->back()->with('status','Vaccine Deleted Successfully');
    }
    function Allocate_Deworm_Animal($id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $dewormhistory = Animals::whereHas('allocatedeworm', function($q) use ($id) {
            $q->where('animal_id','=',$id);
        })->pluck('id')->toArray();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'deworm'=> Deworm::find($id),
            'animal'=> DB::select("select *from animals  where shelter_id ='$shelter->id'"),
            'shelter'=> AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'notallocated' => Animals::whereNotIn('id', $allocateddeworm)->where('shelter_id',$shelter->id)->get()->toArray()
        );
        return view('AnimalShelter.Vaccine & Deworm.Allocate_Pet',$data);
    }
    function Allocate_Vaccine_Animal($id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $vaccinehistory = Vaccine::whereHas('allocatevaccine', function($q) use ($id) {
            $q->where('animal_id','=',$id);
        })->pluck('id')->toArray();
        $dewormhistory = Deworm::whereHas('allocatedeworm', function($q) use ($id) {
            $q->where('animal_id','=',$id);
        })->pluck('id')->toArray();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> Animals::find($id),
            'shelter'=> AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'notallocated' => Vaccine::whereNotIn('id', $vaccinehistory)->where('shelter_id',$shelter->id)->get()->toArray(),
            'notallocated1' => Deworm::whereNotIn('id', $dewormhistory)->where('shelter_id',$shelter->id)->get()->toArray(),
        );
        return view('AnimalShelter.Vaccine & Deworm.Allocate_Pet',$data);
    }

    function Allocation_Deworm(Request $req, $id, $dew_id){
        $deworm = Deworm::where('id',$dew_id)->first();
        $allocate = new AllocateDeworming;
        $allocate->dew_id = $dew_id;
        $allocate->animal_id = $id;
        $allocate->dew_date = $req->dew_date;
        $allocate->dew_expiry_date = $req->dew_expiry;
        $allocate->save();

        $history = new DewormHistory;
        $history->dew_name = $deworm->dew_name;
        $history->dew_desc = $deworm->dew_desc;
        $history->dew_date = $req->dew_date;
        $history->dew_expiry = $req->dew_expiry;
        $history->animal_id = $id;
        $history->stats = "Active";
        $history->save();

        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $animal = Animals::where('shelter_id',$shelter->id)->orWhere('owner_id',$shelter->id)->first();
        $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->count();
        if($getIdMaster > 0){
            $masterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->first();
            $getId = PetBook::where('animal_id',$masterlist->id)->where('shelter_id',$shelter->id)->first();
            $checkdew = DewormHistory::where('animal_id',$id)->count();
            if($checkdew > 0){
                $dewhistory = DewormHistory::where('animal_id',$id)->first();
                $dewhistory->petbook_id = $getId->id;
                $dewhistory->update();
            }
        }

        return redirect('AllocateVaccine/'.$id)->with('status','Deworm Allocated Successfully');
    }

    function Allocation_Vaccine(Request $req, $id, $vac_id){
        $vaccine = Vaccine::where('id',$vac_id)->first();
        $allocate = new AllocateVaccine;
        $allocate->vac_id = $vac_id;
        $allocate->animal_id = $id;
        $allocate->vac_date = $req->vac_date;
        $allocate->vac_expiry_date = $req->vac_expiry;
        $allocate->save();

        $history = new VaccineHistory;
        $history->vac_name = $vaccine->vac_name;
        $history->vac_desc = $vaccine->vac_desc;
        $history->vac_date = $req->vac_date;
        $history->vac_expiry = $req->vac_expiry;
        $history->animal_id = $id;
        $history->stats = "Active";
        $history->save();

        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $animal = Animals::where('shelter_id',$shelter->id)->orWhere('owner_id',$shelter->id)->first();
        $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->count();
        if($getIdMaster > 0){
            $masterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->first();
            $getId = PetBook::where('animal_id',$masterlist->id)->where('shelter_id',$shelter->id)->first();
            $checkvac = VaccineHistory::where('animal_id',$id)->count();
            if($checkvac > 0){
                $vachistory = VaccineHistory::where('animal_id',$id)->first();
                $vachistory->petbook_id = $getId->id;
                $vachistory->update();
            }
        }

        return redirect('AllocateVaccine/'.$id)->with('status','Vaccine Allocated Successfully');
    }

    function EditDeworm(Request $req, $id){
        $deworm = $req->dew_name;
        $description = $req->desc;
        DB::update("update deworm set dew_name = '$deworm', dew_desc ='$description' where id ='$id'");
        return redirect()->back()->with('status','Deworm Updated Successfully');
     }

     function DeleteDeworm($id){
         DB::delete("delete from deworm where id='$id'");
         return redirect()->back()->with('status','Deworm Deleted Successfully');
     }

    function AddDeworm(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $deworm = new Deworm;
        $deworm->dew_name = $req->dew_name;
        $deworm->dew_desc = $req->desc;
        $deworm->shelter_id = $shelter->id;
        $deworm->save();
        return redirect()->back()->with('status','Deworming Added Successfully');
    }

    function ViewAllocationVaccine($id,$vac_id){

        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> Animals::find($id),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'vaccine'=>Vaccine::find($vac_id)
        );
        return view('AnimalShelter.Vaccine & Deworm.Allocation',$data);
    }

    function ViewAllocationDeworm($id, $dew_id){
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> Animals::find($id),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'deworm'=>Deworm::find($dew_id)
        );
        return view('AnimalShelter.Vaccine & Deworm.AllocationDeworming',$data);
    }
    function allocate_view(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
          'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
          'animal'=> DB::select("select *from animals where (shelter_id='$shelter->id' or owner_id ='$shelter->id') and (status ='Available')"),
          'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.Vaccine & Deworm.Allocate',$data);
    }

    function Animalshelter_dashboard(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();

        $id = $shelter->id;
        $subscription = Subscription::whereHas('subscription_transaction', function($q) use ($id) {
            $q->where('shelter_id','=',$id);
            $q->where('status','=','approved');
        })->pluck('id')->toArray();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'subscription'=>Subscription::all(),
            'notsub'=> $subscription,
            'notapprove'=> Subscription::whereNotIn('id', $subscription)->pluck('id')->toArray(),
            'countcredits'=>$shelter->TotalCredits,
            'countpets'=>Animals::
                                where('status','Available')
                                ->where('post_status','posted')
                                -> where(function($query) use($shelter){
                                    $query-> where('shelter_id', $shelter->id)
                                            ->orWhere('owner_id',$shelter->id);
                                })
                                ->count(),
            'countrequest'=>Adoption::where('owner_id',$shelter->id)->where('owner_type',2)->where('status','pending')->count(),
            'totalrevenue'
        );
        return view('AnimalShelter.ShelterDashboard',$data);
    }
    function Animalshelter_tempdashboard(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $sheltercheck= AnimalShelter::
        whereHas('shelterPhoto',function($query)use($shelter){
          $query->where('shelter_id',$shelter->id);
        })
        ->where('is_verified_shelter','0')
        ->where('grace','!=','0')
        ->count();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'check'=>$sheltercheck
        );
        return view('AnimalShelter.TemporaryDash',$data);
    }

    function secondaryIntro (Request $req){
        $shelter = AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $exists = Category::first();
        try {
            if($req->dogs == "Dog"){
                $dogs = Category::where('category_name','=',$req->dogs)->where('shelter_id','=',$shelter->id)->count();
                if(is_null($exists)){
                    $category = new Category;
                    $category->category_name = $req->dogs;
                    $category->shelter_id = $shelter->id;
                    $category->save();
                }
                else{
                    if($dogs == 0){
                        $category = new Category;
                        $category->category_name = $req->dogs;
                        $category->shelter_id = $shelter->id;
                        $category->save();
                    }
                }
                $data =array(
                    'dog' => $req->dogs,
                    'cat' => "",
                    'both' =>"",
                    'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                    'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
                );
                return view('AnimalShelter.SettingUp.SecondIntro',$data);
            }
            elseif($req->cats == "Cat"){
                $cats = Category::where('category_name','=',$req->cats)->where('shelter_id','=',$shelter->id)->count();
                if(is_null($exists)){
                    $category = new Category;
                    $category->category_name = $req->cats;
                    $category->shelter_id = $shelter->id;
                    $category->save();
                }
                else{
                    if($cats == 0){
                        $category = new Category;
                        $category->category_name = $req->cats;
                        $category->shelter_id = $shelter->id;
                        $category->save();
                    }
                }
                $data =array(
                    'dog' => "",
                    'cat' => $req->cats,
                    'both' =>"",
                    'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                    'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
                );
                return view('AnimalShelter.SettingUp.SecondIntro',$data);
            }
            else{
                $dog = Category::where('category_name','=','Dog')->where('shelter_id','=',$shelter->id)->count();
                $cat = Category::where('category_name','=','Cat')->where('shelter_id','=',$shelter->id)->count();
                if(is_null($exists)){
                    $category = new Category;
                    $category->category_name = 'Dog';
                    $category->shelter_id = $shelter->id;
                    $category->save();

                    $category = new Category;
                    $category->category_name = 'Cat';
                    $category->shelter_id = $shelter->id;
                    $category->save();
                }
                else{
                    if($dog == 0 && $cat == 0){
                        $category = new Category;
                        $category->category_name = 'Dog';
                        $category->shelter_id = $shelter->id;
                        $category->save();

                        $category = new Category;
                        $category->category_name = 'Cat';
                        $category->shelter_id = $shelter->id;
                        $category->save();
                    }
                }
                $data =array(
                    'dog' => "",
                    'cat' => "",
                    'both' =>$req->boths,
                    'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                    'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
                );
                return view('AnimalShelter.SettingUp.SecondIntro',$data);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('status1','Something went wrong pls try again!');
        }
    }

    function CatLifeStage(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $type = Type::where('categ_id',$categ_id->id)->count();

        if($type == 0){
            foreach($req->cat as $catss){
                if($catss == "Kitten"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->kit.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($catss == "Junior"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->jun.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($catss == "Prime"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->prim.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($catss == "Mature"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->mat.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($catss == "Senior"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->sen.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
            }
        }
        else{

        }
        $data = array(
            'dog' => "",
            'cat' => "Cat",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function addcatbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed = Breed::where('breed_name','=', $req->breed_name)->where('categ_id','=',$categ_id->id)->count();
        if($breed == 0){
            $catbreed = new Breed;
            $catbreed->breed_name = $req->breed_name;
            $catbreed->categ_id = $categ_id->id;
            $catbreed->save();
        }
        $data = array(
            'dog' => "",
            'cat' => "Cat",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }
    function deletecatbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "",
            'cat' => "Cat",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function savecatbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed1 = Breed::where('categ_id',$categ_cat->id)->count();

        if($breed1 > 0 || $breed1 <= 0){
            foreach($req->cat as $cats){
                if($cats == "Cross-breed"){
                    $exist = Breed::where('breed_name',$cats)->where('categ_id',$categ_cat->id)->count();
                    if($exist == 0){
                        if($req->catbreed ==""){
                            $breed = new Breed;
                            $breed->breed_name = $cats;
                            $breed->categ_id = $categ_cat->id;
                            $breed->save();
                        }
                        else{
                            $breed = new Breed;
                            $breed->breed_name = $cats.''.'('.$req->catbreed.')';
                            $breed->categ_id = $categ_cat->id;
                            $breed->save();
                        }
                    }
                }
                else{
                    $exist = Breed::where('breed_name',$cats)->where('categ_id',$categ_cat->id)->count();
                    if($exist == 0){
                        $breed = new Breed;
                        $breed->breed_name = $cats;
                        $breed->categ_id = $categ_cat->id;
                        $breed->save();
                    }
                }
            }
        }
        $categ = Category::where('shelter_id',$shelter->id)->count();
        $type2 = Type::where('categ_id',$categ_cat->id)->count();
        $petbreed1 = Breed::where('categ_id',$categ_cat->id)->count();

        if($categ > 0){
            if($type2 > 0){
                if($petbreed1 > 0){
                    $shelter->is_welcome_shelter = "1";
                    $shelter->update();
                }
            }
        }
        $data =array(
            'dog' => "",
            'cat' => "Cat",
            'both' =>"",
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.FourthIntro',$data);
    }
    function CatFee(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $catfee = AdoptionFee::where('categ_id',$categ_cat->id)->count();

        if($catfee == 0){
            foreach($req->fee as $fees){
                if($fees == "Free"){
                    $catfees = new AdoptionFee;
                    $catfees->type = "Free";
                    $catfees->cat_fee = "FREE";
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
                elseif($fees == "Default"){
                    $catfees = new AdoptionFee;
                    $catfees->type = "Default";
                    $catfees->cat_fee = $req->catfee;
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
                elseif($fees == "Custom"){
                    $catfees = new AdoptionFee;
                    $catfees->type = "Custom";
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
            }

        }
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
        );
        return view('AnimalShelter.welcomepage',$data);

    }


    function DogLifeStage(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $type = Type::where('categ_id',$categ_id->id)->count();

        if($type == 0){
            foreach($req->dog as $dogss){
                if($dogss == "Puppy"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->pup.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($dogss == "Adolescent"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->adol.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($dogss == "Adult"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->adul.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
                elseif($dogss == "Senior"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->sen.')';
                    $type->categ_id = $categ_id->id;
                    $type->save();
                }
            }
        }
        else{

        }
        $data = array(
            'dog' => "Dog",
            'cat' => "",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function adddogbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $breed = Breed::where('breed_name','=', $req->breed_name)->where('categ_id','=',$categ_id->id)->count();
        if($breed == 0){
            $dogbreed = new Breed;
            $dogbreed->breed_name = $req->breed_name;
            $dogbreed->categ_id = $categ_id->id;
            $dogbreed->save();
        }
        $data = array(
            'dog' => "Dog",
            'cat' => "",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function deletedogbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "Dog",
            'cat' => "",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);

    }

    function savedogbreed(Request $req){

        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $breed = Breed::where('categ_id',$categ_dog->id)->count();
        if($breed > 0 || $breed <= 0){
            foreach($req->dog as $dogs){
                if($dogs == "Cross-breed")
                {
                    $exist = Breed::where('breed_name',$dogs)->where('categ_id',$categ_dog->id)->count();
                    if($exist == 0){
                        if($req->dogbreed ==""){
                            $breed = new Breed;
                            $breed->breed_name = $dogs;
                            $breed->categ_id = $categ_dog->id;
                            $breed->save();
                        }
                        else{
                            $breed = new Breed;
                            $breed->breed_name = $dogs.''.'('.$req->dogbreed.')';
                            $breed->categ_id = $categ_dog->id;
                            $breed->save();
                        }
                    }
                }
                else{
                    $exist = Breed::where('breed_name',$dogs)->where('categ_id',$categ_dog->id)->count();
                    if($exist == 0){
                        $breed = new Breed;
                        $breed->breed_name = $dogs;
                        $breed->categ_id = $categ_dog->id;
                        $breed->save();
                    }
                }
            }
        }

        $categ = Category::where('shelter_id',$shelter->id)->count();
        $type1 = Type::where('categ_id',$categ_dog->id)->count();
        $petbreed = Breed::where('categ_id',$categ_dog->id)->count();

        if($categ > 0){
            if($type1 > 0){
                if($petbreed > 0){
                    $shelter->is_welcome_shelter = "1";
                    $shelter->update();
                }
            }
        }
        $data =array(
            'dog' => "Dog",
            'cat' => "",
            'both' =>"",
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.FourthIntro',$data);

    }

    function DogFee(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $dogfee = AdoptionFee::where('categ_id',$categ_dog->id)->count();

        if($dogfee == 0){
            foreach($req->fee as $fees){
                if($fees == "Free"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Free";
                    $dogfees->dog_fee = "FREE";
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();
                }
                elseif($fees == "Default"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Default";
                    $dogfees->dog_fee = $req->dogfee;
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();
                }
                elseif($fees == "Custom"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Custom";
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();
                }
            }

        }
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
        );
        return view('AnimalShelter.welcomepage',$data);

    }

    function addbothbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        if($req->breed_dogname){
            $breed1 = Breed::where('breed_name','=', $req->breed_dogname)->where('categ_id','=',$categ_dog->id)->count();
            if($breed1 == 0){
                $dogbreed = new Breed;
                $dogbreed->breed_name = $req->breed_dogname;
                $dogbreed->categ_id = $categ_dog->id;
                $dogbreed->save();
            }
        }
        elseif($req->breed_catname){
            $breed2 = Breed::where('breed_name','=', $req->breed_catname)->where('categ_id','=',$categ_cat->id)->count();
            if($breed2 == 0){
                $catbreed = new Breed;
                $catbreed->breed_name = $req->breed_catname;
                $catbreed->categ_id = $categ_cat->id;
                $catbreed->save();
            }

        }
        $data = array(
            'dog' => "",
            'cat' => "",
            'both' =>"Both",
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_dog->id'"),
            'breed2'=> DB::select("select *from breed  where categ_id ='$categ_cat->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function deletebothbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "",
            'cat' => "",
            'both' =>"Both",
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_dog->id'"),
            'breed2'=> DB::select("select *from breed  where categ_id ='$categ_cat->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);

    }


    function BothLifeStage(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $type = Type::where('categ_id',$categ_dog->id)->count();
        $type1 = Type::where('categ_id',$categ_cat->id)->count();
        if($type == 0 && $type1 == 0){
            foreach($req->dog as $dogss){
                if($dogss == "Puppy"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->pup.')';
                    $type->categ_id = $categ_dog->id;
                    $type->save();
                }
                elseif($dogss == "Adolescent"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->adol.')';
                    $type->categ_id = $categ_dog->id;
                    $type->save();
                }
                elseif($dogss == "Adult"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->adul.')';
                    $type->categ_id = $categ_dog->id;
                    $type->save();
                }
                elseif($dogss == "Senior"){
                    $type = new Type;
                    $type->type_name = $dogss.''.'('.$req->sendog.')';
                    $type->categ_id = $categ_dog->id;
                    $type->save();
                }

            }
            foreach($req->cat as $catss){

                if($catss == "Kitten"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->kit.')';
                    $type->categ_id = $categ_cat->id;
                    $type->save();
                }
                elseif($catss == "Junior"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->jun.')';
                    $type->categ_id = $categ_cat->id;
                    $type->save();
                }
                elseif($catss == "Prime"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->prim.')';
                    $type->categ_id = $categ_cat->id;
                    $type->save();
                }
                elseif($catss == "Mature"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->mat.')';
                    $type->categ_id = $categ_cat->id;
                    $type->save();
                }
                elseif($catss == "Senior"){
                    $type = new Type;
                    $type->type_name = $catss.''.'('.$req->sen.')';
                    $type->categ_id = $categ_cat->id;
                    $type->save();
                }
            }
        }
        else{

        }
        $data = array(
            'dog' => "",
            'cat' => "",
            'both' =>"Both",
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_dog->id'"),
            'breed2'=> DB::select("select *from breed  where categ_id ='$categ_cat->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.ThirdIntro',$data);
    }

    function savebothbreed(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed = Breed::where('categ_id',$categ_dog->id)->count();
        $breed1 = Breed::where('categ_id',$categ_cat->id)->count();
        if($breed > 0 || $breed <= 0){
            foreach($req->dog as $dogs){
                if($dogs == "Cross-breed")
                {
                    $exist = Breed::where('breed_name',$dogs)->where('categ_id',$categ_dog->id)->count();
                    if($exist == 0){
                        if($req->dogbreed ==""){
                            $breed = new Breed;
                            $breed->breed_name = $dogs;
                            $breed->categ_id = $categ_dog->id;
                            $breed->save();
                        }
                        else{
                            $breed = new Breed;
                            $breed->breed_name = $dogs.''.'('.$req->dogbreed.')';
                            $breed->categ_id = $categ_dog->id;
                            $breed->save();
                        }

                    }
                }
                else{
                    $exist = Breed::where('breed_name',$dogs)->where('categ_id',$categ_dog->id)->count();
                    if($exist == 0){
                        $breed = new Breed;
                        $breed->breed_name = $dogs;
                        $breed->categ_id = $categ_dog->id;
                        $breed->save();
                    }
                }

            }
        }
        if($breed1 > 0 || $breed1 <= 0){
            foreach($req->cat as $cats){
                if($cats == "Cross-breed"){
                    $exist = Breed::where('breed_name',$cats)->where('categ_id',$categ_cat->id)->count();
                    if($exist==0){
                        if($req->catbreed ==""){
                            $breed = new Breed;
                            $breed->breed_name = $cats;
                            $breed->categ_id = $categ_cat->id;
                            $breed->save();
                        }
                        else{
                            $breed = new Breed;
                            $breed->breed_name = $cats.''.'('.$req->catbreed.')';
                            $breed->categ_id = $categ_cat->id;
                            $breed->save();
                        }

                    }
                }
                else{
                    $exist = Breed::where('breed_name',$cats)->where('categ_id',$categ_cat->id)->count();
                    if($exist == 0){
                        $breed = new Breed;
                        $breed->breed_name = $cats;
                        $breed->categ_id = $categ_cat->id;
                        $breed->save();
                    }
                }
            }
        }
        $categ = Category::where('shelter_id',$shelter->id)->count();
        $type1 = Type::where('categ_id',$categ_dog->id)->count();
        $type2 = Type::where('categ_id',$categ_cat->id)->count();
        $petbreed = Breed::where('categ_id',$categ_dog->id)->count();
        $petbreed1 = Breed::where('categ_id',$categ_cat->id)->count();

        if($categ > 0){
            if($type1 > 0 || $type2 > 0){
                if($petbreed > 0 || $petbreed1 > 0){
                    $shelter->is_welcome_shelter = "1";
                    $shelter->update();
                }
            }
        }
        $data =array(
            'dog' => "",
            'cat' => "",
            'both' =>"Both",
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.SettingUp.FourthIntro',$data);
    }
    function BothFee(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $dogfee = AdoptionFee::where('categ_id',$categ_dog->id)->count();
        $catfee = AdoptionFee::where('categ_id',$categ_cat->id)->count();
        if($dogfee == 0 && $catfee == 0){
            foreach($req->fee as $fees){
                if($fees == "Free"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Free";
                    $dogfees->dog_fee = "FREE";
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();

                    $catfees = new AdoptionFee;
                    $catfees->type = "Free";
                    $catfees->cat_fee = "FREE";
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
                elseif($fees == "Default"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Default";
                    $dogfees->dog_fee = $req->dogfee;
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();

                    $catfees = new AdoptionFee;
                    $catfees->type = "Default";
                    $catfees->cat_fee = $req->catfee;
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
                elseif($fees == "Custom"){
                    $dogfees = new AdoptionFee;
                    $dogfees->type = "Custom";
                    $dogfees->categ_id = $categ_dog->id;
                    $dogfees->save();

                    $catfees = new AdoptionFee;
                    $catfees->type = "Custom";
                    $catfees->categ_id = $categ_cat->id;
                    $catfees->save();
                }
            }

        }
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
        );
        return view('AnimalShelter.welcomepage',$data);

    }

    function AddAnimal(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $stats ='Available';
        $owner = new PetOwner;
        $deworm = new Deworm;
        $vaccine = new Vaccine;
        $animal = new Animals;
        if($req->hasfile('animal_image')){
            $file = $req->file('animal_image');
            $extention =$file->getClientOriginalExtension();
            $filename =time().'.'.$extention;
            $file->move('uploads/animals/',$filename);
            $animal ->animal_image = $filename;
        }
        $animal->name = $req->name;
        $animal->category = $req->category;
        $animal->age = $req->age;
        $animal->gender =$req->gender;
        $animal->size =$req->size;
        $animal->breed =$req->breed;
        $animal->history =$req->history;
        $animal->color =$req->color;
        $animal->info =$req->info;
        $animal->pet_stage = $req->stage;
        $animal->status = $stats;
        $animal->petbooked ="Not generated";
        $animal->petowner_id =$owner->id;
        $animal->shelter_id =$shelter->id;

        $animal->save();

        return redirect()->back()->with('status','Animal Added Successfully');
    }

    function UpdateAnimal(Request $req, $id){
        try {
            $animal = Animals::find($id);
            $check = AnimalMasterList::where('animal_image',$animal->animal_image)->count();
            if($req->hasfile('animal_image')){
                $destination = 'uploads/animals/'.$animal->animal_image;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $file = $req->file('animal_image');
                $extention =$file->getClientOriginalExtension();
                $filename =time().'.'.$extention;
                $file->move('uploads/animals/',$filename);
                $animal ->animal_image = $filename;
            }
            $animal->name = $req->name;
            $animal->age = $req->age;
            $animal->category = $req->category;
            $animal->breed = $req->breed;
            $animal->pet_stage = $req->stage;
            $animal->color =$req->color;
            $animal->history = $req->history;
            $animal->info = $req->info;
            $animal->update();
            if($check > 0){
                $master = AnimalMasterList::where('animal_image',$animal->animal_image)->first();
                $category = Category::where('id',$animal->category)->first();
                if($req->hasfile('animal_image')){
                    $destination = 'uploads/animals/'.$animal->animal_image;
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $file = $req->file('animal_image');
                    $extention =$file->getClientOriginalExtension();
                    $filename =time().'.'.$extention;
                    $file->move('uploads/animals/',$filename);
                    $master->animal_image = $filename;
                }
                $master->name = $req->name;
                $master->age = $req->age;
                $master->category = $category->category_name;
                $master->breed = $req->breed;
                $master->pet_stage = $req->stage;
                $master->color =$req->color;
                $master->history = $req->history;
                $master->info = $req->info;
                $master->update();
            }

            return redirect()->back()->with('status','Animal Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('status1','Something went wrong! Try again later');
        }

    }

    function UpdatePassword(Request $req, $id){
        $shelter = AnimalShelter::find($id);
        $newpass = $req->new_pass;
        $con_pass = $req->con_pass;

        //check if current password is equal to inputted current password
        if(Hash::check($req->password,$shelter->password)){
            if($newpass == $con_pass && $req->password != $newpass && $req->password != $con_pass){
                $shelter->password = Hash::make($newpass);
                $shelter->update();
                return redirect()->back()->with('status','Password Updated Successfully');
            }
            else if($newpass == $req->password && $con_pass == $req->password){
                return redirect()->back()->with('status1','Current password is the same as your new password! Try setting it again');
            }
            else{
                return redirect()->back()->with('status1','Password Mismatch');
            }
        }
        else{
            return redirect()->back()->with('status1','Password is Incorrect');
        }
    }
    function DeactivateProfileAccess(Request $req){
        $shelter = AnimalShelter::find($req->shelterId);
        $pass = $req->password;

        if(Hash::check($req->password,$shelter->password)){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Profile.ProfileDeactivation',$data);
        }else{
            return redirect()->back()->with('status1','Password is Incorrect');
        }
    }
    function Deactivation(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        if($req->radiobutton == "1"){
            $shelter->is_verified_activation ="1";
            $shelter->deact_reason = "This is temporary. I'll be back";
            $shelter->update();
            if(session()->has('LoggedUser')){
                session()->pull('LoggedUser');
                return redirect('/User/login')->with('stat','Your account has been deactivated');
            }
        }
        else if($req->radiobutton == "2"){
            $shelter->is_verified_activation ="1";
            $shelter->deact_reason = $req->others;
            $shelter->update();
            if(session()->has('LoggedUser')){
                session()->pull('LoggedUser');
                return redirect('/User/login')->with('stat','Your account has been deactivated');
            }
        }
    }
    function Updatetime(Request $req, $id){
        $shelter = AnimalShelter::find($id);
        $shelter->start_time =Carbon::parse($req->start_time)->format('h:i A');
        $shelter->end_time = Carbon::parse($req->end_time)->format('h:i A');
        $shelter->update();
        return redirect()->back()->with('status','Opening Hours Updated Successfully');
    }
    function UpdateProfile(Request $req, $id){
        $req->validate([
            'profile'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
            $shelter = AnimalShelter::find($id);
            $default = $shelter->profile;
            if('default.png'!=$default){
                if($req->hasfile('profile')){
                    $destination = 'uploads/animal-shelter/profile/'.$shelter->profile;
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $file = $req->file('profile');
                    $extention =$file->getClientOriginalExtension();
                    $filename =time().'.'.$extention;
                    $file->move('uploads/animal-shelter/profile/',$filename);
                    $shelter ->profile = $filename;
                }
            }else{
                if($req->hasfile('profile')){
                    $file = $req->file('profile');
                    $extention =$file->getClientOriginalExtension();
                    $filename =time().'.'.$extention;
                    $file->move('uploads/animal-shelter/profile',$filename);
                    $shelter ->profile = $filename;
                }
            }
            $shelter->shelter_name = $req->shelter_name;
            $shelter->email =$req->email;
            $shelter->address =$req->address;
            $shelter->founder_name =$req->founder_name;
            $shelter->contact =$req->contact;
            $shelter->g_cash =$req->g_cash;
            $shelter->pay_pal =$req->pay_pal;
            $shelter->start_day =$req->start_day;
            $shelter->end_day =$req->end_day;
            $shelter->update();
            return redirect()->back()->with('status','Profile Updated Successfully');

    }

    function DeleteAnimal($id){
        $animal=Animals::find($id);
        $destination = 'uploads/animals/'.$animal->animal_image;
            if(File::exists($destination)){
                File::delete($destination);
            }
        $animal->delete();
        return redirect()->back()->with('status','Animal Deleted Successfully');
    }

    function ViewEditAnimal($id){
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> Animals::find($id),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
        );
        return view('AnimalShelter.AnimalManagement.EditAnimal',$data);
    }
    function ViewEditProfile($shelter_id){
        $shelter = AnimalShelter::find($shelter_id);

        if($shelter->is_verified_activation == "1"){
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Deactivation.EditProfile',$data);
        }
        else if($shelter->is_verified_activation == "2"){
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Deactivation.EditProfile',$data);
        }
        else{
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Profile.EditProfile',$data);
        }

    }

    function ViewProfile($shelter_id){
        $shelter= AnimalShelter::find($shelter_id);

        if($shelter->is_verified_activation == "1"){
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Deactivation.profile',$data);
        }
        else if($shelter->is_verified_activation == "2"){
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Deactivation.profile',$data);
        }
        else{
            $data = array(
                'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
            );
            return view('AnimalShelter.Profile.profile',$data);
        }
    }

    function ViewDeactDash(){

        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return view('AnimalShelter.Deactivation.deactpage',$data);
    }

    function ViewPolicy(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'policy'=>DB::select("select *from adopt_policy  where shelter_id ='$shelter->id'")
        );
        return view('AnimalShelter.AdoptionPolicy.adoptpolicy',$data);
    }

    function AddPolicy(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();

        $policy = new AdoptionPolicy;
        $policy -> policy_content = $req->policy_content;
        $policy ->shelter_id = $shelter->id;
        $policy->save();
        return redirect()->back()->with('status','Adoption Policy Added Successfully');
    }

    function EditPolicy(Request $req, $id){
       $policy = $req->policy_content;
       DB::update("update adopt_policy set policy_content = '$policy' where id ='$id'");
       return redirect()->back()->with('status','Adoption Policy Updated Successfully');
    }

    function DeletePolicy($id){
        $policy = AdoptionPolicy::find($id);
        $policy->delete();
        return redirect()->back()->with('status','Adoption Policy Deleted Successfully');
    }

    function RequestActivation($shelter_id){
        $shelter = AnimalShelter::find($shelter_id);

        $approveAdmin = array();
        $approveAdmin = [
            'shelter_name' => $shelter->shelter_name,
            'reactivate' => ' is requesting for account reactivation'
        ];
        if($shelter->is_verified_activation == "1"){
            $shelter->is_verified_activation = "2";
            $shelter->save();
            Admin::find(1)->notify( new ApproveReactivationNotif($approveAdmin));
            return redirect()->back()->with('status','You have requested for reactivation of account');
        }
        else{
            return redirect()->route('deactpage')->with('status1','You have already requested for reactivation');
        }
    }

    function petbook_allocate(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltervaccine' =>AnimalShelter::all()->where('id',session('LoggedUser')),
            'shelterdeworm' =>AnimalShelter::all()->where('id',session('LoggedUser')),
            'animal'=> DB::select("select *from animals  where shelter_id ='$shelter->id'"),
        );
        return view('AnimalShelter.Pet Book.Allocate',$data);
    }

    function petbook_viewbook(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();

        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> DB::select("select *from animals  where (shelter_id ='$shelter->id' OR owner_id ='$shelter->id') AND (petbooked = 'Not generated')"),
            'petbook' => PetBook::where('shelter_id',$shelter->id),
        );
        return view('AnimalShelter.Pet Book.ViewBook',$data);
    }

    function load_books(){
     $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
     $petbook = DB::select("select *from animal_master_list where shelter_id ='$shelter->id' OR  owner_id ='$shelter->id'");
     $output = '<div class="row">';
     foreach($petbook as $books)
     {
      $output .= '
      <div class="flip-card">
        <div id="color" class="flip-card-inner">
            <div class="flip-card-front">
                <img src="'.asset('uploads/animals/' . $books->animal_image).'" alt="">
                <h1 style=" text-shadow: 2px 2px 4px #000000; margin-top:10px; font-weight:bold; text-align:center; color:#fff">'.$books->name.'</h1>
                <h5 style=" text-shadow: 2px 2px 4px #000000; margin-top:10px; font-weight:bold; text-align:center; color:#fff">('.$books->breed.')</h5>
                <p style=" text-shadow: 2px 2px 4px #000000; margin-top:5px; text-align:center; color:#fff">'.$books->pet_stage.'</p>
            </div>
            <div class="flip-card-back">
                <div class="info" style="height:50%">
                    <h5 class="head">Pet Name: '.$books->name.'</h5>
                    <h5>Pet Age: '.$books->age.'</h5>
                    <h5>Pet Gender: '.$books->gender.'</h5>
                    <h5>Life Stage: '.$books->pet_stage.'</h5>
                    <h5>Pet Breed: '.$books->breed.'</h5>
                    <h5>Pet Size: '.$books->size.'</h5>
                </div>
                <div class="footer" style="margin-top:40px">
                    <button id="'.$books->id.'" style="text-align:center" class="btn btn-success petbook">View Pet Book Details</button>
                </div>
            </div>
        </div>
     </div>
      ';
     }
     if(empty($books)){
        $output.='
        <div>
        <h6>No Pet book exist!</h6>
        </div>
       ';
     }

     $output .= '</div>';
     echo $output;
    }

    function petbook_details(Request $req,$id){
        $masterlist = AnimalMasterlist::find($id);
        $animal = Animals::where('animal_image',$masterlist->animal_image)->first();
        $vachistory = VaccineHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->count();
        $dewhistory = DewormHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->count();
        if($vachistory > 0 && $dewhistory == 0){
            $vachistory1 = VaccineHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->first();
            $animals = Animals::where('id',$vachistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',$animals->id),
                'deworm' => DewormHistory::all()->where('animal_id', 0),
            );
            return view('AnimalShelter.Pet Book.details',$data);
        }
        if($dewhistory >0 && $vachistory == 0){
            $dewhistory1 = DewormHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->first();
            $animals = Animals::where('id',$dewhistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',0),
                'deworm' => DewormHistory::all()->where('animal_id',$animals->id),
            );
            return view('AnimalShelter.Pet Book.details',$data);
        }
        if($dewhistory >0 && $vachistory > 0 ){
            $vachistory1 = VaccineHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->first();
            $dewhistory1 = DewormHistory::where('petbook_id',$id)->orWhere('animal_id',$animal->id)->first();
            $animals = Animals::where('id',$vachistory1->animal_id)->first();
            $animals1 = Animals::where('id',$dewhistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',$animals->id),
                'deworm' => DewormHistory::all()->where('animal_id',$animals1->id),
            );
            return view('AnimalShelter.Pet Book.details',$data);
        }

        if($dewhistory == 0 && $vachistory == 0){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',0),
                'deworm' => DewormHistory::all()->where('animal_id',0),
            );
            return view('AnimalShelter.Pet Book.details',$data);
        }

    }
    function petbook_generate(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $vaccine = VaccineHistory::where('animal_id',$req->get('id'))->first();
        $deworm = DewormHistory::where('animal_id',$req->get('id'))->first();
        $animal = Animals::where('shelter_id',$shelter->id)->orWhere('owner_id',$shelter->id)->where('id',$req->get('id'))->first();
        $category = Category::where('id',$animal->category)->first();
        $animalmasterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->count();

        if($animalmasterlist == 0){
            $animMasterlist = new AnimalMasterList;
            $animMasterlist->animal_image = $animal->animal_image;
            $animMasterlist->name = $animal->name;
            $animMasterlist->category = $category->category_name;
            $animMasterlist->age = $animal->age;
            $animMasterlist->gender = $animal->gender;
            $animMasterlist->size = $animal->size;
            $animMasterlist->breed = $animal->breed;
            $animMasterlist->history = $animal->history;
            $animMasterlist->color = $animal->color;
            $animMasterlist->info = $animal->info;
            $animMasterlist->pet_stage = $animal->pet_stage;
            $animMasterlist->shelter_id = $shelter->id;
            $animMasterlist->save();

            $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('shelter_id',$shelter->id)->first();

            $petbook = New PetBook;
            $petbook->animal_id = $getIdMaster->id;
            $petbook->shelter_id = $shelter->id;
            $petbook->save();

            $getId = PetBook::where('animal_id',$getIdMaster->id)->where('shelter_id',$shelter->id)->first();
            $checkvac = VaccineHistory::where('animal_id',$req->get('id'))->count();
            if($checkvac > 0){
                $vaccine->petbook_id = $getId->id;
                $vaccine->update();
            }
            $checkdeworm = DewormHistory::where('animal_id',$req->get('id'))->count();
            if($checkdeworm > 0){
                $deworm->petbook_id = $getId->id;
                $deworm->update();
            }
            $animalcheck = Animals::where('shelter_id',$shelter->id)->orWhere('owner_id',$shelter->id)->where('id',$req->get('id'))->count();
            if($animalcheck > 0) {
                $animal->petbooked ="PetBooked";
                $animal->update();
            }
        }
    }

    function postview(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal' =>Animals::
                        where('post_status','not posted')
                        ->where('status','Available')
                        ->where(function($query)use($shelter){
                            $query->where('shelter_id','=',$shelter->id)
                            ->orWhere('owner_id',$shelter->id);
                        })
                        ->get(),
        );
        return view('AnimalShelter.Post Pet.createpost',$data);
    }

    function postcreate($id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal' =>Animals::find($id),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),

        );
        return view('AnimalShelter.Post Pet.uploadpost',$data);
    }

    function postupdate($id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal' =>Animals::find($id),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
        );
        return view('AnimalShelter.Post Pet.updatepost',$data);
    }

    function loadfee ($id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $checkdog = Category::
                        join('adoption_fee','adoption_fee.categ_id','=','category.id')
                        ->where('adoption_fee.id',$id)
                        ->where('category_name',"Dog")->where('shelter_id',$shelter->id)->count();
        $checkcat = Category::
                        join('adoption_fee','adoption_fee.categ_id','=','category.id')
                        ->where('adoption_fee.id',$id)
                        ->where('category_name',"Cat")->where('shelter_id',$shelter->id)->count();
        if($checkcat > 0){
            $checkcat = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->first();
            $cat = AdoptionFee::where('id',$id)->where('categ_id', $checkcat->id)->first();
            if($id == $cat->id){
                if($cat->type =="Free" || $cat->type == "Default"){
                    $output = '
                    <label class="text-sm">Adoption Fee Price</label>
                    <input type="text" style="font:weight:bold; color:black" id="price" readOnly class="form-control" value="'.$cat->cat_fee.'">
                    ';
                    echo $output;
                }
                else{
                    $output = '
                    <label class="text-sm">Adoption Fee Price</label>
                    <input type="number" id="price" placeholder="P500.00" required class="form-control" value="'.$cat->cat_fee.'">
                    ';
                    echo $output;
                }
            }
        }
        if($checkdog > 0){
            $checkdog = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->first();
            $dog = AdoptionFee::where('id',$id)->where('categ_id', $checkdog->id)->first();
            if($id == $dog->id){
                if($dog->type =="Free" || $dog->type == "Default"){
                    $output = '
                    <label class="text-sm">Adoption Fee Price</label>
                    <input type="text" id="price" readOnly class="form-control" value="'.$dog->dog_fee.'">
                    ';
                    echo $output;
                }
                else{
                    $output = '
                    <label class="text-sm">Adoption Fee Price</label>
                    <input type="number" placeholder="P500.00" id="price" required class="form-control" value="'.$dog->dog_fee.'">
                    ';
                    echo $output;
                }
            }
        }
    }

    function post_pet_save(Request $req, $id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $checkdog = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->count();
        $checkcat = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->count();

        if($checkdog > 0){
            $checkdogs = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->first();
            $dog = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkdogs->id)->count();
            if($dog == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();
            }
        }
        if($checkcat > 0){
            $checkcats = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->first();
            $cat = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkcats->id)->count();
            if($cat == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();
            }
        }

        $checkpost = Post::all()->where('animal_id',$id)->count();
        if($checkpost == 0){
            $post = new Post;
            $post->animal_id = $id;
            $post->save();
        }
        $petupdate = Animals::find($id);
        $petupdate->post_status = "posted";
        $petupdate->update();

        //decrement post credits
        $subtotal = (int)$shelter->TotalCredits;
        $remaining = $subtotal - 1 ;
        $shelter->TotalCredits = $remaining;
        $shelter->update();
     }

     function post_pet_update(Request $req, $id){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $checkdog = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->count();
        $checkcat = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->count();

        if($checkdog > 0){
            $checkdogs = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->first();
            $dog = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkdogs->id)->count();
            if($dog == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();
            }
        }
        if($checkcat > 0){
            $checkcats = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->first();
            $cat = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkcats->id)->count();
            if($cat == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();
            }
        }
     }

     function post_pet_delete($id){
        $post = Post::find($id);
        $animal = Animals::where('id',$post->animal_id)->first();
        $photos = UploadedPhotos::all()->where('animal_id',$animal->id);

        $animal->post_status = "not posted";
        $animal->update();

        DB::table('uploaded_photos')->where('animal_id',$animal->id)->delete();
        foreach($photos as $photo){
        $destination = 'uploads/animal-shelter/uploaded-photos/Post/'.$photo->imagename;
            if(File::exists($destination)){
                File::delete($destination);
            }
        }
        $post->delete();
     }

     function load_post(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $post = Animals::
                   where('post_status','posted')
                -> where(function($query) use($shelter){
                    $query-> where('shelter_id', $shelter->id)
                            ->orWhere('owner_id',$shelter->id);
                })
                ->get();
        $output = ' <main style ="margin-top:30px" class="grid-new1">';
            foreach($post as $posts)
            {
            $posted = new Carbon($posts->updated_at);
            $output .= '
            <article>
            <div class="col-sm">
                <div class="card shadow mb-4">
                    <div class="card-header">';
                        if($posts->status == "Available"){
                        $output .= '
                        <div class="dropdown">
                            <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i> </label></span>
                            </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="#" style="text-decoration:none"><button style="text-decoration:none" class="dropdown-item" value="'.$posts->id.'" id="edit">Edit</button></a>
                                    ';
                                        $deletepost = Post::where('animal_id',$posts->id)->first(); $output .= '
                                    <a style="text-decoration:none" href="#"><button style="text-decoration:none" class="dropdown-item" value="'.$deletepost->id.'" id="remove">Remove</button></a>
                                </div>
                            <label>&nbsp &nbsp<i style="color:green; font-size:12px" class="fa fa-circle"></i> '.$posts->status.'</label><span><label style="float:right"> posted '.$posted->diffForHumans(). ' &nbsp
                        </div>
                        ';
                        }
                        elseif($posts->status == "Ongoing"){
                            $output .= '
                            <div class="dropdown">
                            <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i> </label></span>
                            </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                ';
                                    $deletepost = Post::where('animal_id',$posts->id)->first(); $output .= '
                                    <a style="text-decoration:none" href="#"><button style="text-decoration:none" class="dropdown-item" value="'.$deletepost->id.'" id="remove">Remove</button></a>
                                </div>
                            <label>&nbsp &nbsp<i style="color:orange; font-size:12px" class="fa fa-circle"></i> '.$posts->status.'</label><span><label style="float:right"> posted '.$posted->diffForHumans(). ' &nbsp
                        </div>
                        ';
                        }
                        else{
                            $output .= '
                            <div class="dropdown">
                            <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i> </label></span>
                            </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                ';
                                    $deletepost = Post::where('animal_id',$posts->id)->first(); $output .= '
                                    <a style="text-decoration:none" href="#"><button style="text-decoration:none" class="dropdown-item" value="'.$deletepost->id.'" id="remove">Remove</button></a>
                                </div>
                            <label>&nbsp &nbsp<i style="color:red; font-size:12px" class="fa fa-circle"></i> '.$posts->status.'</label><span><label style="float:right"> posted '.$posted->diffForHumans(). ' &nbsp
                        </div>
                        ';
                        }
                        $output .= '
                    </div>
                    <div style="background-color:whitesmoke" class="card-body">
                        <div style="display:flex">
                            <div style="margin:0">
                                <div style="background-color:">
                                <img style="padding:10px;" src="'.asset('uploads/animals/' . $posts->animal_image).'" width="250px" height="200px" alt="">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div style="display:flex">';
                                    foreach($posts->postphotos as $pics){
                                        $check = Animals::where('id',$pics->animal_id)->where('owner_id','none')->count();
                                        if($check > 0){
                                            $output .= '
                                            <div class="col-sm">
                                            <img src="'.asset('uploads/animal-shelter/uploaded-photos/Post/'.$pics->imagename).'" width="100%" height="100%" alt="">
                                            </div>
                                            ';
                                        }
                                        else
                                        {
                                            $output .= '
                                            <div class="col-sm">
                                            <img src="'.asset('uploads/pet-owner/uploaded-photos/Post/'.$pics->imagename).'" width="100%" height="100%" alt="">
                                            </div>
                                            ';
                                        }
                                    }
                                    $output .= '
                                </div>
                                <div>
                                    <h5 style="margin-top:10px;text-align:center; color:black; font-weight:bold">"History of '.$posts->name.'"</h5>
                                    <p style="text-indent:30px;color:black">'.$posts->history.'</p> <hr>
                                 </div>
                            </div>
                        </div>
                            <div>
                                <div style="background-color:#fff; display:flex">
                                    <div class="col-sm">
                                        <label style=" color:black">Name: </label><span style="color:black; font-weight:bold">'.$posts->name.'</span><br>
                                        <label style=" color:black">Gender: </label><span style="color:black; font-weight:bold">'.$posts->gender.'</span><br>
                                        <label style=" color:black">Age: </label><span style="color:black; font-weight:bold">'.$posts->age.'</span><br>
                                        <label style=" color:black">Life Stage: </label><span style="color:black; font-weight:bold">'.$posts->pet_stage.'</span> <br>
                                        <label style=" color:black">Breed: </label><span style="color:black; font-weight:bold">'.$posts->breed.'</span> <br>
                                        <label style=" color:black">Size: </label><span style="color:black; font-weight:bold">'.$posts->size.'</span>
                                    </div>
                                    <div class="col-sm">
                                        <h7 style="color:black;font-weight:bold"">Additional Information</h7>
                                        <p style="padding-top:5px">'.$posts->info.'</p> <hr>
                                        <h7 style="color:black"">Adoption Fee</h7>
                                        <div style="background-color:#fce205; width: 150px;">
                                            <p style=" text-align:center; color:black; font-weight:bold; font-size:24px;">'.$posts->fee.'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="card-header">

                    </div>
                </div>
            </div>
            </article>
            ';
            }
        if(empty($posts)){
            $output.='
            <div>
            <h6>No Post exist!</h6>
            </div>
           ';
         }

        $output .= '</div>';
        echo $output;
     }

     function choosesubscription($id){
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'subs'=>Subscription::find($id),
        );
        return view('AnimalShelter.Subscription.viewtransaction',$data);
    }

    function subdetails($id){
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'subs'=>Subscription::find($id),
        );
        return view('AnimalShelter.Subscription.Paypal.subscribe',$data);
    }

    function viewwaitsubscription($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $check = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('shelter_id',$shelter->id)->count();
        if($check > 0){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'subs'=>Subscription::find($id),
            );
            return view('AnimalShelter.Subscription.viewwaitsubscription',$data);
        }
        if($check == 0){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'subs'=>Subscription::find($id),
                'count'=>SubscriptionTransac::where('sub_id',$id)->where('shelter_id',$shelter->id)->where('status','not approved')->count(),
                'feedback'=>Feedback::where('owner_id',$shelter->id)->where('owner_type',2)->get(),
            );
            return view('AnimalShelter.Subscription.viewtransaction',$data);
        }
    }
    function waitingsub($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $check = UploadedPhotos::where('sub_id',$id)->where('shelter_id',$shelter->id)->count();
        if($check > 0){
            $subscription = Subscription::find($id);
            $waitsub = new SubscriptionTransac;
            $waitsub->status ="pending";
            $waitsub->sub_id = $id;
            $waitsub->shelter_id = $shelter->id;
            $waitsub->save();

            $valid = array();
            $valid = [
                'shelter_name' => $shelter->shelter_name.' has sent a proof of payment',
                'continue' => 'please check it now',
            ];
            Admin::find(1)->notify(new Checkproofsubscriptionpayment($valid));

            return redirect()->route('view.wait.subscription',$id)->with('status','Proof of payment has been sent');
        }
        else{
            return redirect()->back()->with('status1','Please upload a photo that will serve as your proof of payment');
        }
    }
    function viewdonation(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'donors'=>Donation::where('status','pending')->where('animal_shelter',$shelter->id)->get(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
          );
          return view('AnimalShelter.Donation.viewdonation',$data);
    }

    function feedbackmessage(Request $req, $id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $receive = DB::table('donation')
                    ->where('donation_id',$id)
                    ->update(['status'=>'received','feedback'=>$req->feedback]);
        $donor = Donation::where('donation_id',$id)->first();
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Donation';
        $notif->notif_from = $shelter->shelter_name;
        $notif->notif_to = $donor->donor_id;
        $notif->notif_message = ' has received your donation';
        $notif->save();

        return redirect()->back()->with('status','You have accepted his/her donation');

    }

    function feedbackmessageerror(Request $req, $id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $receive = DB::table('donation')
                    ->where('donation_id',$id)
                    ->update(['status'=>'not received','feedback'=>$req->feedback]);
        $donor = Donation::where('donation_id',$id)->first();
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Donation';
        $notif->notif_from = $shelter->shelter_name;
        $notif->notif_to = $donor->donor_id;
        $notif->notif_message = ' has not received your donation please create new transaction for donation';
        $notif->save();

        return redirect()->back()->with('status','Feedback invalid donation sent successfully');
    }
    function cancelsub($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $cancel = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('shelter_id',$shelter->id)->first();

        $cancel->status = 'cancelled';
        $cancel->save();

        $remove = UploadedPhotos::where('type','subscription')->where('sub_id',$id)->where('shelter_id',$shelter->id)->get();
        foreach($remove as $pic){
            $destination = 'uploads/animal-shelter/uploaded-photos/'.$pic->imagename;
            if(File::exists($destination)){
              File::delete($destination);
            }
            $pic->delete();
        }
        return redirect()->back()->with('status','You cancelled your sent subscription proof of payment');
    }
    function adoptionrequests(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'adopter'=>Adoption::all()->where('status','pending')->where('owner_id',$shelter->id)->where('owner_type',2),
        );
        return view('AnimalShelter.Adoption.viewrequest',$data);
    }

    function message(Request $req, $id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $message = Adoption::find($id);
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Adoption Application';
        $notif->notif_from = $shelter->shelter_name;
        $notif->notif_to = $message->adopter_id;
        $notif->notif_message = ' has approved your adoption application';
        $notif->save();
        $message->status = 'approved';
        $message->feedback = $req->feedback;
        $message->update();

        $animal = Animals::find($message->animal_id);
        $animal->status = 'Ongoing';
        $animal->update();

        $check = Animals::find($message->animal_id);
        if($check->fee == "FREE"){
            $payment = new AdoptionPayment;
            $payment->animal_id = $check->id;
            $payment->adopter_id = $message->adopter_id;
            $payment->owner_id = $shelter->shelter_name;
            $payment->owner_type = 2;
            $payment->paymentMethod = "None";
            $payment->fee = "FREE";
            $payment->status = "FREE";
            $payment->adoption_id = $message->id;
            $payment->save();

            //get animal and adoption
            $adoption = Adoption::find($id);
            $adoption->paymentflag = "3";
            $adoption->update();

            $checking = AdoptionPayment::where('animal_id',$check->id)->where('owner_type',2)->where('owner_id',$shelter->shelter_name)->first();
            $recNo = Helper::IDGenerator(new Receipt, 'receipt_no', 5, 'RPT');

            $receipt = new Receipt;
            $receipt->animal_id = $check->id;
            $receipt->adopter_id = $message->adopter_id;
            $receipt->owner_id = $message->owner_id;
            $receipt->usertype_id = 2;
            $receipt->adoption_id = $id;
            $receipt->payment_id = $checking->id;
            $receipt->status = "pending";
            $receipt->receipt_no = $recNo;

            $receipt->save();
        }

        return redirect()->back()->with('status','Feedback has been sent successfully');
    }

    function error(Request $req, $id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $message = Adoption::find($id);
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Adoption Application';
        $notif->notif_from = $shelter->shelter_name;
        $notif->notif_to = $message->adopter_id;
        $notif->notif_message = ' has disapproved your adoption application';
        $notif->save();
        $message->status = 'disapproved';
        $message->feedback = $req->feedback;
        $message->update();

        return redirect()->back()->with('status','Disapprove feedback has been sent successfully');
    }


    function enlarge($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'images'=>Adoption::find($id),
        );
        return view('AnimalShelter.Adoption.viewid',$data);
    }

    function enlargedonation($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'images'=>Donation::where('donation_id',$id)->first(),
        );
        return view('AnimalShelter.Donation.reviewdonation',$data);
    }

    function petownerrequest(){
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'response'=>Requestadoption::where('status','pending')->get(),
        );
        return view('AnimalShelter.Request.viewrequest',$data);
    }
    function viewpetownerdetails($animal_id,$petowner_id){
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'petowner'=>PetOwner::find($petowner_id),
            'animal'=>Animals::find($animal_id)
        );
        return view('AnimalShelter.Request.viewpetowner',$data);
    }
    function approvereq(Request $req,$id){
        $approve = Requestadoption::find($id);
        $approve->feedback = $req->feedback;
        $approve->status = "approved";
        $approve->process = "ongoing";
        $approve->update();

        $animal = Animals::find($approve->animal_id);
        $animal->status ="Ongoing";
        $animal->update();

        $approvereq = array();
        $approvereq = [
            'petowner_name' => 'Great News! your request of adoption was approved by '.$approve->shelter->shelter_name,
            'approve' =>' please proceed to Request Approved to generate your adoption slip.'
        ];

        PetOwner::find($approve->petowner_id)->notify( new ApproveRequest($approvereq));
        return redirect()->back()->with('status','Adoption request has been approved successfully');
    }
    function rejectreq(Request $req,$id){
        $approve = Requestadoption::find($id);
        $approve->feedback = $req->feedback;
        $approve->status = "rejected";
        $approve->process = "denied";
        $approve->update();

        $approvereq = array();
        $approvereq = [
            'petowner_name' => 'Your request for adoption to  '.$approve->shelter->shelter_name.' has been rejected',
            'reject' =>' you can try requesting to other shelters.'
        ];

        PetOwner::find($approve->petowner_id)->notify( new RejectRequestNotif($approvereq));
        return redirect()->back()->with('status','Adoption request has been rejected successfully');
    }

    function receipt(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'receipts'=>Receipt::where('status','pending')->where('owner_id',$shelter->id)->where('usertype_id',2)->get(),
            'count'=>Receipt::where('status','confirmed')->where('owner_id',$shelter->id)->where('usertype_id',2)->count(),
        );
        return view('AnimalShelter.Receipt.receipt',$data);
    }
    function generated(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'generated'=>AdoptionSlip::all()->where('shelter_id',$shelter->id)->where('status','pending'),
            'countconfirm'=>AdoptionSlip::all()->where('shelter_id',$shelter->id)->where('status','confirmed')->count()
        );
        return view('AnimalShelter.AdoptionSlip.slip',$data);
    }

    function confirmed(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'generated'=>AdoptionSlip::all()->where('shelter_id',$shelter->id)->where('status','confirmed'),
        );
        return view('AnimalShelter.AdoptionSlip.confirm',$data);
    }

    function confirmreceipt(){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'receipts'=>Receipt::where('owner_id',$shelter->id)->where('usertype_id','2')->where('status','confirmed')-get(),
        );
        return view('AnimalShelter.Receipt.confirmed',$data);
    }

    function newpets(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data = array(
            'LoggedUserInfo' => AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'animal'=> DB::select("select *from animals  where owner_id ='$shelter->id'"),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'sheltercateg' =>AnimalShelter::all()->where('id',session('LoggedUser')),
          );
          return view('AnimalShelter.AnimalManagement.new',$data);
    }
    function confirmingreceipt($id){
        $receipt = find($id);
        $receipt->status = 'confirmed';
        $receipt->update();
        return redirect()->back()->with('status1','Receipt Confirmed Successfully');
    }
    function viewwait(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'feedback'=>Feedback::where('owner_type',2)->where('owner_id',$shelter->id)->get()
        );
       return view('AnimalShelter.rejected',$data);
    }

    function tempcheckshelter(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first();

        $sheltercheck= AnimalShelter::
                        whereHas('shelterPhoto',function($query)use($shelter){
                          $query->where('shelter_id',$shelter->id);
                        })
                        ->where('is_verified_shelter','2')
                        ->where('grace','!=','0')
                        ->count();
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'check'=>$sheltercheck
        );
       return view('AnimalShelter.tempcheckshelter',$data);
    }

    function wait($id)
    {
        $check = ValidDocuments::where('shelter_id',$id)->count();
        if($check > 0){
            $shelter=AnimalShelter::where('id',$id)->first();
            $convert = (int)$shelter->grace;
            $shelter->grace = $convert-1;
            $shelter->update();

            $data = array();
            $data = [
                'shelter_name' => $shelter->shelter_name,
                'approval'=>" resubmitted their valid documents and is waiting for your approval"
            ];

            $category = Category::all();
            Admin::find(1)->notify( new ApproveRejectShelterNotif($data));
           return redirect()->route('tempcheckshelter')->with('status','Submitted successfully');
        }else{
            return redirect()->back()->with('status1','Please upload valid documents first');
        }
    }

    function confirmadoption($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $confirm = AdoptionSlip::find($id);
        $confirm->status = "confirmed";
        $confirm->save();

        $animals = Animals::find($confirm->animal_id);
        $animals->status = "Available";
        $animals->post_status = "not posted";
        foreach($shelter->category as $categ){
            $animals->category = $categ->id;
        }
        $animals->ownertype = "Animal Shelter";
        $animals->owner_id =$shelter->id;
        $animals->update();

        $requestadopt = Requestadoption::find($confirm->reqadoption_id);
        $requestadopt->process = "completed";
        $requestadopt->update();

        $checkmaster = AnimalMasterList::where('animal_image',$animals->animal_image)->count();
        if($checkmaster > 0){
            $masterlist = AnimalMasterList::where('animal_image',$animals->animal_image)->first();
            $masterlist->ownertype ="Animal Shelter";
            $masterlist->owner_id = $shelter->id;
            $masterlist->update();

        }
        $success = array();
        $success = [
            'success' => 'You have successfully adopted '.$confirm->animal->name.' from '.$confirm->petowner->fname.' '.$confirm->petowner->lname,
            'info' => ' you can check it in your pet management',
        ];
        AnimalShelter::find($shelter->id)->notify(new SuccessAdoption($success));

        $success = array();
        $success = [
            'success' =>$confirm->animal->name.' has been successfully adopted by '.$shelter->shelter_name,
            'info' => ' you can check it in the completed section in request for adoption',
        ];
        PetOwner::find($confirm->petowner_id)->notify(new SuccessAdoption($success));

        return redirect()->back()->with('status','Adoption slip confirmed successfully');
    }

    function subpay($id){
        $shelters =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $subs = new SubscriptionTransac;
        $subs->status = 'pending';
        $subs->sub_id = $id;
        $subs->shelter_id = $shelters->id;
        $subs->save();

        $check = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('shelter_id',$shelters->id)->count();

        if($check > 0){
          $shelter = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('shelter_id',$shelters->id)->first();

          $approvedproof = [
            'shelter_name' => 'You have successfully subscribed '.$shelter->subscription->sub_name.' promo',
            'promo' => ' valid for '.$shelter->subscription->sub_span.''.$shelter->subscription->sub_span_type.'/s',
        ];
        $shelter->status = 'approved';
        $shelter->update();
        AnimalShelter::find($shelters->id)->notify(new ApproveProofPayment($approvedproof));

        $subscription = Subscription::find($id);
            $data = array(
              'admin' => Admin::where('id','=',session('LoggedUserAdmin'))->first(),
              'proof' => UploadedPhotos::where('sub_id',$id)->where('shelter_id',$shelters->id)->get(),
          );
          //check if credits is 0
          $credits = AnimalShelter::find($shelters->id);
          if($credits->TotalCredits == "0"){
            $credits->TotalCredits = $subscription->sub_credit;
            $credits->update();
             //getting the expiry date && the subscription span
             $span_type = $subscription->sub_span_type;
             if($span_type == "day"){
               $convertspan = (int)$subscription->sub_span;
               $datestart = Carbon::parse($shelter->updated_at);
               $expiry = $datestart->addDays($convertspan);
               //update
               $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
               $shelter->update();
             }
             elseif($span_type == "month"){
               $convertspan = (int)$subscription->sub_span;
               $datestart = Carbon::parse($shelter->updated_at);
               $expiry = $datestart->addMonths($convertspan);
               //update
               $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
               $shelter->update();
             }
             elseif($span_type == "year"){
               $convertspan = (int)$subscription->sub_span;
               $datestart = Carbon::parse($shelter->updated_at);
               $expiry = $datestart->addYears($convertspan);
               //update
               $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
               $shelter->update();
             }
          }
          else{
            if($subscription->sub_credit == "UNLI"){
              $credits->TotalCredits = "UNLI";
              $credits->update();
              //getting the expiry date && the subscription span
              $span_type = $subscription->sub_span_type;
              if($span_type == "day"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addDays($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
                $shelter->update();
              }
              elseif($span_type == "month"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addMonths($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
                $shelter->update();
              }
              elseif($span_type == "year"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addYears($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d, Y h:i:s A');
                $shelter->update();
              }
            }
            else{
              $credit = (int)$subscription->sub_credit;
              $subtotal = (int)$credits->TotalCredits;
              $total = $credit + $subtotal;
              $credits->TotalCredits = $total;
              $credits->update();

              $span_type = $subscription->sub_span_type;
              if($span_type == "day"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addDays($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d Y h:i:s A');
                $shelter->update();
              }
              elseif($span_type == "month"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addMonths($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d Y h:i:s A');
                $shelter->update();
              }
              elseif($span_type == "year"){
                $convertspan = (int)$subscription->sub_span;
                $datestart = Carbon::parse($shelter->updated_at);
                $expiry = $datestart->addYears($convertspan);
                //update
                $shelter->expiry_date = Carbon::parse($expiry)->format('F d Y h:i:s A');
                $shelter->update();
              }
            }
          }
        }
    }

}

