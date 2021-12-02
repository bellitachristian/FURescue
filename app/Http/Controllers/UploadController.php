<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;
use App\Models\AnimalShelter;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\PetOwner;
use App\Models\Animals;
use App\Models\UploadedPhotos;

class UploadController extends Controller
{
    function store(Request $req){  
        $image = array();
        if($files = $req->file('images')){
            foreach($files as $file){
                $image_name = md5(rand(1000,10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full = $image_name.'.'.$ext;
                $upload_path = 'uploads/temp/';
                $image_url= $image_full;
                $file->move($upload_path, $image_full);
                $image[] = $image_url;
            }
        }   
        TemporaryStorage::insert([
            'filename' => implode('|', $image),
            'extension'=> $ext, 
            'status'=> '1'
        ]);
    }

    function ownercredentials(Request $req){  
        $image = array();
        if($files = $req->file('images')){
            foreach($files as $file){
                $image_name = md5(rand(1000,10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full = $image_name.'.'.$ext;
                $upload_path = 'uploads/temp/';
                $image_url= $image_full;
                $file->move($upload_path, $image_full);
                $image[] = $image_url;
            }
        }   
        TemporaryStorage::insert([
            'filename' => implode('|', $image),
            'extension'=> $ext, 
            'status'=> '1'
        ]);
    }

    function view(){
        return view('test');
    }
    function upload(Request $req){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();

        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/animal-shelter/uploaded-photos/', $imageName);

            $imageupload = new UploadedPhotos;
            $imageupload->imagename = $imageName;
            $imageupload->shelter_id = $shelter->id;
            $imageupload->type = 'profile';
            $imageupload->save();
        }            

    }

    function upload_petowner(Request $req){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();

        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/pet-owner/uploaded-photos/', $imageName);

            $imageupload = new UploadedPhotos;
            $imageupload->imagename = $imageName;
            $imageupload->petowner_id = $petowner->id;
            $imageupload->type = 'profile';
            $imageupload->save();
        }            

    }
    
    function fetch()
    {
     $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
     $multiple = DB::select("select *from uploaded_photos  where shelter_id ='$shelter->id' and type='profile'");   
     $output = '<div class="row">';
     foreach($multiple as $image)
     {
      $output .= '
      <div class="col-md-3" style="margin-bottom:16px;" align="center">
                <img src="'.asset('uploads/animal-shelter/uploaded-photos/' . $image->imagename).'" class="img-thumbnail" width="200" height="150" style="height:200px;" />
                <button style="margin-top:1%" type="button" class="btn btn-secondary remove_image" id="'.$image->imagename.'">Remove</button>
            </div>
      ';
     }
     $output .= '</div>';
     echo $output;
    }

    function fetchpetownerphotos(){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $multiple = DB::select("select *from uploaded_photos  where petowner_id ='$petowner->id'and type='profile'");   
        $output = '<div class="row">';
        foreach($multiple as $image)
        {
         $output .= '
         <div class="col-md-3" style="margin-bottom:16px;" align="center">
                <img src="'.asset('uploads/pet-owner/uploaded-photos/' . $image->imagename).'" class="img-thumbnail" width="200" height="150" style="height:200px;" />
                <button style="margin-top:1%" type="button" class="btn btn-secondary remove_image" id="'.$image->imagename.'">Remove</button>
        </div>
         ';
        }
        $output .= '</div>';
        echo $output; 
    }

    function deletepetownerphoto(Request $req){
        $imagephoto = $req->get('name');
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/pet-owner/uploaded-photos/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }
    }

    function delete(Request $req)
    {
        $imagephoto = $req->get('name');
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/animal-shelter/uploaded-photos/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }
    }

    function deletepostphotos(Request $req)
    {
        $imagephoto= $req->get('name');
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/animal-shelter/uploaded-photos/Post/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }   
    }

    function deletepostphotos_petowner(Request $req)
    {
        $imagephoto = $req->get('name');
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/pet-owner/uploaded-photos/Post/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }   
    }

    function fetchpostphotos($id)
    {
     $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
     $checkanimal = Animals::where('id',$id)->where('ownertype','Animal Shelter')->count();
     if($checkanimal == 0){
        $multiple = UploadedPhotos::all()->where('animal_id',$id);   
        $output = '<div class="row">';
        foreach($multiple as $image)
        { 
         $output .= '
         <div class="col-md-3" style="margin-bottom:16px;" align="center">
                   <div style="display:flex">
                       <img style="width:200px; height:150px; padding:3px" src="'.asset('uploads/animal-shelter/uploaded-photos/Post/' . $image->imagename).'"/>
                       <button style="margin-top:1%" type="button" class="btn btn-secondary remove_image" id="'.$image->imagename.'">Remove</button>
                   </div>
               </div>
         ';
        }
        $output .= '</div>';
        echo $output;
     }
     else{
        $multiple = UploadedPhotos::all()->where('animal_id',$id);   
        $output = '<div class="row">';
        foreach($multiple as $image)
        {
         $output .= '
         <div class="col-md-3" style="margin-bottom:16px;" align="center">
                   <div style="display:flex">
                       <img style="width:200px; height:150px; padding:3px" src="'.asset('uploads/pet-owner/uploaded-photos/Post/' . $image->imagename).'"/>
                       <button style="margin-top:1%" type="button" class="btn btn-secondary remove_image" id="'.$image->imagename.'">Remove</button>
                   </div>
               </div>
         ';
        }
        $output .= '</div>';
        echo $output;
        }
    }
    function fetchpostphotos_petowner($id)
    {
     $multiple = UploadedPhotos::all()->where('animal_id',$id);   
     $output = '<div class="row">';
     foreach($multiple as $image)
     {
      $output .= '
      <div class="col-md-3" style="margin-bottom:16px;" align="center">
                <div style="display:flex">
                    <img style="width:200px; height:150px; padding:3px" src="'.asset('uploads/pet-owner/uploaded-photos/Post/' . $image->imagename).'"/>
                    <button style="margin-top:1%" type="button" class="btn btn-secondary remove_image" id="'.$image->imagename.'">Remove</button>
                </div>
            </div>
      ';
     }
     $output .= '</div>';
     echo $output;
    }

    function uploadphotopost(Request $req,$id){
        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;
        $name = array();

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/animal-shelter/uploaded-photos/Post', $imageName);
            $name[] = $imageName;
            $imageupload = new UploadedPhotos; 
            $imageupload->imagename= $imageName;
            $imageupload->animal_id = $id;
            $imageupload->save();  
        }        
    }

    function uploadphotopost_petowner(Request $req,$id){
        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;
        $name = array();

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/pet-owner/uploaded-photos/Post', $imageName);
            $name[] = $imageName;
            $imageupload = new UploadedPhotos; 
            $imageupload->imagename= $imageName;
            $imageupload->animal_id = $id;
            $imageupload->save();  
        }        
    }

    function uploadproof(Request $req,$id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $sub =Subscription::Find($id);

        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/animal-shelter/uploaded-photos/', $imageName);

            $imageupload = new UploadedPhotos;
            $imageupload->imagename = $imageName;
            $imageupload->shelter_id = $shelter->id;
            $imageupload->sub_id = $sub->id;
            $imageupload->type = 'subscription';
            $imageupload->save();
        }            
    }

    function uploadproofpetowner(Request $req,$id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $sub =Subscription::Find($id);

        $image = $req->file('file');
        $photo = array();
        $photo[] = $image;

        foreach ($photo as $pics) {
            $image_name = md5(rand(1000,10000));
            $ext = strtolower($image->getClientOriginalExtension());
            $imageName = $image_name.'.' .$ext;
    
            $image->move('uploads/pet-owner/uploaded-photos/', $imageName);

            $imageupload = new UploadedPhotos;
            $imageupload->imagename = $imageName;
            $imageupload->petowner_id = $petowner->id;
            $imageupload->sub_id = $sub->id;
            $imageupload->type = 'subscription';
            $imageupload->save();
        }            
    }

    function loadproof($id,$sub_id)
    {
     $multiple = UploadedPhotos::all()->where('shelter_id',$id)->where('sub_id',$sub_id);   
     foreach($multiple as $image)
     {
      $output = '
      <div class="col-md" style="margin-bottom:16px; text-align:center">
                <div style="display:flex;">
                    <div class="col-md">
                        <img style="width:170px; height:150px; padding:3px" src="'.asset('uploads/animal-shelter/uploaded-photos/' . $image->imagename).'"/>
                    </div>
                </div>
                <i style="margin-top:1%" type="button" class="fa fa-trash remove_image" id="'.$image->imagename.'"></i>
            </div>
      ';
      echo $output;
     }
    }
    function loadproofpetowner($id,$sub_id)
    {
     $multiple = UploadedPhotos::all()->where('petowner_id',$id)->where('sub_id',$sub_id);   
     foreach($multiple as $image)
     {
      $output = '
      <div class="col-md" style="margin-bottom:16px; text-align:center">
                <div style="display:flex;">
                    <div class="col-md">
                        <img style="width:170px; height:150px; padding:3px" src="'.asset('uploads/pet-owner/uploaded-photos/' . $image->imagename).'"/>
                    </div>
                </div>
                <i style="margin-top:1%" type="button" class="fa fa-trash remove_image" id="'.$image->imagename.'"></i>
            </div>
      ';
      echo $output;
     }
    }
    function deleteproof(Request $req)
    {
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/animal-shelter/uploaded-photos/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }   
    }

    function deleteproofpetowner(Request $req)
    {
        DB::table('uploaded_photos')->where('imagename', $req->get('name'))->delete();
        $destination = 'uploads/pet-owner/uploaded-photos/'.$req->get('name');
            if(File::exists($destination)){ 
                File::delete($destination);
            }   
    }

    function shelterphoto($id){
        $shelter =AnimalShelter::find($id);
        $check =UploadedPhotos::where('shelter_id',$shelter->id)->where('type','profile')->count();
        if($check > 0){
            $multiple = DB::select("select *from uploaded_photos  where shelter_id ='$shelter->id' and type='profile'");   
            $output = '<div class="row">';
            foreach($multiple as $image)
            {
             $output .= '
             <div class="col-md-3" style="margin-bottom:16px;" align="center">
                       <img src="'.asset('uploads/animal-shelter/uploaded-photos/'.$image->imagename).'"  width="200" height="150" style="height:200px;" />
                   </div>
             ';
            }
            $output .= '</div>';
            echo $output;
        }else{
            $output = ' <p class="alert alert-danger">No photos</p>';
            echo $output;
        }
        
    }
    function petownerphoto($id){
        $petowner =PetOwner::find($id);
        $check =UploadedPhotos::where('petowner_id',$petowner->id)->where('type','profile')->count();
        if($check > 0){
            $multiple = DB::select("select *from uploaded_photos  where petowner_id ='$petowner->id' and type='profile'");   
            $output = '<div class="row">';
            foreach($multiple as $image)
            {
             $output .= '
             <div class="col-md" style="margin-bottom:16px;" align="center">
                       <img src="'.asset('uploads/pet-owner/uploaded-photos/'.$image->imagename).'"  width="200" height="150" style="height:200px;" />
                   </div>
             ';
            }
            $output .= '</div>';
            echo $output;
        }else{
            $output = ' <p class="alert alert-danger">No photos</p>';
            echo $output;
        }
        
    }
    function animalphoto($id){
        $check =UploadedPhotos::where('animal_id',$id)->count();
        if($check > 0){
            $multiple = DB::select("select *from uploaded_photos  where animal_id ='$id'");   
            $output = '<div class="row">';
            foreach($multiple as $image)
            {
             $output .= '
             <div class="col-md" style="margin-bottom:16px;" align="center">
                       <img src="'.asset('uploads/pet-owner/uploaded-photos/Post/'.$image->imagename).'"  width="200" height="150" style="height:200px;" />
                   </div>
             ';
            }
            $output .= '</div>';
            echo $output;
        }else{
            $output = ' <p class="alert alert-danger">No photos</p>';
            echo $output;
        }
        
    }
}
