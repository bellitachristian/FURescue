<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalShelter;
use Illuminate\Support\Facades\Hash;
use App\Models\TemporaryStorage;    
use App\Models\ValidDocuments;    
use App\Models\Usertype;
use Illuminate\Support\Collection;
use App\Models\PetOwner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use App\Mail\SignupEmail;
use App\Mail\SignupPetOwner;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    function register(){
        return view('Register.signup');
    }

    function viewregisterPetOwner(){
        return view('Register.petownerSignup');
    }
    function registerPetOwner(Request $req){
          //validation purposes
          try {
            $req->validate([
                'fname'=> 'required',
                'lname'=> 'required',
                'gcash'=>'required|min:11|max:11|',
                'email'=>'required|email|unique:pet_owners|unique:animal_shelters',
                'pay_pal'=>'required|min:11|max:11',
                'password'=>'required|min:7',
                'c_password'=>'required|min:7',
                'address'=>'required',
                'gender'=>'required',
                'contact'=>'required|min:11|max:11'
            ]);
          } catch (\Throwable $th) {
            $temp=TemporaryStorage::all();
            if(is_null($temp)){

            }
            else{
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }
            $req->validate([
                'fname'=> 'required',
                'lname'=> 'required',
                'gcash'=>'required|min:11|max:11|',
                'email'=>'required|email|unique:pet_owners|unique:animal_shelters',
                'pay_pal'=>'required|min:11|max:11',
                'password'=>'required|min:7',
                'c_password'=>'required|min:7',
                'address'=>'required',
                'gender'=>'required',
                'contact'=>'required|min:11|max:11'
            ]);   
          }
          
              
        $fpass = $req->password;
        $pass = $req->c_password;
 
        $usertype = new Usertype;
        if($fpass===$pass){
            $usertype ->usertype ="Pet Owner";
            $usertype -> save();
        }
     
        $petowner = new PetOwner;
        

        if($fpass === $pass){
            $petowner ->fname = $req->fname;
            $petowner ->lname = $req->lname;
            $petowner ->gcash = $req->gcash;
            $petowner ->pay_pal = $req->pay_pal;
            $petowner ->password = Hash::make($req->password);
            $petowner ->address = $req->address;
            $petowner->gender= $req->gender;
            $petowner ->contact = $req->contact;
            $petowner ->email = $req->email;
            $petowner ->usertype_id = $usertype->id;
            $petowner ->verfication_code =sha1(time());

            $petowner ->save();

            $data = array();
            $data = [
                'petowner_name' => $petowner-> fname,
                'verify' => $petowner->verfication_code,
            ];

            Mail::to($req->email)->send(new SignupPetOwner($data));

            $temp = TemporaryStorage::all();
            if(!is_null($temp)){
                foreach($temp as $temporary){
                    $file = $temporary->filename;

                    $docs = new ValidDocuments;
                    $docs->filename = $file;
                    $docs->petowner_id = $petowner->id;
                    $docs->extension  = $temporary->extension;
                    $docs->save();
                }

                $path = public_path('uploads/temp/');
                $files =File::allFiles($path);      
                foreach($files as $file){
                    $doc[] = basename($file);
                }
                foreach($doc as $docs){
                    File::move(public_path('uploads/temp/'.$docs), public_path('uploads/valid-documents/'.$docs));
                }
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }
        
            return redirect()->back()->with('status','Registered Successfully, Please check your email to verify your account');
        }
        else{
            $temp=TemporaryStorage::all();
            if(is_null($temp)){

            }
            else{
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }
            return redirect()->back()->with('status1','Password did not match');
        }
    }

    function registerAnimalShelter(Request $req){
        //validation purposes
        try {
            $req->validate([
                'shelter_name'=> 'required|unique:animal_shelters',
                'g_cash'=>'required|min:11|max:11|',
                'email'=>'required|email|unique:animal_shelters|unique:pet_owners',
                'pay_pal'=>'required|min:11|max:11',
                'password'=>'required|min:7',
                'c_password'=>'required|min:7',
                'address'=>'required',
                'founder_name'=>'required',
                'contact'=>'required|min:11|max:11'
            ]);
        } catch (\Throwable $th) {
            $temp=TemporaryStorage::all();
            if(is_null($temp)){

            }
            else{
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }
            $req->validate([
                'shelter_name'=> 'required|unique:animal_shelters',
                'g_cash'=>'required|min:11|max:11|',
                'email'=>'required|email|unique:animal_shelters|unique:pet_owners',
                'pay_pal'=>'required|min:11|max:11',
                'password'=>'required|min:7',
                'c_password'=>'required|min:7',
                'address'=>'required',
                'founder_name'=>'required',
                'contact'=>'required|min:11|max:11'
            ]);   
        }
       
        //Insertion of Animal-Shelter Data

        $shelter = new AnimalShelter;
        $fpass = $req->password;
        $pass = $req->c_password;

        //Insertion of AnimalShelter in Usertype Table
           
        $usertype = new Usertype;
        if($fpass===$pass){
            $usertype ->usertype ="Animal Shelter";
            $usertype -> save();
        }

        if($fpass === $pass){
            $shelter ->shelter_name = $req->shelter_name;
            $shelter ->g_cash = $req->g_cash;
            $shelter ->email = $req->email;
            $shelter ->pay_pal = $req->pay_pal;
            $shelter ->password = Hash::make($req->password);
            $shelter ->address = $req->address;
            $shelter ->founder_name = $req->founder_name;
            $shelter ->contact = $req->contact;
            $shelter ->usertype_id = $usertype->id; 
            $shelter ->verfication_code =sha1(time());
            $shelter ->save();
            
            $data = array();
            $data = [
                'shelter_name' => $shelter->shelter_name,
                'verify' => $shelter->verfication_code,
            ];

            Mail::to($req->email)->send(new SignupEmail($data));

            $temp = TemporaryStorage::all();

            if(!is_null($temp)){
                foreach($temp as $temporary){
                    $file = $temporary->filename;

                    $docs = new ValidDocuments;
                    $docs->filename = $file;
                    $docs->shelter_id = $shelter->id;
                    $docs->extension  = $temporary->extension;
                    $docs->save();
                }

                $path = public_path('uploads/temp/');
                $files =File::allFiles($path);      
                foreach($files as $file){
                    $doc[] = basename($file);
                }
                foreach($doc as $docs){
                    File::move(public_path('uploads/temp/'.$docs), public_path('uploads/valid-documents/'.$docs));
                }
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }

            return redirect()->back()->with('status','Registered Successfully, Please check your email to verify your account');
        }
        else{
            $temp=TemporaryStorage::all();
            if(is_null($temp)){

            }
            else{
                TemporaryStorage::truncate();
                $file = new Filesystem;
                $file->cleanDirectory('uploads/temp');
            }
            return redirect()->back()->with('status1','Password did not match');
        }
    }
    function verifyUser(){
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $shelter_verify = AnimalShelter::where(['verfication_code'=> $verification_code])->first();
        
        if($shelter_verify!=null){
            $shelter_verify->is_verified_account ='1';
            $shelter_verify->save();
            return redirect('/User/login')->with('stat','Verified Successfully! You can now login'); 
        }

    }
    function verifyPetUser(){
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $petowner_verify = PetOwner::where(['verfication_code'=> $verification_code])->first();
        
        if($petowner_verify!=null){
            $petowner_verify->is_verified_account ='1';
            $petowner_verify->save();
            return redirect('/User/login')->with('stat','Verified Successfully! You can now login'); 
        }

    }
}
