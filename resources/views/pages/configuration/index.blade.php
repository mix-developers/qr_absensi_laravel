@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            {{ $title }}
                        </div>
                        <form action="{{ route('konfigurasi.update', 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control" placeholder="Jurusan"
                                        value="{{ $configuration->jurusan }}">
                                </div>
                                <div class="form-group">
                                    <label>Kepala Jurusan</label>
                                    <input type="text" name="kajur" class="form-control" placeholder="Kepala Jurusan"
                                        value="{{ $configuration->kajur }}">
                                </div>
                                <div class="form-group">
                                    <label>NIP/NIDN</label>
                                    <input type="text" name="nip" class="form-control" placeholder="NIP/NIDN"
                                        value="{{ $configuration->nip }}">
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
