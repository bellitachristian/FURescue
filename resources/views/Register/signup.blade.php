<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Animal Shelter</title>
    <link rel="stylesheet" href="/styles/register.css">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyD5HhjPje8DC23_KCXo9ZNJTVP5gb1Eg2g"></script>

    <script>
        var searchInput = 'search_input';
        $(document).ready(function () {
        var autocomplete;
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
        componentRestrictions: {
        country: "PH",
        }
        });
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();       
        });
    });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="/images/flogo.png" alt="Furescue">
        </div>
    </header>
    <div class="container"> 
        <div class="row" style="justify-content:center; margin-top:">
            <div class="col-md-8 mx-auto">
                <h4 style="text-align:center">Sign up as Animal Shelter </h4><hr>
                @if(session('status'))
                <h6 class="alert alert-success">{{session('status')}} <a href="#" class="close" aria-label="Close" data-dismiss="alert">x</a></h6>
                @endif
                @if(session('status1'))
                <h6 class="alert alert-danger">{{session('status1')}} <a href="#" class="close" aria-label="Close" data-dismiss="alert">x</a></h6>
                @endif
                <form action="{{ route('Register.save')}}" method="post"enctype="multipart/form-data">
                @csrf
                    <div class="form-group row">
                        <div class="col-sm-6">
                           <h5>Shelter Information</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Name of Shelter</label>
                            <input type="text" class="form-control" name="shelter_name" required placeholder="Enter Name of shelter" value ="{{old('shelter_name')}}">
                            <span class="text-danger">@error('shelter_name'){{$message}}@enderror</span>
                            <div>
                        </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Gcash No.</label>
                            <input type="text" class="form-control" name="g_cash" required placeholder="Enter Gcash number" value ="{{old('g_cash')}}">
                            <span class="text-danger">@error('g_cash'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" required placeholder="Enter Email address" value ="{{old('email')}}">
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-6">
                            <label>Paypal No.</label>
                            <input type="text" class="form-control" name="pay_pal" required placeholder="Enter Paypal number"value ="{{old('pay_pal')}}">
                            <span class="text-danger">@error('pay_pal'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                                <label>Address</label>
                                <input type="text"  name="address" class="form-control" required placeholder="Enter Address" value ="{{old('address')}}">
                                <span class="text-danger">@error('address'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Enter password" required class="form-control">
                            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Confirm Password</label>
                            <input type="password" name="c_password" placeholder="Enter confirm password" required class="form-control">
                            <span class="text-danger">@error('c_password'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">    
                                <div class="col-sm-6">
                                    <div class="card">
                                            <div class="card-header">
                                                Valid Documents(screenshot or PDF file of e.g.SEC,Business permit)
                                            </div>
                                            <div class="card-body">
                                                 <input type="file" required multiple name="images[]" id="image">    
                                            </div>
                                    </div>
                                </div>      
                            <div class="col-sm-3">
                                <label>Name of Contact Person</label>
                                <input type="text" name="founder_name" required class="form-control" placeholder="Enter founder" value ="{{old('founder_name')}}">
                                <span class="text-danger">@error('founder_name'){{$message}}@enderror</span>     
                            </div>
                            <div class="col-sm-3">
                                <label>Contact No.</label>
                                <input type="text" name="contact" required class="form-control"placeholder="Enter Contact number" value ="{{old('contact')}}">
                                <span class="text-danger">@error('contact'){{$message}}@enderror</span>
                            </div>  
                        <div class="col-sm-3">
                            <label class="text-sm">Starting point(Day)</label>
                            <select class="form-control form-control-sm" id="start" required name="start_day">
                                <option value="">---Select Start Day---</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>    
                        </div>  
                        <div class="col-sm-3">
                            <label class="text-sm">Ending point(Day)</label>
                            <select class="form-control form-control-sm" id="end" required name="end_day">
                                <option value="">---Select End Day---</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>     
                        </div>
                    </div>       
                    <div class="form-group row">
                    <div class="col-sm-3">
                            <label class="text-sm">Start Time(Intime)</label>
                            <input type="time" min="06:00:00" and max="12:00:00" required name="intime">
                        </div>
                        <div class="col-sm-3">
                            <label class="text-sm">End Time(Outime)</label>
                           <input type="time" min="13:00:00" and max="19:00:00" required name="outime">
                        </div>
                    </div>
                    <button type="submit" style="margin-top:5%" class="btn btn-block btn-primary">Sign Up</button>
                    <br>
                    <a href="/User/login">I already have an account, log in</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

</body>
</html>
<script>
    const inputElement = document.querySelector('input[id="image"]');
    const pond = FilePond.create(inputElement);
    FilePond.setOptions({
        allowRevert:false,
        server:{
            url: '/Register', 
            process: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
});
</script>


