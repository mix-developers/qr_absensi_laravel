@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- Page Heading -->
            @include('layouts.backend.title')
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-primary" role="alert">
                        Waktu secara default menggunakan : <b>Waktu Indonesia Timur (WIT) Asia/Jayapura</b>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>{{ $title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Matakuliah</th>
                                            <th>Waktu Absen</th>
                                            <th>Status Absen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($history as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->jadwal->matakuliah->name }}</td>
                                                <td>{{ $item->created_at->diffForHumans() }}<br>
                                                    <small>{{ $item->created_at }}</small>
                                                </td>
                                                <td>
                                                    @php
                                                        $terkonfirmasi = App\Models\AbsenConfirm::where('id_user', Auth::user()->id)->where('id_absen', $item->id_absen);

                                                    @endphp
                                                    {!! $terkonfirmasi != null
                                                        ? '<span class="badge badge-light-success">Terkonfirmasi</span>'
                                                        : '<span class="badge badge-light-warning">Menunggu Konfirmasi</span>' !!}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Belum ada absen...</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
