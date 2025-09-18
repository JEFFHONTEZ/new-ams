<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function checkIn(User $actor, string $employeeId, string $method = 'manual'): Attendance
    {
        $employee = User::where('employee_id', $employeeId)->firstOrFail();
        $date = now()->toDateString();

        return DB::transaction(function () use ($employee, $actor, $date, $method) {
            $attendance = Attendance::firstOrNew([
                'user_id' => $employee->id,
                'date' => $date,
            ]);

            if ($attendance->check_in_at) {
                throw new \Exception("Already checked in today.");
            }

            $attendance->check_in_at = now();
            $attendance->signed_by_user_id = $actor->id;
            $attendance->method = $method;
            $attendance->save();

            AuditLog::create([
                'actor_user_id' => $actor->id,
                'action' => 'check-in',
                'resource_type' => 'attendance',
                'resource_id' => $attendance->id,
                'meta' => json_encode(['employee_id' => $employee->employee_id]),
            ]);

            return $attendance;
        });
    }

    public function checkOut(User $actor, string $employeeId, string $method = 'manual'): Attendance
    {
        $employee = User::where('employee_id', $employeeId)->firstOrFail();
        $date = now()->toDateString();

        return DB::transaction(function () use ($employee, $actor, $date, $method) {
            $attendance = Attendance::where('user_id', $employee->id)
                ->where('date', $date)
                ->firstOrFail();

            if ($attendance->check_out_at) {
                throw new \Exception("Already checked out today.");
            }

            $attendance->check_out_at = now();
            $attendance->signed_by_user_id = $actor->id;
            $attendance->method = $method;
            $attendance->save();

            AuditLog::create([
                'actor_user_id' => $actor->id,
                'action' => 'check-out',
                'resource_type' => 'attendance',
                'resource_id' => $attendance->id,
                'meta' => json_encode(['employee_id' => $employee->employee_id]),
            ]);

            return $attendance;
        });
    }
}
