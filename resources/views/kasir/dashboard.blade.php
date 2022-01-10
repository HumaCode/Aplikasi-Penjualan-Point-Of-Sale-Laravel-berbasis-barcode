@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body text-center">
                    <h1 class="text-info"><strong> Selamat Datang {{ auth()->user()->name }}</strong></h1>
                    <hr style="width: 200px;">
                    <h2>Anda login sebagai KASIR</h2>
                    <br><br>
                    <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg btn-flat">Transaksi Baru</a>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
@endsection
