<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Coming Soon</title>
  <link rel="shortcut icon" href="{{asset('system/images/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('system/vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('system/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('system/css/vertical-layout-light/style.css')}}">
</head>
<style>
    .element{
        width: 1600px;
        height: 928px;
        background-image: url("{{asset('web/img/element.png')}}"); /* The image used */
        background-position: left; /* Center the image */
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover; /* Resize the background image to cover the entire container */
        position: relative;
    }
    .oboss {
        top: 540px;
        left: 269px;
        width: 438px;
        height: 122px;
    }
    .coming{
        width: 484px;
        height: 96px;
        font: normal normal 900 80px/96px Roboto;
        letter-spacing: 0px;
        color: #0044A0;
    }
</style>
<body style="background-color: #F8F8F8!important">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex justify-content-around text-center error-page">
        <div class="row flex-grow align-items-center">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 coming">Coming soon</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{asset('web/img/zamboanga-oboss.png')}}" alt="" class="oboss">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row element"></div>
            </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script src="{{asset('system/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('system/js/off-canvas.js')}}"></script>
  <script src="{{asset('system/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('system/js/template.js')}}"></script>
  <script src="{{asset('system/js/settings.js')}}"></script>
</body>

</html>
