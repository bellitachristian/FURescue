@extends("main")
@section("header")
Archived Pets
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div style="margin-top:1%" class="row">
    <div class="col-md">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <a href="/AnimalManagement"><button class="btn btn-secondary">Back</button></a>
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
                            <th hidden>Category</th>
                            <th>Age</th>
                            <th>Life Stage</th>
                            <th>Breed</th>
                            <th>History</th>
                            <th>Additional Info</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($animal as $anim)
                        <tr>
                            <td>{{ $anim->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$anim->animal_image)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{ $anim->name}}</td>
                            <td hidden>{{ $anim->category}}</td>   
                            <td>{{ $anim->age}}</td>
                            <td>{{ $anim->pet_stage}}</td>
                            <td>{{ $anim->breed}}</td>
                            <td>{{ $anim->history}}</td>
                            <td>{{ $anim->info}}</td>
                            <td style="text-align:center">
                                <a href="{{route('restore_pet',$anim->id)}}"><button class="btn btn-dark">Restore</button></a>
                            </td>
                        </tr> 
                    @endforeach($animal as $anim)
                    @if(empty($anim))   
                        <h6 class="alert alert-danger">No archived pets!</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush

