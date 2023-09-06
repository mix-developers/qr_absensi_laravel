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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jadwal->day }}</td>
                                        <td>{{ $item->jadwal->time_start . ' - ' . $item->jadwal->time_end }}</td>
                                        <td>{{ $item->jadwal->ruangan->name }}</td>
                                        <td>{{ $item->jadwal->matakuliah->name }}</td>
                                        <td>{{ $item->jadwal->matakuliah->sks }}</td>
                                        <td>{{ $item->jadwal->class->name }}</td>
                                        <td>{{ $item->jadwal->user->full_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.jadwal.components.modal_create')
@endsection
