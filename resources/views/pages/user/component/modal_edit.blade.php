<div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit : ' . $item->name) }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="day">Pilih Jabatan</label>
                        <select class="form-control" name="id_matakuliah">
                            <option value="dosen" {{ $item->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="ketua_jurusan" {{ $item->role == 'ketua_jurusan' ? 'selected' : '' }}>Ketua
                                Jurusan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Dosen"
                                    value="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Title Dosen"
                                    value="{{ $item->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>NIP/NIDN</label>
                        <input type="text" name="identity" class="form-control" placeholder="xxxxxxxxx"
                            value="{{ $item->identity }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email"
                            value="{{ $item->email }}">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir (opsional)</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                            value="{{ $item->tempat_lahir }}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir (opsional)</label>
                        <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir"
                            value="{{ $item->tanggal_lahir }}">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
