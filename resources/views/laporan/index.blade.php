@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <button onclick="updatePeriode()" class="btn btn-success btn-flat btn-xs"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                    <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-info btn-flat btn-xs"><i class="fa fa-file"></i> Export PDF</a>

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
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Penjualan</th>
                            <th class="text-center">Pembelian</th>
                            <th class="text-center">Pengeluaran</th>
                            <th class="text-center">Pendapatan</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- memanggil form modal--}}
    @includeIf('laporan.form')
@endsection


@push('scripts')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('AdminLTE-2') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}'
                },
                columns: [
                    {data: 'DT_RowIndex', searchable:false, sortable:false},
                    {data: 'tanggal'},
                    {data: 'penjualan'},
                    {data: 'pembelian'},
                    {data: 'pengeluaran'},
                    {data: 'pendapatan'},
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false
            });

            // datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

        });

        // function ubah periode
        function updatePeriode() {
            $('#modal-form').modal('show');
        }
    </script>
@endpush