@extends("layouts.global")
@section("title")List Pengeluaran @endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="float-left">
                    <a href="javascript:void(0)" class="btn btn-success" onclick="addForm()"><i class="fas fa-plus"></i></a>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Pengeluaran</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
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
@include("pengeluaran.form")
@endsection

@section('script')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $(function(){
        table = $('.table').DataTable({
            "processing" : true,
            "serverside" : true,
            "ajax" : {
                "url" : "{{route('pengeluaran.data')}}",
                "type" : "GET"
            }
        });

        $("#modal-form form").on('submit',function(e){
            if(!e.isDefaultPrevented()){
                var id = $("#id").val();
                if(save_method=="add"){
                    url = "{{route('pengeluaran.store')}}"
                }else{
                    url = "pengeluaran/"+id;
                }

                $.ajax({
                    url : url,
                    type : "POST",
                    data : $("#modal-form form").serialize(),
                    success : function(data){
                        $("#modal-form").modal('hide');
                        table.ajax.reload();
                        if(save_method=="add"){
                            swal("Sukses","Berhasil Menyimpan data","success");
                        }else{
                            swal("Sukses","Berhasil Mengupdate data","success");
                        }
                    },
                    error : function(){
                        swal("Gagal","Gagal Menyimpan data","error");
                    }
                });
                return false;
            }
        });
    });

//tambah data
function addForm(){
    save_method="add";
    $("input[name=_method]").val("POST");
    $("#modal-form").modal('show');
    $("#modal-form form")[0].reset();
    $(".modal-title").text("Tambah Pengeluaran");
}
//edit data
function editForm(id){
    save_method = "edit";
    $("#modal-form form")[0].reset();
    $("input[name=_method]").val("PUT");
    $.ajax({
        url : "pengeluaran/"+id+"/edit",
        dataType : "JSON",
        success : function(data){
            $("#modal-form").modal('show');
            $("#id").val(data.id_pengeluaran);
            $("#jenis_pengeluaran").val(data.jenis_pengeluaran);
            $("#nominal").val(data.nominal);
        }
    });
}
//hapus data
function deleteData(id){
    swal({
        title : "Apakah anda Yakin ?",
        text : "Data yang dihapus tidak dapat di kembalikan",
        icon : "warning",
        buttons : true,
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url : "pengeluaran/"+id,
                type : "DELETE",
                data : {"-method" : "DELETE" , "_token" : $("meta[name=csrf-token]").attr('content')},
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses","Berhasil menghapus data","success");
                },
                error : function(){
                    swal("Error","Gagal Menghapus Data","error");
                }
            })
        }
    });
}
</script>
@endsection