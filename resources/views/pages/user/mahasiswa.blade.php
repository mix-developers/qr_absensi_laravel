@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

    @include('layouts.component.alert')
    @include('layouts.component.alert_validate')

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>{{ $title }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-bordered ">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Mahasiswa</th>
                            <th>Angkatan</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            @php
                                $month = date('n');
                                $year = date('Y');
                                $angkatan = $item->angkatan;
                                
                                if ($month <= 8) {
                                    $semester = ($year - $angkatan) * 2;
                                } else {
                                    $semester = ($year - $angkatan) * 2 + 1;
                                }
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->name }}</strong><br><small>{{ $item->identity }}</small></td>
                                <td>{{ $angkatan }}</td>
                                <td>{{ $semester }}</td>
                                <td>
                                    <a href="{{ url('/jadwal/input_mahasiswa', $item->id) }}" class="btn btn-info"><i
                                            class="fa fa-book"></i> Jadwal</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
