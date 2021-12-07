@extends("mainpetowner")
@section("header")
Adopter's Application Form
@endsection
@push('css')
<link rel="stylesheet" href="{{url('/css/question.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endpush
@section("content")

            <!-- <div class="card-body">
            <img src="{{asset('phpcode/validid/'.$adoption->validId)}}" width="100%" height="600px" />
            </div> -->

<div class="slip-content" >
    <a href="{{route('adoption.request.petowner')}}"><button type="button" class="btn btn-danger">Back</button></a>
    <div class="container bootstrap snippets bootdey">
		<div class="row">
			<div class="col-md-12">
				<div class="slip-wrapper">
					<div class="intro">
                        <h5 style="float:left">Application Form</h5>
                        <div style="float:right">
                            <img src="{{asset('phpcode/validid/'.$adoption->picture)}}" width="150px" height="150px" />
                        </div>
					</div>

					<div class="payment-info">
						<div class="row">
							<div class="col-sm-6">
								<span>Date:</span>
								<strong>{{$today}}</strong>
							</div>
						</div>
					</div>
                    <div class="line-items">
						<div class="headers clearfix">
							<div class="row">
								<div class="col-md-4">Adopter Details</div>
							</div>
						</div>
						<div class="items" >
							<div class="row item">
                                <div class="col-md-5">
                                    
                                    <span>Name</span>
                                    <p><strong>{{$adoption->adopter->fname}} {{$adoption->adopter->lname}}</strong></p>
                                    <span>Gender</span>
                                    <p><strong>{{$adoption->adopter->gender}}</strong></p>
                                    <span>Contact No.</span>
                                    <p><strong>{{$adoption->adopter->phonenum}}</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <span>Birthdate</span>
                                    <p><strong>{{$adoption->adopter->birthdate}}</strong></p>
                                    <span>Address</span>
                                    <p><strong>{{$adoption->adopter->address}}</strong></p>
                                    <span>Email Address</span>
                                    <p><strong>{{$adoption->adopter->email}}</strong></p>
                                </div>
                             </div>
                             <div class="items">
                                <div class="row item">
                                    <span>Valid ID</span><br>
                                    <div class="col-sm">
                                    <img src="{{asset('phpcode/validid/'.$adoption->validId)}}" width="230px" height="200px" />
                                    </div>
                                    <span>Signature</span><br>
                                    <div class="col-sm">
                                    <img src="{{asset('phpcode/validid/'.$adoption->signature)}}" width="150px" height="150px" />
                                    </div>
                                </div>
                             </div>
                             <div class="payment-details">
                                 <div class="row">
                                     <div class="col-sm-6">
                                     <h6 style="color:black">Questionnaires</h6>
                                        <span>Question 1 out of 12</span>
                                        <p>Are you a student or an employee?</p>
                                        Answer: <strong></strong>

                                        <span><br>Question 2 out of 12</span>
                                        <p>For whom are you adopting a pet?</p>
                                        Answer: <strong></strong><br>

                                        <span><br>Question 3 out of 12</span>
                                        <p>Are there children (below18) in the house?</p>
                                        Answer: <strong></strong><br>

                                        <span><br>Question 4 out of 12</span>
                                        <p>Do you have other pets? If yes,tell us about them: </p>
                                        Answer: <strong></strong><br>

                                        <span><br>Question 5 out of 12</span>
                                        <p>Who else do you live with?</p>
                                        Answer: <strong></strong><br>

                                        <span><br>Question 6 out of 12</span>
                                        <p>Are any members of your house hold allergic to animals?</p>
                                        Answer: <strong></strong><br>
							    </div>
                            <div class="col-sm-6">
                                <span>Question 7 out of 12</span>
                                <p>Who will be responsible for feeding, grooming, and generally caring for your pet?</p>
                                Answer: <strong></strong>

                                <span><br>Question 8 out of 12</span>
                                <p>Who will be financially responsible for your pet’s needs(i.e.food,vetbills,etc.)?</p>
                                Answer: <strong></strong><br>

                                <span><br>Question 9 out of 12</span>
                                <p>Who will look after your pet if you go on vacation or in case of emergency?</p>
                                Answer: <strong></strong><br>

                                <span><br>Question 10 out of 12</span>
                                <p>How many hours in an average work day will your pet be left alone?</p>
                                Answer: <strong> </strong><br>

                                <span><br>Question 11 out of 12</span>
                                <p>Does everyone in the family support your decision to adopt a pet?Please explain:</p>
                                Answer: <strong> </strong><br>

                                <span><br>Question 12 out of 12</span>
                                <p>What type of building do you live in?</p>
                                Answer: <strong></strong>
                                
                            </div>

						</div>
                    </div>
                    
                </div>
                
            </div>

            
        </div>
        <div class="footer">
            Copyright © 2014. company name
        </div>
    </div>
@endsection