@extends("mainpetowner")
@section("header")
Shelter Details
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
                            <div class="col-sm-4"> 
                                <div style="text-align:center">
                                    <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" style="border-radius:50%;"height="150" width="170" alt="">
                                </div>       
                                <label style="font-height:1">Name of Shelter</label>                        
                                <input style="margin-bottom:1%" type="text"  value="{{$shelter->shelter_name}}" readOnly class="form-control form-control-sm">
                                <label >Address</label>
                                <input style="margin-bottom:5%" type="text" value="{{$shelter->address}}" readOnly class="form-control form-control-sm">
                                <h5 style="color:black; margin-top:5%; margin-bottom:4%">Shelter Information</h5>
                                <label >Animal Shelter Contact Person</label>
                                <input style="margin-bottom:1%" type="text" value ="{{$shelter->founder_name}}" readOnly  class="form-control form-control-sm">
                                <label >Contact Number</label>
                                <input style="margin-bottom:1%" type="text" value ="{{$shelter->contact}}" readOnly  class="form-control form-control-sm">
                                <label >Email</label>
                                <input style="margin-bottom:5%" type="email" value ="{{$shelter->email}}"readOnly class="form-control form-control-sm">  
                            </div>  
                            <div class="col-sm">
                                <h5 style="color:black; margin-top:5%; margin-bottom:4%">Pets Catered</h5>

                            </div>
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
            </div>
        </div>
    </div>
</div> 
@endsection
@push('js')
<script type ="text/javascript">
load_images();
function load_images()
{
  $.ajax({
    url:"{{route('shelter.photo',$shelter->id)}}",
    success:function(data)
    {
      $('#uploaded_image').html(data);
    }
  })
}
</script>
@endpush
