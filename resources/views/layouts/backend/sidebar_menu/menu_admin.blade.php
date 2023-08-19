<ul class="pc-navbar">
    <li class="pc-item pc-caption">
        <label>{{ env('APP_NAME') }}</label>
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
    @if (Auth::user()->role == 'dosen' || Auth::user()->role == 'mahasiswa')

        @if (Auth::user()->role == 'dosen')
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
            {{-- buat absen --}}
            <li class="pc-item"><a href="{{ route('absen') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Buat absen') }}</span></a>
            </li>
        @endif
        @if (Auth::user()->role == 'mahasiswa')
            {{--  scan --}}
            <li class="pc-item"><a href="{{ route('scan') }}" class="pc-link "><span class="pc-micon"><i
                            data-feather="book"></i></span><span class="pc-mtext">{{ __('Scan Absen') }}</span></a>
            </li>
        @endif
    @endif
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <li class="pc-item pc-caption">
            <label>Pengguna</label>
        </li>
        {{-- user.mahasiswa --}}
        <li class="pc-item"><a href="{{ route('user.mahasiswa') }}" class="pc-link "><span class="pc-micon"><i
                        data-feather="book"></i></span><span class="pc-mtext">{{ __('Mahasiswa') }}</span></a>
        </li>
    @endif
    <li class="pc-item pc-caption">
        <label>Pengaturan</label>
    </li>
    {{-- profile --}}
    <li class="pc-item"><a href="{{ route('profile') }}" class="pc-link "><span class="pc-micon"><i
                    data-feather="book"></i></span><span class="pc-mtext">{{ __('Profile') }}</span></a>
    </li>
</ul>