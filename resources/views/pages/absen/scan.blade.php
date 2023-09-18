@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <center>
                <div class="card">
                    <div class="card-body text-center">
                        <form action="{{ url('scan/createAbsen') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <div class="my-3">
                                {{-- {{ file_get_contents('https://ipinfo.io/ip') }} --}}
                            </div>
                            <div id="coordinates" class="mb-3" style="display: block;"></div>
                            <div class="form-group">
                                <div id="loadingMessage">Tidak dapat mengakses kamera (Mohon untuk mengaktifkan
                                    pengaturan kamera)</div>
                                <canvas id="canvas" hidden></canvas>
                                <div id="output" hidden>
                                    <div id="outputMessage">Qr code tidak terdeteksi, harap perbaiki posisi kamera</div>
                                    <div hidden><b>Data:</b> <span id="outputData"></span></div>
                                </div>
                            </div>
                            <div class="form-group my-2 container">
                                <label>Bukti Foto<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="foto" accept="image/*" capture="camera"
                                    required>
                            </div>
                            <div class="form-group text-center">
                                {{-- <label>Code Absen <span class="text-danger">*</span></label> --}}
                                <input type="hidden" name="code" class="form-control" placeholder="Nomor Resi"
                                    id="outputDatas" required>

                                <button type="button" class="btn btn-secondary btn-lg mt-2" onClick="refreshPage()">
                                    <i class="flaticon2-refresh"></i> Refresh
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg mt-2" disabled id="absen">
                                    <i class="flaticon2-search"></i>Absen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
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
