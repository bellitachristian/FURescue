@extends("PetOwner.Deactivation.deactmain")
@section("header")
Profile
@endsection 
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div class="row">
    <div class="col-sm">  
        <div class="card shadow mb-4">
            <div class="card-body">
                    <div class="card-group-row" style="display:flex">
                            <div class="col-sm"> 
                                <div style="text-align:center">
                                    <img src="{{asset('uploads/pet-owner/profile/'.$petowner->profile)}}" style="border-radius:50%;"height="209" width="270" alt="">
                                </div>       
                                <label style="font-height:1">Pet Owner Name</label>                        
                                <input style="margin-bottom:1%" type="text"  value="{{$petowner->fname}} {{$petowner->lname}}" readOnly class="form-control form-control-sm">
                                <label >Address</label>
                                <input style="margin-bottom:5%" type="text" value="{{$petowner->address}}" readOnly class="form-control form-control-sm">
                            </div>  
                            <div class="col-sm">
                                <h5 style="color:black; margin-top:5%; margin-bottom:4%">Personal Information</h5>
                                <label >Contact Number</label>
                                <input style="margin-bottom:1%" type="text" value ="{{$petowner->contact}}" readOnly  class="form-control form-control-sm">
                                <label >Email</label>
                                <input style="margin-bottom:5%" type="email" value ="{{$petowner->email}}"readOnly class="form-control form-control-sm">
                                
                            </div>
                            <div class="col-sm">
                                <h5 style="color:black; margin-top:5%; margin-bottom:4%">Account Information</h5>
                                <label >Gcash Number</label>
                                <input  style="margin-bottom:1%" type="number" value ="{{$petowner->gcash}}" readOnly class="form-control form-control-sm">
                                <label >Paypal Number</label>
                                <input style="margin-bottom:4%" type="number" value ="{{$petowner->pay_pal}}" readOnly class="form-control form-control-sm">  
                                <div>
                                    <a href="#"><button  style="margin-bottom:20%" data-toggle="modal" data-target="#deactivate" type="button">Deactivate Account</button></a>
                                </div>
                                <div style="float:right">
                                     <a href="{{url('/Profile/Edit/petowner/'.$petowner->id)}}"><button class="btn btn-danger" type="button">Edit Shelter Information</button></a>
                                </div>         
                            <div>
                        </div>   
                    </div>        
                </div>                                  
            </div>  
        </div>
    </div>             
</div>
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h4>Photos</h4>
            </div>
            <div class="card-body">
                <div id="uploaded_image">

                </div>
                <div>
                    <h5 style="text-align:center">Click to Upload Photos</h5>
                </div>
                <form id="dropzoneForm" enctype="multipart/form-data" action="{{ route('up.upload.petowner') }}" class="dropzone">
                    @csrf
                </form>
            </div>
            <div class="card-footer" style="text-align:center">
                <button type="button" class="btn btn-danger" id="submit-all">Upload Photos</button>     
            </div>
        </div>
    </div>
</div>
@include('PetOwner.Profile.Modal.DeactivationModal')
@endsection
@push("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    Dropzone.options.dropzoneForm = {
    autoProcessQueue : false,
    acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
    addRemoveLinks: true,

    init:function(){
      var submitButton = document.querySelector("#submit-all");
      myDropzone = this;

      submitButton.addEventListener('click', function(){
        myDropzone.processQueue();
      });
      this.on("complete", function(){
        if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
        {
          confirm("Photo uploaded successfully");
          var _this = this;
          _this.removeAllFiles();
        }
        load_images();
      });
    }
};
load_images();

  function load_images()
  {
    $.ajax({
      url:"{{ route('dropzone.fetch.petowner') }}",
      success:function(data)
      {
        $('#uploaded_image').html(data);
      }
    })
  }
  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"{{ route('dropzone.delete.petowner') }}",
      data:{name : name},
      success:function(data){
        confirm('Removed Successfully!');
        load_images();
      }
    })
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
