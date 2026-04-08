@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Persetujuan Peminjaman</h3></div>
    <div class="panel-body">
        @if($peminjamans->isEmpty())
            <div class="alert alert-info">Tidak ada peminjaman yang menunggu persetujuan.</div>
        @else
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $peminjamans->firstItem() + $i }}</td>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
                <td>
                    <form action="{{ route('petugas.setujui', $p) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-success btn-xs" onclick="return confirm('Setujui peminjaman ini?')">Setujui</button>
                    </form>
                    <form action="{{ route('petugas.tolak', $p) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-xs" onclick="return confirm('Tolak peminjaman ini?')">Tolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $peminjamans->links() }}
        @endif
    </div>
</div>
@endsection
