@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Edit Alat</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.alat.update', $alat) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ $alat->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi</label>
                <select name="kondisi" class="form-control" required>
                    @foreach(['baik','rusak','perbaikan'] as $k)
                        <option value="{{ $k }}" {{ $alat->kondisi === $k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="tersedia" {{ $alat->status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ $alat->status === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $alat->jumlah) }}" min="1" required>
            </div>
            <a href="{{ route('admin.alat.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
