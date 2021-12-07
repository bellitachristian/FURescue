@extends("main")
@section("header")
Subscribed Promo
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <a href="/dashboard"><button class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subscription Name</th>
                            <th>Post Credits</th>
                            <th>Promo Price</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($promos as $promo)
                        <tr>
                            <td>{{$promo->id}}</td>
                            <td>
                               {{$promo->subscription->sub_name}}
                            </td>
                            <td>{{$promo->subscription->sub_credit}}</td>
                            <td>
                               {{$promo->subscription->sub_price}}
                            </td>
                            <td>{{$promo->expiry_date}}</td>
                            <td>
                                <button disabled class="btn btn-success">Completed</button>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($promo))   
                        <h6 class="alert alert-danger">No subscribed promo</h6>
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