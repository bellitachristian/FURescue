@extends("main")
@section("header")
Pet Management
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush
@section("content")
<div class="row">
    <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Animal header -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#AddAnimalModal" >Add Pet +</button>
                    </div>
                </div>
    <!-- Animal Content -->
    <div class="card-body">
        <table id="datatable" class="table table-light table-hover">
            <thead>
                <tr>
                    <th> ID</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th hidden>Category</th>
                    <th>Age</th>
                    <th>Life Stage</th>
                    <th>Breed</th>
                    <th>History</th>
                    <th>Additional Info</th>
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
                    <td hidden>{{ $anim->category}}</td>   
                    <td>{{ $anim->age}}</td>
                    <td>{{ $anim->pet_stage}}</td>
                    <td>{{ $anim->breed}}</td>
                    <td>{{ $anim->history}}</td>
                    <td>{{ $anim->info}}</td>
                    <td style="text-align:center">
                        <a href="{{route('view.edit.animal',$anim->id)}}"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        <a href="#" id="delete"><i class="fas fa-trash-alt" data-toggle="modal" data-target="#DeleteAnimal" title="Delete">&#xE872;</i></a>
                    </td>
                </tr> 
            @endforeach($animal as $anim)
            @if(empty($anim))   
                <h6 class="alert alert-danger">No data for pets exist! Add Pet +</h6>
            @endif
            </tbody>
        </table>
</div>
@include('Modal.AnimalModal')
@include('Modal.DeleteAnimal')
                    
@endsection
@push("js")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
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

                $('#deleteform').attr('action','/AnimalManagement/'+data[0]);
                $('#DeleteAnimal').modal('show');
            });
        });
    </script>
    <script type=text/javascript>
  $('#category').change(function(){
  var categID = $(this).val();  
  console.log(categID)
  if(categID){
    $.ajax({
      type:"GET",
      url:"{{route('get.breed')}}?categ_id="+categID,
      success:function(res){        
      if(res){
        $("#breed").empty();
        $("#breed").append('<option>Select Breed</option>');
        $.each(res,function(key,value){
          $("#breed").append('<option value="'+value+'">'+value+'</option>');
        });
      
      }else{
        $("#breed").empty();
      }
      }
    });
  }else{
    $("#breed").empty();
  }   
  });
   document.getElementById("age").disabled = true;
    $("#years").change(function(){
        if($("#years").val() == "1"){
        document.getElementById("age").disabled = false;
        $("#age").change(function(){
        var Year  = $("#years").val();
        var Age = $("#age").val();
        var categID = $("#category").val(); 
         
        if(categID){
            $.ajax({
                type:"GET",
                url:"{{route('get.type')}}?categ_id="+categID,
                data:{age:Age,radiobtn:Year},
                success:function(res){      
                    console.log(res)  
                    if(res){
                        $("#stage").empty();
                        $.each(res,function(key,value){
                            $("#stage").append('<option value="'+value+'">'+value+'</option>');
                        });
            
                    }else{
                        $("#stage").empty();
                        }
                    }
                });
            }
        });
    }
  });
  $("#months").change(function(){
    if($("#months").val() == "2"){
        document.getElementById("age").disabled = false;
        $("#age").change(function(){
        var categID = $("#category").val();
        var Month  = $("#months").val();
        var Age = $("#age").val();  
        if(categID){
            $.ajax({
                type:"GET",
                url:"{{route('get.type')}}?categ_id="+categID,
                data:{age:Age,radiobtn:Month},
                success:function(res){        
                    if(res){
                        $("#stage").empty();
                        $.each(res,function(key,value){
                            $("#stage").append('<option value="'+value+'">'+value+'</option>');
                        });
            
                    }else{
                        $("#stage").empty();
                        }
                    }
                });
            }
        });
    }
  });
</script>
@endpush

