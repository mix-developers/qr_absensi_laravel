@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <div class="my-3">

                <a href="{{ route('report.exportMahasiswa') }}" target="__blank" class="btn btn-primary"><i
                        class="fa fa-download"></i>
                    Export
                </a>
            </div>
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
                                    <th>Nama Mahasiswa</th>
                                    <th>Angkatan</th>
                                    <th>Semester</th>
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
                                        <td><strong>{{ $item->name }}</strong><br><small>{{ $item->identity }}</small>
                                        </td>
                                        <td>{{ $angkatan }}</td>
                                        <td>{{ $semester }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
