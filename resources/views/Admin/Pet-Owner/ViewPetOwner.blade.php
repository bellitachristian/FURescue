@extends("Admin.main")
@section("header")
Pet Owner Applications
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
            @foreach($petowner as $owner)
                <tr>
                    <td>{{ $owner->id}}</td>
                    <td>{{ $owner->fname}} {{$owner->lname}}</td>
                    <td>{{ $owner->email}}</td>
                    <td>{{ $owner->address}}</td>
                    <td>{{ $owner->contact}}</td>
                    <td style="text-align:center">
                        @foreach($owner->petownerPhoto as $photo)
                            @if($photo['extension'] == "pdf" || $photo['extension'] == "docx")
                            {{$photo['filename']}}
                            @else
                            <img src="{{asset('uploads/valid-documents/'.$photo['filename'])}}" width="50px" height="40px">
                            @endif
                        @endforeach
                    </td>
                    <td style="text-align:center">
                            <a href="{{route('viewownerdetails',$owner->id)}}"><i class="far fa-eye"></i></a>
                    </td>
                    <td>
                        <a href="{{route('approve.petowner', $owner->id)}}"><button style="margin-bottom:3px" class="btn btn-success" type="button">Approve</button></a>
                        <a href="#"><button data-toggle="modal" data-target="#message"  style="width:90px"  class="btn btn-danger" type="button">Reject</button></a>
                    </td>
                </tr>
                @endforeach
                @if(empty($owner))
                <h6 class="alert alert-danger">No data for pet owners exist!</h6>
                @endif   
        </tbody>
    </table>
</div>
</div>
@if(empty($owner))
@else
@include('Admin.Pet-Owner.Modal.reject')
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

