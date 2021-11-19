@extends("Admin.main")
@section("header")
Animal Shelter Applications
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
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th style="text-align:center">Valid Files</th>
                    <th>Details</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($shelter as $shelters)
                <tr>
                    <td>{{ $shelters->id}}</td>
                    <td>{{ $shelters->shelter_name}}</td>
                    <td>{{ $shelters->email}}</td>
                    <td>{{ $shelters->address}}</td>
                    <td>{{ $shelters->contact}}</td>
                    <td style="text-align:center">
                        @foreach($shelters->shelterPhoto as $photo)
                            @if($photo['extension'] == "pdf" || $photo['extension'] == "docx")
                            {{$photo['filename']}}
                            @else
                            <img src="{{asset('uploads/valid-documents/'.$photo['filename'])}}" width="50px" height="40px">
                            @endif
                        @endforeach
                    </td>
                    <td style="text-align:center">
                            <a href="{{route('viewdetails',$shelters->id)}}"><i class="far fa-eye"></i></a>
                    </td>
                    <td>
                        <a href="{{route('approve.shelter', $shelters->id)}}"><button style="margin-bottom:3px" class="btn btn-success" type="button">Approve</button></a>
                        <a href="{{route('reject.shelter', $shelters->id)}}"><button style="width:90px"  class="btn btn-danger" type="button">Reject</button></a>
                    </td>
                </tr>
                @endforeach($shelter as $shelters)
                @if(empty($shelters))
                <h6 class="alert alert-danger">No data for shelters exist!</h6>
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

