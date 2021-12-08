@extends("sheltertempmain")
@push("css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div  class="row">
    <div class="col-sm-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <a style="color:#42ba96"><h5 style="font-weight:bold;">Chances Remaining</h5></div></a> 
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$shelter->grace}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="row justify-content-center">
        <!-- Dashboard Content -->
        <div style="margin-top:1%" class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Dashboard header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5>Upload Valid Documents</h5>
                </div>
                <!-- Content Body -->
                <div class="card-body">
                    <div>
                        <h7 style="text-align:center">Click to Upload Valid Documents(e.g. Screenshots or PDF file of SEC,Business permits)</h7>
                    </div>
                    <div id="uploaded_image">
                    </div>
                    <form id="dropzoneForm" enctype="multipart/form-data" action="{{route('valid.reupload') }}" class="dropzone">
                        @csrf
                    </form>
                    <div style="text-align:center">
                        <button type="button" class="btn btn-primary" id="submit-all">Upload</button>     
                    </div>
                </div>
                <form action="{{route('wait.response',$shelter->id)}}" method="POST">
                    @csrf
                    <div class="card-footer" style="text-align:center">
                        <button type="submit" style="float:right" class="btn btn-danger">Submit</button>     
                    </div>
                </form>
            </div>
        </div>
        <div style="margin-top:1%" class="col-sm">
            <div class="card">
                <div class="card-header">Feedback</div>

                <div class="card-body">
                    @foreach($feedback as $message)
                        <div style="display:flex">
                            <div style="padding-right:7px">
                                <img class="img-profile rounded-circle" width="50px" height="50px" src="{{asset('img/undraw_profile_2.svg')}}">
                                <h6 style="font-weight:bold">
                                    Admin
                                </h6>
                            </div>
                            <textarea style="font-style:italic" disabled class="form-control" cols="30" rows="3">{{$message->message}}</textarea>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> 
@endsection
@push('js')
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
      url:"{{ route('fetch.valid',$shelter->id) }}",
      success:function(data)
      {
        $('#uploaded_image').html(data);
      }
    })
  }
  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"{{ route('valid.delete')}}",
      data:{name : name},
      success:function(data){
        confirm('Removed Successfully!');
        load_images();
      }
    })
  });
</script>
@endpush