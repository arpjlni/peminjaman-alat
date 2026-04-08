@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Edit User</h3></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                @error('username')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Password Baru <small>(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    @foreach(['admin','petugas','peminjam'] as $role)
                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
