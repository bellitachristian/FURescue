@extends("Admin.main")
@section("header")
Adoption Payment
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal Photo</th>
                            <th>Animal Name</th>
                            <th>Adopter Name</th>
                            <th>Adopter Email</th>
                            <th>Owner Name</th>
                            <th>Adoption Fee</th>
                            <th>Message</th>
                            <th style="text-align:center">View</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{$payment->id}}</td>
                            <td></td>
                            <td>{{$payment->animals->name}}</td>
                            <td>{{$payment->adopter->fname}} {{$payment->adopter->lname}}</td>
                            <td>{{$payment->adopter->email}}</td>
                            @if($payment->owner_type == "2")  
                            <td>{{$payment->owner_id}}</td>
                            @elseif($payment->owner_type == "3")
                            <td>{{$payment->owner_id}}</td>
                            @endif
                            <td>{{$payment->fee}}</td>
                            <td>{{$payment->message}}</td>
                            @if($payment->owner_type == "2")
                            <td>
                                <a href="{{route('enlarge.payment',$payment->id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            @elseif($payment->owner_type == "3")
                            <td>
                                <a href="{{route('enlarge.payment',$payment->id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            @endif
                            @if($payment->owner_type == "2")
                            <td  style="text-align:center">
                                <a href="#"><button style="margin-bottom:3px" data-toggle="modal" data-target="#shelter"  class="btn btn-success" type="button">Approve</button></a>
                                <a href="#"><button style="width:90px" data-toggle="modal" data-target="#shelter1"  class="btn btn-danger" type="button">Reject</button></a>
                            </td>
                            @elseif($payment->owner_type == "3")
                            <td  style="text-align:center">
                                <a href=""><button style="margin-bottom:3px" data-toggle="modal" data-target="#adoption" class="btn btn-success" type="button">Approve</button></a>
                                <a href="#"><button style="width:90px" data-toggle="modal" data-target="#adoption1"  class="btn btn-danger" type="button">Reject</button></a>
                            </td>
                            @endif
                        </tr> 
                    @endforeach
                    @if(empty($payment))   
                        <h6 class="alert alert-danger">No data for adoption payment exist</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@foreach($payments as $payment)
@if($payment->owner_type == "2")  
@include('Admin.Transaction.Modal.feedbackadoption')
@include('Admin.Transaction.Modal.feedbackadoptionerror')
@elseif($payment->owner_type == "3")
@include('Admin.Transaction.Modal.feedbackpetowner')
@include('Admin.Transaction.Modal.feedbackerrorpet')
@endif
@endforeach
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
      var table = $('#datatable').DataTable();
    });
</script>
@endpush