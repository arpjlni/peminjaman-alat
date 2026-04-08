@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Tambah Alat</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.alat.store') }}">
            @csrf
            <div class="form-group {{ $errors->has('nama_alat') ? 'has-error' : '' }}">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat') }}" required>
                @error('nama_alat')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi</label>
                <select name="kondisi" class="form-control" required>
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="perbaikan">Perbaikan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1" required>
            </div>
            <a href="{{ route('admin.alat.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
