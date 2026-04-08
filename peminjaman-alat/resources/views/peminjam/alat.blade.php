@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Daftar Alat Tersedia</h3></div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Nama Alat</th><th>Kategori</th><th>Kondisi</th><th>Jumlah</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($alats as $i => $alat)
            <tr>
                <td>{{ $alats->firstItem() + $i }}</td>
                <td>{{ $alat->nama_alat }}</td>
                <td>{{ $alat->kategori->nama_kategori }}</td>
                <td><span class="label label-success">{{ ucfirst($alat->kondisi) }}</span></td>
                <td>{{ $alat->jumlah }}</td>
                <td>
                    <a href="{{ route('peminjam.ajukan') }}?alat_id={{ $alat->id }}" class="btn btn-primary btn-xs">Pinjam</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $alats->links() }}
    </div>
</div>
@endsection
