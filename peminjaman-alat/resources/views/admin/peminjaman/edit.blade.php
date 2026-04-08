@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Edit Status Peminjaman</h3></div>
    <div class="panel-body">
        <table class="table table-bordered" style="margin-bottom:20px;">
            <tr><th>Peminjam</th><td>{{ $peminjaman->user->nama }}</td></tr>
            <tr><th>Alat</th><td>{{ $peminjaman->alat->nama_alat }}</td></tr>
            <tr><th>Tgl Pinjam</th><td>{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td></tr>
            <tr><th>Tgl Kembali</th><td>{{ $peminjaman->tgl_kembali->format('d/m/Y') }}</td></tr>
        </table>
        <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Status Peminjaman</label>
                <select name="status_peminjaman" class="form-control" required>
                    @foreach(['menunggu','disetujui','ditolak','dikembalikan'] as $s)
                        <option value="{{ $s }}" {{ $peminjaman->status_peminjaman === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
