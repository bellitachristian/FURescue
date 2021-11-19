<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AnimalShelter;
use App\Models\PetOwner;
use Illuminate\Support\Facades\DB;
use App\Models\Breed;
use App\Models\AdoptionFee;
use App\Models\Vaccine;
use App\Models\Deworm;
use App\Models\Type;

class DropDownController extends Controller
{
    
    function get_fee(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $fee = AdoptionFee::all()->where('categ_id',$req->categ_id)->pluck('type','id','cat_fee','dog_fee');
        return response()->json($fee); 
    }

    function get_fee_petowner(Request $req){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $fee = AdoptionFee::all()->where('categ_id',$req->categ_id)->pluck('type','id','cat_fee','dog_fee');
        return response()->json($fee); 
    }

    function getbreed(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $breed = Breed::all()->where('categ_id',$req->categ_id)->pluck('breed_name','id');
        return response()->json($breed);   
    }

    function getbreed_petowner(Request $req){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $breed = Breed::all()->where('categ_id',$req->categ_id)->pluck('breed_name','id');
        return response()->json($breed);   
    }

    function vaccinefetch(Request $req)
    {
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $vaccine = Vaccine::where('id',$req->get('id'))->first();
        $output = '<div class="row">';  
         $output .= '
            <button class="btn btn-warning" style="padding:10px;color:black;margin-right:10px">Vaccine Name: '.$vaccine->vac_name.'</button> <span><button class="btn btn-secondary" style="padding:10px">Vaccine Description: '.$vaccine->vac_desc.'</button></span>
         ';
        $output .= '</div>';
        echo $output;
       
    }
    function dewormfetch(Request $req)
    {
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $deworm = Deworm::where('id',$req->get('id'))->first();
        $output = '<div class="row">';  
         $output .= '
            <button class="btn btn-warning" style="padding:10px;color:black;margin-right:10px">Deworm Name: '.$deworm->dew_name.'</button> <span><button class="btn btn-secondary" style="padding:10px">Deworm Description: '.$deworm->dew_desc.'</button></span>
         ';
        $output .= '</div>';
        echo $output;
       
    }
    function gettype(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $category = Category::where('id',$req->categ_id)->where('shelter_id',$shelter->id)->pluck('category_name')->first();

        if($req->get('radiobtn') == "1"){ //years old
            if($category == "Dog"){
                    //dog
                if($req->get('age') <= 2){
                    $adolescent = Type::where('type_name','Adolescent(6months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adolescent);   
                }
                elseif($req->get('age') >= 3 && $req->get('age') <= 6){
                    $adult = Type::where('type_name','Adult(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adult);   
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 13){
                    $senior = Type::where('type_name','Senior(7-13years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);   
                }
            }
            if($category == "Cat")
            {
                if($req->get('age') <= 2) //cat
                {
                    $junior = Type::where('type_name','Junior(7months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($junior);   
                }
                elseif($req->get('age') >= 3 && $req->get('age') <= 6){
                    $prime = Type::where('type_name','Prime(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($prime);  
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 10){
                    $mature = Type::where('type_name','Mature(7-10years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($mature);  
                }
                elseif($req->get('age') >= 11 && $req->get('age') <= 20){
                    $senior = Type::where('type_name','Senior(11-14years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);  
                } 
            }
          
        }
        if($req->get('radiobtn') == "2"){ //years old
            if($category == "Dog"){
                    //dog
                if($req->get('age') >= 0 && $req->get('age') <= 5){
                    $puppy = Type::where('type_name','Puppy(0-5months old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($puppy); 
                }
                elseif($req->get('age') >= 6 && $req->get('age') <= 24){
                    $adolescent = Type::where('type_name','Adolescent(6months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adolescent);   
                }
                elseif($req->get('age') >= 36 && $req->get('age') <= 72){
                    $adult = Type::where('type_name','Adult(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adult);   
                }
                elseif($req->get('age') >= 84 && $req->get('age') <= 156){
                    $senior = Type::where('type_name','Senior(7-13years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);   
                }
            }
            if($category == "Cat")
            {
                //cat
                if($req->get('age') >= 0 && $req->get('age') <= 6){
                    $kitten = Type::where('type_name','Kitten(0-6months old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($kitten);
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 24) 
                {
                    $junior = Type::where('type_name','Junior(7months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($junior);   
                }
                elseif($req->get('age') >= 36 && $req->get('age') <= 72){
                    $prime = Type::where('type_name','Prime(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($prime);  
                }
                elseif($req->get('age') >= 84 && $req->get('age') <= 120){
                    $mature = Type::where('type_name','Mature(7-10years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($mature);  
                }
                elseif($req->get('age') >= 132 && $req->get('age') <= 168){
                    $senior = Type::where('type_name','Senior(11-14years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);  
                } 
            }
          
        }
    }

    function gettype_petowner(Request $req){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $category = Category::where('id',$req->categ_id)->where('petowner_id',$petowner->id)->pluck('category_name')->first();

        if($req->get('radiobtn') == "1"){ //years old
            if($category == "Dog"){
                    //dog
                if($req->get('age') <= 2){
                    $adolescent = Type::where('type_name','Adolescent(6months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adolescent);   
                }
                elseif($req->get('age') >= 3 && $req->get('age') <= 6){
                    $adult = Type::where('type_name','Adult(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adult);   
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 13){
                    $senior = Type::where('type_name','Senior(7-13years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);   
                }
            }
            if($category == "Cat")
            {
                if($req->get('age') <= 2) //cat
                {
                    $junior = Type::where('type_name','Junior(7months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($junior);   
                }
                elseif($req->get('age') >= 3 && $req->get('age') <= 6){
                    $prime = Type::where('type_name','Prime(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($prime);  
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 10){
                    $mature = Type::where('type_name','Mature(7-10years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($mature);  
                }
                elseif($req->get('age') >= 11 && $req->get('age') <= 20){
                    $senior = Type::where('type_name','Senior(11-14years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);  
                } 
            }
          
        }
        if($req->get('radiobtn') == "2"){ //years old
            if($category == "Dog"){
                    //dog
                if($req->get('age') >= 0 && $req->get('age') <= 5){
                    $puppy = Type::where('type_name','Puppy(0-5months old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($puppy); 
                }
                elseif($req->get('age') >= 6 && $req->get('age') <= 24){
                    $adolescent = Type::where('type_name','Adolescent(6months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adolescent);   
                }
                elseif($req->get('age') >= 36 && $req->get('age') <= 72){
                    $adult = Type::where('type_name','Adult(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($adult);   
                }
                elseif($req->get('age') >= 84 && $req->get('age') <= 156){
                    $senior = Type::where('type_name','Senior(7-13years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);   
                }
            }
            if($category == "Cat")
            {
                //cat
                if($req->get('age') >= 0 && $req->get('age') <= 6){
                    $kitten = Type::where('type_name','Kitten(0-6months old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($kitten);
                }
                elseif($req->get('age') >= 7 && $req->get('age') <= 24) 
                {
                    $junior = Type::where('type_name','Junior(7months-2years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($junior);   
                }
                elseif($req->get('age') >= 36 && $req->get('age') <= 72){
                    $prime = Type::where('type_name','Prime(3-6years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($prime);  
                }
                elseif($req->get('age') >= 84 && $req->get('age') <= 120){
                    $mature = Type::where('type_name','Mature(7-10years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($mature);  
                }
                elseif($req->get('age') >= 132 && $req->get('age') <= 168){
                    $senior = Type::where('type_name','Senior(11-14years old)')->where('categ_id',$req->categ_id)->pluck('type_name','id');
                    return response()->json($senior);  
                } 
            }
          
        }
    }


    function selection_view()
    {
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
        );
        return view('AnimalShelter.Custom-Selection.custom_main',$data);
    }

    function selection_view_petowner()
    {
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
        );
        return view('PetOwner.Custom-Selection.custom_main',$data);
    }

    function selection_category(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
        );
        return view('AnimalShelter.Custom-Selection.Category',$data);
    }

    function selection_category_petowner(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
        );
        return view('PetOwner.Custom-Selection.Category',$data);
    }

    function load_category_petowner(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $multiple = DB::select("select *from category  where petowner_id ='$petowner->id'");  
        $checkdog = Category::all()->whereNotIn('category_name','Dog')->where('petowner_id',$petowner->id)->count();
        $checkcat = Category::all()->whereNotIn('category_name','Cat')->where('petowner_id',$petowner->id)->count();
        $checkboth = Category::all()->where('petowner_id',$petowner->id)->count();
        $output = ' <main style ="margin-top:30px" class="grid">';
        foreach($multiple as $category)
        {
            if($checkdog == 1 && $checkcat == 0){
                $output .= '        
                    <article>
                    <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>Cats</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                    <div class="text">  
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>Dogs</h3>
                            <button id="Dog" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article> 
                 '; 
            }
            if($checkcat == 1 && $checkdog == 0){
                $output .= '        
                <article>
                    <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                    <div class="text">  
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>Dogs</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                </article> 

                <article>
                <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                <div class="text">
                        <input type="text" hidden  name="cats" value="Cat">
                        <h3>Cats</h3>
                        <button id="Cat" class="btn btn-danger apply">APPLY</button>
                </div>
                </article>  
                 
                 ';
            }
            elseif($checkboth == 2){
                if($category->category_name == "Dog"){
                    $output .= '        
                    <article>
                        <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                        <div class="text">  
                                <input type="text" hidden  name="dogs" value="Dog">
                                <h3>Dogs</h3>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                    </article> 
                     ';
                }
                elseif($category->category_name == "Cat"){
                    $output .= '
                    <article>
                    <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>Cats</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  
             
                    ';
                }
            }
           
        }
        $output .= '</div>';
        echo $output;
    }

    function load_category(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $multiple = DB::select("select *from category  where shelter_id ='$shelter->id'");  
        $checkdog = Category::all()->whereNotIn('category_name','Dog')->where('shelter_id',$shelter->id)->count();
        $checkcat = Category::all()->whereNotIn('category_name','Cat')->where('shelter_id',$shelter->id)->count();
        $checkboth = Category::all()->where('shelter_id',$shelter->id)->count();
        $output = ' <main style ="margin-top:30px" class="grid">';
        foreach($multiple as $category)
        {
            if($checkdog == 1 && $checkcat == 0){
                $output .= '        
                    <article>
                    <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>Cats</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                    <div class="text">  
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>Dogs</h3>
                            <button id="Dog" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article> 
                 '; 
            }
            if($checkcat == 1 && $checkdog == 0){
                $output .= '        
                <article>
                    <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                    <div class="text">  
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>Dogs</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                </article> 

                <article>
                <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                <div class="text">
                        <input type="text" hidden  name="cats" value="Cat">
                        <h3>Cats</h3>
                        <button id="Cat" class="btn btn-danger apply">APPLY</button>
                </div>
                </article>  
                 
                 ';
            }
            elseif($checkboth == 2){
                if($category->category_name == "Dog"){
                    $output .= '        
                    <article>
                        <img src="http://iroislandrescue.org/wp-content/uploads/2021/05/aspins-scaled.jpg" height="300" width="400" alt="Dog">
                        <div class="text">  
                                <input type="text" hidden  name="dogs" value="Dog">
                                <h3>Dogs</h3>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                    </article> 
                     ';
                }
                elseif($category->category_name == "Cat"){
                    $output .= '
                    <article>
                    <img src="https://i.pinimg.com/originals/69/9f/e8/699fe836279adb96aee682e5b80bffbc.jpg"  height="300" width="400" alt="Dog">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>Cats</h3>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  
             
                    ';
                }
            }
           
        }
        $output .= '</div>';
        echo $output;
    }

    function selection_adoption(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $data =array(
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
        );
        return view('AnimalShelter.Custom-Selection.AdoptionFee',$data);
    }

    function selection_adoption_petowner(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $data =array(
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
        );
        return view('PetOwner.Custom-Selection.AdoptionFee',$data);
    }

    function load_adoption_petowner(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $checkdog = Category::all()->where('category_name','Dog')->where('petowner_id',$petowner->id)->count();
        $checkcat = Category::all()->where('category_name','Cat')->where('petowner_id',$petowner->id)->count();
        $checkboth = Category::all()->where('petowner_id',$petowner->id)->count();
        if($checkcat > 0 && $checkdog == 0){
            $cat = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->first();
            $multiple = DB::select("select *from adoption_fee  where categ_id ='$cat->id'");  
            $checkfree = AdoptionFee::where('type','Free')->where('categ_id',$cat->id)->count();
            $checkcustom = AdoptionFee::where('type','Custom')->where('categ_id',$cat->id)->count();
            $checkdefault = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->count();

            $output = ' <main style ="margin-top:30px" class="grid">';

                if($checkfree > 0 && $checkcustom == 0 && $checkdefault == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '       
                        <article> 
                        <img src="junior.png" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="cats" value="Cat">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="prime.jpg" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
               
                        <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                        <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                        <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                        </div>
                        </article> 

                        <article>
                        <img src="mature.jpg" style="height:300px"   alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfree == 0 && $checkcustom > 0 && $checkdefault == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="junior.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="prime.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    
                    <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                    </div>
                    </article> 

                    <article>
                    <img src="mature.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree == 0 && $checkcustom == 0 && $checkdefault > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="junior.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="prime.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    
                    <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="applied" class="btn btn-danger changefee">CHANGE FEE</button>
                    </form>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="mature.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="custom" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree > 0 && $checkcustom > 0 && $checkdefault > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://www.affinity-petcare.com/advance/sites/default/files/img/edv_esterilizadojunior@2x.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://cdn.shopify.com/s/files/1/1788/4235/files/PPF-Stages-of-a-Cats-Life-blog-Prime_grande.jpg?v=1522425877" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <input type="number" class="form-control" id="catfee" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="applied" class="btn btn-danger changefee">CHANGE FEE</button>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://meowcatrescue.org/wp-content/uploads/2020/09/Waffles-Resized.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     '; 
                    
                }
            $output .= '</div>';
            echo $output;
        }
        elseif($checkdog > 0 && $checkcat == 0){
            $dog = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->first();
            $checkfree = AdoptionFee::where('type','Free')->where('categ_id',$dog->id)->count();
            $checkcustom = AdoptionFee::where('type','Custom')->where('categ_id',$dog->id)->count();
            $checkdefault = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->count();

            $output = ' <main style ="margin-top:30px" class="grid">'; 
                if($checkfree > 0 && $checkcustom == 0 && $checkdefault == 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                        <article> 
                        <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="dogs" value="Dog">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
                        <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                        <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                        <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                        </div>
                        </article> 

                        <article>
                        <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfree == 0 && $checkcustom > 0 && $checkdefault == 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    </form>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree == 0 && $checkcustom == 0 && $checkdefault > 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="applied" type="submit"  class="btn btn-danger changefee">CHANGE FEE</button>
                    
                    <button id="Dog" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                    <button id="Dog" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree > 0 && $checkcustom > 0 && $checkdefault > 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="dogfee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="applied" type="submit" class="btn btn-danger changefee">CHANGE FEE</button>
                
                    <button id="Dog" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                    <button id="Dog" class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
            $output .= '</div>';
            echo $output;
        }
        elseif($checkboth == 2){
            $cat = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->first();
            $dog = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->first();
            $checkfreecat = AdoptionFee::where('type','Free')->where('categ_id',$cat->id)->count();
            $checkcustomcat = AdoptionFee::where('type','Custom')->where('categ_id',$cat->id)->count();
            $checkdefaultcat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->count();
            $checkfreedog = AdoptionFee::where('type','Free')->where('categ_id',$dog->id)->count();
            $checkcustomdog = AdoptionFee::where('type','Custom')->where('categ_id',$dog->id)->count();
            $checkdefaultdog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->count();

            
            $output = ' <main style ="margin-top:30px" class="grid">';
                if($checkfreecat > 0 && $checkfreedog > 0 && $checkcustomcat == 0 && $checkcustomdog == 0 && $checkdefaultcat == 0 && $checkdefaultdog == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                        <article> 
                        <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="cats" value="Cat">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                                <button  class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
                        <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                        <input type="number" class="form-control" id="fees" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">  
                        <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>                     
                        <button id="default" type="submit" class="btn btn-danger submit">APPLY</button>
                        </div>
                        </article> 

                        <article>
                        <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfreecat == 0 && $checkfreedog == 0 && $checkcustomcat > 0 && $checkcustomdog > 0 && $checkdefaultcat == 0 && $checkdefaultdog == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <form action="" method = "POST">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="fees" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">  
                    <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>                     
                    <button id="default" type="submit" class="btn btn-danger submit">APPLY</button>
                    </form>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="both" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                 '; 
                }
                if($checkfreecat == 0 && $checkfreedog == 0 && $checkcustomcat  == 0 && $checkcustomdog == 0 && $checkdefaultcat > 0 && $checkdefaultdog > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <form action="" method="POST">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>
                    <button id="both" class="btn btn-danger changefee">CHANGE FEE</button>
                    <button id="default" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="custom" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article> 
                 '; 
                }
                if($checkfreecat > 0 && $checkfreedog > 0 && $checkcustomcat  > 0 && $checkcustomdog > 0 && $checkdefaultcat > 0 && $checkdefaultdog > 0){   
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
 
                    <input type="text" value="'.$catfee->id.'" id="catid" hidden>
                    <input type="text" value="'.$dogfee->id.'" id="dogid" hidden>
                    <input type="number" class="form-control" id="catfee"  required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="dogfee"  required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized into two fees, one for cats and the other is for dogs.</p>
                    <button type="submit" id="petfee" class="btn btn-danger">CHANGE FEE</button>
                    
                    <button id="both" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat and dog.</p>
                    <button id="both" class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article> 
                 '; 
                }
                    
            $output .= '</div>';
            echo $output;
        }
    }

    function load_adoption(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $checkdog = Category::all()->where('category_name','Dog')->where('shelter_id',$shelter->id)->count();
        $checkcat = Category::all()->where('category_name','Cat')->where('shelter_id',$shelter->id)->count();
        $checkboth = Category::all()->where('shelter_id',$shelter->id)->count();
        if($checkcat > 0 && $checkdog == 0){
            $cat = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->first();
            $multiple = DB::select("select *from adoption_fee  where categ_id ='$cat->id'");  
            $checkfree = AdoptionFee::where('type','Free')->where('categ_id',$cat->id)->count();
            $checkcustom = AdoptionFee::where('type','Custom')->where('categ_id',$cat->id)->count();
            $checkdefault = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->count();

            $output = ' <main style ="margin-top:30px" class="grid">';

                if($checkfree > 0 && $checkcustom == 0 && $checkdefault == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '       
                        <article> 
                        <img src="junior.png" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="cats" value="Cat">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="prime.jpg" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
               
                        <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                        <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                        <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                        </div>
                        </article> 

                        <article>
                        <img src="mature.jpg" style="height:300px"   alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfree == 0 && $checkcustom > 0 && $checkdefault == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="junior.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="prime.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    
                    <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                    </div>
                    </article> 

                    <article>
                    <img src="mature.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree == 0 && $checkcustom == 0 && $checkdefault > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="junior.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="prime.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    
                    <input type="number" class="form-control" id="fee1" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="applied" class="btn btn-danger changefee">CHANGE FEE</button>
                    </form>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="mature.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="custom" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree > 0 && $checkcustom > 0 && $checkdefault > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://www.affinity-petcare.com/advance/sites/default/files/img/edv_esterilizadojunior@2x.png" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://cdn.shopify.com/s/files/1/1788/4235/files/PPF-Stages-of-a-Cats-Life-blog-Prime_grande.jpg?v=1522425877" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <input type="number" class="form-control" id="catfee" required placeholder="Adoption fee: P'.$catfee->cat_fee.'" name="catfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all cats.</p>
                    <button id="applied" class="btn btn-danger changefee">CHANGE FEE</button>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://meowcatrescue.org/wp-content/uploads/2020/09/Waffles-Resized.jpg" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     '; 
                    
                }
            $output .= '</div>';
            echo $output;
        }
        elseif($checkdog > 0 && $checkcat == 0){
            $dog = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->first();
            $checkfree = AdoptionFee::where('type','Free')->where('categ_id',$dog->id)->count();
            $checkcustom = AdoptionFee::where('type','Custom')->where('categ_id',$dog->id)->count();
            $checkdefault = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->count();

            $output = ' <main style ="margin-top:30px" class="grid">'; 
                if($checkfree > 0 && $checkcustom == 0 && $checkdefault == 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                        <article> 
                        <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="dogs" value="Dog">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                                <button class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
                        <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                        <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                        <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    
                        </div>
                        </article> 

                        <article>
                        <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfree == 0 && $checkcustom > 0 && $checkdefault == 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="apply" type="submit" class="btn btn-danger submit">APPLY</button>
                    </form>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="Cat" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree == 0 && $checkcustom == 0 && $checkdefault > 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="applied" type="submit"  class="btn btn-danger changefee">CHANGE FEE</button>
                    
                    <button id="Dog" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                    <button id="Dog" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article> 
                     
                     ';
                }
                if($checkfree > 0 && $checkcustom > 0 && $checkdefault > 0){
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '        
                    <article> 
                    <img src="https://images.summitmedia-digital.com/esquiremagph/images/2020/05/20/native-dog-breed-philippines-claws-07.jpg" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="dogs" value="Dog">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://dogbreedsfaq.com/wp-content/uploads/Brown-Askal-dog-from-Zambales-Philippines.png?ezimgfmt=rs:374x267/rscb10/ng:webp/ngcb10" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
            
                    <input type="number" class="form-control" id="dogfee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as one fee that will be applicable for all dogs.</p>
                    <button id="applied" type="submit" class="btn btn-danger changefee">CHANGE FEE</button>
                
                    <button id="Dog" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://images.dailykos.com/images/667419/story_image/Aspin-dog-on-beach.jpeg?1555791852" style="height:300px"   alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each dog.</p>
                    <button id="Dog" class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article> 
                     
                     ';
                }
            $output .= '</div>';
            echo $output;
        }
        elseif($checkboth == 2){
            $cat = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->first();
            $dog = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->first();
            $checkfreecat = AdoptionFee::where('type','Free')->where('categ_id',$cat->id)->count();
            $checkcustomcat = AdoptionFee::where('type','Custom')->where('categ_id',$cat->id)->count();
            $checkdefaultcat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->count();
            $checkfreedog = AdoptionFee::where('type','Free')->where('categ_id',$dog->id)->count();
            $checkcustomdog = AdoptionFee::where('type','Custom')->where('categ_id',$dog->id)->count();
            $checkdefaultdog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->count();

            
            $output = ' <main style ="margin-top:30px" class="grid">';
                if($checkfreecat > 0 && $checkfreedog > 0 && $checkcustomcat == 0 && $checkcustomdog == 0 && $checkdefaultcat == 0 && $checkdefaultdog == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                        <article> 
                        <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                        <div class="text">
                                <input type="text" hidden  name="cats" value="Cat">
                                <h3>FREE</h3>
                                <input type="text" hidden name="free" value="FREE">
                                <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                                <button  class="btn btn-success" disabled>APPLIED</button>
                        </div>
                        </article>  
    
                        <article>
                        <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                        <div class="text"> 
                        <h3>DEFAULT</h3> 
                        <input type="text" hidden name="default" value="DEFAULT">
                        <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                        <input type="number" class="form-control" id="fees" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">  
                        <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>                     
                        <button id="default" type="submit" class="btn btn-danger submit">APPLY</button>
                        </div>
                        </article> 

                        <article>
                        <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                        <div class="text"> 
                        <h3>CUSTOM</h3> 
                        <input type="text" hidden name="custom" value="CUSTOM">
                        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                        <button id="custom" class="btn btn-danger apply">APPLY</button>
                        </div>
                        </article> 
                     '; 
                }
                if($checkfreecat == 0 && $checkfreedog == 0 && $checkcustomcat > 0 && $checkcustomdog > 0 && $checkdefaultcat == 0 && $checkdefaultdog == 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <form action="" method = "POST">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="fees" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">  
                    <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>                     
                    <button id="default" type="submit" class="btn btn-danger submit">APPLY</button>
                    </form>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="both" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 
                 '; 
                }
                if($checkfreecat == 0 && $checkfreedog == 0 && $checkcustomcat  == 0 && $checkcustomdog == 0 && $checkdefaultcat > 0 && $checkdefaultdog > 0){
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button id="free" class="btn btn-danger apply" >APPLY</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
                    <form action="" method="POST">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="fee" required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>
                    <button id="both" class="btn btn-danger changefee">CHANGE FEE</button>
                    <button id="default" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat.</p>
                    <button id="custom" class="btn btn-danger apply">APPLY</button>
                    </div>
                    </article> 
                 '; 
                }
                if($checkfreecat > 0 && $checkfreedog > 0 && $checkcustomcat  > 0 && $checkcustomdog > 0 && $checkdefaultcat > 0 && $checkdefaultdog > 0){   
                    $catfee = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
                    $dogfee = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
                    $output .= '       
                    <article> 
                    <img src="https://hips.hearstapps.com/edc.h-cdn.co/assets/16/05/1280x640/landscape-1454434238-gettyimages-157610688.jpg?resize=1200:*" style="height:300px"  alt="Kitten">
                    <div class="text">
                            <input type="text" hidden  name="cats" value="Cat">
                            <h3>FREE</h3>
                            <input type="text" hidden name="free" value="FREE">
                            <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
                            <button class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article>  

                    <article>
                    <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
                    <div class="text"> 
                    <h3>DEFAULT</h3> 
                    <input type="text" hidden name="default" value="DEFAULT">
 
                    <input type="text" value="'.$catfee->id.'" id="catid" hidden>
                    <input type="text" value="'.$dogfee->id.'" id="dogid" hidden>
                    <input type="number" class="form-control" id="catfee"  required placeholder="Adoption Cat fee: P'.$catfee->cat_fee.'" name="catfee">
                    <input type="number" class="form-control" id="dogfee"  required placeholder="Adoption Dog fee: P'.$dogfee->dog_fee.'" name="dogfee">
                    <p style="color:black">Default adoption fee is customized into two fees, one for cats and the other is for dogs.</p>
                    <button type="submit" id="petfee" class="btn btn-danger">CHANGE FEE</button>
                    
                    <button id="both" class="btn btn-success" disabled>APPLIED</button>
                    </div>
                    </article> 

                    <article>
                    <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
                    <div class="text"> 
                    <h3>CUSTOM</h3> 
                    <input type="text" hidden name="custom" value="CUSTOM">
                    <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat and dog.</p>
                    <button id="both" class="btn btn-success"disabled>APPLIED</button>
                    </div>
                    </article> 
                 '; 
                }
                    
            $output .= '</div>';
            echo $output;
        }
    }

    function selection_adoption_savefee_petowner(Request $req){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $dog = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->count();
        $cat = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->count();

        if($dog > 0 && $cat == 0){
            $dog = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->first();
            $feedog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
            $feedog->dog_fee = $req->get('dogfee');
            $feedog->update();
          
        }
        elseif($cat > 0 && $dog == 0){
            $cat = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->first();
            $feecat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
            $feecat->cat_fee = $req->get('catfee');
            $feecat->update(); 
        }
        elseif($cat > 0 && $dog > 0){
            $dog = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->first();
            $cat = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->first();
            $feecat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
            $feecat->cat_fee = $req->get('catfee');
            $feecat->update(); 
    
            $feedog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
            $feedog->dog_fee = $req->get('dogfee');
            $feedog->update();
        }
    }

    function selection_adoption_savefee(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $dog = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->count();
        $cat = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->count();

        if($dog > 0 && $cat == 0){
            $dog = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->first();


            $feedog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
            $feedog->dog_fee = $req->get('dogfee');
            $feedog->update();
          
        }
        elseif($cat > 0 && $dog == 0){
            $cat = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->first();
            $feecat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
            $feecat->cat_fee = $req->get('catfee');
            $feecat->update(); 
        }
        elseif($cat > 0 && $dog > 0){
            $dog = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->first();
            $cat = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->first();
            $feecat = AdoptionFee::where('type','Default')->where('categ_id',$cat->id)->first();
            $feecat->cat_fee = $req->get('catfee');
            $feecat->update(); 
    
            $feedog = AdoptionFee::where('type','Default')->where('categ_id',$dog->id)->first();
            $feedog->dog_fee = $req->get('dogfee');
            $feedog->update();
        }
    }

    function addadoptionfee(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 

    }

    function addcategory_petowner(Request $req){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        if($req->get('name') == "Dog"){
            $category = new Category;
            $category->category_name = "Dog";
            $category->petowner_id = $petowner->id;
            $category->save();

            $dog = Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->first();

            $breed = new Breed;
            $breed->breed_name = "Aspin";
            $breed->categ_id = $dog->id;
            $breed->save();

            $fee = new AdoptionFee;
            $fee->type = "Free";
            $fee->dog_fee = "FREE";
            $fee->categ_id = $dog->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Default";
            $fee->categ_id = $dog->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Custom";
            $fee->categ_id = $dog->id;
            $fee->save();


            $type = new Type;
            $type->type_name = "Puppy(0-5months old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Adolescent(6months-2years old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Adult(3-6years old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Senior(7-13years old)";
            $type->categ_id = $dog->id;
            $type->save();
        }
        elseif($req->get('name') == "Cat"){
            $category = new Category;
            $category->category_name = "Cat";
            $category->petowner_id = $petowner->id;
            $category->save();

            $cat = Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->first();
            
            $breed = new Breed;
            $breed->breed_name = "Puspin";
            $breed->categ_id = $cat->id;
            $breed->save();

            $fee = new AdoptionFee;
            $fee->type = "Free";
            $fee->cat_fee = "FREE";
            $fee->categ_id = $cat->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Default";
            $fee->categ_id = $cat->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Custom";
            $fee->categ_id = $cat->id;
            $fee->save();

            $type = new Type;
            $type->type_name = "Kitten(0-6months old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Junior(7months-2years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Prime(3-6years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Mature(7-10years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Senior(11-14years old)";
            $type->categ_id = $cat->id;
            $type->save();
        }
    }

    function addcategory(Request $req){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        if($req->get('name') == "Dog"){
            $category = new Category;
            $category->category_name = "Dog";
            $category->shelter_id = $shelter->id;
            $category->save();

            $dog = Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->first();

            $breed = new Breed;
            $breed->breed_name = "Aspin";
            $breed->categ_id = $dog->id;
            $breed->save();

            $fee = new AdoptionFee;
            $fee->type = "Free";
            $fee->dog_fee = "FREE";
            $fee->categ_id = $dog->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Default";
            $fee->categ_id = $dog->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Custom";
            $fee->categ_id = $dog->id;
            $fee->save();


            $type = new Type;
            $type->type_name = "Puppy(0-5months old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Adolescent(6months-2years old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Adult(3-6years old)";
            $type->categ_id = $dog->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Senior(7-13years old)";
            $type->categ_id = $dog->id;
            $type->save();
        }
        elseif($req->get('name') == "Cat"){
            $category = new Category;
            $category->category_name = "Cat";
            $category->shelter_id = $shelter->id;
            $category->save();

            $cat = Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->first();
            
            $breed = new Breed;
            $breed->breed_name = "Puspin";
            $breed->categ_id = $cat->id;
            $breed->save();

            $fee = new AdoptionFee;
            $fee->type = "Free";
            $fee->cat_fee = "FREE";
            $fee->categ_id = $cat->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Default";
            $fee->categ_id = $cat->id;
            $fee->save();

            $fee = new AdoptionFee;
            $fee->type = "Custom";
            $fee->categ_id = $cat->id;
            $fee->save();

            $type = new Type;
            $type->type_name = "Kitten(0-6months old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Junior(7months-2years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Prime(3-6years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Mature(7-10years old)";
            $type->categ_id = $cat->id;
            $type->save();

            $type = new Type;
            $type->type_name = "Senior(11-14years old)";
            $type->categ_id = $cat->id;
            $type->save();
        }
    }

    function selection_breed_petowner(){
        $petowner=PetOwner::where('id','=',session('LoggedUserPet'))->first(); 
        $catbreed = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->first();
        $dogbreed = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->first();
        $catcheck = Category::where('category_name','Cat')->where('petowner_id',$petowner->id)->count();
        $dogcheck = Category::where('category_name','Dog')->where('petowner_id',$petowner->id)->count();
        if($catcheck > 0 && $dogcheck == 0){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->count(),
                'breed'=> Breed::all()->where('categ_id',$catbreed->id),
                'breed1'=> '',
            );
        }
        elseif ($dogcheck > 0 && $catcheck == 0) {
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->count(),
                'breed'=> '',
                'breed1'=> Breed::all()->where('categ_id',$dogbreed->id),
            );
        }
        elseif($dogcheck > 0 && $catcheck > 0){
            $data =array(
                'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('petowner_id',$petowner->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('petowner_id',$petowner->id)->count(),
                'breed'=> Breed::all()->where('categ_id',$catbreed->id),
                'breed1'=> Breed::all()->where('categ_id',$dogbreed->id),
            );
        }
        return view('PetOwner.Custom-Selection.Breed',$data);  
    }

    function selection_breed(){
        $shelter=AnimalShelter::where('id','=',session('LoggedUser'))->first(); 
        $catbreed = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->first();
        $dogbreed = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->first();
        $catcheck = Category::where('category_name','Cat')->where('shelter_id',$shelter->id)->count();
        $dogcheck = Category::where('category_name','Dog')->where('shelter_id',$shelter->id)->count();
        if($catcheck > 0 && $dogcheck == 0){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->count(),
                'breed'=> Breed::all()->where('categ_id',$catbreed->id),
                'breed1'=> '',
            );
        }
        elseif ($dogcheck > 0 && $catcheck == 0) {
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->count(),
                'breed'=> '',
                'breed1'=> Breed::all()->where('categ_id',$dogbreed->id),
            );
        }
        elseif($dogcheck > 0 && $catcheck > 0){
            $data =array(
                'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
                'dogcheck' => Category::where('category_name',"Dog")->where('shelter_id',$shelter->id)->count(),
                'catcheck' => Category::where('category_name',"Cat")->where('shelter_id',$shelter->id)->count(),
                'breed'=> Breed::all()->where('categ_id',$catbreed->id),
                'breed1'=> Breed::all()->where('categ_id',$dogbreed->id),
            );
        }
        return view('AnimalShelter.Custom-Selection.Breed',$data);  
    }

    function adddog_breed(Request $req){
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
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return redirect()->back()->with('status','Dog Breed Added Successfully');
    }

    function adddog_breed_petowner(Request $req){
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
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return redirect()->back()->with('status','Dog Breed Added Successfully');
    }

    function deletedogbreed($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('shelter_id','=',$shelter->id)->first();
        $breed = DB::delete("Delete from breed where id ='$id'");
        $data = array(
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return redirect()->back()->with('status','Dog Breed Removed Successfully');
    }

    function deletedogbreed_petowner($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Dog')->where('petowner_id','=',$petowner->id)->first();
        $breed = DB::delete("Delete from breed where id ='$id'");
        $data = array(
            'breed1'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return redirect()->back()->with('status','Dog Breed Removed Successfully');
    }

    function addcat_breed(Request $req){
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
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return redirect()->back()->with('status','Cat Breed Added Successfully');
    }

    function addcat_breed_petowner(Request $req){
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
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return redirect()->back()->with('status','Cat Breed Added Successfully');
    }

    function deletecatbreed($id){
        $shelter =AnimalShelter::where('id','=',session('LoggedUser'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('shelter_id','=',$shelter->id)->first();
        $breed = DB::delete("Delete from breed where id ='$id'");
        $data = array(
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>AnimalShelter::where('id','=',session('LoggedUser'))->first(),
            'shelter'=>AnimalShelter::where('id','=',session('LoggedUser'))->first()
        );
        return redirect()->back()->with('status','Cat Breed Removed Successfully');
    }

    function deletecatbreed_petowner($id){
        $petowner =PetOwner::where('id','=',session('LoggedUserPet'))->first();
        $categ_id = Category::where('category_name','=', 'Cat')->where('petowner_id','=',$petowner->id)->first();
        $breed = DB::delete("Delete from breed where id ='$id'");
        $data = array(
            'breed'=> DB::select("select *from breed  where categ_id ='$categ_id->id'"),
            'LoggedUserInfo'=>PetOwner::where('id','=',session('LoggedUserPet'))->first(),
            'petowner'=>PetOwner::where('id','=',session('LoggedUserPet'))->first()
        );
        return redirect()->back()->with('status','Cat Breed Removed Successfully');
    }
}
