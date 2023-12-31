@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>{{ $title }}</h5>

                </div>
                <div class="card-body">
                    <div class="my-3 text-right">
                        <a href="{{ url('/jadwal/exportJadwal', $user->id) }}" class="btn btn-primary" target="__blank"><i
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->day }}</td>
                                        <td>{{ $item->time_start . ' - ' . $item->time_end }}</td>
                                        <td>{{ $item->ruangan->name }}</td>
                                        <td>{{ $item->matakuliah->name }}</td>
                                        <td>{{ $item->matakuliah->sks }}</td>
                                        <td>{{ $item->class->name }}</td>
                                        <td>{{ $item->user->full_name }}</td>
                                        <td style="width: 300px;">
                                            <a href="{{ url('/jadwal/showAdmin', Crypt::encryptString($item->id)) }}"
                                                class="btn btn-info"><i class="fa fa-book"></i> Absen
                                            </a>
                                            {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                                                <a href="{{ url('/jadwal/showAdmin', Crypt::encryptString($item->id)) }}"
                                                    class="btn btn-info"><i class="fa fa-book"></i> Absen
                                                </a>
                                                <a href="#" data-toggle="modal"
                                                    data-target="#edit-{{ $item->id }}" class="btn btn-warning"><i
                                                        class="fa fa-pencil"></i> Update
                                                </a>
                                                <a href="#" data-toggle="modal"
                                                    data-target="#delete-{{ $item->id }}" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i> Hapus
                                                </a>
                                                @include('pages.jadwal.components.modal_edit')
                                                @include('pages.jadwal.components.modal_delete')
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
