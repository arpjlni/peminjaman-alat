<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Peminjaman Alat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body { padding-top: 70px; background: #f5f5f5; }
        .sidebar { min-height: calc(100vh - 70px); background: #2c3e50; padding-top: 20px; }
        .sidebar a { color: #bdc3c7; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { background: #34495e; color: #fff; }
        .sidebar .menu-title { color: #7f8c8d; font-size: 11px; padding: 10px 20px 5px; text-transform: uppercase; }
        .main-content { padding: 20px; }
        .navbar-brand { font-weight: bold; }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand">Peminjaman Alat</span>
        </div>
        <div class="navbar-right" style="padding:15px;">
            <span class="text-white">Halo, {{ auth()->user()->nama }} ({{ ucfirst(auth()->user()->role) }})</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                <button type="submit" class="btn btn-danger btn-xs">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            @if(auth()->user()->isAdmin())
                <div class="menu-title">Admin Menu</div>
                <a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-home"></span> Dashboard</a>
                <a href="{{ route('admin.users.index') }}"><span class="glyphicon glyphicon-user"></span> Kelola User</a>
                <a href="{{ route('admin.kategori.index') }}"><span class="glyphicon glyphicon-tags"></span> Kategori</a>
                <a href="{{ route('admin.alat.index') }}"><span class="glyphicon glyphicon-wrench"></span> Alat</a>
                <a href="{{ route('admin.peminjaman.index') }}"><span class="glyphicon glyphicon-list-alt"></span> Peminjaman</a>
                <a href="{{ route('admin.pengembalian.index') }}"><span class="glyphicon glyphicon-ok"></span> Pengembalian</a>
                <a href="{{ route('admin.log.index') }}"><span class="glyphicon glyphicon-time"></span> Log Aktivitas</a>
            @elseif(auth()->user()->isPetugas())
                <div class="menu-title">Petugas Menu</div>
                <a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-home"></span> Dashboard</a>
                <a href="{{ route('petugas.persetujuan') }}"><span class="glyphicon glyphicon-check"></span> Persetujuan</a>
                <a href="{{ route('petugas.pengembalian') }}"><span class="glyphicon glyphicon-refresh"></span> Pengembalian</a>
                <a href="{{ route('petugas.laporan') }}"><span class="glyphicon glyphicon-print"></span> Laporan</a>
            @else
                <div class="menu-title">Peminjam Menu</div>
                <a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-home"></span> Dashboard</a>
                <a href="{{ route('peminjam.alat') }}"><span class="glyphicon glyphicon-wrench"></span> Daftar Alat</a>
                <a href="{{ route('peminjam.ajukan') }}"><span class="glyphicon glyphicon-plus"></span> Ajukan Pinjam</a>
                <a href="{{ route('peminjam.riwayat') }}"><span class="glyphicon glyphicon-list"></span> Riwayat</a>
            @endif
        </div>

        <div class="col-md-10 main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
