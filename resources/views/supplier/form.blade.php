<div class="modal" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" class="needs-validation" novalidate>
            @csrf
                <input type="hidden" name="_method">
                <input type="hidden" name="id" id="id">
                
                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                        <div class="invalid-feedback">
                            Nama supplier wajib diisi!
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Telepon</label>
                    <div class="col-sm-9">
                        <input type="text" name="telepon" id="telepon" class="form-control" autofocus required>
                        <div class="invalid-feedback">
                            Telepon wajib diisi!
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                        <div class="invalid-feedback">
                            Nama supplier wajib diisi!
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button class="btn btn-secondary" type="button" class="close" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>