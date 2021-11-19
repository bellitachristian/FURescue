@extends("main")
@section("header")
Allocate 
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Vaccine header -->
                <div  style="position:flex" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-3">
                            <select class="form-control sm" name="vaccine" id="vaccine">
                            <option style="text-align:center" value="">----- Select Vaccine -----</option>
                                        @foreach($sheltervaccine as $vaccine)
                                            @foreach($vaccine->vaccine as $vaccines)
                                                <option style="text-align:center"  value="{{$vaccines['id']}}">{{$vaccines['vac_name']}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                            </select> 
                            
                    </div>
                        <div>
                            <input type="text" hidden name="valuevaccine" id="vac">
                        </div>
                        <div id="vaccineselection">     

                        </div> 
                </div>
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Breed</th>  
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($animal as $anim)
                <tr>
                    <td >{{ $anim->id}}</td>
                    <td>
                    <img src="{{asset('uploads/animals/'.$anim->animal_image)}}" width="70px" height="70px" alt="">
                    </td>
                    <td>{{ $anim->name}}</td>
                    <td>{{ $anim->age}}</td>
                    <td>{{ $anim->breed}}</td>
                    <td style="text-align:center">
                        <button id="vac_apply" data-id="{{$anim->id}}" class="btn btn-danger">Apply</button>
                    </td>
                </tr>
                @endforeach
                @if(empty($anim))
                <h6 class="alert alert-danger">No data for pet exist!</h6>
                @endif   
        </tbody>
    </table>
</div>
</div>
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Deworming header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-3">
                            <select class="form-control sm" name="deworm" id="deworm">
                            <option style="text-align:center" value="">----- Select Deworm -----</option>
                                        @foreach($sheltervaccine as $deworm)
                                            @foreach($deworm->deworm as $deworms)
                                                <option style="text-align:center"  value="{{$deworms['id']}}">{{$deworms['dew_name']}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                            </select>
                        </div>
                        <div>
                            <input type="text" hidden name="valuedeworm" id="dew">
                        </div>
                    <div id="dewormselection">
                    </div>
                </div>  
    <!-- Vaccine and deworm Content -->
    <div class="card-body">
        <table id="datatable1" class="table table-light table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Breed</th>  
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animal as $anim)
                <tr>
                    <td>{{ $anim->id}}</td>
                    <td>
                        <img src="{{asset('uploads/animals/'.$anim->animal_image)}}" width="70px" height="70px" alt="">
                    </td>
                    <td>{{ $anim->name}}</td>
                    <td>{{ $anim->age}}</td>
                    <td>{{ $anim->breed}}</td>
                    <td style="text-align:center">
                        <a href="AllocateVaccine/{{$vaccine->id}}" class="btn btn-danger">Apply</a>
                    </td>
                </tr>
                @endforeach
                @if(empty($anim))
                <h6 class="alert alert-danger">No data exist for pet exist!</h6>
                @endif   
            </tbody>
        </table>
</div>
             
@endsection
@push("js")
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
          $("#vaccine").change(function(){
          load_vaccine()
          var id = $("#vaccine").val();
          $("#vac").val(id)
          });
        });
        function load_vaccine()
        {
            var vac_id = $("#vaccine").val();
            
            $.ajax({
            url:"{{ route('vaccine.fetch') }}",
            data:{id:vac_id},
            success:function(data)
            {   
                $('#vaccineselection').html(data);
            }
            })
        }

        $("#vac_apply").on('click', function(e){
        e.preventDefault(); 
        var vac_id = $("#vac").val();   
        var animal = $(this).data("id");
        $.ajax({
            type:"GET",
            url:"{{ route('vaccine.allocate') }}",
            data:{vac_id:vac_id, animal_id:animal},
            success:function(data)
            {
                window.location.href ="/AllocationVaccine1/"+animal+"/"+vac_id
            },
            error: function(data) {
                alert("Choose selection!");
            }   
            })
        });
    </script>
     <script type="text/javascript">
        $(document).ready(function(){   
          var table = $('#datatable1').DataTable();
          $("#deworm").change(function(){
          load_deworm()
          var id = $("#deworm").val();
          $("#dew").val(id)
          });
        });
        function load_deworm()
        {
            var dew_id = $("#deworm").val();
            $.ajax({
            url:"{{ route('deworm.fetch') }}",
            data:{id:dew_id},
            success:function(data)
            {
                $('#dewormselection').html(data);
            }
            })
        }
    </script>
@endpush