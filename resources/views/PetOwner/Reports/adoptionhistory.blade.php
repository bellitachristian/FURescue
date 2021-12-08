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
                    <div class="col-sm-3">
                        <label for="">Start Date</label><span><input type="date" name="" class="form-control" id=""></span>&nbsp&nbsp
                    </div>
                    <div class="col-sm-3">
                        <label for="">End Date</label><span><input type="date" name="" class="form-control" id=""></span>
                    </div>
                    <div class="col-sm-3">
                        <label for=""></label>
                        <span><button class="btn btn-danger">Generate</button></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
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
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
@endpush