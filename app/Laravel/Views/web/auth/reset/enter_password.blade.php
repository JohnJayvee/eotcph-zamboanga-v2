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
                            <form action="{{ route('web.password.reset_password') }}" method="POST" class="login-signup-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ request('token') }}">
                                <input type="hidden" name="email" value="{{ request('email') }}">
                           	    <h5 class="h5 text-center mb-4">Enter your New Password</h5>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="text-form pb-2">New Password</label>
                                            <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid': NULL  }} form-control-sm" name="password" placeholder="Password" id="password-field" value="{{ old('password') }}">
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            @if($errors->first('password'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('password')}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="text-form pb-2">Confirm New Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="">
                                            <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block secondary-solid-btn fw-500 mt-4 mb-3">
                                    <i class="fa fa-sign-in-alt"></i> Save
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
<script>
    $(function (){
        $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    })
</script>
