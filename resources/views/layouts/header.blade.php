<div class="d-flex align-items-center logo-box justify-content-start">
    <!-- Logo -->
    <a href="index-2.html" class="logo">
      <!-- logo-->
      <div class="logo-mini w-80">
          <span class="light-logo"><img src="{{URL::to('storage/images/logo/'.Setting::get_setting()->logo)}}" alt="logo"></span>
          <span class="dark-logo"><img src="{{URL::to('storage/images/logo/'.Setting::get_setting()->logo)}}" alt="logo"></span>
      </div>
      <div class="logo-lg">
          <span class="light-logo"><img src="{{URL::to('storage/images/logo/'.Setting::get_setting()->small_logo)}}" alt="logo"></span>
          <span class="dark-logo"><img src="{{URL::to('storage/images/logo/'.Setting::get_setting()->small_logo)}}" alt="logo"></span>
      </div>
    </a>
</div>
<!-- Header Navbar -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->


  <div class="app-menu">
    <ul class="header-megamenu nav">
        <li class="btn-group nav-item">
            <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light" data-toggle="push-menu" role="button">
                <i data-feather="align-left"></i>
            </a>
        </li>

    </ul>
  </div>

  <div class="navbar-custom-menu r-side">
    <ul class="nav navbar-nav">

        <li class="btn-group nav-item d-lg-inline-flex d-none">
            <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen btn-warning-light" title="Full Screen">
                <i data-feather="maximize"></i>
            </a>
        </li>
      <!-- Notifications -->


      <!-- Control Sidebar Toggle Button -->
      {{-- <li class="btn-group nav-item">
          <a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect full-screen waves-light btn-danger-light">
              <i data-feather="settings"></i>
          </a>
      </li> --}}

      <!-- User Account-->
      <li class="dropdown user user-menu">
        <a href="#" class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent py-0 no-shadow" data-bs-toggle="dropdown" title="User">
            <img src="{{ isset(Auth::user()->image) ? asset("storage/images/thumbnail/".Auth::user()->image) : asset('assets/images/users/no-content.svg') }}" class="avatar rounded-10 bg-primary-light h-40 w-40" alt="" />
        </a>
        <ul class="dropdown-menu animated flipInX">
          <li class="user-body">
             <a class="dropdown-item" href="{{ url('backend/users') }}"><i class="ti-user text-muted me-2"></i>{{Auth::user()->name}}</a>
             <div class="dropdown-divider"></div>

             <a class="dropdown-item" href="javascript:void();"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
              class="mdi mdi-logout font-size-16 align-middle me-1"></i> <span
              key="t-logout">Log Out</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </li></ul>
  </div>
</nav>
