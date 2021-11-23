@extends("Admin.main")
@section("header")
Subscription Transaction
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
                            <th>Subscription Name</th>
                            <th>Price</th>
                            <th>Subscriber</th>
                            <th  style="text-align:center">Payment Proof</th>
                            <th  style="text-align:center">View</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    @foreach($subscriptions as $sub)
                        <tr>
                            <td>{{$sub->id}}</td>
                            <td>{{$sub->subscription->sub_name}}</td>
                            <td>{{$sub->subscription->sub_price}}</td>
                            @if($sub->shelter)
                            <td>{{$sub->shelter->shelter_name}}</td>
                            @elseif($sub->petowner)
                            <td>{{$sub->petowner->fname}}</td>
                            @endif
                            @if($sub->shelter)
                            <td style="text-align:center">
                            @foreach($sub->subscription->proofpayment as $subs)
                                <img src="{{asset('uploads/animal-shelter/uploaded-photos/'.$subs->imagename)}}" width="90px" height="70px">   
                            @endforeach
                            </td>
                            @elseif($sub->petowner)
                            <td style="text-align:center">
                            @foreach($sub->subscription->proofpayment as $subs)
                                <img src="{{asset('uploads/pet-owner/uploaded-photos/'.$subs->imagename)}}" width="90px" height="70px">
                            @endforeach
                            </td>
                            @endif
                            @if($sub->shelter)
                            <td  style="text-align:center">
                                <a href="{{url('/Admin/viewenlargeproof/'.$sub->sub_id.'/'.$sub->shelter_id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            @elseif($sub->petowner)
                            <td  style="text-align:center">
                                <a href="{{url('/Admin/viewenlargeproof/'.$sub->sub_id.'/'.$sub->petowner_id)}}"><i class="far fa-eye"></i></a>
                            </td>
                            @endif
                            @if($sub->shelter)
                            <td  style="text-align:center">
                                <a href="{{url('/Admin/Approveproofpayment/'.$sub->sub_id.'/'.$sub->shelter_id)}}"><button style="margin-bottom:3px" class="btn btn-success" type="button">Approve</button></a>
                                <a href="#"><button style="width:90px" data-toggle="modal" data-target="#feedback"  class="btn btn-danger" type="button">Reject</button></a>
                            </td>
                            @elseif($sub->petowner)
                            <td  style="text-align:center">
                                <a href="{{url('/Admin/Approveproofpayment/'.$sub->sub_id.'/'.$sub->petowner_id)}}"><button style="margin-bottom:3px" class="btn btn-success" type="button">Approve</button></a>
                                <a href="#"><button style="width:90px" data-toggle="modal" data-target="#feedback1"  class="btn btn-danger" type="button">Reject</button></a>
                            </td>
                            @endif
                        </tr> 
                    @endforeach
                    @if(empty($sub))   
                        <h6 class="alert alert-danger">No data for subscription transaction exist</h6>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@foreach($subscriptions as $sub)
@if($sub->shelter)
@include('Admin.Transaction.Modal.feedbackmessage')
@elseif($sub->petowner)
@include('Admin.Transaction.Modal.feedbackmessagepetowner')
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