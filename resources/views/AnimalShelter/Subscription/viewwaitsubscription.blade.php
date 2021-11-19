@extends("main")
@section("header")
Subscription
@endsection
@push('css')
<link href="{{url('css/style.css')}}" rel="stylesheet">    
@endpush
@section("content")
<div class="row">
    <div class="col-sm-3">
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
        </div>
    </div>
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <h4>Proof of Payment Checking...</h4>
                <hr>
                <p>Please wait patiently as the admin is checking your proof of payment.
                    Your patience is highly appreciated.
                </p>
                <p>Best regards,</p>
                <p>furescue team</p>
                <hr>
                <p>
                    P.S A notification will be sent after the checking of your proof of payment.
                </p>
            </div>
            <div class="card-footer">
                <a href=""><button class="btn btn-secondary">Cancel Subscription</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
