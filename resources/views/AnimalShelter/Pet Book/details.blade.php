@extends("main")
@section("header")
Details
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"> 
@endpush
@section("content")

<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
            </div>  
            <div class="card-body">
                <div style="display:flex; height:350px">
                    <div class="col-sm-5">
                        <img src="{{asset('uploads/animals/'.$petbook->animal_image)}}" style=" width:100%; height:100%;border-radius:3%" width="100%" height="75%" alt="">      
                    </div>  
                    <div class="col-sm">
                        <label>Name:</label>
                        <input type="text" readOnly class="form-control" value="{{$petbook->name}}">
                        <label>Age:</label>
                        <input type="text" readOnly class="form-control" value="{{$petbook->age}}">
                        <label>Life Stage:</label>
                        <input type="text" readOnly class="form-control" value="{{$petbook->pet_stage}}">
                        <label>Size:</label>
                        <input type="text" readOnly class="form-control" value="{{$petbook->size}}">
                        <label>Color:</label>
                        <input type="text" readOnly class="form-control" value="{{$petbook->color}}">
                    </div>
                    <div class="col-sm">
                        <label>History:</label><br>
                        <textarea disabled cols="50" rows="5">{{$petbook->history}}</textarea>
                        <label>Additional Info:</label><br>
                        <textarea disabled cols="50" rows="5">{{$petbook->info}}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div> 

<div style="display:flex">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>Vaccine Name</th>
                            <th>Vaccinated Date</th>
                            <th>Vaccine Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vaccine as $vaccines)
                        <tr>
                            <td>{{$vaccines->vac_name}}</td>
                            <td>{{$vaccines->vac_date}}</td>
                            <td>{{$vaccines->vac_expiry}}</td>
                            <td>
                            @if($vaccines->stats == "Active")
                            <button type="button" disabled class="btn btn-success">{{ $vaccines->stats}}</button>
                            @else
                            <button type="button" disabled class="btn btn-secondary">{{ $vaccines->stats}}</button>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
            </div>
            <div class="card-body">
            <table id="datatable1" class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>Deworm Name</th>
                            <th>Dewormed Date</th>
                            <th>Deworm Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($deworm as $deworms)
                        <tr>
                            <td>{{$deworms->dew_name}}</td>
                            <td>{{$deworms->dew_date}}</td>
                            <td>{{$deworms->dew_expiry}}</td>
                            <td>
                            @if($deworms->stats == "Active")
                            <button type="button" disabled class="btn btn-success">{{ $deworms->stats}}</button>
                            @else
                            <button type="button" disabled class="btn btn-secondary">{{ $deworms->stats}}</button>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
@endsection
@push("js")
<script src="{{url('https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
    var table = $('#datatable').DataTable();
 })
 $(document).ready(function(){
    var table = $('#datatable1').DataTable();
 })
</script>

@endpush
