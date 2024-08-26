<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            APS<span>Patriot</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('index_admin') }}" class="nav-link">
                    <i class="link-icon" data-feather="trello"></i>
                    <span class="link-title">Santri</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('index_admin_mitra') }}" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Mitra</span>
                </a>
            </li>
            @if (Auth::user()->role == 'admin' ||  Auth::user()->role == 'dev')
                <li class="nav-item nav-category">Settings</li>
                <li class="nav-item">
                    <a href="{{ route('magang.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="compass"></i>
                        <span class="link-title">Magang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pembina.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Pembina</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('asrama.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="home"></i>
                        <span class="link-title">Asrama</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sesi') }}" class="nav-link">
                        <i class="link-icon" data-feather="activity"></i>
                        <span class="link-title">Session</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
