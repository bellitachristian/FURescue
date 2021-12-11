<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>FURescue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link rel="stylesheet" href="css/mdb.min.css" />
    <link rel="stylesheet" href="/styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <style>
      #introCarousel,
      .carousel-inner,
      .carousel-item,
      .carousel-item.active {
        height: 100vh;
      }

      .carousel-item:nth-child(1) {
        background-image: url(images/logo.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(2) {
        background-image: url(images/pet2.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(3) {
        background-image: url(images/pet1.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(4) {
        background-image: url(images/pet.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }
      /* Height for devices larger than 576px */
      @media (min-width: 992px) {
        #introCarousel {
          margin-top: -58.59px;
        }
      }

      .navbar .nav-link {
        color: #fff !important;
      }
    </style>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block" style="z-index: 2000;">
      <div class="container-fluid">
        <img style = "height: 40px;" src="images/final-logo-part2.png"/>
        <div class="collapse navbar-collapse" id="navbarExample01">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="#intro"></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://www.youtube.com/channel/UC5CF7mLQZhvx8O5GODZAhdA" rel="nofollow"
                target="_blank"></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://mdbootstrap.com/docs/standard/" target="_blank"></a>
            </li>
          </ul>

          <ul class="navbar-nav list-inline">
            <li>
            <a  href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#choose">Signup</a>
            </li>
            <li>
            <a class="nav-link" aria-current="page" href="/User/login">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <div id="introCarousel" class="carousel slide carousel-fade shadow-2-strong" data-mdb-ride="carousel">
      <ol class="carousel-indicators">
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="0" class="active"></li>
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="1"></li>
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="2"></li>
        <li data-mdb-target="#introCarousel" data-mdb-slide-to="3"></li>
      </ol>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div class="text-white text-center">
                <h1 class="mb-3">WELCOME TO FURESCUE</h1>
                <h5 class="mb-4">Fauna Urgent Rescue</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div class="text-white text-center">
                <h2>WIN</h2>
                <h5>Win the hearts of possible owners by showing relevant information of a pet.</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
            <div class="d-flex justify-content-center align-items-center h-100">
              <div class="text-white text-center">
                <h2>BUILD</h2>
                <h5>Build trust with possible adopters who are able to comply with the adoption requirements.</h5>
              </div>
            </div>
          </div>
        </div>      

        <div class="carousel-item">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
              <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-white text-center">
                  <h2>ADOPT</h2>
                  <h5>Family love achieved.</h5>
                </div>
              </div>
            </div>
          </div>      
        </div>

      </div>
      <a class="carousel-control-prev" href="#introCarousel" role="button" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#introCarousel" role="button" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>

    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2021 Copyright:
      <a class="text-dark" href="https://mdbootstrap.com/">furescue</a>
    </div>
  </footer>

    <script type="text/javascript" src="js/mdb.min.js"></script>
 <!-- Choose as -->
<div class="modal fade" id="choose"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="chooseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header choose">
                <h5 class="modal-title" id="chooseLabel">Choose As</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <!-- <hr>
                        <a class="adopter" href="/register" data-bs-toggle="modal" data-bs-target="#register" data-bs-dismiss="modal">
                            <img src="/images/adopter.png" alt="adopter">   
                            <h4>adopter/pet owner</h4>
                        </a> -->
                </div>
            <div class="modal-footer">
                <div style="padding:3%">

                </div>
            </div>
        </div>
    </div>
</div>   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html> 