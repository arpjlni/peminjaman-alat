@extends('layouts.app')
@section('content')
<h2>Dashboard Petugas</h2>
<div class="row" style="margin-top:20px;">
    <div class="col-md-4">
        <div class="panel panel-warning">
            <div class="panel-heading"><h3 class="panel-title">Menunggu Persetujuan</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['menunggu'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading"><h3 class="panel-title">Sedang Dipinjam</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['disetujui'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Sudah Dikembalikan</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['dikembalikan'] }}</h2></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <a href="{{ route('petugas.persetujuan') }}" class="btn btn-warning btn-lg btn-block">
            <span class="glyphicon glyphicon-check"></span> Kelola Persetujuan
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('petugas.laporan') }}" class="btn btn-info btn-lg btn-block">
            <span class="glyphicon glyphicon-print"></span> Cetak Laporan
        </a>
    </div>
</div>
@endsection
