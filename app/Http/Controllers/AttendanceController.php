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
        return view('attendance.index', [
            'attendances' => Attendance::with('member')->orderByDesc('check_in_time')->get(),
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
