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
<div class="slip-content" >
    <a href="{{route('adoption.request.petowner')}}"><button type="button" class="btn btn-danger">Back</button></a>
    <div class="container bootstrap snippets bootdey">
		<div class="row">
			<div class="col-md-12">
				<div class="slip-wrapper">
					<div class="intro">

                        <hr>
                        <h5>Adoption Questionnaire</h5>
					</div>

					<div class="payment-info">
						<div class="row">
							<div class="col-sm-6">
								<span>Date:</span>
								<strong>November 30, 2021</strong>
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
                                    <p><strong>Christian Sugo</strong></p>
                                    <span>Gender</span>
                                    <p><strong>Male</strong></p>
                                    <span>Contact No.</span>
                                    <p><strong>0912384774834</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <span>Birthdate</span>
                                    <p><strong>05/13/1999</strong></p>
                                    <span>Address</span>
                                    <p><strong>91-G, Langub Road, Guadalupe Cebu City</strong></p>
                                    <span>Email Address</span>
                                    <p><strong>christiansugo@gmail.com</strong></p>
                                </div>
                             </div>
                             <div class="payment-details">
                                 <div class="row">
                                     <div class="col-sm-6">
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