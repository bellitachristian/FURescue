<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetOwner;
use App\Models\Category;
use App\Models\Type;
use App\Models\Breed;
use App\Models\Admin;
use App\Models\Adoption;
use App\Models\Animals;
use App\Models\Adopter_Notif;
use App\Models\AdoptionPolicy;
use App\Models\AdoptionPayment;
use App\Models\AdoptionFee;
use App\Models\Receipt;
use App\Models\PetBook;
use App\Models\Deworm;
use App\Models\Vaccine;
use App\Models\Post;
use App\Models\AnimalShelter;
use App\Models\AllocateVaccine;
use App\Models\AllocateDeworming;
use App\Models\DewormHistory;
use App\Models\VaccineHistory;
use App\Models\AnimalMasterList;
use App\Models\UploadedPhotos;
use App\Models\Feedback;
use App\Models\Subscription;
use App\Models\SubscriptionTransac;
use App\Models\Usertype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RequestReactivationPetOwner;
use App\Notifications\Checkproofpetowner;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;


class PetOwnerManagement extends Controller
{
    function dashboard(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $id = $petowner->id;
        $subscription = Subscription::whereHas('subscription_transaction', function($q) use ($id) {
            $q->where('petowner_id','=',$id);  
            $q->where('status','=','approved');    
        })->pluck('id')->toArray(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'subscription'=>Subscription::all(),
            'notsub'=> $subscription,
            'notapprove'=> Subscription::whereNotIn('id', $subscription)->pluck('id')->toArray(),
            'countcredits'=>$petowner->TotalCredits,
            'countpets'=>Animals::where('petowner_id',$petowner->id)->where('status','Available')->where('post_status','posted')->count(),
            'countrequest',
            'totalrevenue'
        );
        return view('PetOwner.PetOwnerDash',$data);
    } 
    
    function PetOwner_tempdashboard(){
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.TemporaryDash',$data);
    }

    function postview(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal' =>Animals::all()->where('post_status','not posted')->where('status','Available')->where('petowner_id','=',$petowner->id)
        );
        return view('PetOwner.Post Pet.createpost',$data);
    }

    function allocate_view(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();       
        $data = array(
          'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
          'animal'=> DB::select("select *from animals where petowner_id='$petowner->id'"),
          'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );  
        return view('PetOwner.Vaccine & Deworm.Allocate',$data);
    }

    function Allocate_Vaccine_Animal($id){       
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $vaccinehistory = Vaccine::whereHas('allocatevaccine', function($q) use ($id) {
            $q->where('animal_id','=',$id);    
        })->pluck('id')->toArray();
        $dewormhistory = Deworm::whereHas('allocatedeworm', function($q) use ($id) {
            $q->where('animal_id','=',$id);    
        })->pluck('id')->toArray();
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal'=> Animals::find($id),
            'petowner'=> PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'notallocated' => Vaccine::whereNotIn('id', $vaccinehistory)->where('petowner_id',$petowner->id)->get()->toArray(),
            'notallocated1' => Deworm::whereNotIn('id', $dewormhistory)->where('petowner_id',$petowner->id)->get()->toArray(),
        );
        return view('PetOwner.Vaccine & Deworm.Allocate_Pet',$data);
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

        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $animal = Animals::where('petowner_id',$petowner->id)->where('id',$id)->first();
        $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->count();
        if($getIdMaster > 0){
            $masterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->first();
            $getId = PetBook::where('animal_id',$masterlist->id)->where('petowner_id',$petowner->id)->first();
            $checkdew = DewormHistory::where('animal_id',$id)->count();
            if($checkdew > 0){
                $dewhistory = DewormHistory::where('animal_id',$id)->first();
                $dewhistory->petbook_id = $getId->id;
                $dewhistory->update();
            }
        }
        return redirect('AllocateVaccine/petowner/'.$id)->with('status','Deworm Allocated Successfully');     
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
        
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $animal = Animals::where('petowner_id',$petowner->id)->where('id',$id)->first();
        $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->count();
        if($getIdMaster > 0){
            $masterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->first();
            $getId = PetBook::where('animal_id',$masterlist->id)->where('petowner_id',$petowner->id)->first();
            $checkvac = VaccineHistory::where('animal_id',$id)->count();
            if($checkvac > 0){
                $vachistory = VaccineHistory::where('animal_id',$id)->first();
                $vachistory->petbook_id = $getId->id;
                $vachistory->update();
            }   
        }
    
        return redirect('AllocateVaccine/petowner/'.$id)->with('status','Vaccine Allocated Successfully');     
    }

    function ViewAllocationVaccine($id,$vac_id){
  
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal'=> Animals::find($id),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'vaccine'=>Vaccine::find($vac_id)
        );
        return view('PetOwner.Vaccine & Deworm.Allocation',$data);
    }

    function ViewAllocationDeworm($id, $dew_id){
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal'=> Animals::find($id),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'deworm'=>Deworm::find($dew_id)
        );
        return view('PetOwner.Vaccine & Deworm.AllocationDeworming',$data);
    }

    function vaccine_dewormView(){     
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();       
        $data = array(
          'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
          'vac'=> DB::select("select *from vaccine where petowner_id='$petowner->id'"),
          'deworm'=> DB::select("select *from deworm where petowner_id='$petowner->id'"),
          'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first() 
        );   
        return view('PetOwner.Vaccine & Deworm.Vaccine',$data);
    }

    function AddVaccine(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $vaccine = new Vaccine;
        $vaccine->vac_name = $req->vac_name;
        $vaccine->vac_desc = $req->desc;
        $vaccine->petowner_id = $petowner->id;
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
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $deworm = new Deworm;
        $deworm->dew_name = $req->dew_name;
        $deworm->dew_desc = $req->desc;
        $deworm->petowner_id = $petowner->id;
        $deworm->save();
        return redirect()->back()->with('status','Deworming Added Successfully');
    }

    function ViewPolicy(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'policy'=>DB::select("select *from adopt_policy  where petowner_id ='$petowner->id'")
        );
        return view('PetOwner.AdoptionPolicy.adoptpolicy',$data);
    }

    function AddPolicy(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $policy = new AdoptionPolicy;
        $policy -> policy_content = $req->policy_content;
        $policy ->petowner_id = $petowner->id;
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
 

    function ViewEditAnimal($id){
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal'=> Animals::find($id),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.AnimalManagement.EditAnimal',$data);
    }

    function DeleteAnimal($id){
        $animal=Animals::find($id);
        $destination = 'uploads/animals/'.$animal->animal_image;
            if(File::exists($destination)){
                File::delete($destination);
            }
        $animal->delete();
        return redirect()->back()->with('status','Pet Removed Successfully');
    }

    function UpdateAnimal(Request $req, $id){
        try {
            $animal = Animals::find($id);
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
            return redirect()->back()->with('status','Pet Updated Successfully');      
        } catch (\Throwable $th) {
            return redirect()->back()->with('status1','Something went wrong! Try again later');
        }
        
    }

    function petbook_viewbook(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 

        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal'=> DB::select("select *from animals  where petbooked = 'Not generated' and petowner_id ='$petowner->id'"),
            'petbook' => PetBook::where('petowner_id',$petowner->id),
        );
        return view('PetOwner.Pet Book.ViewBook',$data);
    }

    function load_books(){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $petbook = DB::select("select *from animal_master_list where petowner_id ='$petowner->id'");   
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
        //dd($id);
        $vachistory = VaccineHistory::where('petbook_id',$id)->count();
        $dewhistory = DewormHistory::where('petbook_id',$id)->count();
        if($vachistory > 0 &&  $dewhistory == 0){
            $vachistory1 = VaccineHistory::where('petbook_id',$id)->first();
            $animals = Animals::where('id',$vachistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',$animals->id),
                'deworm' => DewormHistory::all()->where('animal_id',0),
            );
            return view('PetOwner.Pet Book.details',$data);
        }
        if($dewhistory > 0 && $vachistory == 0){
            $dewhistory1 = DewormHistory::where('petbook_id',$id)->first();
            $animals = Animals::where('id',$dewhistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',0),
                'deworm' => DewormHistory::all()->where('animal_id',$animals->id),
            );
            return view('PetOwner.Pet Book.details',$data);
        }
        if($dewhistory > 0 && $vachistory > 0){
            $vachistory1 = VaccineHistory::where('petbook_id',$id)->first();
            $dewhistory1 = DewormHistory::where('petbook_id',$id)->first();
            $animals = Animals::where('id',$vachistory1->animal_id)->first();
            $animals1 = Animals::where('id',$dewhistory1->animal_id)->first();
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',$animals->id),
                'deworm' => DewormHistory::all()->where('animal_id',$animals1->id),
            );
            return view('PetOwner.Pet Book.details',$data);
        }
        if($dewhistory == 0 && $vachistory == 0){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petbook' => AnimalMasterList::find($id),
                'vaccine'=> VaccineHistory::all()->where('animal_id',0),
                'deworm' => DewormHistory::all()->where('animal_id',0),
            );
            return view('PetOwner.Pet Book.details',$data);
        }
    }

    function petbook_generate(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $vaccine = VaccineHistory::where('animal_id',$req->get('id'))->first();
        $deworm = DewormHistory::where('animal_id',$req->get('id'))->first();
        $animal = Animals::where('petowner_id',$petowner->id)->where('id',$req->get('id'))->first();
        $category = Category::where('id',$animal->category)->first();
        $animalmasterlist = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->count();

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
            $animMasterlist->petowner_id = $petowner->id;
            $animMasterlist->save();
           
            $getIdMaster = AnimalMasterList::where('animal_image',$animal->animal_image)->where('petowner_id',$petowner->id)->first();

            $petbook = New PetBook;
            $petbook->animal_id = $getIdMaster->id;
            $petbook->petowner_id = $petowner->id;
            $petbook->save();

            $getId = PetBook::where('animal_id',$getIdMaster->id)->where('petowner_id',$petowner->id)->first();
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
            $animalcheck = Animals::where('petowner_id',$petowner->id)->where('id',$req->get('id'))->count();
            if($animalcheck > 0) {
                $animal->petbooked ="PetBooked";
                $animal->update();
            }       
        }
    }

    function ViewProfile($petowner_id){
        $petowner= PetOwner::find($petowner_id);

        if($petowner->is_verified_activation == "1"){
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Deactivation.profile',$data);
        }
        else if($petowner->is_verified_activation == "2"){
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Deactivation.profile',$data);
        }
        else{
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Profile.profile',$data);
        }
    }

    function DeactivateProfileAccess(Request $req){
        $petowner = PetOwner::find($req->petowner);
        $pass = $req->password;

        if(Hash::check($req->password,$petowner->password)){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Profile.ProfileDeactivation',$data);
        }else{
            return redirect()->back()->with('status1','Password is Incorrect');
        }
    }

    function RequestActivation($petowner_id){
        $petowner = PetOwner::find($petowner_id);
         
        $approveAdmin = array();
        $approveAdmin = [
            'petowner_name' => $petowner->fname.' '.$petowner->lname.'(Pet Owner)',
            'reactivate' => ' is requesting for account reactivation'
        ];
        if($petowner->is_verified_activation == "1"){
            $petowner->is_verified_activation = "2";
            $petowner->save();    
            Admin::find(1)->notify( new RequestReactivationPetOwner($approveAdmin));
            return redirect()->back()->with('status','You have requested for reactivation of account');
        }
        else{
            return redirect()->route('deactpage.petowner')->with('status1','You have already requested for reactivation');
        }
    }

    function ViewDeactDash(){
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.Deactivation.deactpage',$data);
    }

    function Deactivation(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        if($req->radiobutton == "1"){
            $petowner->is_verified_activation ="1";
            $petowner->deact_reason = "This is temporary. I'll be back";
            $petowner->update();
            if(session()->has('LoggedUserPet')){
                session()->pull('LoggedUserPet');
                return redirect('/User/login')->with('stat','Your account has been deactivated');
            }
        }
        else if($req->radiobutton == "2"){
            $petowner->is_verified_activation ="1";
            $petowner->deact_reason = $req->others;
            $petowner->update();
            if(session()->has('LoggedUserPet')){
                session()->pull('LoggedUserPet');
                return redirect('/User/login')->with('stat','Your account has been deactivated');
            }
        }
    }
    
    function ViewEditProfile($petowner_id){
        $petowner = PetOwner::find($petowner_id);

        if($petowner->is_verified_activation == "1"){
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Deactivation.EditProfile',$data);
        }
        else if($petowner->is_verified_activation == "2"){
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Deactivation.EditProfile',$data);
        }
        else{
            $data = array(
                'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
            );
            return view('PetOwner.Profile.EditProfile',$data);
        }
      
    }

    function UpdatePassword(Request $req, $id){
        $petowner = PetOwner::find($id);
        $newpass = $req->new_pass;
        $con_pass = $req->con_pass;

        //check if current password is equal to inputted current password  
        if(Hash::check($req->password,$petowner->password)){
            if($newpass == $con_pass && $req->password != $newpass && $req->password != $con_pass){
                $petowner->password = Hash::make($newpass);
                $petowner->update();
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

    function UpdateProfile(Request $req, $id){ 
        $req->validate([
            'profile'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);     
        try{
            $petowner = PetOwner::find($id);
            $default = $petowner->profile;
            if('default.png'!=$default){
                if($req->hasfile('profile')){
                    $destination = 'uploads/pet-owner/profile/'.$petowner->profile;
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $file = $req->file('profile');
                    $extention =$file->getClientOriginalExtension();
                    $filename =time().'.'.$extention;
                    $file->move('uploads/pet-owner/profile/',$filename);
                    $petowner ->profile = $filename;
                }          
            }else{
                if($req->hasfile('profile')){
                    $file = $req->file('profile');
                    $extention =$file->getClientOriginalExtension();
                    $filename =time().'.'.$extention;
                    $file->move('uploads/pet-owner/profile',$filename);
                    $petowner ->profile = $filename;    
                }
            }
            $petowner->fname = $req->fname;
            $petowner->lname = $req->lname;
            $petowner->email =$req->email;
            $petowner->address =$req->address;
            $petowner->contact =$req->contact;
            $petowner->gcash =$req->g_cash;
            $petowner->pay_pal =$req->pay_pal;
            $petowner->update();
            return redirect()->back()->with('status','Profile Updated Successfully');
        }catch(\Throwable $th){
            return redirect()->back()->with('status1','Something went wrong! Try again later');
        }    
    }

    function animal_view(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $data = array(
            'LoggedUserInfo' => PetOwner::where('id','=',session('LoggedUserPet'))->first(), 
            'animal'=> DB::select("select *from animals  where petowner_id ='$petowner->id'and status ='Available'"),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
          );
          return view('PetOwner.AnimalManagement.Animal',$data);
    }


    function AddAnimal(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $stats ='Available';

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
        $animal->petowner_id =$petowner->id;   
     
        $animal->save();

        return redirect()->back()->with('status','Pet Added Successfully');
    }



    function deletedogbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "Dog",
            'cat' => "",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);

    }

    function deletecatbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "",    
            'cat' => "Cat",
            'both' =>"",
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function deletebothbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
        $breed = DB::delete("Delete from breed where id ='$req->id'");
        $data = array(
            'dog' => "",
            'cat' => "",
            'both' =>"Both",
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_dog->id'"),
            'breed2'=> DB::select("select *from breed  where categ_id ='$categ_cat->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);

    }

    function secondaryIntro (Request $req){
        $petowner = PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $exists = Category::first();
        try {
            if($req->dogs == "Dog"){ 
                $dogs = Category::where('category_name','=',$req->dogs)->where('petowner_id','=',$petowner->id)->count();
                if(is_null($exists)){
                    $category = new Category;
                    $category->category_name = $req->dogs;
                    $category->petowner_id = $petowner->id;
                    $category->save();          
                }
                else{
                    if($dogs == 0){
                        $category = new Category;
                        $category->category_name = $req->dogs;
                        $category->petowner_id = $petowner->id;
                        $category->save();
                    }
                }
                $data =array(
                    'dog' => $req->dogs,
                    'cat' => "",
                    'both' =>"",
                    'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                    'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                );
                return view('PetOwner.SettingUp.SecondIntro',$data);    
            }
            elseif($req->cats == "Cat"){
                $cats = Category::where('category_name','=',$req->cats)->where('petowner_id','=',$petowner->id)->count();
                if(is_null($exists)){
                    $category = new Category;
                    $category->category_name = $req->cats;
                    $category->petowner_id = $petowner->id;
                    $category->save();
                }
                else{
                    if($cats == 0){
                        $category = new Category;
                        $category->category_name = $req->cats;
                        $category->petowner_id = $petowner->id;
                        $category->save();
                    }
                }
                $data =array(
                    'dog' => "",
                    'cat' => $req->cats,
                    'both' =>"",
                    'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                    'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                );
                return view('PetOwner.SettingUp.SecondIntro',$data);   
            }
            else{
                $dog = Category::where('category_name','=','Dog')->where('petowner_id','=',$petowner->id)->count();
                $cat = Category::where('category_name','=','Cat')->where('petowner_id','=',$petowner->id)->count();
                if(is_null($exists)){ 
                    $category = new Category;
                    $category->category_name = 'Dog';
                    $category->petowner_id = $petowner->id;
                    $category->save();

                    $category = new Category;
                    $category->category_name = 'Cat';
                    $category->petowner_id = $petowner->id;
                    $category->save();
                }
                else{
                    if($dog == 0 && $cat == 0){
                        $category = new Category;
                        $category->category_name = 'Dog';
                        $category->petowner_id = $petowner->id;
                        $category->save();

                        $category = new Category;
                        $category->category_name = 'Cat';
                        $category->petowner_id = $petowner->id;
                        $category->save();
                    }
                }    
                $data =array(
                    'dog' => "",
                    'cat' => "",
                    'both' =>$req->boths,
                    'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                    'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                );
                return view('PetOwner.SettingUp.SecondIntro',$data);    
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('status1','Something went wrong pls try again!');
        }
    }

    function DogLifeStage(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function CatLifeStage(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function BothLifeStage(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data); 
    }
    function adddogbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function addcatbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function addbothbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUser{et'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.ThirdIntro',$data);
    }

    function savedogbreed(Request $req){

        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
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
       
        $categ = Category::where('petowner_id',$petowner->id)->count();
        $type1 = Type::where('categ_id',$categ_dog->id)->count();
        $petbreed = Breed::where('categ_id',$categ_dog->id)->count();

        if($categ > 0){
            if($type1 > 0){
                if($petbreed > 0){
                    $petowner->is_welcome_petowner = "1";
                    $petowner->update();
                }
            }
        }
        $data =array(
            'dog' => "Dog",    
            'cat' => "",
            'both' =>"",
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.FourthIntro',$data);

    }

    function savecatbreed(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
        $categ = Category::where('petowner_id',$petowner->id)->count();
        $type2 = Type::where('categ_id',$categ_cat->id)->count();
        $petbreed1 = Breed::where('categ_id',$categ_cat->id)->count();

        if($categ > 0){
            if($type2 > 0){
                if($petbreed1 > 0){
                    $petowner->is_welcome_petowner = "1";
                    $petowner->update();      
                }
            }
        }
        $data =array(
            'dog' => "",    
            'cat' => "Cat",
            'both' =>"",
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.FourthIntro',$data);
    }

    function savebothbreed(Request $req){
        $petowner = PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
        $categ = Category::where('petowner_id',$petowner->id)->count();
        $type1 = Type::where('categ_id',$categ_dog->id)->count();
        $type2 = Type::where('categ_id',$categ_cat->id)->count();
        $petbreed = Breed::where('categ_id',$categ_dog->id)->count();
        $petbreed1 = Breed::where('categ_id',$categ_cat->id)->count();

        if($categ > 0){
            if($type1 > 0 || $type2 > 0){
                if($petbreed > 0 || $petbreed1 > 0){
                    $petowner->is_welcome_petowner = "1";
                    $petowner->update();
                }
            }
        }
        $data =array(
            'dog' => "",    
            'cat' => "",
            'both' =>"Both",
            'LoggedUserInfo'=>PetOwner::where('id','=',session ('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return view('PetOwner.SettingUp.FourthIntro',$data);
    }

    function DogFee(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.welcomepage',$data);
    }

    function CatFee(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.welcomepage',$data);
    }

    function BothFee(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_dog = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $categ_cat = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
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
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.welcomepage',$data);
    }

    function postcreate($id){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal' =>Animals::find($id),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.Post Pet.uploadpost',$data);
    }

    function loadfee ($id){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $checkdog = Category::
                        join('adoption_fee','adoption_fee.categ_id','=','category.id')
                        ->where('adoption_fee.id',$id)
                        ->where('category_name',"Dog")->where('petowner_id',$petowner->id)->count();
        $checkcat = Category::
                        join('adoption_fee','adoption_fee.categ_id','=','category.id')
                        ->where('adoption_fee.id',$id)
                        ->where('category_name',"Cat")->where('petowner_id',$petowner->id)->count();
        if($checkcat > 0){
            $checkcat = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->first();
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
            $checkdog = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->first();
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


    function load_post(){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
       
        $post = Animals::
                   where('animals.post_status','posted')
                -> where('animals.petowner_id', $petowner->id)
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
                            <label>&nbsp &nbsp<i style="color:yellow; font-size:12px" class="fa fa-circle"></i> '.$posts->status.'</label><span><label style="float:right"> posted '.$posted->diffForHumans(). ' &nbsp 
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
                                        $output .= '
                                        <div class="col-sm"> 
                                        <img src="'.asset('uploads/pet-owner/uploaded-photos/Post/'.$pics->imagename).'" width="100%" height="100%" alt="">
                                        </div>
                                        ';
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
     
     function post_pet_save(Request $req, $id){
        $petowner = PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $checkdog = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->count();
        $checkcat = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->count();

        if($checkdog > 0){
            $checkdogs = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->first();
            $dog = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkdogs->id)->count();
            if($dog == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();      
            }
        }
        if($checkcat > 0){
            $checkcats = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->first();
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
         $subtotal = (int)$petowner->TotalCredits;
         $remaining = $subtotal - 1 ;
         $petowner->TotalCredits = $remaining;
         $petowner->update();
     }

     function postupdate($id){
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'animal' =>Animals::find($id),
            'petownercateg' =>PetOwner::all()->where('id',session('LoggedUserPet')),
        );
        return view('PetOwner.Post Pet.updatepost',$data);
    }

    function post_pet_update(Request $req, $id){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $checkdog = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->count();
        $checkcat = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->count();

        if($checkdog > 0){
            $checkdogs = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->first();
            $dog = AdoptionFee::where('id', $req->get('feeid'))->where('categ_id', $checkdogs->id)->count();
            if($dog == 1){
                $fee = Animals::find($id);
                $fee->fee =  $req->get('feeprice');
                $fee->update();       
            }
        }
        if($checkcat > 0){
            $checkcats = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->first();
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
        $destination = 'uploads/pet-owner/uploaded-photos/Post/'.$photo->imagename;
            if(File::exists($destination)){ 
                File::delete($destination);
            }   
        }
        $post->delete();
     }

     function choosesubscription($id){
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'subs'=>Subscription::find($id),
        );
        return view('PetOwner.Subscription.viewtransaction',$data);
    }

     function viewwaitsubscription($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $check = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('petowner_id',$petowner->id)->count();
        if($check > 0){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'subs'=>Subscription::find($id),
            );
            return view('PetOwner.Subscription.viewwaitsubscription',$data);
        }
        if($check == 0){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'subs'=>Subscription::find($id),
                'count'=>SubscriptionTransac::where('sub_id',$id)->where('petowner_id',$petowner->id)->where('status','not approved')->count(),
                'feedback'=>Feedback::where('owner_id',$petowner->id)->where('owner_type',3)->get(),
            );
            return view('PetOwner.Subscription.viewtransaction',$data);
        }
    }

    function waitingsub($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $check = UploadedPhotos::where('sub_id',$id)->where('petowner_id',$petowner->id)->count();
        if($check > 0){
            $subscription = Subscription::find($id);
            $waitsub = new SubscriptionTransac;
            $waitsub->status ="pending";
            $waitsub->sub_id = $id;
            $waitsub->petowner_id = $petowner->id;
            $waitsub->save();
    
            $valid = array();
            $valid = [
                'petowner_name' => $petowner->fname.'(Pet Owner) has sent a proof of payment',
                'continue' => 'please check it now',
            ];
            Admin::find(1)->notify(new Checkproofpetowner($valid));
    
            return redirect()->route('owner.view.wait.subscription',$id)->with('status','Proof of payment has been sent');
        }
        else{
            return redirect()->back()->with('status1','Please upload a photo that will serve as your proof of payment');
        }
    }  
    function cancelsub($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $cancel = SubscriptionTransac::where('status','pending')->where('sub_id',$id)->where('petowner_id',$petowner->id)->first();

        $cancel->status = 'cancelled';
        $cancel->save();
        
        $remove = UploadedPhotos::where('type','subscription')->where('sub_id',$id)->where('petowner_id',$petowner->id)->get();
        foreach($remove as $pic){
            $destination = 'uploads/pet-owner/uploaded-photos/'.$pic->imagename;
            if(File::exists($destination)){ 
              File::delete($destination);
            }   
            $pic->delete();
        }
        return redirect()->back()->with('status','You cancelled your sent subscription proof of payment');
    }

    function adoptionrequests(){
        $data =array( 
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'adopter'=>Adoption::all()->where('status','pending')->where('owner_type',3),
        );
        return view('PetOwner.Adoption.viewrequest',$data);
    }
    function message(Request $req, $id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $message = Adoption::find($id);
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Adoption Application';
        $notif->notif_from = $petowner->fname;
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
        if($check->fee = "FREE"){
            $payment = new AdoptionPayment;
            $payment->animal_id = $check->id;
            $payment->adopter_id = $message->adopter_id;
            $payment->owner_id = $message->owner_id;
            $payment->owner_type = 3;
            $payment->paymentMethod = "None";
            $payment->fee = "FREE";
            $payment->status ="approved";
            $payment->adoption_id = $message->id;
            $payment->save();

            $checking = AdoptionPayment::where('animal_id',$check->id)->where('owner_type',3)->where('owner_id',$petowner->id)->first();

            $receipt = new Receipt;
            $receipt->animal_id = $check->id;
            $receipt->adopter_id = $message->adopter_id;
            $receipt->owner_id = $message->owner_id;
            $receipt->usertype_id = 3;
            $receipt->adoption_id = $id;
            $receipt->payment_id = $checking->id;
            $receipt->status = "pending";
            $receipt->save();
        }

        return redirect()->back()->with('status','Feedback has been sent successfully');
    }

    function error(Request $req, $id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $message = Adoption::find($id);
        $notif = new Adopter_Notif;
        $notif->notif_type = 'Adoption Application';
        $notif->notif_from = $petowner->fname;
        $notif->notif_to = $message->adopter_id;
        $notif->notif_message = ' has disapproved your adoption application';
        $notif->save();
        $message->status = 'disapproved';
        $message->feedback = $req->feedback;
        $message->update();

        return redirect()->back()->with('status','Disapprove feedback has been sent successfully');
    }

    function enlarge($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'images'=>Adoption::find($id),
        );
        return view('PetOwner.Adoption.viewid',$data);
    }

    function request_adoption(){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'shelters'=>AnimalShelter::where('is_welcome_shelter',"1")->where('is_verified_activation',"0")->get(),
        );
        return view('PetOwner.Request.request',$data);
    }
    function shelter_detail($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'shelter'=>AnimalShelter::find($id),
            'countpets'=>Animals::where('shelter_id',$id)->where('status','Available')->count(),
            'countprocess'=>Animals::where('shelter_id',$id)->where('status','Ongoing')->count(),
            'countadopted'=>Animals::where('shelter_id',$id)->where('status','Adopted')->count(),
        );
        return view('PetOwner.Request.detailshelter',$data);
    }
}
