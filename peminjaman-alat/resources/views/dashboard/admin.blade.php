@extends('layouts.app')
@section('content')
<h2>Dashboard Admin</h2>
<div class="row" style="margin-top:20px;">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">Total Alat</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['total_alat'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-heading"><h3 class="panel-title">Total User</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['total_user'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Total Peminjaman</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['total_peminjaman'] }}</h2></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-warning">
            <div class="panel-heading"><h3 class="panel-title">Menunggu Persetujuan</h3></div>
            <div class="panel-body text-center"><h2>{{ $data['menunggu'] }}</h2></div>
        </div>
    </div>
</div>
@endsection
