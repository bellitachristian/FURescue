@extends("Admin.main")

@section("content")
<div style="justify-content:center" class="row">
<div class="col-sm-7">
        <div class="card shadow mb-4">
            <!-- Animal header -->
    
<!-- Animal Content -->
<div class="card-header">
    <h4>Pet Owner Details</h4>
</div>
<div class="card-body">
        <div class="row" style="display:flex">
            <div class="col-sm" style="text-align:center">
            <img src="{{asset('uploads/pet-owner/profile/'.$petowner->profile)}}" style=" border-radius:50%" width="80%" height="75%" alt="">
            </div>
            <div class="col-sm">
                    <label class="text-sm"> Pet Owner Name</label>
                    <input type="text" value ="{{$petowner->fname}} {{$petowner->lname}}" readOnly class="form-control form-control-sm" id="name" name="name">
                                    
                    <label class="text-sm">Address</label>
                    <input type="text" value ="{{$petowner->address}}"  readOnly class="form-control form-control-sm" id="age" name="age">
            </div>  
            <div class="col-sm">
                    <label class="text-sm">Email</label>
                    <input type="text" value ="{{$petowner->email}}" readOnly class="form-control form-control-sm" id="name" name="name">
                    <label class="text-sm">Contact Number</label>
                    <input type="text" value ="{{$petowner->contact}}" readOnly class="form-control form-control-sm" id="name" name="name">
            </div>          
        </div>
        <div class="card">
            <div class="card-header" style="text-align:center">
                <h6>Valid Documents</h6>
            </div>
            <div class="card-body" style="text-align:center">
                @foreach($petowner->petownerPhoto as $photo)
                    @if($photo['extension'] == "docx")
                        {{$photo['filename']}}
                        <a href="{{url('Admin/viewshelterenlargedetails/'.$photo['filename']. '/'.$petowner->id)}}" type="button" class="btn btn-primary">View</a>
                    @else   
                    <div>
                      <iframe src="{{asset('uploads/valid-documents/'.$photo['filename'])}}" height="300px" width="100%" frameborder="50"></iframe><a href="{{url('Admin/viewpetownerenlargedetails/'.$photo['filename']. '/'.$petowner->id)}}" type="button" class="btn btn-primary">Enlarge</a>  
                    </div>
                    @endif
                @endforeach 
            </div>
        </div>                                 
    </div>
    <div class="card-footer">
            <div style="float:left">
                <a href="{{route('viewpetowner')}}"><button class="btn btn-secondary" type="button">Back</button></a>
            </div>
            <div style="float:right">
                <a href="{{route('approve.petowner', $petowner->id)}}"><button class="btn btn-success" type="button">Approve</button></a>
                <a href="{{route('reject.petowner', $petowner->id)}}"><button class="btn btn-danger" type="button">Reject</button></a>
            </div>  
    </div>
</div>               
</div>  
@endsection

