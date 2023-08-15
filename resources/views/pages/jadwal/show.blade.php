@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

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
            <table class="table table-bordered">
                <thead>
                    <tr class=" align-middle text-center">
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
                <tbody>
                    @forelse($jadwal_mahasiswa as $item)
                        @php
                            $count = App\Models\AbsenMahasiswa::getCountAbsen($item->id_user, $jadwal->id);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->identity }}</td>
                            <td>{!! $count >= 1 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 2 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 3 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 4 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 5 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 6 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 7 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 8 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 9 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 10 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 11 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 12 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 13 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 14 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 15 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                            <td>{!! $count >= 16 ? '<i class="fa fa-check text-success"></i>' : '-' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td rowspan="19"></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
