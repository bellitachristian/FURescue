@extends("main")
@push('css')
<link href="{{url('css/style.css')}}" rel="stylesheet">    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section("content")
<div class="row justify-content-center">
    <div class="col-sm-7">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="/dashboard"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <div style="display:flex">
                    <div class="col-sm">
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
                            <div id="paypal-button-container">
                        </div>
                    </div>  
                </div>
                <div class="col-sm-4">
                    <p style="color:black; font-size:18px">
                        You are about to subscribe {{$subs->sub_name}} Promo.
                    </p>
                    <hr>
                    <p style="color:black; font-size:18px">
                        Please log in your Paypal account to proceed your subscription payment.
                    </p>
                </div>
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
                location.reload(); 
            }
            })
        }
    });
    }
}).render('#paypal-button-container');
</script>   
@endpush