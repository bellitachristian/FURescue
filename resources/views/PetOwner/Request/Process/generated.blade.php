@extends("mainpetowner")
@section("header")
<a href="{{route('approved')}}">Approved Request </a>/ Generated Slip
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
@endpush
@section("content")
<div class="row">    
<div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h4 style="color:black">Generated Slip</h4>
            </div>
            <div class="card-body">
                <table id="datatable1" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="text-align:center">Slip Number</th>
                            <th style="text-align:center">Shelter Profile</th>
                            <th style="text-align:center">Shelter Name</th>
                            <th style="text-align:center">Animal Photo</th>
                            <th style="text-align:center">Animal Name</th>
                            <th style="text-align:center">Approved Date</th>
                            <th style="text-align:center">Print Slip</th>
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
                                <a href=""><i class="fas fa-print"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @if(empty($generate))
                        <h6 class="alert alert-danger">No generated slip</h6>
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
          var table = $('#datatable1').DataTable(); 
        });
    </script>
@endpush