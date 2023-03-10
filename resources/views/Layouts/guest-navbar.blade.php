<header class="">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                @if (!is_null(Request::segment(1)))
                    <a href="{{ url('/') }}"><i class="bi bi-chevron-left"></i></a>
                @endif
                <a href="{{ url('/') }}"><img src="{{ asset('/') }}assets/images/logo/logo.png" alt="Logo"></a>
            </div>

            <div class="header-top-right">

                @if (Auth::check())
                    <div class="dropdown">
                        <a href="#" id="topbarUserDropdown"
                            class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text">
                                <h6 class="user-dropdown-name">{{ Auth::user()->name }}</h6>
                                <p class="user-dropdown-status text-sm text-muted">{{ Auth::user()->role }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                            <li><a class="dropdown-item" href="/{{ strtolower(Auth::user()->role) }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('Profile.Settings') }}">Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('Auth.Logout') }}">Logout</a></li>
                        </ul>
                    </div>
                @else
                    <div class="dropdown">
                        <a href="#" id="topbarUserDropdown"
                            class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text">
                                <h6 class="user-dropdown-name">Login</h6>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                            <li><a class="dropdown-item" href="{{ route('Auth.Login') }}">Login</a></li>
                        </ul>
                    </div>
                @endif

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>

        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>

                <li class="menu-item">
                    <a href="{{ url('/') }}" class='menu-link'>
                        <i class="bi bi-house"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                @if (!Auth::check())
                    <li class="menu-item">
                        <a href="{{ route('SubmissionBusiness') }}" class='menu-link'>
                            <i class="bi bi-building-add"></i>
                            <span>Pengajuan Usaha</span>
                        </a>
                    </li>
                @endif

                <li class="menu-item">
                    <a href="{{ route('About.Us') }}" class='menu-link'>
                        <i class="bi bi-telephone"></i>
                        <span>Tentang Kami</span>
                    </a>
                </li>

                <li class="menu-item" id="light-mode">
                    <a href="#" class='menu-link'>
                        <i class="bi bi-sun"></i>
                        <span>Mode Terang</span>
                    </a>
                </li>

                <li class="menu-item" id="dark-mode">
                    <a href="#" class='menu-link'>
                        <i class="bi bi-moon"></i>
                        <span>Mode Gelap</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

</header>
