<div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Data') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @php
                $semester = App\Models\Semester::latest()->first()->code;
            @endphp
            <form action="{{ route('jadwal.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="day">Pilih Hari</label>
                        <select class="form-control" name="day">
                            <option value="Senin" @if ($item->day == 'Senin') selected @endif>Senin</option>
                            <option value="Selasa" @if ($item->day == 'Selasa') selected @endif>Selasa</option>
                            <option value="Rabu" @if ($item->day == 'Rabu') selected @endif>Rabu</option>
                            <option value="Kamus" @if ($item->day == 'Kamis') selected @endif>Kamus</option>
                            <option value="Jum'at" @if ($item->day == "Jum'at") selected @endif>Jum'at</option>
                            <option value="Sabtu" @if ($item->day == 'Sabtu') selected @endif>Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group my-2">
                        <div class="row">
                            <div class="col">
                                <label>Waktu Mulai</label>
                                <input type="time" name="time_start" class="form-control"
                                    value="{{ $item->time_start }}">
                            </div>
                            <div class="col">
                                <label>Waktu Selesai</label>
                                <input type="time" name="time_end" class="form-control"
                                    value="{{ $item->time_end }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Ruangan</label>
                        <select class="form-control" name="id_ruangan">
                            <option selected value="">--Pilih ruangan--</option>
                            @foreach (App\Models\Ruangan::all() as $list)
                                <option value="{{ $list->id }}" @if ($list->id == $item->id_ruangan) selected @endif>
                                    {{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Matakuliah</label>
                        <select class="form-control" name="id_matakuliah">
                            <option selected value="">--Pilih Matakuliah--</option>
                            @foreach (App\Models\MataKuliah::where('code', $semester)->get() as $list)
                                <option value="{{ $list->id }}" @if ($list->id == $item->id_matakuliah) selected @endif>
                                    {{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Kelas</label>
                        <select class="form-control" name="id_class">
                            <option selected value="">--Pilih Kelas--</option>
                            @foreach (App\Models\Classes::all() as $list)
                                <option value="{{ $list->id }}" @if ($list->id == $item->id_class) selected @endif>
                                    {{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Pilih Dosen</label>
                        <select class="form-control" name="id_user">
                            <option selected value="">--Pilih Dosen--</option>
                            @foreach (App\Models\User::all() as $list)
                                <option value="{{ $list->id }}" @if ($list->id == $item->id_user) selected @endif>
                                    {{ $list->full_name }}</option>
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
