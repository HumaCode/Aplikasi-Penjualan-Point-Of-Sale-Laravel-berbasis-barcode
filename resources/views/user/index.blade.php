@extends('layouts.master')

@section('title')
    Daftar User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar User</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped tb-bordered">
                        <thead >
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th width="15%" class="text-center"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- memanggil form modal--}}
    @includeIf('user.form')
@endsection


@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('user.data') }}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            // validator
            $('#modal-form').validator().on('submit', function(e) {
                if(! e.preventDefault()) {

                    // method post, url, data
                    $.post($('#modal-form form').attr('action'),  $('#modal-form form').serialize())
                    
                    // calllback
                    .done((response) => {   
                        // jika sukses, modalnya di hide
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => { 
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
                }
            })
        });

        // function tambah
        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah User Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

            $('#password, #password_confirmation').attr('required', true);
        }

        // function edit
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit User');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=name]').focus();

            $('#password, #password_confirmation').attr('required', false);

            // ambil datanya berdasarkan url / id
            $.get(url) 
                .done((response) => {
                    $('#modal-form [name=name]').val(response.name);
                    $('#modal-form [name=email]').val(response.email);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

        // function hapus
        function deleteData(url) {
            if(confirm('Yakin akan menghapus data ini.?')) {
                    $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })

                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    })
            }
        }
    </script>
@endpush