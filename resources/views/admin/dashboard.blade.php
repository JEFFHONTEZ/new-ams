@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add User</a>

    <h4>Users</h4>
    <table class="table table-bordered">
        <tr>
            <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <h4>Recent Attendance</h4>
    <table class="table table-striped">
        <tr><th>User</th><th>Check In</th><th>Check Out</th></tr>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ $attendance->user->name }}</td>
            <td>{{ $attendance->check_in }}</td>
            <td>{{ $attendance->check_out ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
