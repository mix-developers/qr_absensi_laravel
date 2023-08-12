<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-brands fa-stack-overflow"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SIPETA') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Master Data') }}
        </div>
        <!-- Nav Item - Class -->
        <li class="nav-item {{ Nav::isRoute('class') }}">
            <a class="nav-link" href="{{ route('class') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>{{ __('Kelas') }}</span>
            </a>
        </li>
        <!-- Nav Item - Ruangan -->
        <li class="nav-item {{ Nav::isRoute('ruangan') }}">
            <a class="nav-link" href="{{ route('ruangan') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>{{ __('Ruangan') }}</span>
            </a>
        </li>
        <!-- Nav Item - Mata kuliah -->
        <li class="nav-item {{ Nav::isRoute('matakuliah') }}">
            <a class="nav-link" href="{{ route('matakuliah') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>{{ __('Matakuliah') }}</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Jadwal') }}
        </div>
        <!-- Nav Item - Jadwal -->
        <li class="nav-item {{ Nav::isRoute('jadwal') }}">
            <a class="nav-link" href="{{ route('jadwal') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>{{ __('Jadwal') }}</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
    @endif

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Absensi') }}
    </div>
    @if (Auth::user()->role == 'dosen')
        <!-- Nav Item - buat absen -->
        <li class="nav-item {{ Nav::isRoute('absen') }}">
            <a class="nav-link" href="{{ route('absen') }}">
                <i class="fas fa-fw fa-qrcode"></i>
                <span>{{ __('Buat Absen') }}</span>
            </a>
        </li>
    @endif
    @if (Auth::user()->role == 'mahasiswa')
        <!-- Nav Item - buat absen -->
        <li class="nav-item {{ Nav::isRoute('scan') }}">
            <a class="nav-link" href="{{ route('scan') }}">
                <i class="fas fa-fw fa-qrcode"></i>
                <span>{{ __('Absen') }}</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Profile') }}</span>
        </a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
