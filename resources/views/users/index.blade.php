@extends("layouts.global")
@section("title")List Users @endsection

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
                                <td>No</td>
                                <td>Nama User</td>
                                <td>Email</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("modal")
@include("users.form")
@endsection

@section('script')
<script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/modules/jquery.validate.js')}}"></script>
<script>
var table,save_method;
$(function(){
    table = $(".table").DataTable({
        "processing" : true,
        "serverside" : true,
        "ajax" : {
            "url" : "{{ route('users.data') }}",
            "type" : "GET"
        }
    });
    
    $("#modal-form form").validate({
        rules: {
            nama_user: "required",
            password: {
                minlength: 5
            },
            ulangi_password: {
                minlength: 5,
                equalTo: "#password"
            },
            "roles[]" :{
                required : true,
                minlength: 1 
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                minlength: "Your password must be at least 5 characters long"
            },
            "roles[]" :{
                required : "Pilih salah satu Role"
            },
            ulangi_password: {
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `invalid-feedback` class to the error element
            error.addClass( "invalid-feedback" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.next( "label" ) );
            } else {
                error.insertAfter( element );
            }

            if (element.attr("name") == "roles[]"){
                error.insertAfter('#error');
            } else {
                error.insertAfter(element);    
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            $("input[name='roles[]']").removeClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        },
        submitHandler: function(form) {
            var id = $("#id").val();
            if(save_method=="add"){
                url = "{{route('users.store')}}"
            }else{
                url = "users/"+id;
            }
            $.ajax({
                url : url,
                type : "POST",
                data : $("#modal-form form").serialize(),
                success : function(data){
                    $("#modal-form").modal('hide');
                    table.ajax.reload();
                    if(save_method=="add"){
                        swal("Sukses","Berhasil menyimpan Data","success");
                    }else{
                        swal("Sukses","Berhasil Mengupdate Data","success");
                    }
                },
                error : function(){
                    swal("Error","Gagal menyimpan data");
                }            
            });
            return false;
        }
    });
});
//tambah data
function addForm(){
    save_method = "add";
    $("input[name=_method]").val("POST");
    $("#modal-form").modal('show');
    $("#modal-form form")[0].reset();
    $(".modal-title").text("Tambah User");
}
//edit
function editForm(id){
    save_method = "edit";
    $("input[name=_method]").val("PUT");
    $("#modal-form form")[0].reset();
    $.ajax({
        url : "users/"+id+"/edit",
        type : "GET",
        dataType : "JSON",
        success : function(data){
            $("#modal-form").modal("show");
            $(".modal-title").text("Edit User");
            $("#id").val(data.id);
            $("#nama_user").val(data.name);
            $("#email").val(data.email);
            var role = jQuery.parseJSON(data.level);
            if(data.level.indexOf("ADMIN") > -1){
                $("#ADMIN").prop("checked",true);
            }
            if(data.level.indexOf("STAFF") > -1){
                $("#STAFF").prop("checked",true);
            }
            $("#password,#ulangi_password").removeAttr("required");
        },
        error : function(){
            swal("Error","Gagal menampilkan data","error");
        }
    });
}

function deleteData(id){
    swal({
        title: "Apakah Anda Yakin ?",
        text: "Data yang dihapus tidak dapat dikembalikan",
        icon: "warning",
        buttons:true,
    }).then((willdelete)=>{
        if(willdelete){
            $.ajax({
                url: "users/"+id,
                type:"POST",
                data: {'_method' : 'DELETE', '_token': $('meta[name=csrf-token]').attr('content') },
                success: function(data){
                    table.ajax.reload();
                    swal("Sukses","User Berhasil Di Hapus",'success');
                },
                error: function(){
                    swal("Gagal","Gagal menghapus User","error");
                }
            })
        }
    });
}
</script>
@endsection