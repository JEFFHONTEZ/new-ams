<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $attendances = Attendance::latest()->take(10)->get();

        return view('admin.dashboard', compact('users', 'attendances'));
    }

    // === CRUD for Users ===
    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'password' => 'required|min:6'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|string',
        ]);

        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }

    // === Reports ===
    public function reports(Request $request)
    {
        $period = $request->get('period', 'daily'); // daily, weekly, monthly

        if ($period === 'weekly') {
            $attendances = Attendance::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->get();
        } elseif ($period === 'monthly') {
            $attendances = Attendance::whereMonth('created_at', now()->month)->get();
        } else {
            $attendances = Attendance::whereDate('created_at', today())->get();
        }

        return view('admin.reports', compact('attendances', 'period'));
    }
}
