<div class="horizontal-menu">
    <nav class="navbar top-navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="#" class="navbar-brand">
                    APS<span>Patriot Panji Pelopor</span>
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="wd-30 ht-30 rounded-circle" src="{{ asset('assets/images/logo.png') }}" alt="profile">
                        </a>
                        <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="mb-3">
                                <img class="wd-80 ht-80 rounded-circle" src="{{ asset('assets/images/logo.png') }}" alt="">
                            </div>
                            <div class="text-center">
                                <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                                <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <ul class="list-unstyled p-1">
                            @if (Auth::user()->role === 'santri')
                                <a href="{{ route('profile.santri') }}" class="text-body ms-0">
                                    <li class="dropdown-item py-2">
                                        <i class="me-2 icon-md" data-feather="user"></i>
                                        <span>Profile</span>
                                    </li>
                                </a>
                            @elseif (Auth::user()->role === 'mitra')
                                <a href="{{ route('profile.mitra') }}" class="text-body ms-0">
                                    <li class="dropdown-item py-2">
                                        <i class="me-2 icon-md" data-feather="user"></i>
                                        <span>Profile</span>
                                    </li>
                                </a>
                            @endif
                            <a href="{{ route('logout') }}" class="text-body ms-0">
                                <li class="dropdown-item py-2">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </li>
                            </a>
                        </ul>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
                @if (Auth::user()->role == 'dev')
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard dev</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard dev</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard dev</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard dev</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role == 'santri')
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Santri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Santri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Santri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Santri</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role == 'mitra')
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Mitra</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Mitra</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Mitra</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="menu-title">Dashboard Mitra</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
