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
                            <form id="confirmForm" action="{{ route('absen.storeConfirm') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered  mb-0 lara-dataTable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 10px;">
                                                    <input type="checkbox" id="checkAll">
                                                </th>
                                                <th>#</th>
                                                <th>Bukti Foto</th>
                                                <th>Mahasiswa</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($absen_mahasiswa && $absen_mahasiswa->count() > 0)
                                                @forelse($absen_mahasiswa->get() as $list)
                                                    @php
                                                        $foto = App\Models\AbsenFoto::getFoto($list->id_absen, $list->id_user);
                                                    @endphp
                                                    <tr class="@if ($absen_confirm != null && App\Models\AbsenConfirm::checkAbsen($list->id_absen, $list->id_user) == null) bg-light-danger @endif">
                                                        <td>
                                                            <input type="checkbox" name="konfirmasi[]"
                                                                value="{{ $list->id_absen }}" />
                                                            <input type="hidden" name="id_user[]"
                                                                value="{{ $list->id_user }}">
                                                        </td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#foto-{{ $list->id }}">
                                                                <img src="{{ $foto != null || $foto != '' ? $foto : '' }}"
                                                                    style="height: 100px;">
                                                            </a>
                                                            @include('pages.absen.components.modal_foto')
                                                        </td>
                                                        <td><strong>{{ $list->user->name }}</strong><br>
                                                            <small>{{ $list->user->identity }}</small>
                                                        </td>
                                                        <td>{{ $list->created_at }}</td>
                                                    </tr>
                                                    @php
                                                        $id_jadwal = $list->id_jadwal;
                                                        $id_user = $list->id_user;
                                                        $id_absen = $list->id_absen;
                                                    @endphp
                                                @empty
                                                    <tr>
                                                        <td colspan="5">Belum ada yang absen</td>
                                                    </tr>
                                                @endforelse
                                            @else
                                                <tr>
                                                    <td colspan="5">Belum ada yang absen</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="my-2">
                                    @if ($absen_confirm == null && $absen_mahasiswa->count() != 0)
                                        <button type="submit" class="btn btn-primary" id="konfirmasiButton" disabled>
                                            <i class="fa fa-check"></i>
                                            Konfirmasi Kehadiran
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('pages.absen.components.script')
