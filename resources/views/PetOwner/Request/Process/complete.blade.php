@extends("mainpetowner")
@section("header")
Completed Request
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
                            <th style="text-align:center">Slip Number</th>
                            <th style="text-align:center">Shelter Profile</th>
                            <th style="text-align:center">Shelter Name</th>
                            <th style="text-align:center">Animal Photo</th>
                            <th style="text-align:center">Animal Name</th>
                            <th style="text-align:center">Approved Date</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($generated as $generate)
                        <tr>
                            <td style="text-align:center">{{$generate->id}}</td>
                            <td style="text-align:center" >{{$generate->slip_number}}</td>
                            <td style="text-align:center">
                                <img src="{{asset('uploads/animal-shelter/profile/'.$generate->shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td style="text-align:center">{{$generate->shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                <img src="{{asset('uploads/animals/'.$generate->animal->animal_image)}}" width="70px" height="70px" alt="">
                            </td >
                            <td style="text-align:center">{{$generate->animal->name}}</td>
                            <td style="text-align:center">{{$generate->date_approve}}</td>
                            <td style="text-align:center">
                                <button disabled class="btn btn-success">Completed</button>
                            </td>
                        </tr>
                    @endforeach
                    @if(empty($generate))
                        <h6 class="alert alert-danger">No completed request</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-header">
                <a href="{{route('view.request.adoption')}}"><button type="button" class="btn btn-secondary">Back</button></a>
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