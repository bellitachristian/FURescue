@extends("mainpetowner")
@section("header")
Adoption History
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <div style="display:flex">
                    <div class="col-sm">
                        <label for="">Start Date</label><span><input type="date" name="" required class="form-control" id=""></span>&nbsp&nbsp
                    </div>
                    <div class="col-sm">
                        <label for="">End Date</label><span><input type="date" name="" required class="form-control" id=""></span>
                    </div>
                    <div class="col-sm">
                        <span><button style="margin-top:30px" class="btn btn-danger">Generate Report</button></span>
                    </div>
                    <div class="col-sm">
                        <button id="print" type="button"><i class="fa fa-print"></i>Print Report</button>                     
                    </div>
                </div>
            </div>
            <div class="card-body" id="printreport">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="text-align:center">Adopted Pet Photo</th>
                            <th style="text-align:center">Adopted Pet Name</th>
                            <th style="text-align:center">Adopter Photo</th>
                            <th style="text-align:center">Adopter Name</th>
                            <th style="text-align:center">View Application</th>
                            <th style="text-align:center">Date Pet Adopted</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($adoption as $adopt)
                        <tr>
                            <td>{{$adopt->id}}</td>
                            <td  style="text-align:center">
                            <img src="{{asset('uploads/animals/'.$adopt->animal->animal_image)}}" width="70px" height="70px" alt="photo">
                            </td> 
                            <td  style="text-align:center">{{$adopt->animal->name}}</td>
                            <td style="text-align:center">
                            <img src="{{asset('/phpcode/adopter/'.$adopt->adopter->photo)}}" width="70px" height="70px" alt="photo">
                            </td>
                            <td  style="text-align:center">{{$adopt->adopter->fname}} {{$adopt->adopter->lname}}</td>
                            <td style="text-align:center">
                            <a href=""><i class="far fa-eye"></i></a>
                            </td>
                            <td  style="text-align:center">{{ \Carbon\Carbon::parse($adopt->animal->updated_at)->format('F d, Y')}}</td>
                            <td  style="text-align:center">
                                <button disabled class="btn btn-success">Adopted</button>
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($adopt))   
                        <h6 class="alert alert-danger">No Adoption History</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{route('reports')}}"><button class="btn btn-danger">Back</button></a>
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