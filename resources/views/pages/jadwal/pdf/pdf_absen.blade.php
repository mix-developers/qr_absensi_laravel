<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Absen</title>
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
        <table class="table table-bordered">
            <thead>
                <thead>
                    <tr class=" align-middle text-center bg-light">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">NPM</th>
                        <th colspan="16">Pertemuan</th>
                    </tr>
                    <tr class="bg-light text-center">
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                    </tr>
                </thead>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php
                        $count = App\Models\AbsenMahasiswa::getCountAbsen($item->id_user);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->identity }}</td>
                        <td>{!! $count >= 1 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 2 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 3 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 4 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 5 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 6 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 7 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 8 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 9 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 10 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 11 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 12 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 13 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 14 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 15 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                        <td>{!! $count >= 16 ? '<span style="font-family: DejaVu Sans, sans-serif; font-size:16px;">✔</span>' : '-' !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td rowspan="19"></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </main>

</body>

</html>
