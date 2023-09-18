<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Dosen </title>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css') }}/pdf/bootstrap.min.css" media="all" />
    <style>
        body {
            font-family: 'times new roman';

        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"> --}}
</head>

<body>
    <main>
        <table class="table table-borderless">
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

        <table class="table table-bordered mb-0 lara-dataTable">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Nama Dosen</th>
                    <th>Jabatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
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
                        <td><strong>{{ $item->name . ' ' . $item->last_name }}</strong><br><small>{{ $item->identity }}</small>
                        </td>
                        <td>{!! $item->role == 'dosen'
                            ? '<span class="badge badge-light-primary">Dosen</span>'
                            : '<span class="badge badge-light-warning">Ketua Jurusan</span>' !!}</td>

                    </tr>
                @endforeach
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
