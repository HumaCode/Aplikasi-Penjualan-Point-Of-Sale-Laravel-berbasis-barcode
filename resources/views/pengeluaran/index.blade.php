@extends('layouts.master')

@section('title')
    Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengeluaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>

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
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Nominal</th>
                            <th width="15%" class="text-center"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- memanggil form modal--}}
    @includeIf('pengeluaran.form')
@endsection


@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pengeluaran.data') }}'
                },
                columns: [
                    {data: 'DT_RowIndex', searchable:false, sortable:false},
                    {data: 'created_at'},
                    {data: 'deskripsi'},
                    {data: 'nominal'},
                    {data: 'aksi', searchable:false, sortable:false},
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
            $('#modal-form .modal-title').text('Tambah Pengeluaran Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=deskripsi]').focus();
        }

        // function edit
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Pengeluaran');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=deskripsi]').focus();

            // ambil datanya berdasarkan url / id
            $.get(url) 
                .done((response) => {
                    $('#modal-form [name=deskripsi]').val(response.deskripsi);
                    $('#modal-form [name=nominal]').val(response.nominal);
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