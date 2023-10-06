<!-- Delete Modal-->
<div class="modal fade" id="foto-{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Bukti Foto Absen') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">


                <img src="{{ $foto != null || $foto != '' ? $foto : '' }}" style="width: 100%;">

            </div>
        </div>
    </div>
</div>
