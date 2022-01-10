@extends('layouts.master')

@section('title')
    Pengaturan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengaturan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12"> 
            <div class="box">
                <form action="{{ route('setting.update') }}" class="form-setting" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"> Berhasil Diubah..</i>
                        </div>
                        <div class="form-group row">
                            <label for="nama_perusahaan" class="col-lg-2 control-lable">Nama Perusahaan</label>
                            <div class="col-lg-10">
                                <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" required autofocus>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telepon" class="col-lg-2 control-lable">Telepon</label>
                            <div class="col-lg-10">
                                <input type="number" min="0" name="telepon" class="form-control" id="telepon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_perusahaan" class="col-lg-2 control-lable">Alamat</label>
                            <div class="col-lg-10">
                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" required></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_logo" class="col-lg-2 control-lable">Logo Perusahaan</label>
                            <div class="col-lg-3">
                                <input type="file" name="path_logo" class="form-control" id="path_logo" onchange="preview('.tampil-logo', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-logo"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_kartu_member" class="col-lg-2 control-lable">Kartu Member</label>
                            <div class="col-lg-3">
                                <input type="file" name="path_kartu_member" class="form-control" id="path_kartu_member" 
                                onchange="preview('.kartu-member', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="kartu-member"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diskon" class="col-lg-2 control-lable">Diskon</label>
                            <div class="col-lg-3">
                                <input type="number" min="0" name="diskon" class="form-control" id="diskon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tipe_nota" class="col-lg-2 control-lable">Tipe Nota</label>
                            <div class="col-lg-3">
                                <select name="tipe_nota" class="form-control" id="tipe_nota">
                                    <option value="1">Nota Kecil</option>
                                    <option value="2">Nota Besar</option>
                                </select>
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
        showData();
        $('.form-setting').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData();
                    $('.alert').fadeIn();
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            }
        });
    });

        // fungsi tampil data
        function showData() {
            $.get('{{ route('setting.show') }}')
                .done(response => {
                    $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                    $('[name=telepon]').val(response.telepon);
                    $('[name=alamat]').val(response.alamat);
                    $('[name=diskon]').val(response.diskon);
                    $('[name=tipe_nota]').val(response.tipe_nota);
                    $('title').text(response.nama_perusahaan + ' | Pengaturan');
                    $('.logo-lg').text(response.nama_perusahaan);

                    $('.tampil-logo').html(`<img src="${response.path_logo}" width="200">`);
                    $('.kartu-member').html(`<img src="${response.path_kartu_member}" width="200">`);
                    $('[rel=icon]').attr('href', `${response.path_logo}`);
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data..');
                    return;
                })
        }
    </script>
@endpush