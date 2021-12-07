<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="/styles/login.css">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="/images/flogo.png" alt="Furescue">
        </div>
    </header>
    <div class="container"> 
        <div class="row" style="justify-content:center; margin-top:45px">
            <div class="col-md-4 col-md-offset-4">
                <h4 style="text-align:center">Login</h4><hr>
                @if(session('status1'))
                <p class="alert alert-danger">{{session('status1')}}<a href="#" class="close" aria-label="Close" data-dismiss="alert">x</a></p>
                @endif
                @if(session('stat'))
                <p class="alert alert-success">{{session('stat')}}<a href="#" class="close" aria-label="Close" data-dismiss="alert">x</a></p>
                @endif
                <form action="/User/login" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email address" value ="{{old('email')}}">
                        <span class="text-danger">@error('email'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                        <span class="text-danger">@error('password'){{$message}}@enderror</span>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Sign In</button>
                    <a href="/"><--Back</a> &nbsp &nbsp 
                    <a href=""data-bs-toggle="modal" data-bs-target="#choose">I don't have an account, create new</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Choose as -->
    <div class="modal fade" id="choose" data-bs-keyboard="false" tabindex="-1" aria-labelledby="chooseLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header choose">
                                <h5 class="modal-title" id="chooseLabel">Choose As</h5>
                            </div>
                                <div class="modal-body">
                                        <a class="animalshelter" href="/Register/signup">  
                                            <img src="/images/shelter-icon-E.png" alt="animal-shelter">   
                                            <h4>animal shelter</h4>
                                        </a>      
                                         <hr>
                                         <a class="petowner" href="/Register/petOwner">
                                            <img src="/images/icon-petowners.png" alt="petowner">   
                                            <h4>pet owner only</h4>
                                        </a>
                                        <hr>
                                        <!-- <a class="adopter" href="/register" data-bs-toggle="modal" data-bs-target="#register" data-bs-dismiss="modal">
                                            <img src="/images/adopter.png" alt="adopter">   
                                            <h4>adopter/pet owner</h4>
                                        </a> -->
                                </div>
                        </div>
                    </div>
                </div>
        <!-- end of Choose as-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
     </body>
</html>