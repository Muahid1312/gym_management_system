<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\Member;
use App\Services\LockerService;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function __construct(private LockerService $lockerService)
    {
    }

    public function index(Request $request)
    {
        $this->lockerService->releaseExpiredAssignments();

        $lockers = $this->lockerService->getAllLockers();
        $availableLockers = Locker::where('status', Locker::STATUS_AVAILABLE)->orderBy('locker_number')->get();
        $firstAvailableLocker = $this->lockerService->getFirstAvailableLocker();
        $members = Member::whereDoesntHave('lockerAssignment', function ($query) {
            $query->whereNull('returned_at');
        })->orderBy('name')->get();

        $selectedMemberId = $request->query('member');

        return view('lockers.index', [
            'lockers' => $lockers,
            'availableLockers' => $availableLockers,
            'firstAvailableLocker' => $firstAvailableLocker,
            'members' => $members,
            'selectedMemberId' => $selectedMemberId,
        ]);
    }

    public function create()
    {
        return view('lockers.create', [
            'statuses' => Locker::statuses(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locker_number' => 'required|string|max:32|unique:lockers,locker_number',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Locker::create($request->only('locker_number', 'status'));

        return redirect()->route('lockers.index')->with('success', 'Locker created successfully.');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'locker_id' => 'required|exists:lockers,id',
            'expiry_date' => 'nullable|date',
            'temporary' => 'sometimes|boolean',
        ]);

        $member = Member::findOrFail($request->input('member_id'));
        $locker = Locker::findOrFail($request->input('locker_id'));

        $this->lockerService->assignLocker(
            $member,
            $locker,
            $request->input('expiry_date'),
            $request->boolean('temporary'),
        );

        return redirect()->route('lockers.index')->with('success', "Locker {$locker->locker_number} assigned to {$member->name}.");
    }

    public function release(Request $request, Locker $locker)
    {
        $assignment = $locker->activeAssignment()->first();

        if (!$assignment) {
            return redirect()->route('lockers.index')->with('error', 'No active assignment found for this locker.');
        }

        $this->lockerService->releaseLocker($assignment);

        return redirect()->route('lockers.index')->with('success', "Locker {$locker->locker_number} is now available.");
    }
}
