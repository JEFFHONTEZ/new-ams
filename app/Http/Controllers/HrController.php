<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;

class HrController extends Controller
{
    public function index()
    {
        $employees = User::whereIn('role', ['employee', 'intern'])->get();
        $attendances = Attendance::latest()->take(10)->get();

        return view('hr.dashboard', compact('employees', 'attendances'));
    }

    // === CRUD for Employees & Interns ===
    public function createEmployee()
    {
        return view('hr.create-employee');
    }

    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string|in:employee,intern',
            'password' => 'required|min:6'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('hr.dashboard')->with('success', 'Employee created successfully');
    }

    public function editEmployee($id)
    {
        $user = User::findOrFail($id);
        return view('hr.edit-employee', compact('user'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|string|in:employee,intern',
        ]);

        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('hr.dashboard')->with('success', 'Employee updated successfully');
    }

    public function deleteEmployee($id)
    {
        User::destroy($id);
        return redirect()->route('hr.dashboard')->with('success', 'Employee deleted successfully');
    }

    // === Reports ===
    public function reports(Request $request)
    {
        $period = $request->get('period', 'daily');

        if ($period === 'weekly') {
            $attendances = Attendance::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->get();
        } elseif ($period === 'monthly') {
            $attendances = Attendance::whereMonth('created_at', now()->month)->get();
        } else {
            $attendances = Attendance::whereDate('created_at', today())->get();
        }

        return view('hr.reports', compact('attendances', 'period'));
    }
}
