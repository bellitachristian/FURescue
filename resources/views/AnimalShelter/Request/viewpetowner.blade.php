@extends("main")
@section("header")
Shelter Details
@endsection 
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div style="display:flex" class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header"><a href="{{route('petowner.request')}}"><button type="button" class="btn btn-secondary">Back</button></a></div>
            <div class="card-body">
                <div style="text-align:center">
                    <img src="{{asset('uploads/pet-owner/profile/'.$petowner->profile)}}" height="150" width="170" alt="">
                </div>       
                <label style="font-height:1">Name of Pet Owner</label>                        
                <input style="margin-bottom:1%" type="text"  value="{{$petowner->fname}} {{$petowner->lname}}" readOnly class="form-control form-control-sm">
                <label>Gender</label>
                <input style="margin-bottom:5%" type="text" value="{{$petowner->gender}}" readOnly class="form-control form-control-sm">
                <label>Address</label>
                <input style="margin-bottom:1%" type="text" value ="{{$petowner->address}}" readOnly  class="form-control form-control-sm">
                <label>Contact Number</label>
                <input style="margin-bottom:1%" type="text" value ="{{$petowner->contact}}" readOnly  class="form-control form-control-sm">
                <label>Email</label>
                <input style="margin-bottom:5%" type="email" value ="{{$petowner->email}}"readOnly class="form-control form-control-sm">  
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card shadow mb-4">
        <div class="card-header" style="color:black; font-weight:bold; font-size:24px">Pet Requested to be Adopted</div>
            <div class="card-body">
                <div style="display:flex">
                    <div class="col-sm">
                        <div style="text-align:center">
                            <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" height="150" width="170" alt="">
                        </div>       
                        <label style="font-height:1">Name of Pet </label>                        
                        <input style="margin-bottom:1%" type="text"  value="{{$animal->name}}" readOnly class="form-control form-control-sm">
                        <label>Age</label>
                        <input style="margin-bottom:5%" type="text" value="{{$animal->age}}" readOnly class="form-control form-control-sm">
                        <label>Life Stage</label>
                        <input style="margin-bottom:1%" type="text" value ="{{$animal->pet_stage}}" readOnly  class="form-control form-control-sm">
                        <label>Gender</label>
                        <input style="margin-bottom:1%" type="text" value ="{{$animal->gender}}" readOnly  class="form-control form-control-sm">
                        <label>Breed</label>
                        <input style="margin-bottom:5%" type="text" value ="{{$animal->breed}}"readOnly class="form-control form-control-sm">  
                    </div>
                    <div class="col-sm">
                         <h5 style="color:black">HISTORY</h5>
                         <p>{{$animal->history}}</p>
                         <hr>
                         <br>
                         <h5 style="color:black">Additional Info</h5>
                         <p>{{$animal->info}}</p>
                    </div>  
                </div>
            </div>
            <div class="card-footer">
                <a href=""><button class="btn btn-success">Approve</button></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div style="color:black; font-weight:bold" class="card-header">
                Reason for Request of Adoption 
            </div>
            <div class="card-body">
                <p style="color:black;font-style:italic">
                    @foreach($petowner->request as $message)
                        {{$message->message}} <br>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div style="color:black; font-weight:bold"  class="card-header">Photos of {{$animal->name}}</div>
            <div class="card-body">
                <div id="animals">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div style="color:black; font-weight:bold" class="card-header">
                Photos of {{$petowner->fname}}
            </div>
            <div class="card-body">
                <div id="uploaded_image">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type ="text/javascript">
load_animals();
load_images();
function load_images()
{
  $.ajax({
    url:"{{route('petowner.photo',$petowner->id)}}",
    success:function(data)
    {
        $('#uploaded_image').html(data);    
    }
  })
}
function load_animals()
{
  $.ajax({
    url:"{{route('animal.photo',$animal->id)}}",
    success:function(data)
    {
        $('#animals').html(data);       
    }
  })
}
</script>
@endpush
