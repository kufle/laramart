<div class="modal fade" tabindex="-1" role="dialog" id="modal-form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="_method">
                    <input type="hidden" id="id"name="id">
                    
                    <div class="form-group row">
                        <label for="kode" class="col-sm-3 col-form-label">Kode Produk</label>
                        <div class="col-sm-9">
                            <input type="number" name="kode" id="kode" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Kode Produk Wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kode" class="col-sm-3 col-form-label">Nama Produk</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Nama Produk Wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select name="kategori" id="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($category as $kategori)
                                <option value="{{$kategori->id_category}}">{{$kategori->category_name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih Kategori
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                        <div class="col-sm-9">
                            <input type="text" name="merk" id="merk" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Merk wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Harga beli wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                        <div class="col-sm-9">
                            <input type="text" name="diskon" id="diskon" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Diskon wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Harga Jual wajib di isi
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                        <div class="col-sm-9">
                            <input type="text" name="stok" id="stok" class="form-control" autofocus required>
                            <div class="invalid-feedback">
                                Stok wajib di isi
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>