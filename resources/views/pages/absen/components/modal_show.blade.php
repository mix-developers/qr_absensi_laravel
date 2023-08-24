<!-- Delete Modal-->
<div class="modal fade" id="show-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Data Absen') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Mahasiswa</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(App\Models\AbsenMahasiswa::where('id_absen',$item->id)->get() as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $list->user->name }}</strong><br>
                                    <small>{{ $list->user->identity }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Belum ada yang absen</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
