<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'membersCount' => Member::count(),
            'plansCount' => Plan::count(),
            'paymentsCount' => Payment::count(),
            'expiringSoon' => Member::whereBetween('expiry_date', [now()->toDateString(), now()->addDays(3)->toDateString()])->get(),
            'expired' => Member::where('expiry_date', '<', now()->toDateString())->get(),
        ]);
    }
}
