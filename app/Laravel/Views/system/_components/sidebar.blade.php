<nav class="sidebar sidebar-offcanvas p-0" id="sidebar" style="background-color: #31353D;color: #ffff;">
  <h6 class="pl-3 pt-4">Menu</h6>
  <ul class="nav">

    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.dashboard')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.dashboard')}}">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(in_array($auth->type,['super_user','admin','processor','office_head']))
      <!-- @if(in_array($auth->type,['super_user','admin','office_head']))
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.processor.list','system.processor.show' )) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.processor.list')}}">
            <i class="fa fa-user-circle menu-icon"></i>
            <span class="menu-title">Processors</span>
          </a>
        </li>
      @endif -->
   <!--  <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.transaction.index','system.transaction.show','system.transaction.declined','system.transaction.pending','system.transaction.approved','system.transaction.resent')) ? 'active' : ''}}">
      <a class="nav-link" data-toggle="collapse" href="#my_report" aria-expanded="false" aria-controls="my_report">
        <i class="fa fa-file menu-icon"></i>
        <span class="menu-title">Transactions</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="my_report">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.transaction.pending')}}">Pending
          </a></li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.transaction.approved')}}">Approved

          </a></li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.transaction.declined')}}">Declined
          </a></li>
        </ul>
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.transaction.resent')}}">Resent
          </a></li>
        </ul>
        @if(in_array($auth->type,['processor']))
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.transaction.create')}}">Create New</a></li>
        </ul>
        @endif
      </div>
    </li> -->
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.business_transaction.show','system.business_transaction.pending','system.business_transaction.approved','system.business_transaction.declined')) ? 'active' : ''}}">
      <a class="nav-link" data-toggle="collapse" href="#business_transaction" aria-expanded="false" aria-controls="business_transaction">
        <i class="fa fa-file menu-icon"></i>
        <span class="menu-title">Business Transactions</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="business_transaction">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('system.business_transaction.pending')}}">Pending
            <!-- @if($counter['pending'] > 0)
              <span class="badge badge-sm badge-primary">{{$counter['pending']}}</span>
            @endif -->
          </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('system.business_transaction.approved')}}">Approved
            <!-- @if($counter['pending'] > 0)
              <span class="badge badge-sm badge-primary">{{$counter['pending']}}</span>
            @endif -->
          </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('system.business_transaction.declined')}}">Declined
            <!-- @if($counter['pending'] > 0)
              <span class="badge badge-sm badge-primary">{{$counter['pending']}}</span>
            @endif -->
          </a></li>
        </ul>


      </div>
    </li>
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.other_customer.index','system.other_customer.create','system.other_transaction.index','system.other_transaction.show','system.other_customer.show','system.other_transaction.create')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.other_customer.index')}}">
        <i class="fa fa-file menu-icon"></i>
        <span class="menu-title">Local Record</span>
      </a>
    </li>
    @if(in_array($auth->type,['super_user','admin','office_head']))
      @if(in_array($auth->type,['super_user','admin']))
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.business_cv.index', 'system.business_cv.create', 'system.business_cv.show')) ? 'active' : ''}}">
            <a class="nav-link" href="{{route('system.business_cv.index')}}">
            <i class="fa fa-check-circle menu-icon"></i>
            <span class="menu-title">Business CV</span>
            </a>
        </li>
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.application.index','system.application.create','system.application.edit')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.application.index')}}">
            <i class="fa fa-bookmark menu-icon"></i>
            <span class="menu-title">Applications</span>
          </a>
        </li>
        {{-- <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.collection_fees.index', 'system.collection_fees.create', 'system.collection_fees.edit')) ? 'active' : ''}}">
            <a class="nav-link" href="{{route('system.collection_fees.index')}}">
              <i class="fa fa-check-circle menu-icon"></i>
              <span class="menu-title">Collection of Fees</span>
            </a>
        </li> --}}
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.bplo.index', 'system.bplo.edit', 'system.bplo.create')) ? 'active' : ''}}">
            <a class="nav-link" href="{{route('system.bplo.index')}}">
              <i class="fa fa-user menu-icon"></i>
              <span class="menu-title">Registrants</span>
            </a>
        </li>
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.department.index','system.department.create','system.department.edit')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.department.index')}}">
            <i class="fa fa-globe menu-icon"></i>
            <span class="menu-title">Department</span>
          </a>
        </li>

        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.application_requirements.index','system.application_requirements.create','system.application_requirements.edit')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.application_requirements.index')}}">
            <i class="fa fa-check-circle menu-icon"></i>
            <span class="menu-title">Application Requirements</span>
          </a>
        </li>
      @endif
        <!-- <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.regional_office.index','system.regional_office.create','system.regional_office.edit')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.regional_office.index')}}">
            <i class="fa fa-compass menu-icon"></i>
            <span class="menu-title">Regional Offices</span>
          </a>
        </li> -->
      @if(in_array($auth->type,['super_user','admin','office_head']))
        {{-- <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.report.index')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.report.index')}}">
            <i class="fa fa-chart-line menu-icon"></i>
            <span class="menu-title">Reporting</span>
          </a>
        </li> --}}
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.holiday.index','system.holiday.create','system.holiday.edit')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.holiday.index')}}">
            <i class="fa fa-calendar-check menu-icon"></i>
            <span class="menu-title">Holiday</span>
          </a>
        </li>
        <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.processor.index','system.processor.create','system.processor.edit','system.processor.reset')) ? 'active' : ''}}">
          <a class="nav-link" href="{{route('system.processor.index')}}">
            <i class="fa fa-user-plus menu-icon"></i>
            <span class="menu-title">Accounts</span>
          </a>
        </li>
      @endif
    @endif
  @endif
  </ul>

</nav>
