@extends("mainpetowner")
@section("header")
Revenue
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <a href="/pet-owner/dashboard"><button class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction Type</th>
                            <th>Receipt No.</th>
                            <th>Received Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($revenue as $rev)
                        <tr>
                            <td>{{$rev->id}}</td>
                            <td>Adoption Fee</td>
                            <td>{{$rev->receipt_no}}</td>
                            <td>{{$rev->updated_at}}</td>
                            <td>
                               {{$rev->animal->fee}}
                            </td>
                            <td>
                                <button disabled class="btn btn-success">Completed</button>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($rev))   
                        <h6 class="alert alert-danger">No revenue</h6>
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