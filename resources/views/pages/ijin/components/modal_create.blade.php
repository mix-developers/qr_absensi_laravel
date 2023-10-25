<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Pengajuan Ijin') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('ijin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <div class="card-body">
                    <div id="coordinates" class="mb-3" style="display: block;"></div>
                    <div class="form-group">
                        <label>Bukti Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Jenis Ijin</label>
                        <select class="form-control" name="jenis">
                            <option value="sakit" selected>Sakit</option>
                            <option value="ijin">Ijin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Matakuliah</label>
                        <select class="form-control" name="id_jadwal">
                            <option selected value="">--Pilih Matakuliah--</option>
                            @php
                                $semester = App\Models\Semester::latest()->first()->code;
                            @endphp
                            @foreach (App\Models\JadwalMahasiswa::where('id_user', Auth::user()->id)->whereHas('jadwal', function ($query) use ($semester) {
            $query->where('code', $semester);
        })->get() as $item)
                                <option value="{{ $item->id_jadwal }}">{{ $item->jadwal->matakuliah->name }},
                                    Kelas {{ $item->jadwal->class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Ijin</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Keterangan Ijin</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
