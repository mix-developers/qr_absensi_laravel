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
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>{{ $title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form action="{{ route('read_all', Auth::user()->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success"
                                        {{ App\Models\Notifikasi::where('id_user', Auth::user()->id)->where('read_at', null)->count() == 0? 'disabled': '' }}>
                                        <i class="fa fa-check"></i>
                                        <span>Tandai telah dibaca</span>
                                    </button>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead>
                                        <th>Notifikasi</th>
                                    </thead>
                                    <tbody>
                                        @forelse ($notifikasi as $item)
                                            <tr>
                                                <td>
                                                    <form action="{{ route('read_notif', $item->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="dropdown-item">
                                                            <i data-feather="info"
                                                                class="{{ $item->type == 'danger' ? 'text-danger' : 'text-success' }}"></i>
                                                            <span>{{ $item->content }}</span>
                                                            <br><small
                                                                class="text-muted ml-4">{{ $item->created_at->diffForHumans() }}
                                                                @if ($item->read_at != null)
                                                                    | <span class="text-success">Dibaca <i
                                                                            class="fa fa-check "></i></span>
                                                                @endif
                                                            </small>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Belum ada notifikasi...</td>
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
