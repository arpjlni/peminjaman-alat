@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Laporan Peminjaman</h3></div>
    <div class="panel-body">
        <form method="GET" class="form-inline" style="margin-bottom:15px;">
            <div class="form-group">
                <label>Dari: </label>
                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="form-group">
                <label>Sampai: </label>
                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    @foreach(['menunggu','disetujui','ditolak','dikembalikan'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" class="btn btn-success" target="_blank">
                <span class="glyphicon glyphicon-print"></span> Cetak
            </a>
        </form>

        <div class="alert alert-info">Total Denda Terkumpul: <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong></div>

        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Peminjam</th><th>Alat</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Denda</th></tr></thead>
            <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->alat->nama_alat }}</td>
                <td>{{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tgl_kembali->format('d/m/Y') }}</td>
                <td>{{ ucfirst($p->status_peminjaman) }}</td>
                <td>{{ $p->pengembalian && $p->pengembalian->denda > 0 ? 'Rp ' . number_format($p->pengembalian->denda, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
