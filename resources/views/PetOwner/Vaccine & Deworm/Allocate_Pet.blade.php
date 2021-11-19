@extends("mainpetowner")
@section("header")
Allocation of Vaccine & Deworming   
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div style="display:flex">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <!-- Animal header -->
            <div    
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            </div>
            <div class="card-body"style="height:600px">
                <div class="form-group-row" style="display:flex">
                    <div class="col-sm">
                        <div style="text-align:center; height:50%">
                        <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" style="border-radius:50%" width="100%" height="100%" alt=""><br>
                        </div>
                        <label class="text-sm">Name</label>
                        <input type="text" disabled value ="{{$animal->name}}"  class="form-control form-control-sm" id="name" name="name">
                                        
                        <label class="text-sm">Age</label>
                        <input type="text" disabled value ="{{$animal->age}}"  class="form-control form-control-sm" id="age" name="age">
                        
                        <label class="text-sm">Gender</label>
                        <input type="text" disabled value ="{{$animal->gender}}"  class="form-control form-control-sm" id="categ" name="gender">

                        <label class="text-sm">Breed</label>
                        <input type="text" disabled value ="{{$animal->breed}}"  class="form-control form-control-sm" id="breed" name="breed">
                    </div>    
                </div>            
            </div>
        </div>
        </div>
        <div class="col-md">    
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"></div>
                <div class="card-body">
                    <table id="datatable" class="table table-light table-hover">
                        <thead>
                            <tr>
                                <th> ID</th>
                                <th>Vaccine Name</th>
                                <th>Description</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notallocated as $vaccine)
                            <tr>
                                <td>{{ $vaccine['id']}}</td>
                                <td>{{ $vaccine['vac_name']}}</td>
                                <td>{{ $vaccine['vac_desc']}}</td>      
                                <td style="text-align:center"> 
                                <a href="{{url('/AllocationVaccine/view/petowner/'.$animal->id.'/'.$vaccine['id'])}}" class="btn btn-danger">Apply to Pet</a>  
                                </td> 
                            </tr> 
                        @endforeach($notallocated as $vaccine)
                        @if(empty($notallocated))   
                            <h6 class="alert alert-danger">No vaccine available for pet!</h6>
                        @endif  
                        </tbody>
                    </table>
                </div>
            </div>
                <div class="card shadow mb-4">
                    <div    
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    </div>
                    <div class="card-body">
                            <table id="datatable1" class="table table-light table-hover">
                                <thead>
                                    <tr>
                                        <th> ID</th>
                                        <th>Deworm Name</th>
                                        <th>Description</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                @foreach($notallocated1 as $deworm)
                                    <tr>
                                        <td>{{ $deworm['id']}}</td>
                                        <td>{{ $deworm['dew_name']}}</td>
                                        <td>{{ $deworm['dew_desc']}}</td>      
                                        <td style="text-align:center"> 
                                        <a href="{{url('AllocationDeworm/petowner/'.$animal->id.'/'.$deworm['id'])}}" class="btn btn-danger">Apply to Pet</a>    
                                        </td> 
                                    </tr> 
                                @endforeach
                                @if(empty($notallocated1))   
                                    <h6 class="alert alert-danger">No deworm available for pet!</h6>
                                @endif  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div>
</div>
@endsection
@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
        $(document).ready(function(){
          var table = $('#datatable1').DataTable();
        });
    </script>
@endpush
