@extends("main")
@section("content")

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header"><h5 style="color:black">Account Deactivation</h5></div>
                <div class="card-body">
                    <div>
                        <p>Deactivating your account will make all your informations hidden including your posts pets for adoption from Pet Owners and Adopters.</p>
                    </div>
                    <hr>
                <form action="{{route('deactivation.account')}}" method="POST">
                    @csrf
                    <input type="radio" name="radiobutton" id="temporary" value="1"> <label style="color:black">This is temporary. I'll be back.</label> <br>
                    <input type="radio" name="radiobutton" id="otherfield" value="2"> <label style="color:black">Other, please explain further:</label>
                    <textarea name="others" required id="area"cols="52" rows="3"></textarea>
                </div>
                <div class="card-footer">
                  <a href="/Profile"><button class="btn btn-secondary" type="button">Cancel</button> </a>
                    <button class="btn btn-danger" type="submit">Deactivate Accont</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
     document.getElementById("area").disabled = true;
    $("#temporary").change(function(){
        if($("#temporary").val() == "1"){
            console.log($("#temporary").val());
            document.getElementById("area").disabled = true;
        }    
    });
    $("#otherfield").change(function(){
        if($("#otherfield").val() == "2"){
            console.log($("#otherfield").val());
            document.getElementById("area").disabled = false;
        } 
    });     
</script>
@endpush