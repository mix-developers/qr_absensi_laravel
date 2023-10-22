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
                    <div class="alert alert-primary" role="alert">
                        Waktu secara default menggunakan : <b>Waktu Indonesia Timur (WIT) Asia/Jayapura</b>
                    </div>
                </div>
                {{-- <div class="col-12 text-center">
                    <div id="coordinates"></div>
                </div> --}}
                {{-- {{ Crypt::encryptString('firman') }} --}}
                {{-- {{ date('Y-m-d H:i') }} --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <form id="coordinateForm" action="{{ route('absen.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h5>{{ __('Buat Absen') }}</h5>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                                <div id="map" style="height: 400px;" class="my-4"></div>
                                <div id="coordinates" class="mb-3"></div>
                                <div class="form-group">
                                    <label for="day">Pilih Jadwal</label>
                                    <select class="form-control" name="id_jadwal">
                                        <option selected value="">--Pilih Jadwal--</option>
                                        @php
                                            $semester = App\Models\Semester::latest()->first()->code;
                                        @endphp
                                        @foreach (App\Models\Jadwal::where('id_user', Auth::user()->id)->where('code', $semester)->get() as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->matakuliah->name . ' (' . $item->time_start . '-' . $item->time_end . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Waktu Kadaluarsa</label>
                                    <input type="datetime-local" class="form-control" name="expired_date">
                                </div>
                                <div class="form-group">
                                    <label>Materi Kuliah</label>
                                    <textarea class="form-control" name="materi" required></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>{{ $title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered  mb-0 lara-dataTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Matakuliah</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($absen as $item)
                                            <tr
                                                class="{{ $item->expired_date <= date('Y-m-d H:i') ? 'bg-light-danger' : '' }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $item->jadwal->matakuliah->name }}</strong><br>
                                                    <small
                                                        class="text-danger">{{ $item->jadwal->time_start . ' - ' . $item->jadwal->time_end }}</small>
                                                    <br>
                                                    <hr>
                                                    <small>Kadaluarsa :
                                                        <span class="text-danger">{{ $item->expired_date }}</span></small>
                                                </td>
                                                <td>
                                                    <strong class="text-primary">{{ $item->user->full_name }}</strong><br>
                                                    Materi Kuliah :<br>
                                                    <small
                                                        class="text-muted">{{ App\Models\AbsenMateri::getMateriAbsen($item->id) }}</small>
                                                </td>
                                                <td style="width: 200px;">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#qr-{{ $item->id }}" class="btn btn-primary "><i
                                                            class="fa fa-xs fa-qrcode"> </i>
                                                    </a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#show-{{ $item->id }}" class="btn btn-info "><i
                                                            class="fa fa-xs fa-book"></i>
                                                    </a>
                                                    @php
                                                        $absenConfirm = App\Models\AbsenConfirm::where('id_absen', $item->id)->count();
                                                    @endphp

                                                    <form method="GET" action="{{ route('absen.confirm', $item->id) }}"
                                                        style="display: inline;">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fa fa-xs fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#delete-{{ $item->id }}"
                                                        class="btn btn-danger "><i class="fa fa-xs fa-trash"></i>
                                                    </a>
                                                    @include('pages.absen.components.modal_show')
                                                    @include('pages.absen.components.modal_edit')
                                                    @include('pages.absen.components.modal_qr')
                                                    @include('pages.absen.components.modal_delete')
                                                </td>
                                            </tr>
                                        @endforeach
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
@push('js')
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            getLocation();
        });

        // Tambahkan fungsi untuk menangani submit form
        // document.getElementById("coordinateForm").addEventListener("submit", function() {
        //     getLocation();
        // });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude.toFixed(3);
            var longitude = position.coords.longitude.toFixed(3);

            // Tampilkan koordinat
            var coordinatesElement = document.getElementById("coordinates");
            coordinatesElement.innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;

            // Isi nilai input dengan koordinat
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            initMap(latitude, longitude);
        }

        function initMap(latitude, longitude) {
            var map = L.map('map').setView([latitude, longitude], 20);

            L.tileLayer('https://mt0.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 19,
            }).addTo(map);
            // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     maxZoom: 19,
            // }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Lokasi Anda')
                .openPopup();

            var circle = L.circle([latitude, longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 15
            }).addTo(map);
        }


        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }
    </script>
@endpush
