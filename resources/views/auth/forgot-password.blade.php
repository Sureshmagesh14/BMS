<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Brand Surgeon</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light vi-nav-bg">
        <div class="container">
          <a class="navbar-brand w-50 w-md-20" href="#"><img class="img-fluid" src="./assets/images/small-logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li> -->
             
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link text-white text-uppercase fw-700" href="#">About the Brand Surgeon</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white text-uppercase fw-700" href="#">Login</a>
              </li>
            </ul>

          </div>
        </div>
    </nav>
  
    <!-- main starts -->
        <main class="forgot-pass my-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="text-start w-md-50 w-100 m-auto my-3">
                            <p class="mb-0">Forgot Password</p>
                            <h2 class="mb-4 fw-bold h4">Account Info</h2>
                            <label for="date" class="fw-bolder">Email</label>
                            <input type="email" name="email" id="email" placeholder="email@address.com" class="form-control vi-border-clr border-radius-6px" id="">
                            <button type="submit" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2">REQUEST RESET</button> 
                            <button class="btn vi-white-bg border-radius-0 text-white px-5 py-3 m-auto w-100">BACK TO LOGIN</button> 
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div> 
                        </form> 
                        <div class="text-center m-auto d-flex flex-column">
                           
                            
                        </div> 
                    </div>
                </div>
            </div>
        </main>
    <!-- main ends -->
  
    <footer class="vi-grey-bg set-postion-fixed">
        <div class="container">
        <div class="container py-3">
            <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-end">
                <p class="mb-0 pb-0">@ 2024 The Brand Surgeon</p>
                <a href="" class="nav-link px-5 mb-0 pb-0">Terms & Conditions</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="social-icons text-end">
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </footer>

</body>
</html>
