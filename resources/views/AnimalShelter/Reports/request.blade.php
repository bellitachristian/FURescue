@extends("main")
@section("header")
Adoption Request
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <a href="/dashboard"><button class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Adopter Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Pet Interest</th>
                            <th>Name</th>
                            <th>Breed</th>
                            <th>Pet Life Stage</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($adoption as $adopt)
                        <tr>
                            <td>{{$adopt->id}}</td>
                            <td>
                                <img src="{{asset('phpcode/validid/'.$adopt->adopter->picture)}}" width="170px" height="170px" />
                            </td>
                            <td>{{$adopt->adopter->fname}} {{$adopt->adopter->lname}}</td>
                            <td>{{$adopt->adopter->email}}</td>
                            <td>
                               {{$adopt->adopter->phonenum}}
                            </td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$adopt->animals->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$adopt->animals->name}}</td>
                            <td>{{$adopt->animals->breed}}</td>
                            <td>{{$adopt->animals->pet_stage}}</td>
                        </tr> 
                    @endforeach
                    @if(empty($animal))   
                        <h6 class="alert alert-danger">No adoption requests</h6>
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