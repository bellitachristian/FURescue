<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Pet Owner</title>
    <link rel="stylesheet" href="/styles/register.css">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

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
                <h4 style="text-align:center">Sign up as Pet Owner </h4><hr>
                @if(session('status'))
                <h6 class="alert alert-success">{{session('status')}}</h6>
                @endif
                @if(session('status1'))
                <h6 class="alert alert-danger">{{session('status1')}}</h6>
                @endif
                <form action="/Register/petOwner" method="post"enctype="multipart/form-data">
                @csrf
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Personal Information</label>
                        </div>
                        <div class="col-sm-6">  
                            <label> Account Information</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" placeholder="Enter first name" value ="{{old('fname')}}">
                            <span class="text-danger">@error('fname'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" placeholder="Enter last name" value ="{{old('lname')}}">
                            <span class="text-danger">@error('lname'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-6">
                            <label>Gcash No.</label>
                            <input type="text" class="form-control" name="gcash" placeholder="Enter Gcash number" value ="{{old('gcash')}}">
                            <span class="text-danger">@error('gcash'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>Contact No.</label>
                            <input type="text" name="contact" class="form-control" placeholder="Enter Cell no." value ="{{old('contact')}}">
                            <span class="text-danger">@error('contact'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label class="text-sm">Gender</label>
                            <select class="form-control form-control-sm" id="gender" required name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>    
                        </div>
                        <div class="col-sm-6">
                            <label>Paypal No.</label>
                            <input type="text" class="form-control" name="pay_pal" placeholder="Enter Paypal number"value ="{{old('pay_pal')}}">
                            <span class="text-danger">@error('pay_pal'){{$message}}@enderror</span>
                        </div>
            
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter complete address" value ="{{old('address')}}">
                            <span class="text-danger">@error('address'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Confirm Password</label>
                            <input type="password" name="c_password" class="form-control"placeholder="Enter confirm password">
                            <span class="text-danger">@error('c_password'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter email address" value ="{{old('email')}}">
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                                <div class="card">
                                        <div class="card-header">
                                            Valid Documents(screenshot of e.g.driver's license,voter's id,etc.)
                                        </div>
                                        <div class="card-body">
                                                <input type="file" required multiple name="images[]" id="image">    
                                        </div>
                                </div>
                            </div>      
                    </div>            
                    <button type="submit" class="btn btn-block btn-primary">Sign Up</button>
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