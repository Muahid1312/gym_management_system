<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendancesQuery = Attendance::with('member')->orderByDesc('check_in_time');
        $attendances = $attendancesQuery->paginate(10);

        $todayCount = Attendance::whereDate('check_in_time', now()->toDateString())->count();
        $monthCount = Attendance::whereYear('check_in_time', now()->year)->whereMonth('check_in_time', now()->month)->count();

        // simple 7-day average
        $sevenDayCounts = Attendance::whereBetween('check_in_time', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->selectRaw('DATE(check_in_time) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->pluck('cnt')
            ->toArray();

        $weekAverage = count($sevenDayCounts) ? round(array_sum($sevenDayCounts) / count($sevenDayCounts)) : 0;

        return view('attendance-modern', [
            'attendances' => $attendances,
            'todayCount' => $todayCount,
            'weekAverage' => $weekAverage,
            'monthCount' => $monthCount,
        ]);
    }

    public function checkIn(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        $attendance = Attendance::where('qr_code', $request->qr_code)->first();

        if (!$attendance) {
            return response()->json(['error' => 'Invalid QR code'], 400);
        }

        $attendance->update(['check_in_time' => now()]);

        return response()->json(['success' => 'Checked in']);
    }

    public function generateQr(Member $member)
    {
        $qrCode = uniqid();
        Attendance::create([
            'member_id' => $member->id,
            'qr_code' => $qrCode,
            'check_in_time' => now(),
        ]);

        $qrImage = QrCode::size(200)->generate($qrCode);

        return view('attendance.qr', compact('qrImage', 'member'));
    }
}
