@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Riwayat Peminjaman Saya</h3></div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $peminjamans->firstItem() + $i }}</td>
                <td>{{ $p->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
                <td>
                    @php $colors = ['menunggu'=>'warning','disetujui'=>'success','ditolak'=>'danger','dikembalikan'=>'info']; @endphp
                    <span class="label label-{{ $colors[$p->status_peminjaman] }}">{{ ucfirst($p->status_peminjaman) }}</span>
                </td>
                <td>{{ $p->pengembalian && $p->pengembalian->denda > 0 ? 'Rp ' . number_format($p->pengembalian->denda, 0, ',', '.') : '-' }}</td>
                <td>
                    @if($p->status_peminjaman === 'disetujui')
                        <a href="{{ route('peminjam.kembali', $p) }}" class="btn btn-info btn-xs">Kembalikan</a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection
