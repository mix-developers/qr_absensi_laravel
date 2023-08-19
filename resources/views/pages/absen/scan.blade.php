@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

            @include('layouts.component.alert')
            @include('layouts.component.alert_validate')
            <center>

                <div class="card">
                    <div class="card-body text-center">
                        <form action="{{ url('/scan/createAbsen') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <div id="loadingMessage">Tidak dapat mengakses kamera (Mohon untuk mengaktifkan
                                    pengaturan kamera)</div>
                                <canvas id="canvas" hidden></canvas>
                                <div id="output" hidden>
                                    <div id="outputMessage">Qr code tidak terdeteksi, harap perbaiki posisi paket</div>
                                    <div hidden><b>Data:</b> <span id="outputData"></span></div>
                                </div>
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
    <script src="https://jastiphabibi.id/js/app.js" type="text/javascript"></script>
    <script src="https://jastiphabibi.id/js/jsQR.js" type="text/javascript"></script>
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
                canvasElement.height = 120;
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
@endpush
