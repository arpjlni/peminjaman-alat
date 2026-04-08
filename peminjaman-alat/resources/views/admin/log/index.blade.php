@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Log Aktivitas</h3></div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>User</th><th>Role</th><th>Aktivitas</th><th>Waktu</th></tr></thead>
            <tbody>
            @foreach($logs as $i => $log)
            <tr>
                <td>{{ $logs->firstItem() + $i }}</td>
                <td>{{ $log->user->nama }}</td>
                <td><span class="label label-default">{{ ucfirst($log->user->role) }}</span></td>
                <td>{{ $log->aktivitas }}</td>
                <td>{{ \Carbon\Carbon::parse($log->waktu)->format('d/m/Y H:i:s') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
