@extends("mainpetowner")
@section("header")
Request Adoption
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href=""><button type="button" class="btn btn-danger">Request All</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Contact Number</th>
                            <th>View</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shelters as $shelter)
                        <tr>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter_name}}</td>
                            <td>{{$shelter->email}}</td>
                            <td>{{$shelter->address}}</td>
                            <td>{{$shelter->founder_name}}</td>
                            <td>{{$shelter->contact}}</td>
                            <td>
                                <a href=""><i class="far fa-eye"></i></a>
                            </td>
                            <td>
                                <a href=""><button type="button" class="btn btn-success">Request</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No data exist for adoption policy! Add Adoption Policy +</h6>
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