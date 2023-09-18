<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Absen {{ $jadwal->matakuliah->name }}</title>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css') }}/pdf/bootstrap.min.css" media="all" />
    <style>
        body {
            font-family: 'times new roman';
            font-size: 12px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main>
        <table class="table table-borderless" style="font-size: 14px;">
            <tr>
                <td style="width: 20%">
                    <img style="width: 100px;" src="{{ public_path('img') }}/musamus.png">
                </td>
                <td class="text-center" style="width: 80%">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN
                    RISET, DAN TEKNOLOGI<br>
                    UNIVERSITAS MUSAMUS (UNMUS)<br>
                    FAKULTAS TEKNIK<br>
                    <b>JURUSAN SISTEM INFORMASI</b><br>
                    Jl. Kamizaun Mopah Lama Merauke 99600 Telp/Fax (0971) 325923<br>
                    E-mail: si@unmus.ac.id, Website: http://unmus.ac.id
                </td>
                <td style="width: 20%"></td>
            </tr>
        </table>
        <hr style="border: 1px solid black;">
        <table class="table-borderless mb-3">
            <tr>
                <td>Matakuliah</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>{{ $jadwal->matakuliah->name }}</b></td>
            </tr>
            <tr>
                <td>Dosen Pengampuh</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>{{ $jadwal->user->name }}</b></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <thead>
                <thead style="font-size: 14px;">
                    <tr class=" align-middle text-center ">
                        <th rowspan="2">No</th>
                        <th colspan="2">Mahasiswa</th>

                        <th colspan="16">Pertemuan</th>
                    </tr>
                    <tr class=" text-center">
                        <th>NPM</th>
                        <th>Nama</th>
                        @for ($i = 1; $i <= 16; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php
                        $absen = App\Models\AbsenMahasiswa::getCountAbsen($item->id_user, $jadwal->id);
                        $count = $absen->count();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->identity }}</td>
                        <td>{{ $item->user->name }}</td>
                        @for ($i = 1; $i <= 16; $i++)
                            <td>{!! $count >= $i ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td rowspan="19"></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3 float-right text-center">
            Merauke , {{ date('d F Y') }}<br>
            Ketua Jurusan {{ App\Models\Configuration::Konfigurasi()->jurusan }}
            <div style="margin-top:80px;">
                <strong><u>{{ App\Models\Configuration::Konfigurasi()->kajur }}</u></strong><br>
                {{ App\Models\Configuration::Konfigurasi()->nip }}
            </div>
        </div>

    </main>

</body>

</html>
