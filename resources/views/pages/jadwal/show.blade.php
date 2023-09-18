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
                    <h5>{{ $title }} Matakuliah : {{ $jadwal->matakuliah->name }}</h5>
                </div>

                <div class="card-body">
                    <div class="my-3 text-right">
                        <a href="{{ url('/jadwal/exportAbsen', $jadwal->id) }}" class="btn btn-primary" target="__blank"><i
                                class="fa fa-print"></i>
                            Cetak</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class=" align-middle text-center ">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">NPM</th>
                                    <th colspan="16">Pertemuan</th>
                                </tr>
                                <tr class=" text-center">
                                    @for ($i = 1; $i <= 16; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwal_mahasiswa as $item)
                                    @php
                                        $absen = App\Models\AbsenMahasiswa::getCountAbsen($item->id_user, $jadwal->id);
                                        $count = $absen->count();
                                        
                                        if ($absen != null && $count > 0) {
                                            $materi = App\Models\AbsenMateri::getMateriAbsen($absen->first()->id_absen);
                                        } else {
                                            $materi = null;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->identity }}</td>
                                        @for ($i = 1; $i <= 16; $i++)
                                            <td>{!! $count >= $i
                                                ? '<i class="fa fa-sm fa-check text-success"></i><br><a href="#" data-toggle="modal" data-target="#materi-' .
                                                    $i .
                                                    '"><i class="fa fa-comments fa-xs"></i></a>'
                                                : '-' !!}</td>
                                            @if ($absen != null)
                                                @include('pages.jadwal.components.modal_materi')
                                            @endif
                                        @endfor
                                    </tr>
                                @empty
                                    <tr>
                                        <td rowspan="19"></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
