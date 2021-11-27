@extends("main")
@section("header")
Pet Owner's Request for Adoption
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
            </div>
            <div class="card-body">
            <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pet Owner's Photo</th>
                            <th>Pet Owner's Name</th>
                            <th>Animal Photo</th>
                            <th>Animal Name</th>
                            <th>View Details</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($response as $resp)
                        <tr>
                            <td>{{$resp->id}}</td>
                            <td>
                                <img src="{{asset('uploads/pet-owner/profile/'.$resp->petowner->profile)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$resp->petowner->fname}} {{$resp->petowner->lname}}</td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$resp->animal->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$resp->animal->name}}</td>
                            <td style="text-align:center">
                                 <a href="{{url('/View/PetOwner/request/'.$resp->animal->id. '/'.$resp->petowner->id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            <td style="text-align:center">
                                <a href="#" ><button data-toggle="modal" data-target="#message" type="button" class="btn btn-success">Approve</button></a>
                                <a href="#"><button data-toggle="modal" data-target="#error" type="button" class="btn btn-danger">Disapprove</button></a>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($resp))   
                        <h6 class="alert alert-danger">No adoption request found!</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if(empty($resp))
@else
@include('AnimalShelter.Request.Modal.message')
@include('AnimalShelter.Request.Modal.error')
@endif
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush