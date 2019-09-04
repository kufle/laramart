@extends("layouts.global")

@section('title') List Supplier @endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="float-left">
                    <a href="javascript:void(0)" class="btn btn-success" onclick="addForm()" data-toggle="tooltip" title="Tambah Supplier"><i class="fas fa-plus"></i></a>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("modal")
@include('supplier.form')
@endsection

@section('script')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
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
        "processing" : true,
        "serverside" : true,
        "ajax" : {
            "url" : "{{route('supplier.data')}}",
            "type" : "GET",
        }
    });

    $('#modal-form form').on('submit',function(e){
        if(!e.isDefaultPrevented()){
            var id = $("#id").val();
            if(save_method=="add"){
                url = "{{route('supplier.store')}}"
            }else{
                url = "supplier/"+id;
            }

            $.ajax({
                url : url,
                type : "POST",
                data : $('#modal-form form').serialize(),
                success : function(data){
                    $("#modal-form").modal('hide');
                    table.ajax.reload();
                    if(save_method=="add"){
                        swal("Sukses","Data Supplier Berhasil Disimpan","success");
                    }else{
                        swal("Sukses","Berhasil Memperbarui Supplier","success");
                    }
                },
                error : function(){
                    swal("Error","Gagal Menyimpan data","error");
                }
            });
            return false;
        }
    });
});

//add supplier
function addForm(){
    save_method = "add";
    $('input[name=_method]').val('POST');
    $("#modal-form").modal('show');
    $("#modal-form form")[0].reset();
    $('.modal-title').text("Tambah Supplier");
}

function editForm(id){
    save_method = "edit";
    $('input[name=_method]').val("PUT");
    $("#modal-form form")[0].reset();
    $.ajax({
        url : "supplier/"+id+"/edit",
        type : "GET",
        dataType : "JSON",
        success : function(data){
            $("#modal-form").modal('show');
            $(".modal-title").text('Edit Supplier');
            $("#id").val(data.id_supplier);
            $("#nama").val(data.nama);
            $("#telepon").val(data.telepon);
            $("#alamat").val(data.alamat);
        },
        error : function(){
            swal("Error","Gagal menampilkan Data","error");
        }
    })
}

function deleteData(id){
    swal({
        title : "Apakah anda Yakin ?",
        text : "data yang sudah di hapus tidak dapat di kembalikan",
        icon : "warning",
        buttons:true,
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url : "supplier/"+id,
                type : "POST",
                data : {'_method' : 'DELETE' , '_token' : $('meta[name=csrf-token]').attr('content')},
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses","Berhasil menghapus Data","success");
                },
                error : function(){
                    swal("Error","Gagal Menghapus Data","error");
                }
            });
        }
    });
}
</script>
@endsection