<?php

namespace App\Services;

use App\Models\Member;
use App\Notifications\MembershipExpiryNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendExpiryNotifications()
    {
        $nearExpiry = Member::whereBetween('expiry_date', [now()->toDateString(), now()->addDays(3)->toDateString()])
            ->whereNotNull('email')
            ->get();

        foreach ($nearExpiry as $member) {
            $days = now()->diffInDays($member->expiry_date, false);
            $status = $days <= 1 ? 'near' : 'near';
            Notification::route('mail', $member->email)
                ->notify(new MembershipExpiryNotification($member, $status));
        }

        $expired = Member::where('expiry_date', '<', now()->toDateString())
            ->whereNotNull('email')
            ->get();

        foreach ($expired as $member) {
            Notification::route('mail', $member->email)
                ->notify(new MembershipExpiryNotification($member, 'expired'));
        }
    }
}
