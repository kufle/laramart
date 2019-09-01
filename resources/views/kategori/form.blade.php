<div class="modal fade" tabindex="-1" role="dialog" id="modal-form">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="POST">
            @csrf
            <input type="hidden" name="_method">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="category">Nama Kategori</label>
                <input type="text" name="category_name" id="category_name" class="form-control" autofocus required>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
        </div>
    </div>
    </div>
</div>