<!-- Topbar Start -->
<div class="navbar-custom topnav-navbar topnav-navbar-dark">
    <div class="container-fluid">
        <!-- LOGO -->
        <a class="topnav-logo" href="{{ route('home') }}">
            <span class="topnav-logo-lg">
                <img src="{{ asset('assets/images/logo.png') }}" height="40" alt="{{__('messages.support feeling')}}">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{ asset('assets/images/logo.png') }}" height="40" alt="{{__('messages.support feeling')}}">
            </span>
        </a>

        <ul class="list-unstyled topbar-right-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop"
                    href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{asset(auth()->user()->picture)}}" alt="user-image" class="rounded-circle">
                    </span>
                    <span  style="color: #fff;">
                        <span class="account-user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                        <span class="account-position">
                            {{ auth()->user()->role }}
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                aria-labelledby="topbar-userdrop">
                <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- Account -->

                     <!--Logout-->
                     <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('messages.Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        {{__('messages.Profile')}}
                    </a>

                </div>
            </li>
        </ul>
<a class="button-menu-mobile disable-btn">
    <div class="lines">
        <span></span>
        <span></span>
        <span></span>
    </div>
</a>
<div class="visit_website">
    <a href="{{ route('home') }}" target="" class="btn btn-outline-light ml-3 d-none d-md-inline-block">visit website</a>
</div>
</div>
</div>
<!-- end Topbar -->