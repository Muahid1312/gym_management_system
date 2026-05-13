<?php

namespace App\Models;

use App\Models\LockerAssignment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'plan_id',
        'partner_id',
        'join_date',
        'expiry_date',
        'workout_level',
        'diet_level',
        'debt',
    ];

    protected $casts = [
        'join_date' => 'date',
        'expiry_date' => 'date',
        'debt' => 'decimal:2',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function workoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }

    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

    public function lockerAssignment()
    {
        return $this->hasOne(LockerAssignment::class)->whereNull('returned_at');
    }

    public function lockerHistory()
    {
        return $this->hasMany(LockerAssignment::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function extendExpiry(Plan $plan): void
    {
        $baseDate = now();

        if ($this->expiry_date && $this->expiry_date->greaterThan($baseDate)) {
            $baseDate = $this->expiry_date;
        }

        $this->expiry_date = $baseDate->copy()->addDays($plan->duration_days);

        if (empty($this->join_date)) {
            $this->join_date = now()->toDateString();
        }

        $this->save();
    }
}
