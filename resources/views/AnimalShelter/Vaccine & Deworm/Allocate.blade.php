@extends("main")
@section("header")
Allocate 
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Breed</th>  
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($animal as $anim)
                <tr>
                    <td >{{ $anim->id}}</td>
                    <td>
                    <img src="{{asset('uploads/animals/'.$anim->animal_image)}}" width="70px" height="70px" alt="">
                    </td>
                    <td>{{ $anim->name}}</td>
                    <td>{{ $anim->age}}</td>
                    <td>{{ $anim->gender}}</td>
                    <td>{{ $anim->breed}}</td>
                    <td style="text-align:center">
                        <a href="AllocateVaccine/{{$anim->id}}" class="btn btn-danger">Apply Vaccine/Deworming</a>
                    </td>
                </tr>
                @endforeach
                @if(empty($anim))
                <h6 class="alert alert-danger">No data for pet exist!</h6>
                @endif   
        </tbody>
    </table>
</div>
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