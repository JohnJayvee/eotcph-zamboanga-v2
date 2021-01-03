<!--header section start-->
@if(Auth::guard('customer')->user())
<!--header section start-->
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top bg-white p-0" style="
    border-bottom: 4px solid #254DA0;">
        <div class="container">
            <a class="brand-logo" href="{{route('web.business.index')}}">
                <img src="{{asset('web/img/oBOSS.png')}}" alt="logo" class="img-fluid" width="30%" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="date-time pl-4">
                <i class="fa fa-calendar-alt" style="color: #C74A4F"> <span id="current_date" class=""></span></i>
                <i class="fa fa-hourglass-half pl-4" style="color: #C74A4F"> <span id="current_time" class=""></span></i>
            </div>
            <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu">
                    <li>
                        <a href="#" class=""><img src="{{asset('placeholder/user.png')}}" alt="logo" class="img-fluid profile-image"/> Welcome , {{Str::title(Auth::guard('customer')->user()->fname)}}
                            <i class="fas fa-caret-down ml-2"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{route('web.profile.edit')}}">Edit Profile</a></li>
                            <li><a href="{{route('web.profile.password.edit')}}">Change Password</a></li>
                        </ul>
                    </li>
                    <li>
                        <li><a  href="#"><i class="fa fa-handshake"></i> Services <i class="fas fa-caret-down"></i></a>
                        <ul class="sub-menu">
                            <li><a  href="http://staging.eor.ziapay.ph/validate" target="_blank"><i ></i> EOR Authenticity</a></li>
                            <li><a href="{{route('web.coming_soon')}}">New Registration</a></li>
                            <li><a href="{{route('web.business.index')}}">Renewal</a></li>
                            <li><a href="{{route('web.coming_soon')}}">Taxes , Fees and Dues</a></li>
                        </ul>
                    </li>
                    <li><a  href="{{route('web.logout')}}"><i class="fa fa-sign-out-alt"></i> Sign Out</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!--header section end-->
@else
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top bg-white" style="
    border-bottom: 4px solid #254DA0;">
        <div class="container">
            <a class="brand-logo" href="{{route('web.main.index')}}">
                <img src="{{asset('web/img/oBOSS.png')}}" alt="logo" class="img-fluid" width="30%" />
            </a>
            <div class="date-time pl-4">
                <i class="fa fa-calendar-alt" style="color: #C74A4F"> <span id="current_date" class=""></span></i>
                <i class="fa fa-hourglass-half pl-4" style="color: #C74A4F"> <span id="current_time" class=""></span></i>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>

            <div class="collapse navbar-collapse h-auto " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu" >
                    {{-- <li><a  href="about-us.html">About Us</a></li> --}}
                    {{-- <li><a  href="{{route('web.main.index')}}"><i class="fa fa-home" ></i> Home</a></li> --}}
                    <li><a  href="http://staging.eor.ziapay.ph/validate" target="_blank"><i ></i> EOR Authenticity</a></li>
                    <li>
                        <li><a  href="#"><i class="fa fa-handshake"></i> Services <i class="fas fa-caret-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="{{route('web.coming_soon')}}">New Registration</a></li>
                            <li><a href="{{route('web.business.index')}}">Renewal</a></li>
                            <li><a href="{{route('web.coming_soon')}}">Taxes , Fees and Dues</a></li>
                        </ul>
                    </li>
                    <li><a  href="#" data-toggle="modal" data-target=".targeted-tutorial-video"><i class="fa fa-list-alt"></i> Tutorial</a></li>
                    <li><a  href="{{route('web.login')}}"><span class="badge badge-primary-2"><i class="fa fa-sign-in-alt"></i> Login</span></a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>
@endif
<!--header section end-->
