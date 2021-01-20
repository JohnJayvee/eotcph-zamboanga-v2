<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center">
    <a class="navbar-brand brand-logo" href="{{route('system.dashboard')}}"><img src="{{asset('web/img/oBOSS.png')}}" alt="logo"/></a>
    <a class="navbar-brand brand-logo-mini" href="{{route('system.dashboard')}}"><img src="{{asset('web/img/oBOSS.png')}}" alt="logo"/></a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <i class="fa fa-calendar-alt header-datetime" style="color: #C74A4F"> <span id="current_date" class="text-roboto"></span></i>
    <i class="fa fa-hourglass-half pl-3 header-datetime" style="color: #C74A4F"> <span id="current_time" class="text-roboto"></span></i>
    <ul class="navbar-nav navbar-nav-right">

    </ul>
    <ul class="navbar-nav navbar-nav-right">
        {{-- <li class="nav-item nav-profile dropdown navbar-nav-right float-right mr-0" style="width: 70px;">
            @if(in_array($auth->type,['super_user','admin']))
            <a class="nav-link text-title fw-500" href="#" data-toggle="dropdown" id="">
                <i class="fas fa-bell fa-lg">
                </i>
                <span class="badge badge-danger">{{ $notif_count }}</span>
              </a>
            @endif
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" style="overflow-y: auto; height: 260px;" aria-labelledby="profileDropdown">
                <div class="text-center " style="bg-color: #999 !important;">
                    <a href="{{ route('system.business_transaction.read_all_notifs') }}" class="btn btn-sm text-primary w-100">MARK ALL AS READ</a>
                </div>
                @if(in_array($auth->type,['super_user','admin']))
                        @forelse ($new_business_cv as $item)
                            @if ($item->owner)
                                @if (get_class($item) == 'App\Laravel\Models\BusinessTransaction')
                                    <a class="dropdown-item" href="{{route('system.business_transaction.show',[$item->id])}}">

                                         <i class="fas fa-circle text-danger" style="font-size: 8px; {{ $item->isNew != 1 ? 'visibility: hidden;' : '' }}"></i>
                                         {{ $item->for_bplo_approval == 1 ?  'BPLO Admin, ' : 'New Business Transaction Added ' }} {{  strtoupper($item->business_name)}} /<br>  {{strtoupper($item->owner->name)}} {{ $item->for_bplo_approval == 1 ?  'is now ready for your approval.' : '' }}
                                    </a>
                                @endif
                                @if (get_class($item) == 'App\Laravel\Models\Business')
                                    <a class="dropdown-item" href="{{ route('system.business_cv.show', ['id' => $item->id]) }}">
                                        New Business CV Addded {{strtoupper($item->business_name)}} /<br>  {{strtoupper($item->owner->name)}}
                                    </a>
                                @endif
                            @endif
                        @empty
                    <a href="#" class="dropdown-item">
                        No notification
                    </a>
                    @endforelse
                @endif
            </div>
        </li> --}}
        <li class="nav-item nav-profile dropdown navbar-nav-right ml-0" style="width: 250px;">
          <a class="nav-link text-title fw-500" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="{{strlen($auth->filename) > 0 ? "{$auth->directory}/resized/{$auth->filename}" : asset('placeholder/user.png')}}" alt="profile"/>
             <span class="profile-details">&nbsp; Welcome, {{Auth::user()->fullname}}</span>
            <i class="fas fa-caret-down ml-2"></i>
          </a>

          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item disabled">Welcome {{$auth->name}}!</a>
            <a href="{{route('system.profile.index')}}" class="dropdown-item">
              <i class="mdi mdi-settings "></i>
              My Profile
            </a>
            <a href="{{route('system.profile.password.edit')}}" class="dropdown-item">
              <i class="mdi mdi-key"></i>
              Change Password
            </a>
            <a href="{{route('system.auth.logout')}}" class="dropdown-item">
              <i class="mdi mdi-logout"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>

  </div>
</nav>
<div class="theme-setting-wrapper">
  <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>
  <div id="theme-settings" class="settings-panel">
    <i class="settings-close mdi mdi-close"></i>
    <p class="settings-heading">SIDEBAR SKINS</p>
    <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
    <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
    <p class="settings-heading mt-2">HEADER SKINS</p>
    <div class="color-tiles mx-0 px-4">
      <div class="tiles primary"></div>
      <div class="tiles secondary"></div>
      <div class="tiles dark"></div>
      <div class="tiles default"></div>
    </div>
  </div>
</div>
