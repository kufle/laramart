@extends("layouts.global")
@section("title") Profile @endsection

@section("content")
<h2 class="section-title">Hi, {{ Auth::user()->name }}</h2>
<p class="section-lead">
    Change information about yourself on this page.
</p>

<div class="row mt-sm-4">
    <div class="col-12 col-md-12">
    <div class="card profile-widget">
        <div class="profile-widget-header">                     
        <img alt="image" id="myimage" src="{{asset('avatar/'.Auth::user()->avatar)}}" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">Posts</div>
                <div class="profile-widget-item-value">187</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">Followers</div>
                <div class="profile-widget-item-value">6,8K</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">Following</div>
                <div class="profile-widget-item-value">2,1K</div>
            </div>
        </div>
        </div>
        <div class="card-body">
        <div class="col-12">
            <form id="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group row">
                <label for="Nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                <input type="text" name="nama" id="nama" class="form-control" value="{{Auth::user()->name}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="foto" class="col-sm-3 col-form-label">Foto</label>
                <div class="col-sm-9">
                <input type="file" name="avatar" id="avatar" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="password_lama" class="col-sm-3 col-form-label">Password Lama</label>
                <div class="col-sm-9">
                <input type="password" name="old_password" id="old_password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="password_baru" class="col-sm-3 col-form-label">Password Baru</label>
                <div class="col-sm-9">
                <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="konfirmasi_password" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-9">
                <input type="password" name="password1" id="password1" class="form-control">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Simpan">
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/modules/jquery.validate.js')}}"></script>
<script>
    $(function(){
        //cek password di isi atau ngga
        $("#old_password").keyup(function(){
            if($(this).val() != '') {
                $("#password,#password1").attr('required',true);
            }else{
                $("#password,#password1").attr('required',false);
            }
        });

        $("#password").keyup(function(){
            if($(this).val() != '') {
                $("#old_password,#password1").attr('required',true);
            }else{
                $("#old_password,#password1").attr('required',false);
            }
        });
        //upload file pake ajax
        $('#form').validate({
            rules: {
                nama: "required",
                password: {
                    minlength: 5
                },
                password1: {
                    minlength: 5,
                    equalTo: "#password"
                }
            },
            messages: {
                nama: "Please enter your firstname",
                password: {
                    minlength: "Your password must be at least 5 characters long"
                },
                password1: {
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                }
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
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form) {
                $.ajax({
                    url : "{{Auth::user()->id}}/change",
                    type : "POST",
                    data: new FormData($("#form")[0]),
                    dataType: "JSON",
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        if(data.msg=="error"){
                            swal("Gagal","Password lama salah","error");
                            $("#old_password").focus().select();
                        }else{
                            d = new Date();
                            swal("Sukses","Data berhasil di Update");
                            $("#myimage, .avatars").attr('src',data.url+'?'+d.getTime());
                        }
                    },
                    error : function(){
                        swal("Error","Gagal mengupdate Data");
                    }
                });
                return false;
            }
        });

    });
</script>
@endsection