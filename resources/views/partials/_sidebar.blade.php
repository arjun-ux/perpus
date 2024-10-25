<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            E-Perpus<span></span>
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

            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Transaksi" role="button" aria-expanded="false" aria-controls="Transaksi">
                    <i class="link-icon" data-feather="book-open"></i>
                    <span class="link-title">Transaksi</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Transaksi">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('borrow.create') }}" class="nav-link">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('returns.create') }}" class="nav-link">Pengembalian</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#katalog" role="button" aria-expanded="false" aria-controls="katalog">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Katalog Buku</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="katalog">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">Kategori Buku</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('buku.index') }}" class="nav-link">Data Buku</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#master-data" role="button" aria-expanded="false" aria-controls="master-data">
                    <i class="link-icon" data-feather="folder"></i>
                    <span class="link-title">Masterdata</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="master-data">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('member.index') }}" class="nav-link">Data Anggota</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('publisher.index') }}" class="nav-link">Data Penerbit</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('administrator') }}" class="nav-link">Administrator</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#laporan" role="button" aria-expanded="false" aria-controls="laporan">
                    <i class="link-icon" data-feather="folder"></i>
                    <span class="link-title">Laporan</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="laporan">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link">Laporan Perpustakaan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('borrow.index') }}" class="nav-link">Data Peminjam</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Settings</li>
            <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
