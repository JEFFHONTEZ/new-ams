<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    protected $service;

    public function __construct(AttendanceService $service)
    {
        $this->service = $service;
    }

    public function checkIn(Request $request)
    {
        $request->validate(['employee_id' => 'required|string']);
        $actor = $request->user();

        try {
            $attendance = $this->service->checkIn($actor, $request->employee_id, $request->method ?? 'manual');
            return back()->with('success', 'Checked in: ' . $attendance->user->name);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function checkOut(Request $request)
    {
        $request->validate(['employee_id' => 'required|string']);
        $actor = $request->user();

        try {
            $attendance = $this->service->checkOut($actor, $request->employee_id, $request->method ?? 'manual');
            return back()->with('success', 'Checked out: ' . $attendance->user->name);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
