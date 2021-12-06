@extends("main")
@section("header")
Receipts
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
                        <a href="{{route('adoption.confirmed.result')}}" style="color:#42ba96"><h5 style="font-weight:bold;">Confirmed Receipts</h5></div></a> 
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count}}</div>
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
            </div>
            <div class="card-body">
            <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Receipt Number</th>
                            <th>Adopter Photo</th>
                            <th>Adopter Name</th>
                            <th>Adopter Email</th>
                            <th>Adopter Contact No.</th>
                            <th>Animal Photo</th>
                            <th>Animal Name</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($receipts as $receipt)
                        <tr>
                            <td>{{$receipt->id}}</td>
                            <td>{{$receipt->receipt_no}}</td>
                            <td>
                                <img src="{{asset('/phpcode/adopter/'.$receipt->adopter->photo)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$receipt->adopter->fname}} {{$receipt->adopter->lname}}</td>
                            <td>{{$receipt->adopter->email}}</td>
                            <td>{{$receipt->adopter->phonenum}}</td>
                            <td>
                                <img src="{{asset('uploads/animals/'.$receipt->animal->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td>{{$receipt->animal->name}}</td>
                            <td style="text-align:center">
                                <a href="{{route('confirm.receipt.shelter',$receipt->id)}}"><button type="button" class="btn btn-success">Confirm Receipt</button></a>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($receipt))   
                        <h6 class="alert alert-danger">No receipt found!</h6>
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