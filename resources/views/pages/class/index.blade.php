@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <form action="{{ route('class.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h5>{{ __('Tambah Data') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">Nama Kelas<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Kelas">
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Kelas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($class as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td style="width: 300px;">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#edit-{{ $item->id }}"
                                                        class="btn btn-light-warning"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#delete-{{ $item->id }}"
                                                        class="btn btn-light-danger"><i class="fa fa-trash"></i>
                                                    </a>
                                                    @include('pages.class.components.modal_edit')
                                                    @include('pages.class.components.modal_delete')
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
        </div>
    </div>
@endsection
