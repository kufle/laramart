<div class="modal" role="dialog" tabindex="-1" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="modal-body">
                <input type="hidden" name="_method">
                <input type="hidden" name="id" id="id">

                <div class="form-group row">
                    <label for="kode" class="col-sm-3 col-form-label">Kode Member</label>
                    <div class="col-sm-9">
                        <input type="number" name="code_member" id="code_member" class="form-control" required focus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Member</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" id="nama" class="form-control" required focus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea name="alamat" id="alamat" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                    <div class="col-sm-9">
                        <input type="text" name="telepon" id="telepon" class="form-control" required focus>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>