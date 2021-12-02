@extends("main")
@section("header")
Pet Owner's Adoption Slip
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
@endpush
@section("content")
<div class="row">
    <div class="col-sm-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <a href="{{route('adoption.confirmed.view')}}" style="color:#42ba96"><h5 style="font-weight:bold;">Confirmed Slip</h5></div></a> 
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countconfirm}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:1%" class="row">    
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h4 style="color:black">Slips to be Confirmed</h4>
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
                            <th style="text-align:center">Action</th>
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
                                <a href="#"><button data-toggle="modal" data-target="#confirm" class="btn btn-success">Confirm</button></a>
                            </td>
                        </tr>
                    @endforeach
                    @if(empty($generate))
                        <h6 class="alert alert-danger">No slip to be confirmed</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if(empty($generate))
@else
@include('AnimalShelter.AdoptionSlip.confirmation')
@endif
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable1').DataTable(); 
        });
    </script>
@endpush