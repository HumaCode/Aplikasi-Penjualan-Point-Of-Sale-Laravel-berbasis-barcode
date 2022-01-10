@extends('layouts.master')

@section('title')
    Member
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Member</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-success btn-flat btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-info btn-flat btn-xs"><i class="fa fa-id-card"></i> Cetak Kartu Member</button>

                    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <form action="" class="form-member" method="post">
                        @csrf
                        <table class="table table-striped tb-bordered">
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="15%" class="text-center"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- memanggil form modal--}}
    @includeIf('member.form')
@endsection


@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('member.data') }}'
                },
                columns: [
                    {data: 'select_all', searchable:false, sortable:false},
                    {data: 'DT_RowIndex', searchable:false, sortable:false},
                    {data: 'kode_member'},
                    {data: 'nama'},
                    {data: 'telepon'},
                    {data: 'alamat'},
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
            $('#modal-form .modal-title').text('Tambah Member Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        // function edit
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Member');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama]').focus();

            // ambil datanya berdasarkan url / id
            $.get(url) 
                .done((response) => {
                    $('#modal-form [name=nama]').val(response.nama);
                    $('#modal-form [name=telepon]').val(response.telepon);
                    $('#modal-form [name=alamat]').val(response.alamat);
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

        // function cetak member
        function cetakMember(url){
            // apakah ada data yang di checklist
            if($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            }else{
                $('.form-member')
                .attr('action', url)
                .attr('target', '_blank')
                .submit(); 
            }
        }
    </script>
@endpush