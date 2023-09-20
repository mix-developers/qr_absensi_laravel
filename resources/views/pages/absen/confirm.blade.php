@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- Page Heading -->
            @include('layouts.backend.title')
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            @if ($absen_confirm != null)
                <div class="alert alert-primary border-left-primary alert-dismissible fade show" role="alert">
                    Absen Telah dikonfirmasi
                </div>
            @endif
            @if ($absen_mahasiswa->count() == 0)
                <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                    Mahasiswa belum melakukan absen
                </div>
            @endif
            <div class="row">

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
                                            <td>#</td>
                                            <td>Bukti Foto</td>
                                            <td>Mahasiswa</td>
                                            <td>Waktu</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($absen_mahasiswa && $absen_mahasiswa->count() > 0)
                                            @forelse($absen_mahasiswa as $list)
                                                @php
                                                    $foto = App\Models\AbsenFoto::getFoto($list->id_absen, $list->id_user);
                                                    
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ $foto != null || $foto != '' ? $foto : '' }}"
                                                            style="height: 100px;"></td>
                                                    <td><strong>{{ $list->user->name }}</strong><br>
                                                        <small>{{ $list->user->identity }}</small>
                                                    </td>
                                                    <td>{{ $list->created_at }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2">Belum ada yang absen</td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="2">Belum ada yang absen</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="my-2">
                                @if ($absen_mahasiswa->count() > 0)
                                    @if ($absen_confirm == null)
                                        <form action="{{ route('absen.storeConfirm') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_absen" value="{{ $absen->id }}">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check "></i>
                                                Konfirmasi
                                                Kehadiran</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
