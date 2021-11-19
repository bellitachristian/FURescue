@extends("main")
@section("header")
Vaccination History
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
                    <th>Vaccine Name</th>
                    <th>Vaccine Description</th>
                    <th>Vaccinated Date</th>
                    <th>Vaccine Expiry</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($apply as $vaccine)
                <tr>
                    <td style="text-align:center">
                        <img src="{{asset('uploads/animals/'.$vaccine->animal_image)}}" width="70px" height="70px" alt="">
                    </td>
                    <td>{{ $vaccine->name}}</td>
                    <td>{{ $vaccine->vac_name}}</td>
                    <td>{{ $vaccine->vac_desc}}</td>
                    <td>{{ $vaccine->vac_date}}</td>
                    <td>{{ $vaccine->vac_expiry_date}}</td>
                    <td>
                        @if($vaccine->stats == "Active")
                        <button type="button" disabled class="btn btn-success">{{ $vaccine->stats}}</button>
                        @else
                        <button type="button" disabled class="btn btn-secondary">{{ $vaccine->stats}}</button>
                        @endif
                    </td>
                </tr>   
                @endforeach($apply as $vaccine)
                @if(empty($vaccine))
                <h6 class="alert alert-danger">No vaccinated animals</h6>
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
