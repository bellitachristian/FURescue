@extends("mainpetowner")
@section("header")
Approved Request
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div style="display:flex">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href=""><button type="button" class="btn btn-success">Generate All</button></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th style="text-align:center">Feedback</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shelters as $shelter)
                        <tr>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                {{$shelter->feedback}}
                            </td >
                            <td style="text-align:center">
                                <a href="{{route('select',$shelter->id)}}"><button type="button" class="btn btn-success">Generate Adoption Slip</button></a>       
                            </td>
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No approve request</h6>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="card-header">
                <a href="{{route('view.request.adoption')}}"><button type="button" class="btn btn-secondary">Back</button></a>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h4 style="color:black">Generated Slip</h4>
            </div>
            <div class="card-body">
                <table id="datatable1" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Slip Number</th>
                            <th>Approved Date</th>
                            <th style="text-align:center">View Slip</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shelters as $shelter)
                        <tr>
                            <td>{{$shelter->id}}</td>
                            <td>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->shelter->profile)}}" width="70px" height="70px" alt="">
                            </td>
                            <td>{{$shelter->shelter->shelter_name}}</td>
                            <td style="text-align:center">
                                {{$shelter->feedback}}
                            </td >
                            <td style="text-align:center">
                                <a href="{{route('generate',$shelter->id)}}"><button type="button" class="btn btn-success">Generate Adoption Slip</button></a>       
                            </td>   
                        </tr> 
                    @endforeach
                    @if(empty($shelter))   
                        <h6 class="alert alert-danger">No generated slip</h6>
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
        $(document).ready(function(){
          var table = $('#datatable1').DataTable();
        });
    </script>
@endpush