@extends("mainpetowner")
@section("header")
Request to {{$shelter->shelter_name}}
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group-row" style="display:flex">
                    <div class="col-sm">
                        <div style="text-align:center">
                            <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" width="170px" height="150px" alt="">
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
                </div>                                                
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <form id="myForm" action="POST">
                    <a href="#"><button type="button" class="btn btn-success">Submit All</button></a>
                </form>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal Photo</th>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <th>Life Stage</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($animals as $animal)
                        <tr>
                            <td>{{$animal->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$animal->name}}</td>
                            <td>{{$animal->breed}}</td>
                            <td>{{$animal->age}}</td>
                            <td>{{$animal->pet_stage}}</td>
                            <td>
                                <a href=""><button type="button" class="btn btn-success">Select</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($animal))   
                        <h6 class="alert alert-danger">No animals being posted for adoption</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('view.request.adoption')}}"><button type="button" class="btn btn-secondary">Back</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable({
        });
    });
    </script>
@endpush