<?php

namespace App\Services;

use App\Models\Locker;
use App\Models\LockerAssignment;
use App\Models\Member;
use Carbon\Carbon;

class LockerService
{
    public function assignLocker(Member $member, Locker $locker, ?string $expiryDate = null, bool $temporary = false): LockerAssignment
    {
        if ($locker->status !== Locker::STATUS_AVAILABLE) {
            throw new \InvalidArgumentException('Only available lockers can be assigned.');
        }

        if ($member->lockerAssignment()->active()->exists()) {
            throw new \InvalidArgumentException('This member already has an active locker assignment.');
        }

        $assignment = LockerAssignment::create([
            'locker_id' => $locker->id,
            'member_id' => $member->id,
            'assigned_at' => now(),
            'expiry_date' => $expiryDate ? Carbon::parse($expiryDate)->toDateString() : null,
            'temporary' => $temporary,
        ]);

        $locker->update(['status' => Locker::STATUS_OCCUPIED]);

        return $assignment;
    }

    public function releaseLocker(LockerAssignment $assignment): LockerAssignment
    {
        if ($assignment->returned_at) {
            return $assignment;
        }

        $assignment->update(['returned_at' => now()]);

        $locker = $assignment->locker;
        $locker->update(['status' => Locker::STATUS_AVAILABLE]);

        return $assignment;
    }

    public function releaseExpiredAssignments(): int
    {
        $assignments = LockerAssignment::active()
            ->where(function ($query) {
                $query->whereDate('expiry_date', '<', now()->toDateString())
                    ->orWhereHas('member', function ($query) {
                        $query->whereDate('expiry_date', '<', now()->toDateString());
                    });
            })
            ->get();

        foreach ($assignments as $assignment) {
            $this->releaseLocker($assignment);
        }

        return $assignments->count();
    }

    public function getFirstAvailableLocker(): ?Locker
    {
        return Locker::where('status', Locker::STATUS_AVAILABLE)
            ->orderBy('locker_number')
            ->first();
    }

    public function getAllLockers()
    {
        return Locker::with(['activeAssignment.member'])
            ->orderBy('locker_number')
            ->get();
    }
}
