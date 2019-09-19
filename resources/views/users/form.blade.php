<div class="modal" role="dialog" tabindex="-1" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="_method">
                <input type="hidden" name="id" id="id">

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama user</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_user" id="nama_user" required focus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" id="email" required focus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Roles</label>
                    <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
                        <label class="form-check-label" for="administrator">Administrator</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" id="STAFF" value="STAFF">
                        <label class="form-check-label" for="staff">Staff</label>
                      </div>
                      <div id="error"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" required focus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Ulangi Password</label>
                    <div class="col-sm-9">
                        <input type="password" data-match="#password" class="form-control" name="ulangi_password" id="ulangi_password" required focus>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>