@extends("mainpetowner")
@section("header")
Adoption Slip
@endsection
@push("css")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/print.css')}}">
@endpush
@section("content")             
<div class="slip-content">
    <a href="{{route('generated')}}"><button class="btn btn-secondary">Back</button></a>
    <div class="container bootstrap snippets bootdey">
		<div class="row">
			<div class="col-md-12">
				<div class="slip-wrapper">
					<div class="intro">
                        <h5>Adoption Slip</h5>
						Hi <strong>{{$slip->shelter->shelter_name}}</strong>, 
						<br>
						This is to validate the complete transaction for request of adoption by <strong>{{$slip->petowner->fname}} {{$slip->petowner->lname}}</strong>.
					</div>

					<div class="payment-info">
						<div class="row">
							<div class="col-sm-6">
								<span>Slip No.</span>
								<strong>{{$slip->slip_number}}</strong>
                                <span>Approved Date</span>
								<strong>{{$slip->date_approve}}</strong>
							</div>
							<div class="col-sm-6 text-right">
								<span>Date Today</span>
								<strong>{{$today}}</strong>
							</div>
						</div>
					</div>

					<div class="payment-details">
						<div class="row">
							<div class="col">
								<span style="margin-bottom: 10px; color:black">Requested by</span>
                                <img src="{{asset('uploads/pet-owner/profile/'.$slip->petowner->profile)}}" style="width: 150px; height: 150px;"><br>
              
							</div>
                            <div class="col">
                                
                                <span><br>Name</span>
								<p>{{$slip->petowner->fname}} {{$slip->petowner->lname}}</p>
                                <span>Gender</span>
								<p>{{$slip->petowner->gender}}</p>
                                <span>Address</span>
								<p>{{$slip->petowner->address}}</p>
                            </div>
							<div class="col">
                                <span><br>Birthdate</span>
                                <p>10/31/1999</p>
                                <span>Contact No</span>
                                <p>{{$slip->petowner->contact}}</p>
                                <span>Email</span>
								<p><a href="#">
                                    {{$slip->petowner->email}}
                                </a></p>
							</div>

						</div>
					</div>

					<div class="line-items">
						<div class="headers clearfix">
							<div class="row">
								<div class="col-xs-4" style="color:black">Request for Adoption</div>
							</div>
						</div>
						<div class="items">
							<div class="row item">
                                <div class="col">
                                    <img src="{{asset('uploads/animals/'.$slip->animal->animal_image)}}" style="width: 130px; height: 130px;"><br>
                                    <span><br>Name</span>
                                    <p><strong>{{$slip->animal->name}}</strong></p>
                                    <span>Category</span>
                                    @foreach($slip->petowner->category as $type)
                                        <p><strong>{{$type->category_name}}</strong></p>
                                    @endforeach
                                    
                                    
                                </div>
                                <div class="col">
                                    <span><br>Breed</span>
                                    <p><strong>{{$slip->animal->breed}}</strong></p>
                                    <span>Gender</span>
                                <p><strong>{{$slip->animal->gender}}</strong></p>
								<span>Age</span>
                                <p><strong>{{$slip->animal->age}}</strong></p>
                                <span>Life Stage</span>
                                    <p><strong>{{$slip->animal->pet_stage}}</strong></p>
                                </div>
                                <div class="col">
                                    <span><br>Size</span>
                                    <p><strong>{{$slip->animal->size}}</strong></p>
                                    <span>Color</span>
                                    <p><strong>{{$slip->animal->color}}</strong></p>
                                </div>
							</div>
                            <hr>
                            <p ><strong >Shelter Requested</strong></p>
							<div class="row item">
                                
                                
                                <div class="col">
                                    <span>Name</span>
                                    <p><strong>{{$slip->shelter->shelter_name}}</strong></p>
                                    
								<span>Address</span>
                                <p><strong>{{$slip->shelter->address}}</strong></p>
                                <span>Contact Person</span>
                                <p><strong>{{$slip->shelter->founder_name}}  </strong></p>
                                </div>
                                <div class="col">
                                    <span>Contact No.</span>
                                    <p><strong>{{$slip->shelter->contact}}</strong></p>
                                    <span>Email</span>
                                <p><strong>{{$slip->shelter->email}}</strong></p>
                                </div>
                            </div>
						</div>
						
						<div class="print">
							<a href="#">
								<i id="print" class="fa fa-print"></i>
								Print this slip
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>                    
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.js" integrity="sha512-BaXrDZSVGt+DvByw0xuYdsGJgzhIXNgES0E9B+Pgfe13XlZQvmiCkQ9GXpjVeLWEGLxqHzhPjNSBs4osiuNZyg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js" integrity="sha512-t3XNbzH2GEXeT9juLjifw/5ejswnjWWMMDxsdCg4+MmvrM+MwqGhxlWeFJ53xN/SBHPDnW0gXYvBx/afZZfGMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.print').click(function(){
     $(".slip-content").print();
});
</script>
@endpush