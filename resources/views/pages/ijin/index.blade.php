@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            @if (Auth::user()->role == 'mahasiswa')
                <div class="my-3">
                    <a href="#" data-toggle="modal" data-target="#create" class="btn btn-primary"><i
                            class="fa fa-plus"></i>
                        Ajukan Ijin
                    </a>
                </div>
            @endif
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
                                    <th>Bukti</th>
                                    <th>Tanggal Ijin</th>
                                    <th>Matakuliah</th>
                                    <th>Jenis Ijin</th>
                                    <th>Status Pengajuan</th>
                                    @if (Auth::user()->role != 'mahasiswa')
                                        <th>Konfirmasi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absen_ijin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ Storage::url($item->foto) }}" style="height: 100px;"></td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>
                                            <strong>{{ $item->jadwal->matakuliah->name }}</strong><br>
                                            <small>Kelas :
                                                {{ $item->jadwal->class->name }}</small>
                                        </td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>
                                            @if ($item->konfirmasi == 0)
                                                <span class="badge badge-light-warning">Proses Pengajuan</span>
                                            @elseif($item->konfirmasi == 1)
                                                <span class="badge badge-light-success">Disetujui</span>
                                            @elseif($item->konfirmasi == 2)
                                                <span class="badge badge-light-danger">Pengajuan ditolak</span>
                                            @endif
                                        </td>
                                        @if (Auth::user()->role != 'mahasiswa')
                                            <td>
                                                @if ($item->konfirmasi == 0)
                                                    <div class="form-inline">
                                                        <form action="{{ route('ijin.terima', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success mx-2">Terima</button>
                                                        </form>
                                                        <form action="{{ route('ijin.tolak', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger mx-2">Tolak</button>
                                                        </form>
                                                    </div>
                                                @elseif($item->konfirmasi == 1)
                                                    <span class="text-primary">Telah dikonfirmasi </span><br>
                                                    <form action="{{ route('ijin.tolak', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger ">batalkan
                                                            dan tolak?</button>
                                                    </form>
                                                @elseif($item->konfirmasi == 2)
                                                    <span class="text-danger">Telah ditolak </span><br>
                                                    <form action="{{ route('ijin.terima', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success ">batalkan
                                                            dan terima?</button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.ijin.components.modal_create')
@endsection
@push('js')
    <script src="{{ asset('/') }}js/app-qr.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}js/jsQR.js" type="text/javascript"></script>
    <script>
        function refreshPage() {
            window.location.reload();
        }

        var video = document.createElement("video");
        var canvasElement = document.getElementById("canvas");
        var canvas = canvasElement.getContext("2d");
        var loadingMessage = document.getElementById("loadingMessage");
        var outputContainer = document.getElementById("output");
        var outputMessage = document.getElementById("outputMessage");
        var outputData = document.getElementById("outputData");
        var absen = document.getElementById("absen");
        var outputDatas = document.getElementById("outputDatas");

        function drawLine(begin, end, color) {
            canvas.beginPath();
            canvas.moveTo(begin.x, begin.y);
            canvas.lineTo(end.x, end.y);
            canvas.lineWidth = 4;
            canvas.strokeStyle = color;
            canvas.stroke();
        }

        // Use facingMode: environment to attemt to get the front camera on phones
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "environment"
            }
        }).then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });

        function tick() {
            loadingMessage.innerText = "Loading camera..."
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                loadingMessage.hidden = true;
                canvasElement.hidden = false;
                outputContainer.hidden = false;

                // canvasElement.height = video.videoHeight;
                // canvasElement.width = video.videoWidth;
                canvasElement.height = 200;
                canvasElement.width = 240;
                canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code) {
                    drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                    drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                    drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                    drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                    outputMessage.hidden = true;
                    outputData.parentElement.hidden = true;
                    outputData.innerText = code.data;
                    outputDatas.value = code.data;
                    absen.disabled = false;
                } else {
                    outputMessage.hidden = false;
                    outputData.parentElement.hidden = true;
                }
            }
            requestAnimationFrame(tick);
        }
    </script>
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
