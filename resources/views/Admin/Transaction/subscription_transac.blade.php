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
                            <th>Payment Proof</th>
                            <th>View</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subscriptions as $sub)
                        <tr>
                            <td>{{$sub->id}}</td>
                            <td>{{$sub->subscription->sub_name}}</td>
                            <td>{{$sub->subscription->sub_price}}</td>
                            <td>{{$sub->shelter->shelter_name}}</td>
                            @foreach($sub->shelter->)
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
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
      var table = $('#datatable').DataTable();
    });
</script>
@endpush