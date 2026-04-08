@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Pantau Pengembalian</h3></div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Keterangan</th></tr></thead>
            <tbody>
            @foreach($peminjamans as $i => $p)
            @php $terlambat = now()->gt($p->tgl_kembali) && !$p->pengembalian; @endphp
            <tr class="{{ $terlambat ? 'danger' : '' }}">
                <td>{{ $peminjamans->firstItem() + $i }}</td>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
                <td><span class="label label-success">Disetujui</span></td>
                <td>{{ $terlambat ? '<span class="label label-danger">TERLAMBAT</span>' : 'Belum dikembalikan' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection
