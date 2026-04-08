@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Kelola Kategori
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-xs pull-right">+ Tambah</a>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Nama Kategori</th><th>Jumlah Alat</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($kategoris as $i => $k)
            <tr>
                <td>{{ $kategoris->firstItem() + $i }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>{{ $k->alat_count }}</td>
                <td>
                    <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-warning btn-xs">Edit</a>
                    <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $kategoris->links() }}
    </div>
</div>
@endsection
