@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

    @include('layouts.component.alert')
    @include('layouts.component.alert_validate')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <form action="{{ route('ruangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h5>{{ __('Tambah Data') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group focused">
                            <label class="form-control-label" for="name">Nama Ruangan<span
                                    class="small text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Ruangan">
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
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruangan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="width: 300px;">
                                        <a href="#" data-toggle="modal" data-target="#edit-{{ $item->id }}"
                                            class="btn btn-warning"><i class="fa fa-pencil"></i> Update
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#delete-{{ $item->id }}"
                                            class="btn btn-danger"><i class="fa fa-trash"></i> Hapus
                                        </a>
                                        @include('pages.ruangan.components.modal_edit')
                                        @include('pages.ruangan.components.modal_delete')
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
