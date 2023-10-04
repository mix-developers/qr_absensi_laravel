@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>{{ $title }} Matakuliah : {{ $jadwal->matakuliah->name }}</h5>
                </div>

                <div class="card-body">
                    <div class="my-3 text-right">
                        <a href="{{ url('/jadwal/exportAbsen', $jadwal->id) }}" class="btn btn-primary" target="__blank"><i
                                class="fa fa-print"></i>
                            Cetak</a>
                    </div>
                    <div class="table-responsive">
                        @php
                            //master absen
                            $absen_exist = App\Models\Absen::where('id_jadwal', $jadwal->id);
                            $total_absen = $absen_exist->count();
                            
                        @endphp
                        <table class="table table-bordered">
                            <thead>
                                <tr class=" align-middle text-center ">
                                    <th rowspan="2">No</th>
                                    <th colspan="2">Mahasiswa</th>
                                    <th colspan="16">Pertemuan</th>
                                </tr>
                                <tr class=" text-center">
                                    <th>NPM</th>
                                    <th>Nama</th>
                                    @foreach ($absen_exist->get() as $list)
                                        <th>{{ $loop->iteration }}<br>
                                            <a href="#" data-toggle="modal"
                                                data-target="#materi-{{ $list->id }}                                                                                                                                                                                                                                                                                                                                  "><i
                                                    class="fa fa-comments fa-xs"></i>
                                            </a>
                                            @include('pages.jadwal.components.modal_materi')
                                        </th>
                                    @endforeach
                                    @for ($i = $total_absen + 1; $i <= 16; $i++)
                                        <th>{{ $i }}<br>
                                            <a href="#"><i class="fa fa-comments fa-xs text-muted"></i>
                                            </a>
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($jadwal_mahasiswa as $item)
                                    @php
                                        //absen mahasiswa
                                        $absen = App\Models\AbsenMahasiswa::getCountAbsen($item->id_user, $jadwal->id);
                                        
                                        //check pada konfirmasi absen
                                        $count = $absen
                                            ->whereIn('id_absen', function ($query) {
                                                $query->select('id_absen')->from('absen_confirms');
                                            })
                                            ->count();
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->identity }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        @foreach ($absen_exist->get() as $list)
                                            @php
                                                $exist_user = App\Models\AbsenMahasiswa::checkAbsen($list->id, $item->id_user)->count();
                                            @endphp
                                            <td>
                                                @if ($exist_user > 0)
                                                    <i class="fa fa-sm fa-check text-success"></i><br>
                                                @else
                                                    <span class="text-danger">&times;</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        @for ($i = 1; $i <= 16 - $total_absen; $i++)
                                            <td>
                                                -
                                            </td>
                                        @endfor
                                    </tr>
                                @empty
                                    <tr>
                                        <td rowspan="19"></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-2">
                    <h5 class="my-3">Data Ijin Mahasiswa</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Tanggal Ijin</th>
                                <th>Jenis Ijin</th>
                                <th>Keterangan</th>
                            </thead>
                            <tbody>
                                @foreach ($ijin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->full_name }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ $item->keterangan }}</td>
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
@push('js')
    @if ($absen_confirm == null && $absen_mahasiswa->first() && $absen_mahasiswa->first()->created_at)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var createdAt = new Date(
                    '{{ \Carbon\Carbon::parse($absen_mahasiswa->first()->created_at)->format('Y-m-d\TH:i:s') }}');
                var now = new Date();
                var timeDiff = Math.abs(now - createdAt) / 60000; // Dalam menit

                if (timeDiff > 30) {
                    var formData = new FormData();
                    formData.append('id_absen', '{{ $absen->id }}');

                    fetch('{{ route('absen.storeConfirm') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Tindakan setelah mendapatkan respons dari server
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        </script>
    @endif
@endpush
