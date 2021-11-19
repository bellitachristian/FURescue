@extends("mainpetowner")
@section("header")
Edit Pet
@endsection
@section("content")
<div class="row">
<div class="col-sm">
        <div class="card shadow mb-4">
            <!-- Animal header -->
    
<!-- Animal Content -->
<div class="card-body">
    <form action="{{route('update.pet',$animal->id)}}"  method="POST" enctype="multipart/form-data">
        @csrf 
        <div class="form-group-row" style="display:flex">
            <div class="col-sm-6 flex-1"> 
                <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" style=" border-left: 5px solid black; border-right: 5px solid black; border-radius:3%" width="100%" height="75%" alt="">
                <br><label class="text-sm" >Upload Image</label>      
                <input type="file" class="form-control form-control-sm" id="animal_image" name="animal_image">
            </div>  

            <div class="col-sm-3 flex-1">
                    <label class="text-sm">Name</label>
                    <input type="text" value ="{{$animal->name}}"  class="form-control form-control-sm" id="name" name="name">
                                    
                    <label class="text-sm">Age</label>
                    <input type="number" value ="{{$animal->age}}"  class="form-control form-control-sm" id="age" name="age">
                    <span><input type="radio" value="1" id="years" name="radiobtn"></span> <label style="padding-right:3px" class="text-sm">Years</label>  <span><input class="radio sm" id="months" name="radiobtn" value="2" type="radio"></span> <label class="text-sm">Months</label> <br>

                    <label class="text-sm">Breed</label>
                    <select class="form-control form-control-sm" id="breed" name="breed">
                    <option value="{{$animal->breed}}">{{$animal->breed}}</option>
                    @foreach($petownercateg as $categories)
                        @foreach($categories->category as $categ)
                            @foreach($categ->breed as $breeds)
                                <option value="{{$breeds['breed_name']}}">{{$breeds['breed_name']}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                    </select>

                    <label class="text-sm">History</label>
                    <textarea class="form-control" name="history" rows="3" id="history">{{$animal->history}}</textarea>


            </div>  
            <div class="col-sm-3">
                    <label class="text-sm">Category</label>
                    <select class="form-control form-control-sm" id="category" name="category">
                    @foreach($petownercateg as $categories)
                        @foreach($categories->category as $categ)
                            <option value="{{$categ['id']}}">{{$categ['category_name']}}</option>
                        @endforeach
                    @endforeach       
                    </select>

                    <label class="text-sm">Pet's Life Stage</label>
                    <select class="form-control form-control-sm" id="stage" name="stage">
                    <option value="{{$animal->pet_stage}}">{{$animal->pet_stage}}</option>   
                    </select>

                    <label class="text-sm">Color</label>
                            <select class="form-control form-control-sm" id="color" required name="color">
                                <option value="{{$animal->color}}">{{$animal->color}}</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Brown">Brown</option>
                                <option value="Orange">Orange</option> 
                                <option value="Tiger">Tiger</option>
                                <option value="Mixed">Mixed</option>
                            </select>

                    <label>Additional Info</label>
                    <textarea class="form-control" name="info" rows="3" id="info">{{$animal->info}}</textarea>           
            </div>          
        </div>    
        <div style="float:right; margin-top:-1.5%">
            <a href="{{route('pet.view')}}"><button class="btn btn-secondary" type="button">Back</button></a>
            <button class="btn btn-danger" id="btn" type="submit">Update</button>
            </div>                    
        </form>                                 
    </div>               
</div>  
@endsection  
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type=text/javascript>
  $('#category').change(function(){
  var categID = $(this).val();  
  console.log(categID)
  if(categID){
    $.ajax({
      type:"GET",
      url:"{{route('get.breed.petowner')}}?categ_id="+categID,
      success:function(res){        
      if(res){
        $("#breed").empty();
        $("#breed").append('<option>Select Breed</option>');
        $.each(res,function(key,value){
          $("#breed").append('<option value="'+value+'">'+value+'</option>');
        });
      
      }else{
        $("#breed").empty();
      }
      }
    });
  }else{
    $("#breed").empty();
  }   
  });
   document.getElementById("age").readOnly = true;
    $("#years").change(function(){
        if($("#years").val() == "1"){
        document.getElementById("age").readOnly = false;
        $("#age").change(function(){
        var Year  = $("#years").val();
        var Age = $("#age").val();
        var categID = $("#category").val(); 
         
        if(categID){
            $.ajax({
                type:"GET",
                url:"{{route('get.type.petowner')}}?categ_id="+categID,
                data:{age:Age,radiobtn:Year},
                success:function(res){      
                    console.log(res)  
                    if(res){
                        $("#stage").empty();
                        $.each(res,function(key,value){
                            $("#stage").append('<option value="'+value+'">'+value+'</option>');
                        });            
                    }
                    }
                });
            }
        });
    }
  });
  $("#months").change(function(){
    if($("#months").val() == "2"){
        document.getElementById("age").readOnly = false;
        $("#age").change(function(){
        var categID = $("#category").val();
        var Month  = $("#months").val();
        var Age = $("#age").val();  
        if(categID){
            $.ajax({
                type:"GET",
                url:"{{route('get.type.petowner')}}?categ_id="+categID,
                data:{age:Age,radiobtn:Month},
                success:function(res){        
                    if(res){
                        $("#stage").empty();
                        $.each(res,function(key,value){
                            $("#stage").append('<option value="'+value+'">'+value+'</option>');
                        });
            
                    }else{
                        $("#stage").empty();
                        }
                    }
                });
            }
        });
    }
  });
</script>
 
@endpush 

