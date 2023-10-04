<?php

namespace App\Http\Middleware;

use Closure;

class AutoAbsenConfirmation
{
    public function handle($request, Closure $next)
    {
        // Tambahkan skrip JavaScript di sini

        echo <<<SCRIPT
                document.addEventListener('DOMContentLoaded', function() {
                    var createdAt = new Date(
                        '{\{ \Carbon\Carbon::parse($absen_mahasiswa->first()->created_at)->format('Y-m-d\TH:i:s') }}');
                    var now = new Date();
                    var timeDiff = Math.abs(now - createdAt) / 60000; // Dalam menit

                    if (timeDiff > 30) {
                        var formData = new FormData();
                        formData.append('id_absen', '{\{ $absen->id }}');

                        fetch('{\{ route('storeConfirm') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{\{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Tindakan setelah mendapatkan respons dari server
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            SCRIPT;


        return $next($request);
    }
}
