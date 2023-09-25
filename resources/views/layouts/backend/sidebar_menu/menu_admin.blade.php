<ul class="pc-navbar">
    <li class="pc-item pc-caption">

        <label>{{ config('app.name') }}</label>
    </li>
    {{-- @if (Auth::user()->role == 'super_admin') --}}
    <li class="pc-item"><a href="{{ url('/home') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="layout"></i></span><span class="pc-mtext">Dashboard</span></a></li>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <li class="pc-item pc-caption">
            <label>Master Data</label>
        </li>

        {{-- kelas --}}
        <li class="pc-item"><a href="{{ route('class') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="home"></i></span><span class="pc-mtext">{{ __('Kelas') }}</span></a>
        </li>
        {{-- ruangan --}}
        <li class="pc-item"><a href="{{ route('ruangan') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="home"></i></span><span class="pc-mtext">{{ __('Ruangan') }}</span></a>
        </li>
        {{-- matakuliah --}}
        <li class="pc-item"><a href="{{ route('matakuliah') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span class="pc-mtext">{{ __('Matakuliah') }}</span></a>
        </li>
        <li class="pc-item pc-caption">
            <label>Data Jadwal</label>
        </li>
        {{-- jadwal --}}
        <li class="pc-item"><a href="{{ route('jadwal') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span class="pc-mtext">{{ __('Jadwal') }}</span></a>
        </li>
    @endif
    @if (Auth::user()->role == 'dosen' || Auth::user()->role == 'ketua_jurusan' || Auth::user()->role == 'mahasiswa')

        @if (Auth::user()->role == 'dosen')
            <li class="pc-item pc-caption">
                <label>Data Jadwal</label>
            </li>
            {{-- jadwal --}}
            <li class="pc-item"><a href="{{ route('jadwal') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Jadwal') }}</span></a>
            </li>
        @elseif(Auth::user()->role == 'ketua_jurusan')
            <li class="pc-item pc-caption">
                <label>Data Jadwal</label>
            </li>
            {{-- jadwal --}}
            <li class="pc-item"><a href="{{ route('jadwal') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Jadwal') }}</span></a>
            </li>
        @elseif(Auth::user()->role == 'mahasiswa')
            <li class="pc-item pc-caption">
                <label>Data Jadwal</label>
            </li>
            {{-- jadwal --}}
            <li class="pc-item"><a href="{{ route('jadwal') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Jadwal') }}</span></a>
            </li>
        @endif

        <li class="pc-item pc-caption">
            <label>Absensi</label>
        </li>
        @if (Auth::user()->role == 'dosen')
            {{--  pengajuan ijin --}}
            <li class="pc-item"><a href="{{ route('ijin') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Pengajuan Ijin') }}</span></a>
            </li>
            {{-- buat absen --}}
            <li class="pc-item"><a href="{{ route('absen') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Buat absen') }}</span></a>
            </li>
        @elseif(Auth::user()->role == 'ketua_jurusan')
            {{-- buat absen --}}
            <li class="pc-item"><a href="{{ route('absen') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Buat absen') }}</span></a>
            </li>
        @endif
        @if (Auth::user()->role == 'mahasiswa')
            {{--  pengajuan ijin --}}
            <li class="pc-item"><a href="{{ route('ijin') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="target"></i></span><span
                        class="pc-mtext">{{ __('Pengajuan Ijin') }}</span></a>
            </li>
            {{--  scan --}}
            <li class="pc-item"><a href="{{ route('scan') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="target"></i></span><span class="pc-mtext">{{ __('Scan Absen') }}</span></a>
            </li>
            <li class="pc-item"><a href="{{ route('history') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('HIstory Absen') }}</span></a>
            </li>
        @endif
    @endif
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <li class="pc-item pc-caption">
            <label>Pengguna</label>
        </li>
        {{-- user.mahasiswa --}}
        <li class="pc-item"><a href="{{ route('user.mahasiswa') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="users"></i></span><span class="pc-mtext">{{ __('Mahasiswa') }}</span></a>
        </li>
        {{-- user.dosen --}}
        <li class="pc-item"><a href="{{ route('user.dosen') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="users"></i></span><span class="pc-mtext">{{ __('Dosen') }}</span></a>
        </li>
    @endif
    @if (Auth::user()->role == 'ketua_jurusan' || Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <li class="pc-item pc-caption">
            <label>Laporan</label>
        </li>
        {{-- laporan mahasiswa  --}}
        <li class="pc-item"><a href="{{ route('report.mahasiswa') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span
                    class="pc-mtext">{{ __('Laporan Mahasiswa') }}</span></a>
        </li>
        {{-- laporan dosen  --}}
        <li class="pc-item"><a href="{{ route('report.dosen') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span class="pc-mtext">{{ __('Laporan dosen') }}</span></a>
        </li>
        {{-- laporan jadwal  --}}
        {{-- <li class="pc-item"><a href="{{ route('report.jadwal') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span class="pc-mtext">{{ __('Laporan jadwal') }}</span></a>
        </li> --}}
    @endif
    <li class="pc-item pc-caption">
        <label>Pengaturan</label>
    </li>
    {{-- profile --}}
    <li class="pc-item"><a href="{{ route('profile') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="book"></i></span><span class="pc-mtext">{{ __('Profile') }}</span></a>
    </li>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        {{-- konfigurasi --}}
        <li class="pc-item"><a href="{{ route('konfigurasi') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="settings"></i></span><span class="pc-mtext">{{ __('Konfigurasi') }}</span></a>
        </li>
    @endif
</ul>
