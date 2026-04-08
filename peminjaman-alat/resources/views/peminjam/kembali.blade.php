@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Form Pengembalian Alat</h3></div>
    <div class="panel-body">
        <table class="table table-bordered" style="margin-bottom:20px;">
            <tr><th>Alat</th><td>{{ $peminjaman->alat->nama_alat }}</td></tr>
            <tr><th>Tgl Pinjam</th><td>{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td></tr>
            <tr><th>Tgl Kembali (Rencana)</th><td>{{ $peminjaman->tgl_kembali->format('d/m/Y') }}</td></tr>
        </table>

        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-warning-sign"></span>
            Jika terlambat, denda <strong>Rp 5.000 / hari</strong> akan dikenakan.
        </div>

        <form method="POST" action="{{ route('peminjam.kembali.store', $peminjaman) }}">
            @csrf
            <div class="form-group {{ $errors->has('tgl_pengembalian') ? 'has-error' : '' }}">
                <label>Tanggal Pengembalian</label>
                <input type="date" name="tgl_pengembalian" class="form-control" value="{{ old('tgl_pengembalian', date('Y-m-d')) }}" required>
                @error('tgl_pengembalian')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Kondisi Alat Saat Dikembalikan</label>
                <select name="kondisi_alat" class="form-control" required>
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="perbaikan">Perlu Perbaikan</option>
                </select>
            </div>
            <a href="{{ route('peminjam.riwayat') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
        </form>
    </div>
</div>
@endsection
