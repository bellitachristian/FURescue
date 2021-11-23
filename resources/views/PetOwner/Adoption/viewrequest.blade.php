@extends("mainpetowner")
@section("header")
Adoption Requests
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
                            <th>Animal Photo</th>
                            <th>Animal Name</th>
                            <th>Adopter Name</th>
                            <th>View</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($adopter as $adopters)
                        <tr>
                            <td>{{$adopters->id}}</td>
                            @foreach($adopters->animals as $animalphoto)
                            <td>
                                <img src="{{asset('uploads/animals/'.$animalphoto->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$animalphoto->name}}</td>
                            @endforeach
                            @foreach($adopters->adopter as $adoption)
                            <td>{{$adoption->fname}} {{$adoption->lname}}</td>
                            @endforeach
                            <td>
                                
                            </td>
                            <td style="text-align:center">
                                <a href="#" id="edit"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#" id="delete"><i class="fas fa-trash-alt" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($adopters))   
                        <h6 class="alert alert-danger">No adoption request found!</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection