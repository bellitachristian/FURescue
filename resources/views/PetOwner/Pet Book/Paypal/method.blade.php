@extends("mainpetowner")
@section("header")
Donate
@endsection
@push('css')
<link href="{{url('css/style.css')}}" rel="stylesheet">    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <style>
            /* The Modal (background) */
            .modal-confirm {		
		color: #636363;
		width: 400px;
		margin: 30px auto;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-confirm .modal-header {
		border-bottom: none;   
        position: relative;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -15px;
	}
	.modal-confirm .form-control, .modal-confirm .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-confirm .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}	
	.modal-confirm .modal-footer {
		border: none;
		text-align: center;
		border-radius: 5px;
		font-size: 13px;
	}	
	.modal-confirm .icon-box {
		color: #fff;		
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #E84D31;
		padding: 15px;
		text-align: center;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-confirm .icon-box i {
		font-size: 58px;
		position: relative;
		top: 3px;
	}
	.modal-confirm.modal-dialog {
		margin-top: 80px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #E84D31;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
    }
	.modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #6fb32b;
		outline: none;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
        /* The Close Button */
        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }
        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
        </style>
@endpush

@section("content")
<div class="row justify-content-center">
    <div class="col-sm-5">
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="{{route('view.to.donate')}}"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
            <div class="card-body">
                <div class="form-group-row" style="display:flex">
                        <div class="col-sm">
                            <div style="text-align:center">
                                <img src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}" width="170px" height="150px" alt="">
                            </div>
                            <label style="font-height:1">Name of Shelter</label>                        
                            <input style="margin-bottom:1%" type="text"  value="{{$shelter->shelter_name}}" readOnly class="form-control form-control-sm">
                            <label >Address</label>
                            <input style="margin-bottom:5%" type="text" value="{{$shelter->address}}" readOnly class="form-control form-control-sm">
                            <h5 style="color:black; margin-top:5%; margin-bottom:4%">Shelter Information</h5>
                            <label >Animal Shelter Contact Person</label>
                            <input style="margin-bottom:1%" type="text" value ="{{$shelter->founder_name}}" readOnly  class="form-control form-control-sm">
                            <label >Contact Number</label>
                            <input style="margin-bottom:1%" type="text" value ="{{$shelter->contact}}" readOnly  class="form-control form-control-sm">
                            <label >Email</label>
                            <input style="margin-bottom:5%" type="email" value ="{{$shelter->email}}"readOnly class="form-control form-control-sm">  
                        </div>    
                    </div>
                    <div style="display:flex">
                    <div class="col-sm">
                        <div class="pricingTable">
                            <div class="pricingTable-header">    
                                <div class="price-value">{{$amount->donor_amount}}
                                    <span class="currency">PHP</span>
                                </div>
                            </div>
                            <div id="paypal-button-container">
                        </div>
                    </div>  
                </div>                          
            </div> 
        </div>
    </div>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">&#xE876;</i>
                </div>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Donation sent successfully</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
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
            value: '{{$amount->donor_amount}}' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
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
            url:"{{route('donate.update',$amount->animal_shelter)}}",
            success:function(data)
            {
                $(document).ready(function(){
                    $("#myModal").modal('show');
                });
            }
            })
        }
    });
    }
}).render('#paypal-button-container');
</script>   
@endpush