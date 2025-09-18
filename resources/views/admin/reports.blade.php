@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Attendance Reports ({{ ucfirst($period) }})</h2>

    <form method="GET" action="{{ route('admin.reports') }}" class="mb-3">
        <select name="period" class="form-control d-inline w-auto">
            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
        </select>
        <button type="submit" class="btn btn-secondary">View</button>
    </form>

    <table class="table table-striped">
        <tr>
            <th>User</th><th>Check In</th><th>Check Out</th><th>Date</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ $attendance->user->name }}</td>
            <td>{{ $attendance->check_in }}</td>
            <td>{{ $attendance->check_out ?? 'N/A' }}</td>
            <td>{{ $attendance->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
