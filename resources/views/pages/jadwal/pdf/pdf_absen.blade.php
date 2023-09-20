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
            font-size: 16px;
        }

        table.table_custom th,
        table.table_custom td {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid;
            padding: 5px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main class="mt-0">
        <table class="" style="font-size: 18px; padding:5px; width:100%; border:0px;">
            <tr>
                <td style="width: 20%">
                    <img style="width: 130px;" src="{{ public_path('img') }}/musamus.png">
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
                <td><b>{{ $jadwal->matakuliah->name }}</b> (Kelas {{ $jadwal->class->name }})</td>
            </tr>
            <tr>
                <td>Dosen Pengampuh</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>{{ $jadwal->user->name }}</b></td>
            </tr>
        </table>
        @php
            //master absen
            $absen_exist = App\Models\Absen::where('id_jadwal', $jadwal->id);
            $total_absen = $absen_exist->count();
            
        @endphp
        <table class="table_custom" style="width: 100%;">
            <thead>
                <tr class=" align-middle text-center ">
                    <th rowspan="2">No</th>
                    <th colspan="2">Mahasiswa</th>
                    <th colspan="16">Pertemuan</th>
                </tr>
                <tr class=" text-center">
                    <th>NPM</th>
                    <th>Nama</th>
                    @for ($i = 1; $i <= 16; $i++)
                        <th>{{ $i }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>

                @forelse($data as $item)
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
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->user->identity }}</td>
                        <td>{{ $item->user->name }}</td>
                        @foreach ($absen_exist->get() as $list)
                            @php
                                $exist_user = App\Models\AbsenMahasiswa::checkAbsen($list->id, $item->id_user)->count();
                            @endphp
                            <td class="text-center">
                                @if ($exist_user > 0)
                                    <span style="font-family: DejaVu Sans, sans-serif; font-size:16px;"
                                        class="text-success">✔</span>
                                @else
                                    <span class="text-danger" style="font-size: 20px;">&times;</span>
                                @endif
                            </td>
                        @endforeach
                        @for ($i = 1; $i <= 16 - $total_absen; $i++)
                            <td class="text-center">
                                <span style="font-size: 20px;">-</span>
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
