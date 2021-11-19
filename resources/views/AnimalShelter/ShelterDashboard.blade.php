@extends("main")
@section("header")
Animal Shelter Dashboard
@endsection
@push("css")
<link href="{{url('css/style.css')}}" rel="stylesheet">    
@endpush
@section("content")
<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Earnings (Monthly)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Earnings (Annual)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Requests</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <!-- Dashboard Content -->
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <!-- Dashboard header -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5>To add a pet</h5>
                <div>
              <a href="/AnimalManagement"><button class="btn btn-danger">Go to Pet Management</button></a> 
                </div>
            </div>
            <!-- Content Body -->
        </div>
    </div>
</div>
<div class="row">
    @foreach($subscription as $subs)
    <div style="margin-bottom:2%" class="col-md-4 col-sm-6">
        <div class="pricingTable">
            <div class="pricingTable-header">
                <h3 class="heading">{{$subs->sub_name}}</h3>
                
                <div class="price-value">{{$subs->sub_price}}
                    <span class="currency">PHP</span>
                </div>
            </div>
            @foreach($subs->sub_desc as $descs)
            <ul class="pricing-content"> 
                    {{$descs}}
            </ul>
            @endforeach
            @if($transnotcheck > 0)    
                <a href="{{route('view.wait.subscription',$subs->id)}}" class="read">subscribe<i class="fa fa-angle-right"></i></a>
            @elseif($transnotcheck == 0)
                <a href="{{route('choose.subscription',$subs->id)}}" class="read">subscribe<i class="fa fa-angle-right"></i></a>
            @endif
        </div>
    </div>
    @endforeach
</div>

@endsection
@push('js')
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
