@extends("Admin.main")
@section("header")
Transfer Adoption Fee
@endsection
@push("css")

@endpush
@section("content")
<div class="row">
    <div class="col-sm">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('view.transfer')}}"><button class="btn btn-danger">Back</button></a>
            </div>
                <div class="card-body">
                    @if($transfer->usertype->id == 2)
                    <div>
                    <img src="{{asset('uploads/animal-shelter/profile/'.$transfer->shelter->profile)}}" width="100px" height="80px" alt="">
                    </div>
                    <label for="">Fostered by:</label>
                    <p><strong>{{$transfer->shelter->shelter_name}}</strong></p> 
                    @endif
                </div>
            </div>
    </div>
</div>
@endsection
<script src="https://www.paypal.com/sdk/js?client-id=AfnKmdBSmUQRaxV-lxa9RuDvl26tdBGu2HugwMERbS0Jp2Ronpx5Q9EW376wDPydVgswBBpAaBEAKlXy&currency=PHP"></script>
<script>
paypal.Buttons({

    // Sets up the transaction when a payment button is clicked
    createOrder: function(data, actions) {
    return actions.order.create({
        purchase_units: [{
        amount: {
            value: '{{$subs->sub_price}}' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
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
            url:"{{route('subscription.trans',$subs->id)}}",
            success:function(data)
            {
                alert('Subscribed Successfully!');
            }
            })
        }
    });
    }
}).render('#paypal-button-container');
</script>   
@endpush