@extends("mainpetowner")
@section("content")

<div style="justify-content:center" class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header">
                Edit Profile
            </div>
            <div class="card-body">
                <form action="{{url('/EditProfile/petowner/'.$petowner->id)}}"  method="POST" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group-row" style="display:flex"> 
                                <div class="col-sm"> 
                                    <div style="text-align:center">
                                        <img src="{{asset('uploads/pet-owner/profile/'.$petowner->profile)}}" style="border-radius:50%;"height="209" width="270" alt="">
                                    </div>

                                    <label style="font-size:14px" >Change profile image</label>    

                                    <input style="margin-bottom:2%" type="file" required class="form-control form-control-sm" id="animal_image" name="profile">
                                    <span class="text-danger">@error('profile'){{$message}}@enderror</span>
                                    
                                    <label style="font-size:14px" >First Name</label>    
                                    <input style="margin-bottom:2%" type="text" value="{{$petowner->fname}}" required class="form-control form-control-sm"  name="fname">
                                    <span class="text-danger">@error('name'){{$message}}@enderror</span>

                                    <label style="font-size:14px" >Last Name</label>    
                                    <input style="margin-bottom:2%" type="text" value="{{$petowner->lname}}" required class="form-control form-control-sm" name="lname">
                                    <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                    
                                    <label style="font-size:14px" >Address</label> 
                                    <input style="margin-bottom:2%" type="text" id="" value="{{$petowner->address}}"  class="form-control form-control-sm" required  name="address">
                                    
                                    <label style="font-size:14px" >Contact Number</label> 
                                    <input style="margin-bottom:2%" type="number" value="{{$petowner->contact}}"  class="form-control form-control-sm" required  name="contact">
                                    <span class="text-danger">@error('contact'){{$message}}@enderror</span>
                                    
                                    <label style="font-size:14px" >Email</label> 
                                    <input style="margin-bottom:2%" type="email" value="{{$petowner->email}}" class="form-control form-control-sm" required  name="email">
                                    <span class="text-danger">@error('email'){{$message}}@enderror</span>

                                    <input type="password" value ="{{$petowner->password}}" hidden class="form-control form-control-sm" id="name" name="password">
                                    <button style="margin-bottom:2%; float:right" type="button" onclick="location.href='#'" data-toggle="modal" data-target="#EditPass">Change Password</button>
                                
                                    <h5 style="color:black; margin-top:5%; margin-bottom:4%">Account Information</h5>
                                    
                                    <label style="font-size:14px" >Gcash Number</label> 
                                    <input  style="margin-bottom:2%" type="number" value="{{$petowner->gcash}}" required  class="form-control form-control-sm"  name="g_cash">
                                    <span class="text-danger">@error('g_cash'){{$message}}@enderror</span>

                                    <label style="font-size:14px" >Paypal Number</label> 
                                    <input  style="margin-bottom:2%" type="number" value="{{$petowner->pay_pal}}" required  class="form-control form-control-sm"  name="pay_pal"> 
                                    <span class="text-danger">@error('paypal'){{$message}}@enderror</span>   
                                </div>  
                            </div>      
                        </div>
                        <div class="card-footer">
                            <a href="{{url('/Profile/petowner/'.$petowner->id)}}"><button class="btn btn-secondary" type="button">Cancel</button></a>
                            <button class="btn btn-danger"  id="btn" type="submit">Save Changes</button>
                        </div>                
                    </div>         
                </form>                                 
            </div>  
        </div>
    </div>             
</div>

<!-- Edit Password Modal -->
<div class="modal fade"  id="EditPass"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Setting Your New Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <form action="{{url('/UpdatePassword/petowner/'.$petowner->id)}}" id="passchange" method="POST">
                @csrf
                <div class="modal-body">
                <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm" style="color:black">Current Password</label>
                            <input type="password" class="form-control form-control-sm" placeholder="Current password" id="curr_pass" name="password" required>
                            <img src="/images/error.png" class="curr-img" style="height:30px; width:35px; margin:5px" alt="error">7 Characters long or more not less
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm" style="color:black">New Password</label>
                            <input type="password" class="form-control form-control-sm" placeholder="Set new password" id="new_password" name="new_pass" required>
                            <img id="auth" class="myImg" src="/images/error.png" style="height:30px; width:35px; margin:5px" alt="error">7 Characters long or more not less
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md"> 
                            <label class="text-sm" style="color:black">Confirm New Password</label>
                            <input type="password" class="form-control form-control-sm" placeholder="Confirm new password" id="confirm_password" name="con_pass" required>
                            <img src="/images/error.png" class="con-img" style="height:30px; width:35px; margin:5px" alt="error">7 Characters long or more not less
                        </div>
                    </div>
                    <img src="/images/error.png" class="con-pass" style="height:30px; width:35px; margin-left:5px; margin-top:-30px" alt="error">
                    <div style="margin-left:46px; margin-top:-40px">
                        Password Match
                    </div>
                </div>    
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button">Cancel</button>
                    <button class="btn btn-danger" id="btn" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div> 
</div> 
@endsection
@push("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyD5HhjPje8DC23_KCXo9ZNJTVP5gb1Eg2g"></script>

<script>
    var searchInput = 'search_input';
    $(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
    types: ['geocode'],
    componentRestrictions: {
    country: "PH",
    }
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var near_place = autocomplete.getPlace();       
    });
});
</script>
<script>
    $('#EditPass').on('hidden.bs.modal', function (e) {
        document.getElementById("passchange").reset();
        var myImg = $(".myImg");
        var newImg = "/images/error.png";
        myImg.attr('src', newImg);

        var myImg1 = $(".curr-img");
        var newImg1 = "/images/error.png";
        myImg1.attr('src', newImg1);

        var myImg2 = $(".con-img");
        var newImg2 = "/images/error.png";
        myImg2.attr('src', newImg2);

        var myImg3 = $(".con-pass");
        var newImg3 = "/images/error.png";
        myImg3.attr('src', newImg3);    
    });
    $("input[type=password]").keyup(function(){
        if($("#new_password").val().length >= 7){
            var myImg = $(".myImg");
            var newImg = "/images/check.png";
            myImg.attr('src', newImg);
	    }else{
            var myImg = $(".myImg");
            var newImg = "/images/error.png";
            myImg.attr('src', newImg);
	    }

        if($("#curr_pass").val().length >= 7){
            var myImg = $(".curr-img");
            var newImg = "/images/check.png";
            myImg.attr('src', newImg);
	    }else{
            var myImg = $(".curr-img");
            var newImg = "/images/error.png";
            myImg.attr('src', newImg);
	    }

        if($("#confirm_password").val().length >= 7){
            var myImg = $(".con-img");
            var newImg = "/images/check.png";
            myImg.attr('src', newImg);
            if($("#confirm_password").val() === $("#new_password").val()){
                var myImg = $(".con-pass");
                var newImg = "/images/check.png";
                myImg.attr('src', newImg);
            }
            else{
                var myImg = $(".con-pass");
                var newImg = "/images/error.png";
                myImg.attr('src', newImg);
            }
	    }else{
            var myImg = $(".con-img");
            var newImg = "/images/error.png";
            myImg.attr('src', newImg);
	    }
    });

</script>
@endpush
