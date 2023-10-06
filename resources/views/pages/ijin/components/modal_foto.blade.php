<!-- Delete Modal-->
<div class="modal fade" id="foto-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Bukti Foto Ijin') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">


                <p><strong>Keterangan</strong> : {{ $item->keterangan }}</p>
                <hr>
                <img src="{{ Storage::url($item->foto) }}" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
