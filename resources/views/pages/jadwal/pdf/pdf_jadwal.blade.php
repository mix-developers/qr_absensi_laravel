<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Jadwal Matakuliah </title>
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
                <td>Semester</td>
                <td style="width: 15px" class="text-center">:</td>
                <td><b>{{ $code }}</b></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th>Matakuliah</th>
                    <th>SKS</th>
                    <th>Kelas</th>
                    <th>Dosen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->day }}</td>
                        <td>{{ $item->time_start . ' - ' . $item->time_end }}</td>
                        <td>{{ $item->ruangan->name }}</td>
                        <td>{{ $item->matakuliah->name }}</td>
                        <td>{{ $item->matakuliah->sks }}</td>
                        <td>{{ $item->class->name }}</td>
                        <td>{{ $item->user->full_name }}</td>
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
