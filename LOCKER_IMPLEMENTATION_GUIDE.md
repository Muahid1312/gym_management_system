# Locker Management System – Implementation Guide

## 🎯 Overview

A complete, production-ready **Locker Management System** for the Gym Management app. Features:
- ✅ Visual locker grid with status colors (green/red/yellow)
- ✅ Smart locker assignment (prevents duplicates, suggests first available)
- ✅ Auto-release on membership expiry
- ✅ Temporary daily-use lockers
- ✅ Offline form support (syncs when online)
- ✅ Member profile integration

---

## 📁 Files Implemented

### 1. Database Migrations

#### `database/migrations/2026_05_04_000001_create_lockers_table.php`
```sql
CREATE TABLE lockers (
  id INT PRIMARY KEY,
  locker_number VARCHAR(32) UNIQUE,
  status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
  created_at, updated_at
)
```

#### `database/migrations/2026_05_04_000002_create_locker_assignments_table.php`
```sql
CREATE TABLE locker_assignments (
  id INT PRIMARY KEY,
  locker_id INT FOREIGN KEY → lockers.id,
  member_id INT FOREIGN KEY → members.id,
  assigned_at DATETIME DEFAULT NOW(),
  expiry_date DATE nullable,
  temporary BOOLEAN DEFAULT false,
  returned_at DATETIME nullable,
  created_at, updated_at
)
```

---

### 2. Models

#### `app/Models/Locker.php`
- Statuses: `available`, `occupied`, `maintenance`
- Relations:
  - `assignments()` – all historical assignments
  - `activeAssignment()` – current assignment (if any)

#### `app/Models/LockerAssignment.php`
- Relations:
  - `locker()` – belongsTo
  - `member()` – belongsTo
- Scope: `active()` – filters `whereNull('returned_at')`

#### `app/Models/Member.php` (Updated)
- Added:
  - `lockerAssignment()` – hasOne (currently active)
  - `lockerHistory()` – hasMany (all assignments)

---

### 3. Service Class

#### `app/Services/LockerService.php`

**Core Methods:**

```php
assignLocker(Member $member, Locker $locker, ?string $expiryDate, bool $temporary): LockerAssignment
// Validates locker is available & member has no active assignment
// Creates assignment & updates locker status to occupied

releaseLocker(LockerAssignment $assignment): LockerAssignment
// Marks assignment as returned
// Sets locker back to available

releaseExpiredAssignments(): int
// Auto-called in controller index()
// Finds active assignments where:
//   - locker expiry_date < today OR
//   - member expiry_date < today
// Releases them & returns count

getFirstAvailableLocker(): ?Locker
// Suggests first available locker (ordered by locker_number)

getAllLockers()
// Returns all lockers with eager-loaded activeAssignment.member
```

---

### 4. Controller

#### `app/Http/Controllers/LockerController.php`

**Actions:**

| Action | Method | Purpose |
|--------|--------|---------|
| `index()` | GET `/lockers` | Grid + assignment form |
| `create()` | GET `/lockers/create` | Create locker form |
| `store()` | POST `/lockers` | Save new locker |
| `assign()` | POST `/lockers/assign` | Assign locker to member |
| `release()` | POST `/lockers/{locker}/release` | Release & make available |

**Key Logic:**
- `index()` calls `releaseExpiredAssignments()` automatically
- `assign()` accepts generic form data (member_id, locker_id)
- Validates constraints & delegates to service

---

### 5. Routes

```php
Route::resource('lockers', LockerController::class)->except(['show']);
Route::post('lockers/assign', [LockerController::class, 'assign'])->name('lockers.assign');
Route::post('lockers/{locker}/release', [LockerController::class, 'release'])->name('lockers.release');
```

---

### 6. UI Components

#### `resources/views/lockers/index.blade.php`

**Layout:**
- Left column: Assignment form
- Right column: Locker grid (3-column responsive)

**Form:**
- Member dropdown (excludes members with active assignments)
- Locker dropdown (available only)
- Expiry date (optional)
- Temporary checkbox (daily usage flag)

**Grid:**
- Each locker shows:
  - **Locker number** (prominent)
  - **Status badge** (green/red/yellow)
  - **Assigned member** (if occupied)
  - **Expiry date** (if has one)
  - **Release button** (if occupied)

**Color Scheme:**
- 🟢 **Available**: `bg-emerald-100 text-emerald-700`
- 🔴 **Occupied**: `bg-rose-100 text-rose-700`
- 🟡 **Maintenance**: `bg-amber-100 text-amber-700`

#### `resources/views/lockers/create.blade.php`

Simple form to create new locker:
- Locker number (unique)
- Status dropdown
- Submit button

#### `resources/views/members/show.blade.php` (Updated)

Added "Locker Assignment" card showing:
- Current locker number
- Expiry date
- "Occupied" badge
- Link to locker grid

---

### 7. Offline Support

**Generalized offline form handling** in `resources/views/layouts/app.blade.php`:

All forms with `data-offline-sync="true"` are intercepted when offline:

```html
<form action="{{ route('lockers.assign') }}" 
      method="POST" 
      data-offline-sync="true">
```

**Behavior:**
1. User submits form while offline
2. Form prevented from submitting (JavaScript)
3. Request queued: `{ url, method, payload }`
4. User sees: "Saved locally, will sync when online"
5. When reconnected → all queued requests replay automatically
6. Navbar shows "Back Online" status

**Queue Storage:** `localStorage['gym_offline_queue']`

**Service Worker Caching:** Updated to cache:
- `/lockers`
- `/lockers/create`

---

## 🚀 Usage Flow

### 1. Creating a Locker
1. Click **Lockers** in sidebar
2. Click **Create Locker** button
3. Enter locker number (e.g., "A-1", "B-2")
4. Select status (usually "available")
5. Submit → redirects to grid

### 2. Assigning a Locker
1. In **Locker Management** page:
2. Select member from dropdown
3. Select locker from dropdown (auto-filtered to available)
4. (Optional) Set custom expiry date
5. (Optional) Check "Temporary daily usage"
6. Click **Assign Locker**

**Result:**
- Assignment created
- Locker status → "occupied"
- Grid updates
- Member profile shows locker card

### 3. Releasing a Locker
1. Find occupied locker in grid
2. Click **Release Locker** button
3. Locker → "available"
4. Previous member can get new locker

### 4. Auto-Release
1. System runs on every page load (no cronjob needed)
2. If membership expires → all assignments auto-released
3. If locker expiry passes → auto-released

---

## 🔌 Integration Points

### Member Profile Card
```html
<div class="card">
    <h2>Locker Assignment</h2>
    @if($member->lockerAssignment)
        Locker: {{ $member->lockerAssignment->locker->locker_number }}
    @endif
</div>
```

### Dashboard Stats (Optional)
```php
Locker::where('status', 'available')->count()
Locker::where('status', 'occupied')->count()
LockerAssignment::active()->count()
```

---

## 🧪 Testing Endpoints

### Terminal Commands

```bash
# Run migrations
php artisan migrate

# Create test data
php artisan tinker
> $locker = \App\Models\Locker::create(['locker_number' => 'A-1', 'status' => 'available']);
> $member = \App\Models\Member::first();
> app(\App\Services\LockerService::class)->assignLocker($member, $locker);
```

### In Browser

1. **Create Locker:** `POST /lockers`
2. **View Grid:** `GET /lockers`
3. **Assign:** `POST /lockers/assign` (form)
4. **Release:** `POST /lockers/{id}/release` (button)
5. **Member Profile:** `GET /members/{id}` (should show locker card)

---

## 🛡️ Security & Validation

✅ **Request Validation:**
- locker_number: required, string, unique
- status: required, enum
- member_id: exists:members,id
- locker_id: exists:lockers,id

✅ **Business Rules:**
- Only available lockers can be assigned
- One active assignment per member (enforced in service)
- Cannot assign occupied locker

✅ **Offline:**
- All forms include CSRF token in queue
- Queued requests validated server-side on replay

---

## 📋 Checklist

- [x] Migrations created & link relations
- [x] Models with correct relationships
- [x] Service class with all logic
- [x] Controller endpoints working
- [x] Routes configured
- [x] Blade UI with grid view
- [x] Color-coded status badges
- [x] Offline form support
- [x] Member profile integration
- [x] Auto-release logic
- [x] Navigation updated
- [x] Service worker caching
- [x] No syntax errors
- [x] Production-ready

---

## 🔄 Workflow Example

**Scenario:** John joins gym with 30-day membership + gets locker

1. **Day 1:** Admin creates locker "A-1" (status: available)
2. **Day 1:** Admin assigns "A-1" to John
   - LockerAssignment created
   - Locker status → occupied
   - John's profile shows "A-1"
3. **Day 15:** John is on member page (works offline too)
4. **Day 31:** System detects John's membership expired
   - On next page load → auto-releases locker
   - Status → available
   - Can assign to another member
5. **Day 31:** Admin releases locker → reusable

---

## 🎨 UI/UX Features

| Feature | Status |
|---------|--------|
| Locker grid (visual) | ✅ 3-column responsive |
| Color-coded status | ✅ Green/red/yellow |
| Smart suggestion | ✅ First available shown |
| Assignment form | ✅ Filtered dropdowns |
| Member integration | ✅ Shows in profile |
| Offline support | ✅ Auto-queues & syncs |
| Auto-release | ✅ On page load |
| History tracking | ✅ Via LockerAssignment |

---

## 🔧 Future Enhancements (Optional)

1. **API Endpoint:** `GET /api/lockers/{id}/assignment` (for QR scanning)
2. **Locker History Page:** View all past assignments for a locker
3. **Member Locker History:** Timeline of all lockers used
4. **Bulk Import:** CSV to create lockers
5. **Scheduled Release:** Cron job for auto-release (backup to page-load check)
6. **Notifications:** Email when locker expires
7. **Locker Edit:** Change locker number, maintenance status
8. **Permissions:** Allow staff to manage only certain locker zones

---

## 📝 Notes

- All forms automatically sync offline — no extra configuration needed
- Service runs in-request (no queue/scheduler required)
- Locker expiry optional — can leave null for indefinite use
- Temporary flag for day-pass style usage (both regular & daily supported)
- Member profile loads locker assignment eager-loaded (no N+1)
- First-available suggestion prevents manual searching

**Ready to go live!** 🚀
