@extends("main")
@section("header")
Allocating Vaccine
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">   
@endpush

@section("content")
<div class="row">                        
    <div class="col-sm-4">
        <div class="card shadow mb-4">
            <!-- Animal header -->                            
            <!-- Animal Content -->
            <div class="card-body">
                <div class="form-group-row" style="display:flex">
                    <div class="col-sm" style="height:500px">
                        <div style="text-align:center; height:50%">
                        <img src="{{asset('uploads/animals/'.$animal->animal_image)}}" style="border-radius:50%" width="100%" height="100%" alt=""><br>
                        </div>
                        <label class="text-sm">Name</label>
                        <input type="text" disabled value ="{{$animal->name}}"  class="form-control form-control-sm" id="name" name="name">
                                        
                        <label class="text-sm">Age(months)</label>
                        <input type="text" disabled value ="{{$animal->age}}"  class="form-control form-control-sm" id="age" name="age">
                        
                        <label class="text-sm">Gender</label>
                        <input type="text" disabled value ="{{$animal->gender}}"  class="form-control form-control-sm" id="categ" name="gender">

                        <label class="text-sm">Breed</label>
                        <input type="text" disabled value ="{{$animal->breed}}"  class="form-control form-control-sm" id="breed" name="breed">
                    </div>    
                </div>                                                
            </div>
        </div>
    </div>
    
    <div class="col-sm">
        <div class="card shadow mb-4">
            <!-- Animal header -->                           
            <!-- Animal Content -->
            <div class="card-body">
                <div class="form-group-row">   
                    <div class="col-sm flex-1">
                        <h2>Allocate Vaccine</h2>
                        

                        <form action="{{url('/AllocationVaccine/'.$animal->id).'/'.$vaccine->id}}" method="POST">
                            @csrf

                            <label class="text-sm">Vaccine Name</label>
                            <input type="text" readOnly value ="{{$vaccine->vac_name}}" name="vac_name"  class="form-control form-control-sm">
                                        
                            <label class="text-sm">Description</label>
                            <input type="text" readOnly value ="{{$vaccine->vac_desc}}" name="vac_desc"  class="form-control form-control-sm">

                            <label class="text-sm">Date Vaccinated</label>
                            <input type="date"  class="form-control form-control-sm" id="vaccine_date" name="vac_date" required>
                                            
                            <label class="text-sm">Vaccine Active</label>
                            <select class="form-control form-control-sm" id="vaccine_effective" name="vac_effect" required>
                                <option value="">--Select Vaccine Effectiveness Span--</option>
                                <option value="3">3-Months</option>
                                <option value="1">1-Year</option>
                                <option value="custom">Custom</option> 
                            </select>
                            <label class="text-sm">Vaccine Expiry</label>
                            <input type="date"  class="form-control form-control-sm" id="vaccine_expiry" name="vac_expiry"  required> <br>
                            
                            <a href="{{url('AllocateVaccine/'.$animal->id)}}"><button type="button" class="btn btn-secondary">Back</button></a>
                            <button class="btn btn-danger" id="btn" type="submit">Apply Vaccine</button>
                        </form>
                        
                    </div>    
                </div>                                                
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
</div>
@endsection
@push("js")
    <script src="{{url('https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var table = $('#datatable').DataTable();
        });
    </script>
    <script>
        document.getElementById("vaccine_expiry").readOnly = true;
        $("#vaccine_date").change(function(){
            var currentdate = new Date();
            var day1 = String(currentdate.getDate()).padStart(2,'0');
            var month1 = String(currentdate.getMonth()+1).padStart(2,'0');
            var year1 = currentdate.getFullYear();
            var current_date = year1+"-"+month1+"-"+day1;   

            var input = document.getElementById("vaccine_date").value;
            var vaccinedate = new Date(input);
            var day = String(vaccinedate.getDate()).padStart(2,'0');
            var month = String(vaccinedate.getMonth()+1).padStart(2,'0');
            var year = vaccinedate.getFullYear();
            var vaccinated_date = year+"-"+month+"-"+day;  
                if(vaccinated_date > current_date){
                alert("Please select a valid time frame");
                document.getElementById("vaccine_date").value="";
                }         
            if($("#vaccine_effective").val() =="3"){
                document.getElementById("vaccine_expiry").readOnly = true;
                var input = document.getElementById("vaccine_date").value;           
                var vaccinedate = new Date(input);
                var expiry = vaccinedate.setMonth(vaccinedate.getMonth()+3);
                var expirydate = new Date(expiry);
                var day = String(expirydate.getDate()).padStart(2,'0');
                var month = String(expirydate.getMonth()+1).padStart(2,'0');
                var year = expirydate.getFullYear();
                var expiration = year+"-"+month+"-"+day;
                console.log(expiration);
                document.getElementById("vaccine_expiry").value = expiration;
            }
            if($("#vaccine_effective").val() =="1"){
                document.getElementById("vaccine_expiry").readOnly = true;
                var input = document.getElementById("vaccine_date").value;           
                var vaccinedate = new Date(input);
                var expiry = vaccinedate.setYear(vaccinedate.getFullYear()+1);
                var expirydate = new Date(expiry);
                var day = String(expirydate.getDate()).padStart(2,'0');
                var month = String(expirydate.getMonth()+1).padStart(2,'0');
                var year = expirydate.getFullYear();
                var expiration = year+"-"+month+"-"+day;
                console.log(expiration);
                document.getElementById("vaccine_expiry").value = expiration;
            }

        });
        $("#vaccine_expiry").change(function(){
            if($("#vaccine_effective").val()=="custom"){
                var input = document.getElementById("vaccine_date").value;
                var vaccinedate = new Date(input);
                var day = String(vaccinedate.getDate()).padStart(2,'0');
                var month = String(vaccinedate.getMonth()+1).padStart(2,'0');
                var year = vaccinedate.getFullYear();
                var vaccinated_date = year+"-"+month+"-"+day; 

                var input1 = document.getElementById("vaccine_expiry").value;
                var vaccineexpiry = new Date(input1);
                var day1 = String(vaccineexpiry.getDate()).padStart(2,'0');
                var month1 = String(vaccineexpiry.getMonth()+1).padStart(2,'0');
                var year1 = vaccineexpiry.getFullYear();
                var vaccination_expiry = year1+"-"+month1+"-"+day1;

                if(vaccination_expiry<=vaccinated_date){
                    alert("Please select a valid time frame");
                    document.getElementById("vaccine_expiry").value="";  
                }  
            }
        });
        $("#vaccine_effective").change(function(){
            if($(this).val()=="custom"){ 
                document.getElementById("vaccine_expiry").readOnly = false;
                document.getElementById("vaccine_expiry").value="";
            }
            else if($(this).val() =="3"){
                    document.getElementById("vaccine_expiry").readOnly = true;
                    var input = document.getElementById("vaccine_date").value;           
                    var vaccinedate = new Date(input);
                    var expiry = vaccinedate.setMonth(vaccinedate.getMonth()+3);
                    var expirydate = new Date(expiry);
                    var day = String(expirydate.getDate()).padStart(2,'0');
                    var month = String(expirydate.getMonth()+1).padStart(2,'0');
                    var year = expirydate.getFullYear();
                    var expiration = year+"-"+month+"-"+day;
                    console.log(expiration);
                    document.getElementById("vaccine_expiry").value = expiration; 
                   // document.getElementById("vaccine_expiry").dispatchEvent(new Event("input")); 
            }
            else if($(this).val()=="1"){
                document.getElementById("vaccine_expiry").readOnly = true;
                var input = document.getElementById("vaccine_date").value;           
                var vaccinedate = new Date(input);
                var expiry = vaccinedate.setYear(vaccinedate.getFullYear()+1);
                var expirydate = new Date(expiry);
                var day = String(expirydate.getDate()).padStart(2,'0');
                var month = String(expirydate.getMonth()+1).padStart(2,'0');
                var year = expirydate.getFullYear();
                var expiration = year+"-"+month+"-"+day;
                console.log(expiration);
                document.getElementById("vaccine_expiry").value = expiration;         
            }
            else{
                document.getElementById("vaccine_expiry").disabled = true;
            }
        });
    </script>
@endpush
