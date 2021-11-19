<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalShelter;
use App\Models\PetOwner;
use App\Models\Admin;
use App\Models\Usertype;
use App\Models\Category;
use App\Notifications\ApproveRejectPetOwnerNotif;
use App\Notifications\ApproveRejectShelterNotif;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    function login(){
        return view('User.login');
    }

    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/User/login')->with('stat','Successfully logged out!');
        }
        if(session()->has('LoggedUserPet')){
            session()->pull('LoggedUserPet');
            return redirect('/User/login')->with('stat','Successfully logged out!');
        }
        if(session()->has('LoggedUserAdmin')){
            session()->pull('LoggedUserAdmin');
            return redirect('/User/login')->with('stat','Successfully logged out!');
        }
    }   
    function autologout($shelter_id){
        if(session('LoggedUser') == $shelter_id){
            session()->pull('LoggedUser');
            return redirect('/User/login')->with('stat','Your account has been approved!');
        }
       
    }
    
    function autologoutpetowner($petowner_id){
        if(session('LoggedUserPet') == $petowner_id){
            session()->pull('LoggedUserPet');
            return redirect('/User/login')->with('stat','Your account has been approved!');
        }
    }

    function check(Request $req){
        //validation and checking of inputs

        $req->validate([
            'email'=>'required|email',
            'password'=>'required|min:7'
        ]);
        
        $admin = Admin::where('email','=',$req->email)->first();
        $pet = PetOwner::where('email','=',$req->email)->first();
        $shelter =AnimalShelter::where('email','=',$req->email)->first();
        $userinfo = Usertype::first(); 

        if($admin){
            //check password
            if(Hash::check($req->password,$admin->password)){
            $req->session()->put("LoggedUserAdmin",$admin->id);
            return redirect()->route('admindash');
            }
            else{
                return back()->with('status1','Incorrect Password');
            }
        }
        if($shelter){
            $check = Hash::check($req->password,$shelter->password);
            if($check == 'true'){
                if(Hash::check($req->password,$shelter->password)){
                    if($shelter->is_verified_account == "1" && $shelter->is_verified_shelter == "1"){
                        if($shelter->is_welcome_shelter == "1"){
                            if($shelter->is_verified_activation =="0"){
                                $req->session()->put("LoggedUser",$shelter->id);
                                return redirect('/dashboard');  
                            }
                            else{
                                $req->session()->put("LoggedUser",$shelter->id);
                                $data =array(
                                    'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                                    'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
                                );
                               return view('AnimalShelter.Deactivation.deactpage',$data);  //adtu sa view for reactivation of account
                            }
                        }
                        else{
                            $req->session()->put("LoggedUser",$shelter->id);
                            $data =array(
                                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
                            );
                           return view('AnimalShelter.SettingUp.Intro',$data); // go to intro page, welcoming shelter (filtering)
                        }
                    }  
                    else if($shelter->is_verified_account == "1" && $shelter->is_verified_shelter == "0"){
                        if($shelter->is_verified_activation =="0"){
                            $req->session()->put("LoggedUser",$shelter->id);
                          
                            $data = array();
                            $data = [
                                'shelter_name' => $shelter->shelter_name,
                                'approval'=>"is waiting for your approval"
                            ];
                
                            $category = Category::all();
                            Admin::find(1)->notify( new ApproveRejectShelterNotif($data));
                            return redirect('/tempdashboard'); //view for wait of approval of admin 
                        }
                    } 
                    else if($shelter->is_verified_account == "1" && $shelter->is_verified_shelter == "2"){ //which means rejected
                        if($shelter->is_verified_activation =="0"){
                            $req->session()->put("LoggedUser",$shelter->id);
                            //return redirect('/dashboard'); automatically logs out(give note if admin rejects, your account will be automatically removed in the system)
                        }
                    }    
                    else{
                        return back()->with('status1','It seems like your account is not verified, please check your email');
                    }
                }
                else{
                    return back()->with('status1','Incorrect Password');
                }
            }
            else{
                return redirect()->back()->with('status1','We do not recognize your email address');       
            }
           
        }  
        if($pet){
            if(Hash::check($req->password,$pet->password)){
                if($pet->is_verified_account == "1" && $pet->is_verified_petowner == "1"){
                    if($pet->is_welcome_petowner == "1"){
                        if($pet->is_verified_activation =="0"){
                            $req->session()->put("LoggedUserPet",$pet->id);
                            $data =array(
                                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                            );
                           return redirect('/pet-owner/dashboard'); 
                        }
                        else{
                            $req->session()->put("LoggedUserPet",$pet->id);
                            $data =array(
                                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                            );
                            return view('PetOwner.Deactivation.deactpage',$data);  //adtu sa view for reactivation of account
                        }
                    }
                    else{
                        $req->session()->put("LoggedUserPet",$pet->id);
                        $data = array(
                            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
                        );
                        return view('PetOwner.SettingUp.Intro',$data); // go to intro page, welcoming petowner (filtering)
                    }
            }  
            else if($pet->is_verified_account == "1" && $pet->is_verified_petowner == "0"){
                if($pet->is_verified_activation =="0"){
                    $req->session()->put("LoggedUserPet",$pet->id);

                    $data = array();
                    $data = [
                        'petowner_name' => $pet->fname. "(Pet Owner)",
                        'approval'=>"is waiting for your approval"
                    ];
        
                    $category = Category::all();
                    Admin::find(1)->notify( new ApproveRejectPetOwnerNotif($data));
                    return redirect('/tempdashboard/petowner'); //view for wait of approval of admin 
                }
            } 
            else if($pet->is_verified_account == "1" && $pet->is_verified_petowner == "2"){ //which means rejected
                if($pet->is_verified_activation =="0"){
                    $req->session()->put("LoggedUserPet",$pet->id);
                    //return redirect('/dashboard'); automatically logs out(give note if admin rejects, your account will be automatically removed in the system)
                }
            }    
            else{
                return back()->with('status1','It seems like your account is not verified, please check your email');
            }
        }
        else{
            return back()->with('status1','Incorrect Password');
        }
    }
    else{
        return redirect()->back()->with('status1','We do not recognize your email address');       
    }
    }
}
