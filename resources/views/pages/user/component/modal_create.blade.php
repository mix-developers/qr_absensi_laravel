<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Dosen') }}</h5>
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
                            <option selected value="dosen">Dosen</option>
                            <option value="ketua_jurusan">Ketua Jurusan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Dosen">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Title Dosen">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>NIP/NIDN</label>
                        <input type="text" name="identity" class="form-control" placeholder="xxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir (opsional)</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir (opsional)</label>
                        <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
