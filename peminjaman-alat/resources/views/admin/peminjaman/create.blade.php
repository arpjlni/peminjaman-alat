@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Tambah Data Peminjaman</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.peminjaman.store') }}">
            @csrf
            <div class="form-group">
                <label>User (Peminjam)</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    @foreach(\App\Models\User::where('role','peminjam')->get() as $u)
                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Alat</label>
                <select name="alat_id" class="form-control" required>
                    <option value="">-- Pilih Alat --</option>
                    @foreach($alats as $a)
                        <option value="{{ $a->id }}">{{ $a->nama_alat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Tanggal Kembali (Rencana)</label>
                <input type="date" name="tgl_kembali" class="form-control" required>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
