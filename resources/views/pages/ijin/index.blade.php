@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            @if (Auth::user()->role == 'mahasiswa')
                <div class="my-3">
                    <a href="#" data-toggle="modal" data-target="#create" class="btn btn-primary"><i
                            class="fa fa-plus"></i>
                        Ajukan Ijin
                    </a>
                </div>
            @endif
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
                                    <th>Bukti</th>
                                    <th>Oleh</th>
                                    <th>Matakuliah</th>
                                    <th>Jenis Ijin</th>
                                    <th>Status Pengajuan</th>
                                    @if (Auth::user()->role != 'mahasiswa')
                                        <th>Konfirmasi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absen_ijin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#foto-{{ $item->id }}">
                                                <img src="{{ Storage::url($item->foto) }}" style="height: 100px;">
                                            </a>
                                        </td>
                                        <td>
                                            <strong>{{ $item->user->name }}</strong>
                                            <br>{{ $item->tanggal }}
                                        </td>
                                        <td>
                                            <strong>{{ $item->jadwal->matakuliah->name }}</strong><br>
                                            <small>Kelas :
                                                {{ $item->jadwal->class->name }}</small>
                                        </td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>
                                            @if ($item->konfirmasi == 0)
                                                <span class="badge badge-light-warning">Proses Pengajuan</span>
                                            @elseif($item->konfirmasi == 1)
                                                <span class="badge badge-light-success">Disetujui</span>
                                            @elseif($item->konfirmasi == 2)
                                                <span class="badge badge-light-danger">Pengajuan ditolak</span>
                                            @endif
                                        </td>
                                        @if (Auth::user()->role != 'mahasiswa')
                                            <td>
                                                @if ($item->konfirmasi == 0)
                                                    <div class="form-inline">
                                                        <form action="{{ route('ijin.terima', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success mx-2">Terima</button>
                                                        </form>
                                                        <form action="{{ route('ijin.tolak', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger mx-2">Tolak</button>
                                                        </form>
                                                    </div>
                                                @elseif($item->konfirmasi == 1)
                                                    <span class="text-primary">Telah dikonfirmasi </span><br>
                                                    <form action="{{ route('ijin.tolak', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger ">batalkan
                                                            dan tolak?</button>
                                                    </form>
                                                @elseif($item->konfirmasi == 2)
                                                    <span class="text-danger">Telah ditolak </span><br>
                                                    <form action="{{ route('ijin.terima', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success ">batalkan
                                                            dan terima?</button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    @include('pages.ijin.components.modal_foto')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.ijin.components.modal_create')
@endsection
