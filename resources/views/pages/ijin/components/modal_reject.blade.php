<!-- Delete Modal-->
<div class="modal fade" id="reject-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Konfirmasi penolakan absen') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('ijin.tolak', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body ">
                    <div class="form-group">
                        <label>Keterangan penolakan</label>
                        <textarea name="message" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-danger mx-2">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
