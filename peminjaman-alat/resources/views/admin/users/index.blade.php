@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Kelola User
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-xs pull-right">+ Tambah User</a>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>Username</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td>{{ $users->firstItem() + $i }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="label label-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'petugas' ? 'warning' : 'info') }}">{{ ucfirst($user->role) }}</span></td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-xs">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus user ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
