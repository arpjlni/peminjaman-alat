@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Data Pengembalian</h3></div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Kembali</th><th>Kondisi</th><th>Denda</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($pengembalians as $i => $p)
            <tr>
                <td>{{ $pengembalians->firstItem() + $i }}</td>
                <td>{{ $p->peminjaman->user->nama }}</td>
                <td>{{ $p->peminjaman->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pengembalian->format('d/m/Y') }}</td>
                <td>{{ ucfirst($p->kondisi_alat) }}</td>
                <td>{{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}</td>
                <td>
                    <form action="{{ route('admin.pengembalian.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection
