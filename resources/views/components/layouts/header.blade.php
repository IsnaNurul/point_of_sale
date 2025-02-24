<div class="header">
    <div class="header-left active">
        @if (Auth::user()->role == 'cashier')
            <a href="{{ route('pos') }}" class="logo logo-normal">
                <img src="{{ asset('assets/img/logo.png') }}" alt />
            </a>
            <a href="{{ route('pos') }}" class="logo logo-white">
                <img src="{{ asset('assets/img/logo-white.png') }}" alt />
            </a>
            <a href="{{ route('pos') }}" class="logo-small">
                <img src="{{ asset('assets/img/logo-small.png') }}" alt />
            </a>
            <a id="toggle_btn" href="javascript:void(0);">
                <i data-feather="chevrons-left" class="feather-16"></i>
            </a>
        @else
        <a href="{{ route('dashboard') }}" class="logo logo-normal">
            <img src="{{ asset('assets/img/logo.png') }}" alt />
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-white">
            <img src="{{ asset('assets/img/logo-white.png') }}" alt />
        </a>
        <a href="{{ route('dashboard') }}" class="logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt />
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
        @endif
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <ul class="nav user-menu" style="display: flex; justify-content: end;">
        <li class="nav-item nav-item-box">
            <a href="javascript:void(0);" id="btnFullscreen">
                <i data-feather="maximize"></i>
            </a>
        </li>

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-info">
                    <span class="user-letter">
                        <img src="https://img.favpng.com/8/0/5/computer-icons-user-profile-avatar-png-favpng-6jJk1WU2YkTBLjFs4ZwueE8Ub.jpg"
                            alt class="img-fluid" />
                    </span>
                    <span class="user-detail">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ Auth::user()->role }}</span>
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img
                                src="https://img.favpng.com/8/0/5/computer-icons-user-profile-avatar-png-favpng-6jJk1WU2YkTBLjFs4ZwueE8Ub.jpg"
                                alt />
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>{{ Auth::user()->name }}</h6>
                            <h5>{{ Auth::user()->role }}</h5>
                        </div>
                    </div>
                    <hr class="m-0" />
                    {{-- <a class="dropdown-item" href="profile.html">
                        <i class="me-2" data-feather="user"></i> My Profile</a>
                    <a class="dropdown-item" href="general-settings.html"><i class="me-2"
                            data-feather="settings"></i>Settings</a> --}}
                    <hr class="m-0" />
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="me-2" data-feather="user"></i> My Profile</a>
                    <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"><img
                            src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2"
                            alt="img" />Logout</a>
                </div>
            </div>
        </li>
    </ul>

    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="general-settings.html">Settings</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
        </div>
    </div>
</div>
