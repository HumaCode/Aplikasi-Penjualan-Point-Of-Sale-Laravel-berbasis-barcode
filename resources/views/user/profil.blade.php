@extends('layouts.master')

@section('title')
    Edit Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Edit Profil</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12"> 
            <div class="box">
                <form action="{{ route('user.update_profil') }}" class="form-profil" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"> Berhasil Diubah..</i>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-lg-2 control-lable">Nama</label>
                            <div class="col-lg-8">
                                <input type="text" name="name" class="form-control" id="name" required value="{{ $profil->name }}">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto" class="col-lg-2 control-lable">Foto Profil</label>
                            <div class="col-lg-3">
                                <input type="file" name="foto" class="form-control" id="foto" onchange="preview('.tampil-foto', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-foto">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="200">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="old_password" class="col-md-2  control-label">Password Lama</label>
                            <div class="col-md-8">
                                <input type="password" name="old_password" class="form-control "   id="old_password" minlength="8">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-2  control-label">Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control "   id="password" minlength="8">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-2  control-label">Konfirmasi Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password_confirmation" class="form-control "   id="password_confirmation" data-match="#password">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-primary btn-flat">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

        // javascrip carikan saya id yang namanya old_password, yang ketika onkeyup/krusor mouse di keataskan pada inputan old_password, maka jalankan function berikut
        $('#old_password').on('keyup', function() {
            // jika valuenya di dalam inputan old password tidak sama dengan string kosong/kosong, maka
            if($(this).val() != "") {
            // field inputan password menjadi required/harus diisi
                $('#password, #password_confirmation').attr('required', true);
            } else {
                $('#password, #password_confirmation').attr('required', false);
            }
        });

        $('.form-profil').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-profil').attr('action'),
                    type: $('.form-profil').attr('method'),
                    data: new FormData($('.form-profil')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    $('[name=name]').val(response.name);
                    $('.tampil-foto').html(`<img src="${response.foto}" width="200">`);
                    $('.img-profil').attr('src', `{{ url('${response.foto}') }}`);

                    $('.alert').fadeIn();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    if(errors.status == 422) {
                        alert(errors.responseJSON);    
                    }else {
                        alert('Tidak dapat menyimpan data');
                    }
                    return;
                });
            }
        });
    });

        
    </script>
@endpush