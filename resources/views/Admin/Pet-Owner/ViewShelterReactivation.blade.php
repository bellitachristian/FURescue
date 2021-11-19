@extends("Admin.main")
@section("header")
Pet Owner Reactivation Requests
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="{{route('approve.all')}}"><button style="margin-bottom:3px" class="btn btn-danger" type="button">Approve All</button></a>
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Owner Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Deactivate Reason</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($petowner as $petowners)
                <tr>
                    <td>{{ $petowners->id}}</td>
                    <td>{{ $petowners->fname}} {{ $petowners->lname}}</td>
                    <td>{{ $petowners->email}}</td>
                    <td>{{ $petowners->address}}</td>
                    <td>{{ $petowners->contact}}</td>
                    <td style="text-align:center">
                        {{ $petowners->deact_reason}}
                    </td>
                    <td>
                        <a href="{{route('approve.reactivation.petowner', $petowners->id)}}"><button style="margin-bottom:3px" class="btn btn-success" type="button">Approve</button></a>
                    </td>
                </tr>
                @endforeach
                @if(empty($petowners))
                <h6 class="alert alert-danger">No data for reactivation of Pet Owners</h6>
                @endif   
        </tbody>
    </table>
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

