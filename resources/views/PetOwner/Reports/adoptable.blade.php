@extends("mainpetowner")
@section("header")
Adoptable Pets
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <a href="/pet-owner/dashboard"><button class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal Photo</th>
                            <th>Animal Name</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <th>Pet Stage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($animals as $animal)
                        <tr>
                            <td>{{$animal->id}}</td>
                            <td>
                            <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$animal->name}}</td>
                            <td>{{$animal->breed}}</td>
                            <td>
                               {{$animal->age}}
                            </td>
                            <td>{{$animal->pet_stage}}</td>
                            <td>
                                <button disabled class="btn btn-success">Available</button>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($animal))   
                        <h6 class="alert alert-danger">No available pets for adoption</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush