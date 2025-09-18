@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Gateman Attendance Panel</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-900 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-200 text-red-900 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-8">
        <!-- Check In -->
        <div class="p-6 border rounded shadow">
            <h2 class="text-xl mb-4">Check In</h2>
            <form method="POST" action="{{ route('attendance.checkin') }}">
                @csrf
                <label for="employee_id" class="block mb-2">Employee ID</label>
                <input type="text" id="employee_id" name="employee_id" class="w-full p-2 border rounded mb-4" autofocus required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Check In</button>
            </form>
        </div>

        <!-- Check Out -->
        <div class="p-6 border rounded shadow">
            <h2 class="text-xl mb-4">Check Out</h2>
            <form method="POST" action="{{ route('attendance.checkout') }}">
                @csrf
                <label for="employee_id_out" class="block mb-2">Employee ID</label>
                <input type="text" id="employee_id_out" name="employee_id" class="w-full p-2 border rounded mb-4" required>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Check Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
