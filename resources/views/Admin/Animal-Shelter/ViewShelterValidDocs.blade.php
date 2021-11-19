@extends("Admin.main")

@section("content")
<div style="justify-content:center" class="row">
<div class="col-sm-7">
        <div class="card shadow mb-4">
            <!-- Animal header -->
    
<!-- Animal Content -->
<div class="card-header">
    <h4>Animal Shelter Details</h4>
</div>
<div class="card-body">
        <div class="row" style="display:flex">
            <div class="col-sm" style="text-align:center">
            <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" style=" border-radius:50%" width="80%" height="75%" alt="">
            </div>
            <div class="col-sm">
                    <label class="text-sm">Shelter Name</label>
                    <input type="text" value ="{{$shelter->shelter_name}}" readOnly class="form-control form-control-sm" id="name" name="name">
                                    
                    <label class="text-sm">Address</label>
                    <input type="text" value ="{{$shelter->address}}"  readOnly class="form-control form-control-sm" id="age" name="age">
            </div>  
            <div class="col-sm">
                    <label class="text-sm">Email</label>
                    <input type="text" value ="{{$shelter->email}}" readOnly class="form-control form-control-sm" id="name" name="name">
                    <label class="text-sm">Contact Number</label>
                    <input type="text" value ="{{$shelter->contact}}" readOnly class="form-control form-control-sm" id="name" name="name">
            </div>          
        </div>
        <div class="card">
            <div class="card-header" style="text-align:center">
                <h6>Valid Documents</h6>
            </div>
            <div class="card-body" style="text-align:center">
                @foreach($shelter->shelterPhoto as $photo)
                    @if($photo['extension'] == "docx")
                        {{$photo['filename']}}
                        <a href="{{url('Admin/viewshelterenlargedetails/'.$photo['filename']. '/'.$shelter->id)}}" type="button" class="btn btn-primary">View</a>
                    @else   
                    <div>
                      <iframe src="{{asset('uploads/valid-documents/'.$photo['filename'])}}" height="300px" width="100%" frameborder="50"></iframe><a href="{{url('Admin/viewshelterenlargedetails/'.$photo['filename']. '/'.$shelter->id)}}" type="button" class="btn btn-primary">Enlarge</a>  
                    </div>
                    @endif
                @endforeach 
            </div>
        </div>                                 
    </div>
    <div class="card-footer">
            <div style="float:left">
                <a href="{{route('viewshelter')}}"><button class="btn btn-secondary" type="button">Back</button></a>
            </div>
            <div style="float:right">
                <a href="{{route('approve.shelter', $shelter->id)}}"><button class="btn btn-success" type="button">Approve</button></a>
                <button class="btn btn-danger" id="btn" type="submit">Reject</button>
            </div>  
    </div>
</div>               
</div>  
@endsection

