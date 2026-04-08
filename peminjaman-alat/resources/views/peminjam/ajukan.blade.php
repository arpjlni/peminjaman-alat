@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Ajukan Peminjaman</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('peminjam.ajukan.store') }}">
            @csrf
            <div class="form-group {{ $errors->has('alat_id') ? 'has-error' : '' }}">
                <label>Pilih Alat</label>
                <select name="alat_id" class="form-control" required>
                    <option value="">-- Pilih Alat --</option>
                    @foreach($alats as $a)
                        <option value="{{ $a->id }}" {{ (request('alat_id') == $a->id || old('alat_id') == $a->id) ? 'selected' : '' }}>
                            {{ $a->nama_alat }} ({{ $a->kategori->nama_kategori }})
                        </option>
                    @endforeach
                </select>
                @error('alat_id')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group {{ $errors->has('tgl_pinjam') ? 'has-error' : '' }}">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" class="form-control" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                @error('tgl_pinjam')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group {{ $errors->has('tgl_kembali') ? 'has-error' : '' }}">
                <label>Tanggal Kembali (Rencana)</label>
                <input type="date" name="tgl_kembali" class="form-control" value="{{ old('tgl_kembali') }}" required>
                @error('tgl_kembali')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="alert alert-info">
                <span class="glyphicon glyphicon-info-sign"></span>
                Denda keterlambatan: <strong>Rp 5.000 / hari</strong>
            </div>
            <a href="{{ route('peminjam.alat') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        </form>
    </div>
</div>
@endsection
