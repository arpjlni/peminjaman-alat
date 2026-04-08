@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Tambah User</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                @error('username')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                @error('nama')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="peminjam" selected>Peminjam</option>
                </select>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
