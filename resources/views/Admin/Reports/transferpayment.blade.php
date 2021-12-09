@extends("Admin.main")
@section("header")
Transferred Payment History
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
            <form action="{{route('searchtransfer.admin')}}" method="POST">
                <div style="display:flex">
                        @csrf
                        <div class="col-sm">
                            <label for="">From Date</label><span><input type="date" name="fromdate" required class="form-control" id=""></span>&nbsp&nbsp
                        </div>
                        <div class="col-sm">
                            <label for="">To Date</label><span><input type="date" name="todate" required class="form-control" id=""></span>
                        </div>
                        <div class="col-sm">
                            <span><button type="submit" style="margin-top:30px" class="btn btn-danger">Generate Report</button></span>
                        </div>
                    <div style="float:right">
                        <span><button id="print"type="button"><i class="fa fa-print"></i> Print Report</button></span>
                    </div>
                </div>
             </form>
            </div>
            <div class="card-body" id="printreport">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center">ID</th>
                            <th style="text-align:center">UserType</th>
                            <th style="text-align:center">Profile</th>
                            <th style="text-align:center">Transfer to</th>
                            <th style="text-align:center">Email</th>
                            <th style="text-align:center">Contact Number</th>
                            <th style="text-align:center">Amount</th>
                            <th style="text-align:center">Date Transferred</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($transfers as $money)
                        <tr>
                        <td style="text-align:center">{{$money->id}}</td>
                            @if($money->usertype->id == 2)
                            <td style="text-align:center">{{$money->usertype->usertype}}</td>
                                    <td style="text-align:center">
                                        <img src="{{asset('uploads/animal-shelter/profile/'.$money->shelter->profile)}}" width="70px" height="70px" alt="">
                                    </td>
                                    <td style="text-align:center">{{$money->shelter->shelter_name}}</td>
                                    <td style="text-align:center">{{$money->shelter->email}}</td>
                                    <td style="text-align:center">{{$money->shelter->contact}}</td>   
                          
                            <td style="text-align:center">{{$money->payment->fee}}</td>
                            <td style="text-align:center">{{ \Carbon\Carbon::parse($money->updated_at)->format('F d, Y')}}</td>
                            <td style="text-align:center">
                                <button disabled class="btn btn-success">Completed</button>
                            </td>
                            @elseif($money->usertype->id == 3)
                            <td style="text-align:center">{{$money->usertype->usertype}}</td>
                                    <td style="text-align:center">
                                        <img src="{{asset('uploads/pet-owner/profile/'.$money->petowner->profile)}}" width="70px" height="70px" alt="">
                                    </td>
                                    <td style="text-align:center">{{$money->petowner->fname}} {{$money->petowner->lname}}</td>
                                    <td style="text-align:center">{{$money->petowner->email}}</td>
                                    <td style="text-align:center">{{$money->petowner->contact}}</td>   
            
                            <td style="text-align:center">{{$money->payment->fee}}</td>
                            <td style="text-align:center">{{ \Carbon\Carbon::parse($money->updated_at)->format('F d, Y')}}</td>
                            <td style="text-align:center">
                                <button disabled class="btn btn-success">Completed</button>
                            </td>
                            @endif
                        </tr> 
                    @endforeach
                    @if(empty($money))   
                        <h6 class="alert alert-danger">No Payment has been transferred</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('view.reports.admin')}}"><button class="btn btn-danger">Back</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.js" integrity="sha512-BaXrDZSVGt+DvByw0xuYdsGJgzhIXNgES0E9B+Pgfe13XlZQvmiCkQ9GXpjVeLWEGLxqHzhPjNSBs4osiuNZyg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js" integrity="sha512-t3XNbzH2GEXeT9juLjifw/5ejswnjWWMMDxsdCg4+MmvrM+MwqGhxlWeFJ53xN/SBHPDnW0gXYvBx/afZZfGMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#datatable').DataTable();
});
$('#print').click(function(){
    $("#printreport").print();
});
</script>
@endpush