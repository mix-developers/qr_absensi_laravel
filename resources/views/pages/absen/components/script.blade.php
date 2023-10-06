@push('js')
    {{-- @if ($absen_confirm == null && $absen_mahasiswa->first() && $absen_mahasiswa->first()->created_at)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var createdAt = new Date(
                    '{{ \Carbon\Carbon::parse($absen_mahasiswa->first()->created_at)->format('Y-m-d\TH:i:s') }}');
                var now = new Date();
                var timeDiff = Math.abs(now - createdAt) / 60000; // Dalam menit

                if (timeDiff > 30) {
                    var formData = new FormData();
                    formData.append('id_absen', '{{ $absen->id }}');

                    fetch('{{ route('absen.storeConfirm') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Tindakan setelah mendapatkan respons dari server
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        </script>
    @endif --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="konfirmasi[]"]');
            const konfirmasiButton = document.getElementById('konfirmasiButton');
            const checkAllCheckbox = document.getElementById('checkAll');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const checkedCheckboxes = document.querySelectorAll(
                        'input[name="konfirmasi[]"]:checked');
                    if (checkedCheckboxes.length > 0) {
                        konfirmasiButton.removeAttribute('disabled');
                    } else {
                        konfirmasiButton.setAttribute('disabled', 'disabled');
                    }
                });
            });

            checkAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                });
            });
        });
    </script>
@endpush
