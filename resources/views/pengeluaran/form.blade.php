<div class="modal" role="dialog" tabindex="-1" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="POST" class="needs-validation" novalidate>
            @csrf
            <div class="modal-body">

            <input type="hidden" name="_method">
            <input type="hidden" name="id" id="id">
            <div class="form-group row">
                <label for="jenis" class="col-sm-3 col-form-label">Jenis Pengeluaran</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis_pengeluaran" id="jenis_pengeluaran" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="nominal" id="nominal" required>
                </div>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>