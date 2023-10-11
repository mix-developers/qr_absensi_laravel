@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                <div class="my-3">
                    <a href="#" data-toggle="modal" data-target="#create" class="btn btn-primary"><i
                            class="fa fa-plus"></i>
                        Tambah Jadwal
                    </a>
                </div>
            @endif
            @php
                $user = Auth::user()->role;
            @endphp
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <div class="my-3 text-right">
                        <a href="{{ url('/jadwal/exportJadwalAll') }}" class="btn btn-primary" target="__blank"><i
                                class="fa fa-print"></i>
                            Cetak Jadwal</a>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped mb-0 lara-dataTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Ruangan</th>
                                    <th>Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Kelas</th>
                                    <th>Dosen</th>
                                    <th>Pertemuan</th>
                                    @if ($user != 'mahasiswa')
                                        <th>Aksi</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->day : $item->day }}</td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->time_start : $item->time_start }} -
                                            {{ $user == 'mahasiswa' ? $item->jadwal->time_end : $item->time_end }} WIT
                                        </td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->ruangan->name : $item->ruangan->name }}
                                        </td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->matakuliah->name : $item->matakuliah->name }}
                                        </td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->matakuliah->sks : $item->matakuliah->sks }}
                                        </td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->class->name : $item->class->name }}
                                        </td>
                                        <td>{{ $user == 'mahasiswa' ? $item->jadwal->user->full_name : $item->user->full_name }}
                                        </td>
                                        <td>
                                            {!! App\Models\Absen::getPertemuan($user == 'mahasiswa' ? $item->jadwal->id : $item->id) !!}
                                        </td>
                                        @if ($user != 'mahasiswa')
                                            <td style="width: 300px;">
                                                @if (Auth::user()->role == 'dosen' || Auth::user()->role == 'ketua_jurusan')
                                                    {{-- <a href="{{ Auth::user()->role == 'dosen' ? url('/jadwal/show', Crypt::encryptString($item->id)) : url('jadwal/show', Crypt::encryptString($item->id)) }}"
                                                        class="btn btn-info"><i class="fa fa-book"></i> Absen
                                                    </a> --}}
                                                    <form action="{{ url('/jadwal/show', $item->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('GET')
                                                        <button type="submit" class="btn btn-info">
                                                            <i class="fa fa-book"></i> Absen
                                                        </button>
                                                    </form>
                                                @elseif (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                                                    {{-- <a href="{{ url('/jadwal/showAdmin', Crypt::encryptString($item->id)) }}"
                                                        class="btn btn-info"><i class="fa fa-book"></i> Absen
                                                    </a> --}}
                                                    <form action="{{ url('/jadwal/show', $item->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('GET')
                                                        <button type="submit" class="btn btn-info">
                                                            <i class="fa fa-book"></i> Absen
                                                        </button>
                                                    </form>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#edit-{{ $item->id }}"
                                                        class="btn btn-light-warning"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#delete-{{ $item->id }}"
                                                        class="btn btn-light-danger"><i class="fa fa-trash"></i>
                                                    </a>
                                                    @include('pages.jadwal.components.modal_edit')
                                                    @include('pages.jadwal.components.modal_delete')
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        @include('pages.jadwal.components.modal_create')
    @endif
@endsection
