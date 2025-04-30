<ul class="navbar-nav iq-main-menu" id="sidebar">
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('dashboard')) }}" aria-current="page" href="{{ route('dashboard') }}">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4"
                        d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                        fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                        fill="currentColor"></path>
                </svg>
            </i>
            <span class="item-name">Dashboard</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>
    {{-- Master --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Master</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('bahan.index')) }}" href="{{ route('bahan.index') }}">
            <i class="fas fa-dolly mt-1"></i>
            <span class="item-name">Bahan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('pekerjaan.index')) }}" href="{{ route('pekerjaan.index') }}">
            <i class="fas fa-clipboard mt-1"></i>
            <span class="item-name">Pekerjaan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('tenaga-kerja.index')) }}" href="{{ route('tenaga-kerja.index') }}">
            <i class="fas fa-user-pen mt-1"></i>
            <span class="item-name">Tenaga Kerja</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>
    {{-- Proses --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Proses</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('proyek.index')) }}" href="{{ route('proyek.index') }}">
            <i class="fas fa-briefcase mt-1"></i>
            <span class="item-name">Proyek</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('preorder.index')) }}" href="{{ route('preorder.index') }}">
            <i class="fas fa-truck mt-1"></i>
            <span class="item-name">Preorder</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('approval.index')) }}" href="{{ route('approval.index') }}">
            <i class="fas fa-clipboard-check mt-1"></i>
            <span class="item-name">Approval</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>
    {{-- Laporan --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Laporan</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('laporan-harian.index')) }}" href="{{ route('laporan-harian.index') }}">
            <i class="fas fa-calendar-day mt-1"></i>
            <span class="item-name">Laporan Harian</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#laporan-mingguan" role="button" aria-expanded="false" aria-controls="laporan-mingguan">
            <i class="fas fa-calendar-week mt-1"></i>
            <span class="item-name">Laporan Mingguan</span>
            <i class="right-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </i>
        </a>
        <ul class="sub-nav collapse" id="laporan-mingguan" data-bs-parent="#sidebar">
            <li class="nav-item ">
                <a class="nav-link {{ activeRoute(route('laporan-mingguan.index')) }}" href="{{ route('laporan-mingguan.index') }}">
                  <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                            <g>
                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="fas fa-bars sidenav-mini-icon mt-1"></i>
                  <span class="item-name">Laporan Progress</span>
                </a>
            </li>
            <li class=" nav-item ">
                <a class="nav-link {{ activeRoute(route('dokumentasi-mingguan.index')) }}" href="{{ route('dokumentasi-mingguan.index') }}">
                    <i class="icon svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                            <g>
                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="fas fa-book sidenav-mini-icon mt-1"></i>
                    <span class="item-name">Dokumentasi Proyek</span>
                </a>
            </li>
            <li class=" nav-item ">
                <a class="nav-link {{ activeRoute(route('cuaca-mingguan.index')) }}" href="{{ route('cuaca-mingguan.index') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                            <g>
                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="fas fa-cloud sidenav-mini-icon mt-1"></i>
                    <span class="item-name">Keadaan Cuaca</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('laporan-bulanan.index')) }}" href="{{ route('laporan-bulanan.index') }}">
            <i class="fas fa-calendar-days mt-1"></i>
            <span class="item-name">Laporan Bulanan</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>
    {{-- Setting --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Setting</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item mb-5">
        <a class="nav-link {{ activeRoute(route('users.index')) }}" href="{{ route('users.index') }}">
            <i class="fas fa-user mt-1"></i>
            <span class="item-name">Users</span>
        </a>
    </li>
</ul>
