@extends("Admin.main")
@section("header")
Transfer Adoption Fee
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header"></div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>UserType</th>
                            <th>Transfer to</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Amount</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($transfer as $money)
                        <tr>
                            <td>{{$money->id}}</td>
                            @if($money->usertype->id == 2)
                            <td>{{$money->usertype->usertype}}</td>
                            @foreach($money->usertype->shelter as $shelters)
                                @foreach($shelters->receipt as $receipts)
                                    <td>{{$receipts->shelter->shelter_name}}</td>
                                    <td>{{$receipts->shelter->email}}</td>
                                    <td>{{$receipts->shelter->contact}}</td>
                                @endforeach
                            @endforeach       
                            <td>{{$money->payment->fee}}</td>
                            <td>
                                <a href=""><button class="btn btn-success">Transfer</button></a>
                            </td>
                            @elseif($money->usertype->id == 3)
                            <td>{{$money->usertype->usertype}}</td>
                            @foreach($money->usertype->petowner as $petowners)
                                @foreach($petowners->receipt as $receipts) 
                                    <td>{{$receipts->petowner->fname}} {{$receipts->petowner->lname}}</td>
                                    <td>{{$receipts->petowner->email}}</td>
                                    <td>{{$receipts->petowner->contact}}</td>   
                                @endforeach
                            @endforeach
                            <td>{{$money->payment->fee}}</td>
                            <td>
                                <a href=""><button class="btn btn-success">Transfer</button></a>
                            </td>
                            @endif
                        </tr> 
                    @endforeach
                    @if(empty($sub))   
                        <h6 class="alert alert-danger">No money to be transferred</h6>
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