@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Data Peminjaman
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary btn-xs pull-right">+ Tambah</a>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $peminjamans->firstItem() + $i }}</td>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
                <td>
                    @php $colors = ['menunggu'=>'warning','disetujui'=>'success','ditolak'=>'danger','dikembalikan'=>'info']; @endphp
                    <span class="label label-{{ $colors[$p->status_peminjaman] }}">{{ ucfirst($p->status_peminjaman) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.peminjaman.edit', $p) }}" class="btn btn-warning btn-xs">Edit</a>
                    <form action="{{ route('admin.peminjaman.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection
