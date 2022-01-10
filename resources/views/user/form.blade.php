<!-- Modal -->
<div class="modal  fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-3  control-label">Nama</label>
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control " required autofocus id="name">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-3  control-label">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" class="form-control " required  id="email">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-3  control-label">Password</label>
                        <div class="col-md-8">
                            <input type="password" name="password" class="form-control " required  id="password" minlength="8">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-3  control-label">Konfirmasi Password</label>
                        <div class="col-md-8">
                            <input type="password" name="password_confirmation" class="form-control " required  id="password_confirmation" data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                    <button  class="btn btn-primary btn-flat">Simpan</button>
                </div>
            </div>

        </form>
    </div>
</div>
