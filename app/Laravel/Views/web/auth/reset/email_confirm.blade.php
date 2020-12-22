<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{$page_title}}</title>
  @include('web._components.styles')
  <style type="text/css">
    .auth .brand-logo img {width: 250px; }

  </style>
</head>

<body>
 <section class="hero-section hero-bg-1 ptb-100 full-screen">
        <div class="container">
            <div class="row align-items-center justify-content-center pt-5 pt-sm-5 pt-md-5 pt-lg-0">
                <div class="col-md-4 col-lg-4">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <h5 class="h5 text-center mb-4">Password Reset link has been sent to your Email Address.</h5>
                            <h3><a href="{{ route('web.main.index') }}">Back to home</a></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
