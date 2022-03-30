@extends("mainpetowner")
@section("header")
Archive Deworm
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

                    <div>
                        <a href="{{route('vaccine.deworm.view')}}"><button class="btn btn-secondary">Back</button></a>
                    </div>
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deworm Name</th>
                    <th>Description</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($deworm as $dew)
                <tr>
                    <td>{{$dew->id}}</td>
                    <td>{{$dew->dew_name}}</td>
                    <td>{{$dew->dew_desc}}</td>
                    <td style="text-align:center">
                        <a href="{{route('restore_deworm.petowner',$dew->id)}}"><button class="btn btn-dark">Restore</button></a>
                    </td>
                </tr>   
                @endforeach()
                @if(empty($dew))
                <h6 class="alert alert-danger">No archived deworm!</h6>
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
