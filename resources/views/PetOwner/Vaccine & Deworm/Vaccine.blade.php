@extends("mainpetowner")
@section("header")
Vaccination & Deworming
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddVaccine" >Add Vaccine +</button>
                    </div>
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vaccine Name</th>
                    <th>Description</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($vac as $vaccine)
                <tr>
                    <td>{{$vaccine->id}}</td>
                    <td>{{ $vaccine->vac_name}}</td>
                    <td>{{ $vaccine->vac_desc}}</td>
                    <td style="text-align:center">
                        <a href="#" id="edit" ><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        <a href="#" id="delete"><i class="fas fa-trash-alt" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                    </td>
                </tr>   
                @endforeach($vac as $vaccine)
                @if(empty($vac))
                <h6 class="alert alert-danger">No data for vaccine exist! Add Vaccine +</h6>
                @endif   
            </tbody>
        </table>
    </div>
</div>
<div class="row">
<div class="col-md">
        <div class="card shadow mb-4">
            <!-- Deworming header -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div>
                <button class="btn btn-danger" data-toggle="modal" data-target="#AddDeworm" >Add Deworming +</button>
                </div>
            </div>  
<!-- Vaccine and deworm Content -->
<div class="card-body">
    <table id="datatable1" class="table table-light table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Deworming Name</th>
                <th>Description</th>
                <th style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deworm as $dew)
            <tr>
                <td>{{$dew->id}}</td>
                <td>{{ $dew->dew_name}}</td>
                <td>{{ $dew->dew_desc}}</td>
                <td style="text-align:center">
                    <a href="#" id="edit1"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#" id="delete1"><i class="fas fa-trash-alt" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                </td>
            </tr>
            @endforeach($deworm as $dew)
            @if(empty($deworm))
            <h6 class="alert alert-danger">No data exist for deworming! Add Deworming +</h6>
            @endif   
        </tbody>
    </table>
  </div>
</div>
@include("PetOwner.Vaccine & Deworm.Modal.VaccineModal")
@include("PetOwner.Vaccine & Deworm.Modal.DewormModal")
@endsection
@push("js")
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();

            table.on('click','#edit', function(){
                $tr =$(this).closest('tr');
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                
                $('#name').val(data[1]);
                $('#desc').val(data[2]);

                $('#editform').attr('action','/vaccine/editvac/petowner/'+data[0]);
                $('#EditVaccine').modal('show');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();

            table.on('click','#delete', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                $('#vac_name').val(data[1]);
                $('#vac_desc').val(data[2]);


                $('#deleteform').attr('action','/vaccine/deletevac/petowner/'+data[0]);
                $('#DeleteVaccine').modal('show');
            });
        });
    </script>
     <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable1').DataTable();

            table.on('click','#edit1', function(){
                $tr =$(this).closest('tr');
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                
                $('#deworm_name').val(data[1]);
                $('#deworm_desc').val(data[2]);

                $('#editform1').attr('action','/deworm/editdeworm/petowner/'+data[0]);
                $('#Editdeworm').modal('show');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable1').DataTable();

            table.on('click','#delete1', function(){
                $tr =$(this).closest('tr');
                var data = table.row($tr).data();
                if($($tr).hasClass('child')) {
                    $tr=$tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                $('#dew_name').val(data[1]);
                $('#dew_desc').val(data[2]);


                $('#deleteform1').attr('action','/deworm/deletedeworm/petowner/'+data[0]);
                $('#Deletedeworm').modal('show');
            });
        });
    </script>
@endpush
