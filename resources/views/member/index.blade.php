@extends("layouts.global")

@section("title") List Member @endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="float-left">
                    <a href="javascript:void(0)" class="btn btn-success mr-2" onclick="addForm()" data-toggle="tooltip" title="Tambah Member"><i class="fas fa-plus"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger mr-2" onclick="deleteAll()" data-toggle="tooltip" title="Hapus Member"><i class="fas fa-trash"></i></a>
                    <a href="javascript:void(0)" class="btn btn-info" onclick="printCard()" data-toggle="tooltip" title="Print Card Member"><i class="fas fa-credit-card"></i></a>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive">
                    <form method="POST" id="form-member">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" value="1" id="select-all"></th>
                                <th>No</th>
                                <th>Kode Member</th>
                                <th>Nama Member</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("modal")
@include("member.form")
@endsection

@section("script")
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script>
$(function(){
    table =  $('table').DataTable({
        "processing" : true,
        "serverside" : true,
        "ajax" : {
            "url" : "{{route('member.data')}}",
            "type" : "GET"
        },
        'columnDefs' : [{
            'targets' : 0,
            'searchable' : false,
            'orderable' : false
        }],
        'order' : [1,'asc']
    });

    $("#modal-form form").on('submit',function(e){
    if(!e.isDefaultPrevented()){
        if(save_method == "add"){
            url = "{{route('member.store')}}";
        }else{
            var id = $("#id").val();
            url = "member/"+id;
        }

        $.ajax({
            url : url,
            type : "POST",
            data : $("#modal-form form").serialize(),
            dataType : "JSON",
            success : function(data){
                if(data.msg=="error"){
                    swal("Error","Kode Member Sudah pernah di gunakan","error");
                    $("#code_member").focus().select();
                }else{
                    $("#modal-form").modal('hide');
                    table.ajax.reload();
                    if(save_method=="add"){
                        swal("Sukses","Berhasil Menyimpan Data","success");
                    }else{
                        swal("Sukses","Berhasil Memperbarui Data","success");
                    }
                }
            },
            error : function(){
                swal("Error","Gagal Menyimpan Data","error");
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
    save_method = "add";
    $("input[name=_method]").val("POST");
    $("#modal-form").modal('show');
    $("#modal-form form")[0].reset();
    $(".modal-title").text("Tambah Member");
}

function editForm(id){
    save_method = "edit";
    $("input[name=_method]").val("PUT");
    $("#modal-form form")[0].reset();
    $.ajax({
        url : "member/"+id+"/edit",
        type : "GET",
        dataType : "JSON",
        success : function(data){
            $(".modal-title").text("Edit Member");
            $("#modal-form").modal('show');
            $("#id").val(data.id_member);
            $("#code_member").val(data.code_member).attr("readonly",true);
            $("#nama").val(data.nama);
            $("#alamat").val(data.alamat);
            $("#telepon").val(data.telephone);
        },
        error : function(){
            swal("Error","Gagal menampilkan Data","error");
        }
    });
}

function deleteData(id){
    swal({
        title : "Apakah anda yakin ?",
        text : "Data yang dihapus tidak dapat dikembalikan",
        icon : 'warning',
        buttons : true
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url : "member/"+id,
                type : "POST",
                data : {'_method' : 'DELETE' ,'_token' : $("meta[name=csrf-token]").attr("content")},
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses", "Berhasil menghapus Data","success");
                },
                error : function(){
                    swal("Error","Gagal menghapus data","error");
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
                url:"{{route('member.delete-batch')}}",
                type : 'DELETE',
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data : $("#form-member").serialize(),
                success : function(data){
                    table.ajax.reload();
                    swal("Sukses", "Berhasil Menghapus Member", "success");
                },
                error : function(){
                    swal("Error", "Gagal menghapus data!", "error");
                }
            });
        }
    });
    }
}

function printCard(){
    if($('input:checked').length < 1){
        swal("Warning", "Pilih data yang akan di hapus!", "warning");
    }else{
        $("#form-member").attr('target','_blank').attr('action','member/cetak').submit();
    }
}
</script>
@endsection