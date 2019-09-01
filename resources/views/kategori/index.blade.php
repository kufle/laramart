@extends("layouts.global")

@section("title") List Kategori @endsection

@section("content")

<div class="alert alert-success alert-dismissible show fade" id="alerts" style="display:none">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">x</button>
        <p id="messages"></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="float-left">
                    <a href="javascript:void(0)" onclick="addForm()" class="btn btn-success"><i class="fas fa-plus"></i></a>
                </div>
                <div class="clearfix mb-3"></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
@include('kategori.form')
@endsection

@section('script')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/page/bootstrap-modal.js')}}"></script>
<script>
var table, save_method;
$(function(){
//menampilkan data dengan plugin datatable
    table = $(".table").DataTable({
        "processing" : true,
        "ajax" : {
            "url" : "{{route('kategori.data')}}",
            "type" : "GET"
        }
    });

    //menyimpan data form tambah/edit
    $('#modal-form form').on('submit',function(e){
        if(!e.isDefaultPrevented()){
            var id = $("#id").val();
            if(save_method == "add"){
                url = "{{route('kategori.store')}}"
            }else{
                url = "kategori/"+id;
            }
            $.ajax({
                url : url,
                type : "POST",
                data : $("#modal-form form").serialize(),
                success : function(data){
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                    if(save_method=="add"){
                        swal("Sukses", "Berhasil Menyimpan Kategori", "success");
                    }else{
                        if(save_method=="edit"){
                            swal("Sukses", "Berhasil Mengupdate Kategori", "success");
                        }
                    }
                },
                error : function(){
                    alert("Tidak dapat menyimpan data");
                }
            });
            return false;
        }
    });

});

//menampilkan form tambah 
function addForm(){
    save_method = "add";
    $('input[name=_method]').val('POST');
    $('#modal-form').modal('show');
    $('#modal-form form')[0].reset();
    $('.modal-title').text('Tambah Kategori');
}

//menampilkan form edit
function editForm(id){
    save_method = "edit";
    $("input[name=_method]").val("PUT");
    $("#modal-form form")[0].reset();
    $.ajax({
        url : "kategori/"+id+"/edit",
        type : "GET",
        dataType : "JSON",
        success : function(data){
            $("#modal-form").modal('show');
            $('.modal-title').text('Edit Kategori');
            $("#id").val(data.id_category);
            $("#category_name").val(data.category_name)
        },
        error : function(){
            alert("Tidak Dapat Menampilkan Data");
        }
    });
}

function deleteData(id){       
    swal({
        title: "Apakah Anda Yakin?",
        text: "Data Tidak dapat dikembalikan Apabila sudah di Hapus!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url : "kategori/"+id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $("meta[name='csrf-token']").attr('content')},
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses", "Berhasil Menghapus Kategori", "success");
                },
                error : function(){
                    swal("Error", "Gagal menghapus kategori", "error");
                }
            });
        }
    });
}
</script>
@endsection