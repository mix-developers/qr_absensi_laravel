<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Data') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="day">Pilih Hari</label>
                        <select class="form-control" name="day">
                            <option value="Senin" selected>Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamus">Kamus</option>
                            <option value="Jum'at">Jum'at</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group my-2">
                        <div class="row">
                            <div class="col">
                                <label>Waktu Mulai</label>
                                <input type="time" name="time_start" class="form-control">
                            </div>
                            <div class="col">
                                <label>Waktu Selesai</label>
                                <input type="time" name="time_end" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Ruangan</label>
                        <select class="form-control" name="id_ruangan">
                            <option selected value="">--Pilih ruangan--</option>
                            @foreach (App\Models\Ruangan::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Matakuliah</label>
                        <select class="form-control" name="id_matakuliah">
                            <option selected value="">--Pilih Matakuliah--</option>
                            @foreach (App\Models\MataKuliah::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Kelas</label>
                        <select class="form-control" name="id_class">
                            <option selected value="">--Pilih Kelas--</option>
                            @foreach (App\Models\Classes::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Dosen</label>
                        <select class="form-control" name="id_user">
                            <option selected value="">--Pilih Dosen--</option>
                            @foreach (App\Models\User::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
