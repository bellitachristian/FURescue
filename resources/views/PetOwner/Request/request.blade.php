@extends("mainpetowner")
@section("header")
Request Adoption
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-md">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        <a href="{{route('sent')}}"><h5 style="font-weight:bold">Request Sent</h5></div></a> 
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countsentreq}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        <a href="{{route('rejected')}}" style="color:#df4759"><h5 style="font-weight:bold">Request rejected</h5></div></a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countrejectreq}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <a href="{{route('approved')}}" style="color: #ffc107"><h5 style="font-weight:bold">Request Approved</h5></div></a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countapprovereq}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <a href="{{route('complete')}}" style="color:#42ba96"><h5 style="font-weight:bold">Completed</h5></div></a>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$countcomplete}}</div>
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
                <a href=""><button type="button" class="btn btn-danger">Request Selected</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center"><input id="all" type="checkbox"></th>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th style="text-align:center">View Shelter Details</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shelters as $shelter)
                        <tr>
                            <td style="text-align:center"><input type="checkbox" class="item" name="" id="" value="{{$shelter->id}}"></td>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                <a href="{{route('shelter.details',$shelter->id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            <td style="text-align:center">
                                <a href="{{route('select',$shelter->id)}}"><button type="button" class="btn btn-success">Request</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No shelters available for request of adoption</h6>
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
          $("#all").change(function(){
              $("input:checkbox").prop("checked",$(this).prop("checked"))
          })
          $(".item").change(function(){
              if($(this).prop("checked")==false){
                  $("#all").prop("checked",false)
              }
              if($(".item:checked").length == $("item").length){
                  $("#all").prop("checked",true)
              }
          })
        });
    </script>
@endpush