@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Employee/Intern</h2>

    <form method="POST" action="{{ route('hr.employees.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="intern" {{ $user->role == 'intern' ? 'selected' : '' }}>Intern</option>
            </select>
        </div>

        <div class="mb-3">
            <label>New Password (leave blank to keep existing)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
