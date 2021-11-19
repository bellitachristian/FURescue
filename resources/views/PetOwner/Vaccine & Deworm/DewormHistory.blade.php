@extends("mainpetowner")
@section("header")
Deworm History
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th style="text-align:center">Pet Image</th>
                    <th>Pet Name</th>
                    <th>Deworm Name</th>
                    <th>Deworm Description</th>
                    <th>Dewormed Date</th>
                    <th>Deworm Expiry</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($apply as $deworm)
                <tr>
                    <td style="text-align:center">
                        <img src="{{asset('uploads/animals/'.$deworm->animal_image)}}" width="70px" height="70px" alt="">
                    </td>
                    <td>{{ $deworm->name}}</td>
                    <td>{{ $deworm->dew_name}}</td>
                    <td>{{ $deworm->dew_desc}}</td>
                    <td>{{ $deworm->dew_date}}</td>
                    <td>{{ $deworm->dew_expiry_date}}</td>
                    <td>
                        @if($deworm->stats == "Active")
                        <button type="button" disabled class="btn btn-success">{{ $deworm->stats}}</button>
                        @else
                        <button type="button" disabled class="btn btn-secondary">{{ $deworm->stats}}</button>
                        @endif
                    </td>
                </tr>   
                @endforeach($apply as $deworm)
                @if(empty($deworm))
                <h6 class="alert alert-danger">No dewormed animals</h6>
                @endif   
            </tbody>
        </table>
</div>

<!-- Vaccine and deworm Content -->

@endsection
@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
  
@endpush
