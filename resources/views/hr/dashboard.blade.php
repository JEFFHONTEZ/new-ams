@extends('layouts.app')

@section('content')
<div class="container">
    <h2>HR Dashboard</h2>

    <a href="{{ route('hr.employees.create') }}" class="btn btn-primary mb-3">Add Employee/Intern</a>

    <h4>Employees</h4>
    <table class="table table-bordered">
        <tr>
            <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
        </tr>
        @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->name }}</td><td>{{ $emp->email }}</td><td>{{ $emp->role }}</td>
            <td>
                <a href="{{ route('hr.employees.edit', $emp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('hr.employees.delete', $emp->id) }}" method="POST" style="display:inline">
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
