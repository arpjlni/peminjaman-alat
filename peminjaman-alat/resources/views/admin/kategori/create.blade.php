@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Tambah Kategori</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <div class="form-group {{ $errors->has('nama_kategori') ? 'has-error' : '' }}">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}" required>
                @error('nama_kategori')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
