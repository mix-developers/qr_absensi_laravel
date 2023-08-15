@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

    @include('layouts.component.alert')
    @include('layouts.component.alert_validate')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <form action="{{ route('jadwal.storeInput') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h5>{{ __('Tambah Jadwal') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" name="id_user" value="{{ $user->id }}">
                            <label for="day">Pilih Jadwal</label>
                            <select class="form-control" name="id_jadwal">
                                <option selected value="">--Pilih Jadwal--</option>
                                @foreach (App\Models\Jadwal::all() as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->class->name . ' | ' . $item->matakuliah->name . ' (' . $item->time_start . '-' . $item->time_end . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-hover table-bordered ">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Jadwal</th>
                                <th>Ruangan</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal_mahasiswa as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->jadwal->matakuliah->name }}</strong><br>
                                        <small
                                            class="text-danger">{{ $item->jadwal->time_start . ' - ' . $item->jadwal->time_end }}</small>
                                    </td>
                                    <td>
                                        {{ $item->jadwal->ruangan->name }}
                                    </td>
                                    <td>
                                        {{ $item->jadwal->class->name }}
                                    </td>
                                    <td style="width: 100px;">
                                        <a href="#" data-toggle="modal"
                                            data-target="#delete-input-{{ $item->id }}" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> Hapus
                                        </a>
                                        @include('pages.jadwal.components.modal_delete')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
