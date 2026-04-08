@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Kelola Alat
            <a href="{{ route('admin.alat.create') }}" class="btn btn-primary btn-xs pull-right">+ Tambah Alat</a>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Nama Alat</th><th>Kategori</th><th>Kondisi</th><th>Status</th><th>Jumlah</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($alats as $i => $alat)
            <tr>
                <td>{{ $alats->firstItem() + $i }}</td>
                <td>{{ $alat->nama_alat }}</td>
                <td>{{ $alat->kategori->nama_kategori }}</td>
                <td><span class="label label-{{ $alat->kondisi === 'baik' ? 'success' : 'danger' }}">{{ ucfirst($alat->kondisi) }}</span></td>
                <td><span class="label label-{{ $alat->status === 'tersedia' ? 'success' : 'warning' }}">{{ ucfirst($alat->status) }}</span></td>
                <td>{{ $alat->jumlah }}</td>
                <td>
                    <a href="{{ route('admin.alat.edit', $alat) }}" class="btn btn-warning btn-xs">Edit</a>
                    <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $alats->links() }}
    </div>
</div>
@endsection
