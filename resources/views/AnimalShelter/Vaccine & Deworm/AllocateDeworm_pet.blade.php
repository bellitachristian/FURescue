@extends("main")
@section("header")
Allocation of Deworming
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">
    <div class="col-md">
        <div class="card shadow mb-4">
            <!-- Animal header -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-md-3" style="display:flex">
                <h5>Deworming Name:</h5><button id ="vaccine_name" style="color:black; margin-top:-5px; margin-left:5px" disabled>{{$deworm->dew_name}}</button>
                
            </div>
                <div class="col-md" style="display:flex">
                <h5>Description: </h5><button style="color:black; margin-top:-5px; margin-left:5px" disabled>{{$deworm->dew_desc}}</button>
                </div>
            </div>
    <!-- Animal Content -->
    <div class="card-body">
    <table id="datatable" class="table table-light table-hover">
        <thead>
            <tr>
                <th> ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Category</th>
                <th>Age (Months)</th>
                <th>Breed</th>
                <th style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notallocated as $anim)
            <tr>
                <td>{{ $anim['id']}}</td>
                <td>
                        <img src="{{asset('uploads/animals/'.$anim['animal_image'])}}" width="70px" height="70px" alt="">
                </td>
                <td>{{ $anim['name']}}</td>
                <td>{{ $anim['category']}}</td>   
                <td>{{ $anim['age']}}</td>
                <td>{{ $anim['breed']}}</td>    
                <td style="text-align:center">   
                        <a href="{{url('AllocationDeworm/'.$anim['id']. '/'.$deworm->id)}}" class="btn btn-danger" >Apply</a>
                </td> 
            </tr> 
        @endforeach($notallocated as $anim)
        @if(empty($notallocated))   
            <h6 class="alert alert-danger">No pets available for allocation of deworming!</h6>
        @endif  
        </tbody>
    </table>
</div>
@endsection
@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush
