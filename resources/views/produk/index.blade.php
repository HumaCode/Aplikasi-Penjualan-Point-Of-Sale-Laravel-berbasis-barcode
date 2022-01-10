@extends('layouts.master')

@section('title')
    Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Hapus</button>
                        <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-flat btn-xs"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                    </div>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    
                    <form action="" class="form-produk" method="post">
                        @csrf
                        <table class="table table-striped tb-bordered">
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th width="15%" class="text-center"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- memanggil form modal--}}
    @includeIf('produk.form')
@endsection


@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('produk.data') }}'
                },
                columns: [
                    {data: 'select_all', searchable:false, sortable:false},
                    {data: 'DT_RowIndex', searchable:false, sortable:false},
                    {data: 'kode_produk'},
                    {data: 'nama_produk'},
                    {data: 'nama_kategori'},
                    {data: 'merk'},
                    {data: 'harga_beli'},
                    {data: 'harga_jual'},
                    {data: 'diskon'},
                    {data: 'stok'},
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

            // select all
            $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            });
        });

        // function tambah
        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }

        // function edit
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Produk');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_produk]').focus();
        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
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

        // function delete selected
        function deleteSelected(url) {
            if($('input:checked').length > 1) {
                if(confirm('Yakin akan menghapus data ini.?')) {
                    $.post(url, $('.form-produk').serialize())

                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    })
                }
            }else{
                alert('Pilih data yang akan dihapus');
                return;
            }
        }

        // function cetak barcode
        function cetakBarcode(url){
            // apakah ada data yang di checklist
            if($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            }else if($('input:checked').length < 3 ){
                alert('Pilih minimal 3 data yang dicetak');
                return;
            }else{
                $('.form-produk')
                .attr('action', url)
                .attr('target', '_blank')
                .submit(); 
            }
        }
    </script>
@endpush