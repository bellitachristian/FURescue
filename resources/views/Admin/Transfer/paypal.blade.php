@extends("Admin.main")
@section("header")
Transfer Adoption Fee
@endsection
@section("content")
<div class="row justify-content-center">
    <div class="col-sm-7">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('view.transfer')}}"><button class="btn btn-danger">Back</button></a>
            </div>
                <div class="card-body">
                    @if($transfer->usertype->id == 2)
                    <h5>Transfer Money to:</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('uploads/animal-shelter/profile/'.$transfer->shelter->profile)}}" width="100%" height="80%" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Sheltername:</label>
                            <p><strong>{{$transfer->shelter->shelter_name}}</strong></p> 
                            <label for="">Email:</label>
                            <p><strong>{{$transfer->shelter->email}}</strong></p> 
                            <label for="">Address:</label>
                            <p><strong>{{$transfer->shelter->address}}</strong></p> <hr>
                        </div>
                        <div class="col-sm">
                            <label for="">Contact Person:</label>
                            <p><strong>{{$transfer->shelter->founder_name}}</strong></p> 
                            <label for="">Contact Number:</label>
                            <p><strong>{{$transfer->shelter->contact}}</strong></p> 
                        </div>
                    </div>
                    <hr>
                    <h5>Pet Adopted Details</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('uploads/animals/'.$transfer->animal->animal_image)}}" width="100%" height="80%" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Pet Name:</label>
                            <p><strong>{{$transfer->animal->name}}</strong></p> 
                            <label for="">Gender:</label>
                            <p><strong>{{$transfer->animal->gender}}</strong></p> 
                            <label for="">Age:</label>
                            <p><strong>{{$transfer->animal->age}}</strong></p> 
                        </div>
                        <div class="col-sm">
                            <label for="">Pet stage:</label>
                            <p><strong>{{$transfer->animal->pet_stage}}</strong></p> 
                            <label for="">Breed:</label>
                            <p><strong>{{$transfer->animal->breed}}</strong></p> 
                            <label for="">Adoption Fee:</label>
                            <p><strong>{{$transfer->animal->fee}}</strong></p> 
                        </div>
                    </div>
                    <hr>
                    <h5>Adopter Details</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('/phpcode/adopter/'.$transfer->adopter->photo)}}" width="100px" height="80px" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Name:</label>
                            <p><strong>{{$transfer->adopter->name}}</strong></p> 
                            <label for="">Gender:</label>
                            <p><strong>{{$transfer->adopter->gender}}</strong></p> 
                            <label for="">Email:</label>
                            <p><strong>{{$transfer->adopter->email}}</strong></p> 
                            </div>
                        <div class="col-sm">
                            <label for="">Address:</label>
                            <p><strong>{{$transfer->adopter->address}}</strong></p> 
                            <label for="">Contact:</label>
                            <p><strong>{{$transfer->adopter->phonenum}}</strong></p> 
                        </div>
                    </div>           
                    <hr>
                    <div style="float:right">
                        <label for="">Amount to be Transferred:</label>
                        <p style="font: size 24px; color:black"><strong>PHP{{$transfer->animal->fee}}</strong></p> 
                    </div>
                    <div id="paypal-button-container">

                    </div>
                    @else 
                    <h5>Transfer Money to:</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('uploads/pet-owner/profile/'.$transfer->petowner->profile)}}" width="100%" height="80%" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Pet Owner Name:</label>
                            <p><strong>{{$transfer->petowner->fname}} {{$transfer->petowner->lname}}</strong></p> 
                            <label for="">Email:</label>
                            <p><strong>{{$transfer->petowner->email}}</strong></p> 
                            <label for="">Gender:</label>
                            <p><strong>{{$transfer->petowner->gender}}</strong></p> 
                        </div>
                        <div class="col-sm">
                            <label for="">Address:</label>
                            <p><strong>{{$transfer->petowner->address}}</strong></p> 
                            <label for="">Contact:</label>
                            <p><strong>{{$transfer->petowner->contact}}</strong></p> 
                        </div>
                    </div>   
                    <hr>
                    <h5>Pet Adopted Details</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('uploads/animals/'.$transfer->animal->animal_image)}}" width="100%" height="80%" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Pet Name:</label>
                            <p><strong>{{$transfer->animal->name}}</strong></p> 
                            <label for="">Gender:</label>
                            <p><strong>{{$transfer->animal->gender}}</strong></p> 
                            <label for="">Age:</label>
                            <p><strong>{{$transfer->animal->age}}</strong></p> 
                        </div>
                        <div class="col-sm">
                            <label for="">Pet stage:</label>
                            <p><strong>{{$transfer->animal->pet_stage}}</strong></p> 
                            <label for="">Breed:</label>
                            <p><strong>{{$transfer->animal->breed}}</strong></p> 
                            <label for="">Adoption Fee:</label>
                            <p><strong>{{$transfer->animal->fee}}</strong></p> 
                        </div>
                    </div>  
                    <hr>
                    <h5>Adopter Details</h5>
                    <div style="display:flex">
                        <div class="col-sm-3">
                            <div>
                                <img src="{{asset('/phpcode/adopter/'.$transfer->adopter->photo)}}" width="100%" height="80%" alt="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="">Name:</label>
                            <p><strong>{{$transfer->adopter->name}}</strong></p> 
                            <label for="">Gender:</label>
                            <p><strong>{{$transfer->adopter->gender}}</strong></p> 
                            <label for="">Email:</label>
                            <p><strong>{{$transfer->adopter->email}}</strong></p> 
                        </div>
                        <div class="col-sm">
                            <label for="">Address:</label>
                            <p><strong>{{$transfer->adopter->address}}</strong></p> 
                            <label for="">Contact:</label>
                            <p><strong>{{$transfer->adopter->phonenum}}</strong></p> 
                        </div>
                    </div>
                    <hr>
                    <div style="float:right">
                        <label for="">Amount to be Transferred:</label>
                        <p style="font: size 24px; color:black"><strong>PHP{{$transfer->animal->fee}}</strong></p> 
                    </div>
                    <div style="text-align:center" id="paypal-button-container">

                    </div>
                    @endif
                </div>
            </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://www.paypal.com/sdk/js?client-id=AfnKmdBSmUQRaxV-lxa9RuDvl26tdBGu2HugwMERbS0Jp2Ronpx5Q9EW376wDPydVgswBBpAaBEAKlXy&currency=PHP"></script>
<script>
paypal.Buttons({

    // Sets up the transaction when a payment button is clicked
    createOrder: function(data, actions) {
    return actions.order.create({
        purchase_units: [{
        amount: {
            value: '{{$transfer->animal->fee}}' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
        }
        }]
    });
    },

    // Finalize the transaction after payer approval
    onApprove: function(data, actions) {
    return actions.order.capture().then(function(orderData) {
        save();
        function save()
        {
            $.ajax({
            url:"{{route('transferring.money',$transfer->id)}}",
            success:function(data)
            {
                alert('Transferred Successfully!');
            }
            })
        }
    });
    }
}).render('#paypal-button-container');
</script>   
@endpush