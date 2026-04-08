@extends('layouts.app')
@section('content')
<h2>Dashboard Peminjam</h2>
<div class="row" style="margin-top:20px;">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Peminjaman Aktif</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['peminjaman_aktif'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Total Riwayat</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['riwayat'] }}</h2></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <a href="{{ route('peminjam.ajukan') }}" class="btn btn-primary btn-lg btn-block">
            <span class="glyphicon glyphicon-plus"></span> Ajukan Peminjaman
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('peminjam.riwayat') }}" class="btn btn-default btn-lg btn-block">
            <span class="glyphicon glyphicon-list"></span> Lihat Riwayat
        </a>
    </div>
</div>
@endsection
