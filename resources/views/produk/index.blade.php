@extends("layouts.global")

@section("title") List Produk @endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <div class="float-left">
                    <a href="javascript:void(0)" onclick="addForm()" class="btn btn-success mr-3" data-toggle="tooltip" title="Tambah Produk"><i class="fas fa-plus"></i></a>
                    <a href="javascript:void(0)" onclick="deleteAll()" class="btn btn-danger mr-3" data-toggle="tooltip" title="Hapus Produk"><i class="fas fa-trash"></i></a>   
                    <a href="javascript:void(0)" onclick="printBarcode()" class="btn btn-info" data-toggle="tooltip" title="Print Barcode"><i class="fas fa-barcode"></i></a>                 
                </div>
                <div class="clearfix mb-3"></div>
                <form method="POST" id="form-produk">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" value="1" id="select-all"></th>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
@include('produk.form')
@endsection

@section('script')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/page/bootstrap-modal.js')}}"></script>
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
$(function(){
    table = $('.table').DataTable({
        "processing" :true,
        "serverside" :true,
        "ajax" : {
            "url" : "{{ route('produk.data') }}",
            "type" : "GET"
        },
        'columnDefs' : [{
            'targets' : 0,
            'searchable' :false,
            'orderable' :false
        }],
        'order' : [1,'asc']
    });

    //menyimpan data
    $("#modal-form form").on('submit',function(e){
        if(!e.isDefaultPrevented()){
            var id = $("#id").val();
            if(save_method == "add"){
                url = "{{route('produk.store')}}";
            }else{
                url = "produk/"+id;
            }
            $.ajax({
                url : url,
                type : "POST",
                data : $("#modal-form form").serialize(),
                dataType : "json",
                success : function(data){
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    if(data.msg=="error"){
                        swal("Error","Kode Produk sudah pernah di gunakan","error");
                    }else{
                        if(save_method=="add"){
                        swal("Sukses","Sukses menambah Produk","success");
                        }else{
                            if(save_method=="edit"){
                                swal("Sukses","Sukses mengupdate Produk","success");
                            }
                        }
                    }
                },
                error : function(){
                    swal("Gagal","Gagal menyimpan data","error");
                }
            });
            return false;
        }
    });

    $('#select-all').click(function(){
        $('input[type="checkbox"]').prop('checked',this.checked);
    });
});
function addForm(){
    save_method="add";
    $("input[name=_method]").val('POST');
    $("#modal-form").modal('show');
    $("#modal-form form")[0].reset();
    $('.modal-title').text('Tambah Produk');
    $("#kode").attr('readonly',false);
}

function editForm(id){
    save_method = "edit";
    $('input[name=_method]').val('PUT');
    $("#modal-form form")[0].reset();
    $.ajax({
        url : "produk/"+id+"/edit",
        type : "GET",
        dataType : "JSON",
        success : function(data) {
            $("#modal-form").modal('show');
            $(".modal-title").text('Edit Produk');
            $("#id").val(data.id_product);
            $("#kode").val(data.code_product).attr('readonly',true);
            $("#nama").val(data.product_name);
            $("#kategori").val(data.id_category);
            $("#merk").val(data.merk);
            $("#harga_beli").val(data.harga_beli);
            $("#diskon").val(data.diskon);
            $("#harga_jual").val(data.harga_jual);
            $("#stok").val(data.stock);
        },
        error : function(){
            swal("Gagal","Gagal menampilkan data","error");
        }
    });
}

function deleteData(id){
    swal({
        title:"Apakah anda Yakin?",
        text : "data yang di hapus tidak dapat di kembalikan",
        icon : "warning",
        buttons : true,
        dangerMode: true,
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url : "produk/"+id,
                type : "POST",
                data : {'_method' : 'DELETE','_token' : $('meta[name=csrf-token]').attr('content')},
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses", "Berhasil Menghapus Produk", "success");
                },
                error : function(){
                    swal("Error", "Gagal menghapus kategori", "error");
                }
            });
        }
    });
}

function deleteAll(){
    if($('input:checked').length < 1){
        swal("Warning", "Pilih data yang akan di hapus!", "warning");
    }else{
        swal({
        title:"Apakah anda Yakin?",
        text : "data yang di hapus tidak dapat di kembalikan",
        icon : "warning",
        buttons : true,
        dangerMode: true,
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url:"{{route('produk.delete-batch')}}",
                type : 'DELETE',
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data : $("#form-produk").serialize(),
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses", "Berhasil Menghapus Produk", "success");
                },
                error : function(){
                    swal("Error", "Gagal menghapus data!", "error");
                }
            })
        }
    });
    }
}

function printBarcode(){
    if($('input:checked').length < 1){
        swal("Warning", "Pilih data yang akan di cetak!", "warning");
    }else{
        $("#form-produk").attr('target','_blank').attr('action',"produk/cetak").submit();
    }
}
</script>
@endsection