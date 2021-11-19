@extends("main")
@section("header")
Subscription
@endsection
@push('css')
<link href="{{url('css/style.css')}}" rel="stylesheet">    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div class="row">
    <div class="col-sm-3">
        <div class="pricingTable">
            <div class="pricingTable-header">
                <h3 class="heading">{{$subs->sub_name}}</h3>
                
                <div class="price-value">{{$subs->sub_price}}
                    <span class="currency">PHP</span>
                </div>
            </div>
            @foreach($subs->sub_desc as $descs)
            <ul class="pricing-content">
                    {{$descs}}
            </ul>
            @endforeach
        </div>
    </div>
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="/dashboard"><button type="button" class="btn btn-secondary">Back</button></a>
            </div>
            <div class="card-body">
                <div style="display:flex">
                    <div class="col-sm">
                        <label style="font-size:16px;color:black" for="">Send subscription payment to any of these account:</label>
                    </div>
                    <div class="col-sm">
                        <h6 style="text-align:center;font-weight:bold;color:black">Proof of Payment</h6>
                        <label style="font-style:italic" for="">(e.g:screenshot of gcash payment transaction or paypal)</label>
                    </div>
                </div>
                <div class="col-sm">
                    <div style="display:flex">
                        <div class="col-sm">
                            <hr>
                            <img src="{{asset('/images/gcash.png')}}" style="margin:2%" height="70px" width="80px" alt="">
                            <label style="font-weight:bold; color:black" for="">GCash No. </label><span style="text-decoration:underline">09293291231</span>
                        </div>
                        <div class="col-sm">
                            <form id="dropzoneForm" enctype="multipart/form-data" action="{{ route('upload.proof',$subs->id) }}" class="dropzone">
                                @csrf
                            </form> 
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div style="display:flex">
                        <div class="col-sm">
                            <hr>
                            <img src="{{asset('/images/paypal.png')}}" style="margin:2%" height="70px" width="80px" alt="">
                            <label style="font-weight:bold; color:black" for="">PayPal No. </label><span style="text-decoration:underline">09293291231</span>
                        </div>
                        <div class="col-sm">
                            <div style="text-align:center">
                                <button type="button" class="btn btn-primary" id="submit-all">Upload Proof</button>     
                            </div>
                            <div>
                                <label style="font-weight:bold; color:black">Photo</label>
                            </div>
                            <form action="{{route('waiting.subscription',$subs->id)}}" method="POST">
                                @csrf
                            <div>
                                <div style="text-align:center" id="uploaded_image">

                                </div>
 
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
                <div style="text-align:center">
                    <button type="submit" class="btn btn-danger">Subscribe</button>
                </div>
            </div>
            </form>
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
      url:"{{url('Admin/loadproof/'.$shelter->id.'/'.$subs->id)}}",
      success:function(data)
      {
        $('#uploaded_image').html(data);
      }
    })
  }
  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"{{ route('delete.proof') }}",
      data:{name : name},
      success:function(data){
        confirm('Removed Successfully!');
        load_images();
      }
    })
  });

</script>
@endpush