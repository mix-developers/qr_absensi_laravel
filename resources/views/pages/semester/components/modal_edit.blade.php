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
            <form action="{{ route('class.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <<div class="form-group focused">
                        <label class="form-control-label" for="year">Tahun<span
                                class="small text-danger">*</span></label>
                        <input type="number" class="form-control" name="year" placeholder="Tahun"
                            value="{{ $item->year }}">
                </div>
                <div class="form-group ">
                    <label class="form-control-label" for="type">Tahun<span
                            class="small text-danger">*</span></label>
                    <select class="form-control" name="type">
                        <option value="1" @if ($item->type == 1) selected @endif>Ganjil</option>
                        <option value="2" @if ($item->type == 2) selected @endif>Genap</option>
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
