@extends("mainpetowner")
@section("header")
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@push("css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div class="col-sm">
    <div class="card shadow mb-4">
        <div class="card-header">
          <input type="text" hidden value="{{$animal->category}}" id="category" >
          <form action="" method="POST" id="post">
            <div style="display:flex">
              <div class="col-sm">
                <br>
              <button type="submit"  style="padding:10px;width:150px" class="btn btn-danger">Post</button>     
              </div> 
              <div class="col-sm-3">
                <label class="text-sm">Adoption Fee</label>
                <select class="form-control form-control-sm" required id="fee" required name="fee">
                </select> 
              </div>  
              <div class="col-sm-2" id="feeprice" >
              </div>          
            </div>
          </form>
        </div>
        <div class="card-body">
            <div style="display:flex">
                <div class="col-sm-4">
                    <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" style=" width:100%; height:100%;border-radius:3%"alt="">   
                </div>   
                <div class="col-sm">
                    <label>Name:</label>
                    <input type="text" readOnly class="form-control" value="{{$animal->name}}">
                    <label>Age:</label>
                    <input type="text" readOnly class="form-control" value="{{$animal->age}}">
                    <label>Life Stage:</label> 
                    <input type="text" readOnly class="form-control" value="{{$animal->pet_stage}}">
                    <label>Size:</label>
                    <input type="text" readOnly class="form-control" value="{{$animal->size}}">
                    <label>Gender:</label>
                    <input type="text" readOnly class="form-control" value="{{$animal->gender}}">
                </div>  
                <div class="col-sm">
                    <label>Additional Info:</label><br>
                    <textarea disabled cols="50" rows="5">{{$animal->info}}</textarea>
                    <h4>{{$animal->name}}'s History</h4>
                        <textarea disabled cols="50" rows="5">{{$animal->history}}</textarea>
                </div>
            </div>
                
        </div> 
        <div class="card-footer">

        </div>
    </div>
</div>
<div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
               <h4 style="text-transform:uppercase; color:black">UPLOAD PHOTOS OF {{$animal->name}}</h4> </div>
            <div class="card-body">
                <div style="display:flex">   
                    <div class="col-sm">
                        <div id="uploaded_image">
                           
                        </div>
                        <div>
                            <h6 style="text-align:center">Click to Upload Photos of {{$animal->name}}</h6>
                        </div>
                        <form id="dropzoneForm" enctype="multipart/form-data" action="{{ route('post.uploadphoto.petowner',$animal->id) }}" class="dropzone">
                            @csrf
                        </form>
                        <div style="text-align:center; margin-top:10px" >
                            <button type="button" class="btn btn-danger" id="submit-all">Upload</button>     
                        </div>
                    </div>
                </div>
                 
            </div> 
        </div>
    </div>
@endsection 
@push("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
    Dropzone.options.dropzoneForm = {
    autoProcessQueue : false,
    acceptedFiles : ".png,.jpg,.jpeg",
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
          confirm("Photo added");
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
      url:"{{ route('post.fetch.petowner',$animal->id) }}",
      success:function(data)  
      {
        $('#uploaded_image').html(data);
      }
    })
  }
  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"{{ route('postphoto.delete.petowner') }}",
      data:{name : name},
      success:function(data){
        confirm('Removed Successfully!');
        load_images();
      }
    })
  });
  var categID = document.getElementById("category").value;  
  console.log(categID)
  if(categID){
    $.ajax({
      type:"GET",
      url:"{{route('get.fee.petowner')}}?categ_id="+categID,
      success:function(res){        
      if(res){
        $("#fee").empty();
        $("#fee").append('<option value="">Select Adoption Fee</option>');
        $.each(res,function(key,value){
          $("#fee").append('<option value="'+key+'">'+value+'</option>');
          $('#fee').change(function(){
          var feeID = $(this).val();
          console.log(feeID)
          load_price(feeID);
          });
        });
      }else{
        $("#fee").empty();
      }
      }
    });
  }else{
    $("#fee").empty();
  }   

function load_price(key){ 
var id = key
console.log(id)
$.ajax({
    url:"/postpet/loadfee/petowner/"+ id,
    success:function(data)  
    {
      $('#feeprice').html(data);
    }
  })
}
</script>
<script>

$("#post").submit(function(e){
      e.preventDefault();
      let feeid = $("#fee").val();
      let feeprice = $("#price").val();
      let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: "{{route('post.pet.save.petowner',$animal->id)}}",
        type:"POST",
        data:{
          feeid:feeid,
          feeprice:feeprice,
          _token: _token
        },
        success:function(html){
          confirm('Posted Successfully')
          window.location.href ="{{route('post.view.petowner')}}"
        },
        error: function(error) {
         alert('Something went wrong')
        }
       }); 
       return false;

  });

</script> 
@endpush
