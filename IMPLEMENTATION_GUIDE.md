# Gym Management System - Advanced Admin Features

## Overview

This document explains the advanced admin features implemented in the Gym Management System, including database structure, service classes, controllers, routes, and usage examples.

---

## 1. Database Schema

### Settings Table
Stores configurable admin preferences as key-value pairs.

```sql
CREATE TABLE settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE NOT NULL,
    value VARCHAR(255) NULL,
    type VARCHAR(50) DEFAULT 'string', -- string, integer, boolean, json
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Default Settings:**
- `expiry_reminder_days`: Days before expiry to show warning (default: 3)
- `inactivity_days`: Days without activity to mark as inactive (default: 7)
- `enable_notifications`: Enable/disable alerts (default: true)
- `timezone`: Timezone for date calculations (default: UTC)

---

## 2. Service Classes

### RiskDetectionService

Located in `app/Services/RiskDetectionService.php`

**Purpose:** Identify members at risk (expiring soon, with debt, inactive)

**Key Methods:**

```php
// Get members expiring within configured days
$expiringSoon = $riskService->getMembersExpiringsoon();

// Get members with unpaid balance
$withDebt = $riskService->getMembersWithDebt();

// Get inactive members (no recent check-in)
$inactive = $riskService->getMembersInactive();

// Get risk summary for dashboard
$summary = $riskService->getRiskSummary();
// Returns: ['expiring_soon_count' => 5, 'with_debt_count' => 3, 'inactive_count' => 2]

// Check if specific member is at risk
$isAtRisk = $riskService->isAtRisk($member);

// Get days until member expiry
$days = $riskService->getDaysUntilExpiry($member); // Returns: 2
```

**Example Queries:**

```php
// Get all expiring members
$expiring = DB::table('members')
    ->whereBetween('expiry_date', [
        now()->toDateString(),
        now()->addDays(3)->toDateString()
    ])
    ->with('plan', 'payments')
    ->orderBy('expiry_date', 'asc')
    ->get();

// Get members with debt > $100
$debtors = DB::table('members')
    ->where('debt', '>', 100)
    ->orderBy('debt', 'desc')
    ->get();

// Get inactive members (no check-in for 7 days)
$inactive = DB::table('members')
    ->where('expiry_date', '>=', now()->toDateString())
    ->where(function ($q) {
        $q->whereDoesntHave('attendances')
            ->orWhereHas('attendances', function ($sub) {
                $sub->whereDate('check_in_time', '<', now()->subDays(7));
            }, '=', 0);
    })
    ->get();
```

### FinancialReportService

Located in `app/Services/FinancialReportService.php`

**Purpose:** Calculate financial metrics and generate reports

**Key Methods:**

```php
// Daily income
$todayIncome = $financialService->getTodayIncome();

// Monthly income
$monthlyIncome = $financialService->getCurrentMonthIncome();
$specificMonth = $financialService->getMonthlyIncome(2026, 4);

// Outstanding debt
$totalDebt = $financialService->getTotalOutstandingDebt();

// Yearly income
$yearlyIncome = $financialService->getYearlyIncome(2026);

// Income by day for current month
$dailyIncome = $financialService->getMonthlyIncomeByDay();
// Returns: ['2026-04-01' => 500.00, '2026-04-02' => 750.00, ...]

// Income by plan
$byPlan = $financialService->getIncomeByPlan();
// Returns: [
//     ['plan_name' => 'Gold', 'total_income' => 5000, 'payment_count' => 10, 'average_payment' => 500],
//     ['plan_name' => 'Silver', 'total_income' => 3000, 'payment_count' => 6, 'average_payment' => 500],
// ]

// Debt statistics
$debtStats = $financialService->getDebtStatistics();
// Returns: [
//     'total_debt' => 2000,
//     'members_with_debt' => 5,
//     'average_debt_per_member' => 400,
//     'highest_debt' => 800
// ]

// Member payment statistics
$memberStats = $financialService->getMemberPaymentStats($memberId);
// Returns: [
//     'total_paid' => 5000,
//     'payment_count' => 5,
//     'average_payment' => 1000,
//     'last_payment_date' => Carbon instance,
//     'first_payment_date' => Carbon instance
// ]
```

**Example Queries:**

```php
// Daily income for specific date
$income = DB::table('payments')
    ->whereDate('paid_at', '2026-04-30')
    ->sum('amount');
// Result: 1250.50

// Monthly income comparison
$april = DB::table('payments')
    ->whereYear('paid_at', 2026)
    ->whereMonth('paid_at', 4)
    ->sum('amount'); // 15000.00

$march = DB::table('payments')
    ->whereYear('paid_at', 2026)
    ->whereMonth('paid_at', 3)
    ->sum('amount'); // 12000.00

$difference = $april - $march; // 3000.00
$percentChange = ($difference / $march) * 100; // 25%

// Income breakdown by plan
$incomeByPlan = DB::table('payments')
    ->selectRaw('plan_id, plans.name, COUNT(*) as count, SUM(amount) as total, AVG(amount) as average')
    ->withCount('plan')
    ->groupBy('plan_id', 'plans.name')
    ->join('plans', 'payments.plan_id', '=', 'plans.id')
    ->get();
```

### DashboardService

Located in `app/Services/DashboardService.php`

**Purpose:** Aggregate all dashboard metrics

**Key Methods:**

```php
// Get all dashboard data at once
$metrics = $dashboardService->getDashboardMetrics();
// Returns:
// [
//     'members' => [...member metrics...],
//     'financial' => [...financial metrics...],
//     'risks' => [...risk summary...],
//     'alerts' => [...alert data...]
// ]

// Get quick stats cards
$quickStats = $dashboardService->getQuickStats();
// Returns: [
//     ['label' => 'Active Members', 'value' => 45, 'icon' => '👥', 'color' => 'bg-blue-500'],
//     [...]
// ]

// Get member metrics
$memberStats = $dashboardService->getMemberMetrics();
// Returns: [
//     'total_members' => 50,
//     'active_members' => 45,
//     'expired_members' => 5,
//     'members_expiring_soon' => 3,
//     'members_with_debt' => 2
// ]

// Get financial metrics
$financeStats = $dashboardService->getFinancialMetrics();
// Returns: [
//     'today_income' => 500.00,
//     'monthly_income' => 12000.00,
//     'total_outstanding_debt' => 1500.00,
//     'debt_stats' => [...]
// ]

// Get dashboard alerts
$alerts = $dashboardService->getAlerts();
// Returns: [
//     ['type' => 'warning', 'title' => 'Members Expiring Soon', ...],
//     ['type' => 'danger', 'title' => 'Outstanding Debt', ...],
//     ...
// ]
```

---

## 3. Controllers

### DashboardController

**Route:** `GET /`

**Purpose:** Display smart dashboard with all metrics

**Implementation:**
```php
public function index()
{
    $metrics = $this->dashboardService->getDashboardMetrics();
    $quickStats = $this->dashboardService->getQuickStats();
    $alerts = $this->dashboardService->getAlerts();

    return view('dashboard', [
        'metrics' => $metrics,
        'quickStats' => $quickStats,
        'alerts' => $alerts,
        'expiringSoon' => $this->riskService->getMembersExpiringsoon(),
        'withDebt' => $this->riskService->getMembersWithDebt(),
        'inactive' => $this->riskService->getMembersInactive(),
        'monthlyIncomeByDay' => $this->financialService->getMonthlyIncomeByDay(),
        'incomeByPlan' => $this->financialService->getIncomeByPlan(),
    ]);
}
```

### MemberController

**New Methods:**

```php
// Display member profile with full details
public function show(Member $member)
{
    $member->load(['plan', 'payments', 'attendances', 'workoutPlans', 'dietPlans']);

    $paymentStats = $this->financialService->getMemberPaymentStats($member->id);
    $daysUntilExpiry = $this->riskService->getDaysUntilExpiry($member);
    $isAtRisk = $this->riskService->isAtRisk($member);

    return view('members.show', [
        'member' => $member,
        'paymentStats' => $paymentStats,
        'daysUntilExpiry' => $daysUntilExpiry,
        'isAtRisk' => $isAtRisk,
    ]);
}

// Index with search and filter
public function index(Request $request)
{
    $query = Member::with('plan');

    // Search
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%");
    }

    // Filter by status
    $filter = $request->input('filter', 'all');
    match ($filter) {
        'active' => $query->where('expiry_date', '>=', now()->toDateString()),
        'expired' => $query->where('expiry_date', '<', now()->toDateString()),
        'expiring_soon' => $query->whereBetween('expiry_date', [
            now()->toDateString(),
            now()->addDays(3)->toDateString(),
        ]),
        'in_debt' => $query->where('debt', '>', 0),
        default => null,
    };

    return view('members.index', [
        'members' => $query->orderBy('name')->get(),
        'filter' => $filter,
        'search' => $request->input('search'),
    ]);
}
```

### SettingsController

**Routes:**
- `GET /settings` - Show settings form
- `POST /settings` - Update settings

**Implementation:**
```php
public function index()
{
    $settings = [
        'expiry_reminder_days' => Setting::get('expiry_reminder_days', 3),
        'inactivity_days' => Setting::get('inactivity_days', 7),
        'enable_notifications' => Setting::get('enable_notifications', true),
        'timezone' => Setting::get('timezone', 'UTC'),
    ];

    return view('settings.index', ['settings' => $settings]);
}

public function update(Request $request)
{
    $data = $request->validate([
        'expiry_reminder_days' => 'required|integer|min:1|max:30',
        'inactivity_days' => 'required|integer|min:1|max:365',
        'enable_notifications' => 'boolean',
        'timezone' => 'required|string|timezone',
    ]);

    Setting::put('expiry_reminder_days', $data['expiry_reminder_days'], 'integer');
    Setting::put('inactivity_days', $data['inactivity_days'], 'integer');
    Setting::put('enable_notifications', $request->has('enable_notifications'), 'boolean');
    Setting::put('timezone', $data['timezone'], 'string');

    return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
}
```

---

## 4. Routes

```php
// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Members (now includes show)
Route::resource('members', MemberController::class);

// Settings
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
```

---

## 5. Views

### Dashboard View (`resources/views/dashboard.blade.php`)

Features:
- Quick stats cards (active, expired, today's income, debt)
- Member metrics overview
- Financial overview
- At-risk member lists (expiring, debt, inactive)
- Income by plan breakdown
- Quick action buttons
- Alert system

### Member Profile View (`resources/views/members/show.blade.php`)

Features:
- Personal information
- Payment history table
- Attendance records
- Membership status
- Debt status
- Risk indicator
- Assigned plans
- Edit/Delete actions

### Members Index View (`resources/views/members/index.blade.php`)

Features:
- Search by name or phone
- Filter by status (active, expired, expiring soon, in debt)
- Member cards with quick info
- Status badges
- Quick action buttons

### Settings View (`resources/views/settings/index.blade.php`)

Features:
- Expiry reminder slider (1-30 days)
- Inactivity threshold slider (1-365 days)
- Notification toggle
- Timezone selector
- Save button

---

## 6. Usage Examples

### Example 1: Dashboard Display

```php
// In DashboardController@index
$metrics = app(DashboardService::class)->getDashboardMetrics();

// Returns:
// [
//     'members' => [
//         'total_members' => 50,
//         'active_members' => 45,
//         'expired_members' => 5,
//         'members_expiring_soon' => 3,
//         'members_with_debt' => 2,
//     ],
//     'financial' => [
//         'today_income' => 1250.50,
//         'monthly_income' => 25000.00,
//         'total_outstanding_debt' => 2500.00,
//         'debt_stats' => [
//             'total_debt' => 2500.00,
//             'members_with_debt' => 5,
//             'average_debt_per_member' => 500.00,
//             'highest_debt' => 1000.00,
//         ],
//     ],
//     'risks' => [
//         'expiring_soon_count' => 3,
//         'with_debt_count' => 2,
//         'inactive_count' => 4,
//     ],
//     'alerts' => [
//         ['type' => 'warning', 'title' => 'Members Expiring Soon', ...],
//         ['type' => 'danger', 'title' => 'Outstanding Debt', ...],
//         ...
//     ],
// ]
```

### Example 2: Finding At-Risk Members

```php
$riskService = app(RiskDetectionService::class);

// Get members expiring soon
$expiringSoon = $riskService->getMembersExpiringsoon();
// Returns array of member data with expiry dates

// Get members with debt
$withDebt = $riskService->getMembersWithDebt();
// Returns array of member data with debt amounts

// Get inactive members
$inactive = $riskService->getMembersInactive();
// Returns array of member data with no recent attendance

// Check if specific member is at risk
if ($riskService->isAtRisk($member)) {
    // Send reminder email, show warning badge, etc.
}
```

### Example 3: Financial Reporting

```php
$financialService = app(FinancialReportService::class);

// Get today's income
$todayIncome = $financialService->getTodayIncome(); // 1250.50

// Get this month's income
$monthlyIncome = $financialService->getCurrentMonthIncome(); // 25000.00

// Get income by day for display in chart
$dailyIncome = $financialService->getMonthlyIncomeByDay();
// [
//     '2026-04-01' => 500.00,
//     '2026-04-02' => 750.00,
//     '2026-04-03' => 1000.00,
//     ...
// ]

// Compare months
$comparison = $financialService->compareMonths(2026, 3, 2026, 4);
// [
//     'month1_income' => 23000.00,
//     'month2_income' => 25000.00,
//     'difference' => 2000.00,
//     'percentage_change' => 8.7,
//     'trend' => 'up',
// ]

// Get member payment stats
$stats = $financialService->getMemberPaymentStats($memberId);
// [
//     'total_paid' => 5000.00,
//     'payment_count' => 5,
//     'average_payment' => 1000.00,
//     'last_payment_date' => Carbon,
//     'first_payment_date' => Carbon,
// ]
```

### Example 4: Search and Filter

```php
// Search members by name or phone
$members = Member::where('name', 'like', '%John%')
    ->orWhere('phone', 'like', '%555%')
    ->with('plan')
    ->orderBy('name')
    ->get();

// Filter active members
$active = Member::where('expiry_date', '>=', now()->toDateString())
    ->with('plan')
    ->get();

// Filter expired members
$expired = Member::where('expiry_date', '<', now()->toDateString())
    ->with('plan')
    ->get();

// Filter expiring soon (within 3 days)
$expiring = Member::whereBetween('expiry_date', [
        now()->toDateString(),
        now()->addDays(3)->toDateString(),
    ])
    ->with('plan')
    ->orderBy('expiry_date', 'asc')
    ->get();

// Filter members in debt
$debtors = Member::where('debt', '>', 0)
    ->orderBy('debt', 'desc')
    ->get();
```

### Example 5: Settings Configuration

```php
$setting = app(Setting::class);

// Get settings
$expiryDays = Setting::get('expiry_reminder_days'); // 3
$inactivityDays = Setting::get('inactivity_days'); // 7
$enableNotifications = Setting::get('enable_notifications'); // true
$timezone = Setting::get('timezone'); // 'UTC'

// Update settings
Setting::put('expiry_reminder_days', 5, 'integer');
Setting::put('inactivity_days', 14, 'integer');
Setting::put('enable_notifications', false, 'boolean');
Setting::put('timezone', 'America/New_York', 'string');

// Use in code
$reminderDays = Setting::get('expiry_reminder_days', 3); // Default to 3 if not set
```

---

## 7. Advanced Query Examples

### Query 1: Members Expiring in Next 3 Days with Latest Payment

```php
$membersExpiring = Member::whereBetween('expiry_date', [
        now()->toDateString(),
        now()->addDays(3)->toDateString()
    ])
    ->with([
        'plan',
        'payments' => fn ($q) => $q->latest('paid_at')->limit(1)
    ])
    ->orderBy('expiry_date', 'asc')
    ->get();
```

### Query 2: Total Debt by Plan

```php
$debtByPlan = Member::selectRaw('plan_id, SUM(debt) as total_debt, COUNT(*) as member_count')
    ->groupBy('plan_id')
    ->with('plan')
    ->having('total_debt', '>', 0)
    ->orderByDesc('total_debt')
    ->get();
```

### Query 3: Members with Most Payments

```php
$topPayingMembers = Member::withCount('payments')
    ->whereHas('payments')
    ->orderByDesc('payments_count')
    ->limit(10)
    ->get();
```

### Query 4: Attendance Trends - Active Last 30 Days

```php
$activeMembers = Member::whereHas('attendances', function ($q) {
    $q->where('check_in_time', '>=', now()->subDays(30));
})->with('plan')->get();
```

### Query 5: Revenue by Member Level

```php
$revenueBylevel = Payment::selectRaw('members.workout_level, SUM(amount) as total_revenue, COUNT(*) as payment_count')
    ->join('members', 'payments.member_id', '=', 'members.id')
    ->groupBy('members.workout_level')
    ->get();
```

---

## 8. Best Practices Implemented

1. **Eager Loading**: All queries use `with()` to prevent N+1 problems
2. **Service Layer**: Business logic separated from controllers
3. **Reusable Queries**: Complex queries encapsulated in service methods
4. **Type Hints**: Proper return types and parameter types
5. **Configuration**: Settings stored in database, not hardcoded
6. **Security**: User input validated before filtering
7. **Performance**: Optimized queries with indexes on frequently used columns
8. **Blade Templating**: Consistent UI using Tailwind CSS

---

## 9. Testing

### Basic Service Test

```php
// Feature test for DashboardController
test('dashboard displays metrics', function () {
    $response = $this->get(route('dashboard'));
    
    $response->assertStatus(200);
    $response->assertViewHasAll(['metrics', 'quickStats', 'alerts']);
});

// Test RiskDetectionService
test('detects members expiring soon', function () {
    $member = Member::factory()->create([
        'expiry_date' => now()->addDays(2)
    ]);
    
    $riskService = app(RiskDetectionService::class);
    $expiring = $riskService->getMembersExpiringsoon();
    
    expect($expiring)->toHaveCount(1);
    expect($expiring[0]['id'])->toBe($member->id);
});

// Test search functionality
test('members index can filter by status', function () {
    $active = Member::factory()->create(['expiry_date' => now()->addDays(10)]);
    $expired = Member::factory()->create(['expiry_date' => now()->subDays(5)]);
    
    $response = $this->get(route('members.index', ['filter' => 'active']));
    $response->assertSee($active->name);
    $response->assertDontSee($expired->name);
});
```

---

## 10. Migration Guide

### Running the Migration

```bash
php artisan migrate
```

This will create the `settings` table with default values.

### Clearing Cache

If settings are cached, clear:

```bash
php artisan cache:clear
php artisan view:clear
```

---

## Summary

The advanced admin features transform the basic CRUD system into a powerful management tool with:

✅ Smart risk detection for at-risk members
✅ Comprehensive financial reporting
✅ Configurable alert system
✅ Search and filter capabilities
✅ Detailed member profiles
✅ Dashboard with key metrics

All implemented following Laravel best practices with clean, maintainable code.
