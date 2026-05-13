# Complete Feature Implementation Guide

This document provides a comprehensive overview of all implemented features in the Gym Management System, including the **Locker Management System** and **AI-Powered Workout & Diet Plan Generator**.

---

## Table of Contents

1. [Locker Management System](#locker-management-system)
2. [AI Workout & Diet Plan Generator](#ai-workout--diet-plan-generator)
3. [PDF Export](#pdf-export)
4. [Database Migrations](#database-migrations)
5. [Routes & Endpoints](#routes--endpoints)
6. [Testing](#testing)
7. [Python AI Integration (Optional)](#python-ai-integration-optional)

---

## Locker Management System

### Overview

A complete locker management solution allowing gyms to:
- Create and manage lockers
- Assign lockers to members
- Auto-release expired lockers
- Track locker history

### Features

#### 1. **Create Lockers**
- Unique locker numbers
- Status tracking: `available`, `occupied`, `maintenance`
- Visual locker grid dashboard

**File:** [app/Http/Controllers/LockerController.php](app/Http/Controllers/LockerController.php)
**View:** [resources/views/lockers/create.blade.php](resources/views/lockers/create.blade.php)

```php
// Create a locker via POST /lockers
Locker::create([
    'locker_number' => 'A-001',
    'status' => 'available'
]);
```

#### 2. **Assign Lockers to Members**
- Prevent assigning occupied lockers
- Optional expiry date
- Temporary (daily) usage flag
- One active locker per member

**Service:** [app/Services/LockerService.php](app/Services/LockerService.php) → `assignLocker()`

```php
$lockerService->assignLocker(
    member: $member,
    locker: $locker,
    expiryDate: '2026-06-01',
    temporary: false
);
```

#### 3. **Auto-Release Expired Lockers**
Automatically release lockers when:
- Locker expiry date is reached, OR
- Member's membership expires

**Method:** [LockerService::releaseExpiredAssignments()](app/Services/LockerService.php#L47)

```php
// Called in LockerController::index()
$this->lockerService->releaseExpiredAssignments();
```

#### 4. **Locker Grid Dashboard**
Visual display of all lockers with:
- Color-coded status badges (Green = available, Red = occupied, Amber = maintenance)
- Member assignment details
- Quick-access release buttons

**View:** [resources/views/lockers/index.blade.php](resources/views/lockers/index.blade.php)

### Models & Relationships

#### Locker Model
```php
class Locker extends Model
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_MAINTENANCE = 'maintenance';
    
    public function assignments()
    public function activeAssignment()
}
```

#### LockerAssignment Model
```php
class LockerAssignment extends Model
{
    public function locker()
    public function member()
    public function scopeActive($query)  // whereNull('returned_at')
}
```

#### Member Model Relations
```php
public function lockerAssignment()      // Active locker
public function lockerHistory()         // All past & present
```

### Database Schema

**Lockers Table:**
```sql
CREATE TABLE lockers (
    id BIGINT PRIMARY KEY,
    locker_number VARCHAR(32) UNIQUE,
    status ENUM('available', 'occupied', 'maintenance'),
    timestamps
);
```

**Locker Assignments Table:**
```sql
CREATE TABLE locker_assignments (
    id BIGINT PRIMARY KEY,
    locker_id BIGINT (FK: lockers.id),
    member_id BIGINT (FK: members.id),
    assigned_at DATETIME,
    expiry_date DATE (nullable),
    temporary BOOLEAN,
    returned_at DATETIME (nullable),
    timestamps
);
```

**Migration Files:**
- [2026_05_04_000001_create_lockers_table.php](database/migrations/2026_05_04_000001_create_lockers_table.php)
- [2026_05_04_000002_create_locker_assignments_table.php](database/migrations/2026_05_04_000002_create_locker_assignments_table.php)

### Routes

| Method | Route | Action | Name |
|--------|-------|--------|------|
| GET | `/lockers` | List all lockers | `lockers.index` |
| GET | `/lockers/create` | Show create form | `lockers.create` |
| POST | `/lockers` | Store new locker | `lockers.store` |
| POST | `/lockers/assign` | Assign locker to member | `lockers.assign` |
| POST | `/lockers/{locker}/release` | Release locker | `lockers.release` |

---

## AI Workout & Diet Plan Generator

### Overview

An intelligent system for generating personalized workout and diet plans based on:
- Age, Weight, Height
- Fitness Goal (Fat Loss, Muscle Gain, General Fitness)
- Experience Level (Beginner, Intermediate, Advanced)

### Features

#### 1. **AI Workout Plan Generation**

Generates a structured 7-day workout program:
- **Day 1:** Chest & Triceps (Bench Press, Incline Press, Flyes, Dips)
- **Day 2:** Back & Biceps (Pull-ups, Rows, Lat Pulldown, Curls)
- **Day 3:** Rest/Cardio
- **Day 4:** Legs (Squats, Deadlifts, Lunges, Leg Press)
- **Day 5:** Shoulders & Core
- **Day 6:** Full Body
- **Day 7:** Recovery

Each exercise includes:
- Sets and reps (adjusted by level)
- Exercise-specific notes
- Goal-appropriate coaching tips

**Service:** [app/Services/AIService.php](app/Services/AIService.php) → `generateWorkoutPlan()`

```php
$plan = $aiService->generateWorkoutPlan([
    'age' => 28,
    'weight' => 75,
    'height' => 180,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate'
]);
```

#### 2. **AI Diet Plan Generation**

Generates a daily meal plan with:
- **Breakfast, Lunch, Dinner, Snacks**
- Foods suited to goals and affordable
- Macro targets (protein, carbs, fats)
- Calorie distribution

Macro ratios by goal:
- **Fat Loss:** 35% protein, 40% carbs, 25% fats
- **Muscle Gain:** 30% protein, 50% carbs, 20% fats
- **General Fitness:** 30% protein, 40% carbs, 30% fats

**Service:** [app/Services/AIService.php](app/Services/AIService.php) → `generateDietPlan()`

```php
$plan = $aiService->generateDietPlan([
    'age' => 28,
    'weight' => 75,
    'height' => 180,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate'
]);
```

#### 3. **Plan Persistence**

Plans are saved to the database with full input data:

**WorkoutPlan Model:**
```php
WorkoutPlan::create([
    'member_id' => 1,
    'age' => 28,
    'weight' => 75,
    'height' => 180,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate',
    'plan_data' => array // Full 7-day plan
]);
```

**DietPlan Model:**
```php
DietPlan::create([
    'member_id' => 1,
    'age' => 28,
    'weight' => 75,
    'height' => 180,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate',
    'plan_data' => array // Breakfast, Lunch, Dinner, Snacks
]);
```

#### 4. **Plan Display**

Show plans with:
- BMI calculation
- BMI category (Underweight, Normal, Overweight, Obese)
- Formatted exercises with sets/reps
- Daily meal breakdowns
- Macro summaries
- Delete functionality

**View:** [resources/views/plans/show.blade.php](resources/views/plans/show.blade.php)

#### 5. **Multiple Plans Per Member**

Members can generate multiple plans and keep history. Latest plan is shown by default.

### Models & Relationships

#### WorkoutPlan Model
```php
class WorkoutPlan extends Model
{
    protected $fillable = ['member_id', 'age', 'weight', 'height', 'goal', 'level', 'plan_data'];
    protected $casts = ['plan_data' => 'array', 'weight' => 'decimal:2'];
    
    public function member()
}
```

#### DietPlan Model
```php
class DietPlan extends Model
{
    protected $fillable = ['member_id', 'age', 'weight', 'height', 'goal', 'level', 'plan_data'];
    protected $casts = ['plan_data' => 'array', 'weight' => 'decimal:2'];
    
    public function member()
}
```

#### Member Relations
```php
public function workoutPlans()    // hasMany
public function dietPlans()       // hasMany
```

### Database Schema

**Workout Plans Table:**
```sql
CREATE TABLE workout_plans (
    id BIGINT PRIMARY KEY,
    member_id BIGINT (FK: members.id),
    age INT,
    weight DECIMAL(8,2),
    height INT,
    goal ENUM('Fat Loss', 'Muscle Gain', 'General Fitness'),
    level ENUM('Beginner', 'Intermediate', 'Advanced'),
    plan_data JSON,
    timestamps
);
```

**Diet Plans Table:**
```sql
CREATE TABLE diet_plans (
    id BIGINT PRIMARY KEY,
    member_id BIGINT (FK: members.id),
    age INT,
    weight DECIMAL(8,2),
    height INT,
    goal ENUM('Fat Loss', 'Muscle Gain', 'General Fitness'),
    level ENUM('Beginner', 'Intermediate', 'Advanced'),
    plan_data JSON,
    timestamps
);
```

**Migration Files:**
- [2026_04_30_000008_create_workout_plans_table.php](database/migrations/2026_04_30_000008_create_workout_plans_table.php)
- [2026_04_30_000009_create_diet_plans_table.php](database/migrations/2026_04_30_000009_create_diet_plans_table.php)

### Routes

| Method | Route | Action | Name |
|--------|-------|--------|------|
| GET | `/members/{member}/generate-plans` | Show generation form | `ai.generate` |
| POST | `/members/{member}/generate-workout` | Generate workout plan | `ai.workout` |
| POST | `/members/{member}/generate-diet` | Generate diet plan | `ai.diet` |
| GET | `/members/{member}/plans` | View generated plans | `ai.show-plans` |
| DELETE | `/workout-plans/{plan}` | Delete workout plan | `plans.workout.delete` |
| DELETE | `/diet-plans/{plan}` | Delete diet plan | `plans.diet.delete` |

---

## PDF Export

### Overview

Combines workout and diet plans into a professional, printable 2-page PDF.

### Features

#### 1. **Unified PDF Generation**

Combines latest workout + diet plans into a single downloadable PDF.

**Service:** [app/Services/PlanService.php](app/Services/PlanService.php) → `generateCombinedPdf()`

```php
return $this->planService->generateCombinedPdf($member);
// Downloads: plan_<member_id>_<member_name>.pdf
```

#### 2. **PDF Layout**

**Page 1: Workout Plan**
- Header with title and member name
- Member info (name, goal, level, age)
- 7-day workout schedule (2-column layout)
- Each day shows muscle groups and exercises with sets/reps

**Page 2: Diet Plan**
- Header with title and member name
- Member info (name, goal, level, height/weight)
- Daily macro summary (Total Calories, Protein, Carbs, Fats)
- Meal breakdown (Breakfast, Lunch, Dinner, Snacks)
- Each meal shows foods and macro distribution

#### 3. **Clean, Print-Optimized Design**

- Professional typography (Segoe UI)
- Color-coded sections
- Proper spacing and margins
- Page breaks for multi-page output
- Print-friendly CSS media queries

**Template:** [resources/views/plans/pdf.blade.php](resources/views/plans/pdf.blade.php)

### Dependencies

- **Laravel DomPDF:** [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- Configured in `composer.json` (already installed)

```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('plans.pdf', $data)
    ->setPaper('a4')
    ->setOption('margin-top', 10)
    ->download('filename.pdf');
```

### Routes

| Method | Route | Action | Name |
|--------|-------|--------|------|
| GET | `/members/{member}/plans/download-pdf` | Download combined PDF | `ai.download-pdf` |

---

## Database Migrations

### Status

All migrations have been created and should be up-to-date:

| Migration | File | Table | Status |
|-----------|------|-------|--------|
| Lockers | [2026_05_04_000001](database/migrations/2026_05_04_000001_create_lockers_table.php) | `lockers` | ✅ |
| Locker Assignments | [2026_05_04_000002](database/migrations/2026_05_04_000002_create_locker_assignments_table.php) | `locker_assignments` | ✅ |
| Workout Plans | [2026_04_30_000008](database/migrations/2026_04_30_000008_create_workout_plans_table.php) | `workout_plans` | ✅ |
| Diet Plans | [2026_04_30_000009](database/migrations/2026_04_30_000009_create_diet_plans_table.php) | `diet_plans` | ✅ |

### Run Migrations

```bash
php artisan migrate
```

### Rollback (if needed)

```bash
php artisan migrate:rollback
```

---

## Routes & Endpoints

All routes are defined in [routes/web.php](routes/web.php).

### Locker Management Routes

```php
Route::resource('lockers', LockerController::class)->except(['show']);
Route::post('lockers/assign', [LockerController::class, 'assign'])->name('lockers.assign');
Route::post('lockers/{locker}/release', [LockerController::class, 'release'])->name('lockers.release');
```

### AI Plans Routes

```php
Route::post('members/{member}/generate-workout', [AIController::class, 'generateWorkoutPlan'])->name('ai.workout');
Route::post('members/{member}/generate-diet', [AIController::class, 'generateDietPlan'])->name('ai.diet');
Route::get('members/{member}/generate-plans', [AIController::class, 'showGeneratePlanForm'])->name('ai.generate');
Route::get('members/{member}/plans', [AIController::class, 'showPlans'])->name('ai.show-plans');
Route::get('members/{member}/plans/download-pdf', [AIController::class, 'downloadPdf'])->name('ai.download-pdf');
Route::delete('workout-plans/{plan}', [AIController::class, 'deleteWorkoutPlan'])->name('plans.workout.delete');
Route::delete('diet-plans/{plan}', [AIController::class, 'deleteDietPlan'])->name('plans.diet.delete');
```

---

## Testing

### Controllers

#### LockerController

```php
// tests/Feature/LockerControllerTest.php
test('can create locker', function () { ... });
test('can assign locker to member', function () { ... });
test('can release locker', function () { ... });
test('auto-releases expired lockers', function () { ... });
```

#### AIController

```php
// tests/Feature/AIControllerTest.php
test('can generate workout plan', function () { ... });
test('can generate diet plan', function () { ... });
test('can download combined pdf', function () { ... });
test('can delete workout plan', function () { ... });
test('can delete diet plan', function () { ... });
```

### Running Tests

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/LockerControllerTest.php

# With verbose output
php artisan test --verbose

# Using Pest
./vendor/bin/pest
```

---

## Python AI Integration (Optional)

### Overview

While the current implementation uses **PHP templates** for AI generation, you can integrate a Python-based AI system for more sophisticated plan generation.

### Option 1: Python Subprocess Integration

#### Setup

1. **Create Python script** at `resources/python/ai_generator.py`

```python
import json
import sys

def generate_workout_plan(data):
    """Generate workout plan using AI logic"""
    # Implement custom AI logic here
    return {"days": {...}}

def generate_diet_plan(data):
    """Generate diet plan using AI logic"""
    # Implement custom AI logic here
    return {"meals": {...}}

if __name__ == "__main__":
    action = sys.argv[1]
    data = json.loads(sys.argv[2])
    
    if action == "workout":
        result = generate_workout_plan(data)
    else:
        result = generate_diet_plan(data)
    
    print(json.dumps(result))
```

2. **Modify AIService** to call Python:

```php
private function callPythonAI(string $action, array $data): array
{
    $pythonScript = base_path('resources/python/ai_generator.py');
    $command = 'python ' . escapeshellarg($pythonScript) . ' ' 
             . escapeshellarg($action) . ' ' 
             . escapeshellarg(json_encode($data));
    
    $output = shell_exec($command);
    return json_decode($output, true);
}
```

3. **Update generation methods:**

```php
public function generateWorkoutPlan(array $data): array
{
    // Option 1: Use PHP templates (current)
    // return $this->getWorkoutTemplates($data['goal'], $data['level']);
    
    // Option 2: Call Python AI
    // return $this->callPythonAI('workout', $data);
    
    // Your choice here
}
```

### Option 2: API Integration

Call an external AI service (OpenAI, Google Palm, etc.):

```php
private function callExternalAI(string $prompt): string
{
    $client = new \OpenAI\Client(config('services.openai.api_key'));
    
    $response = $client->completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => $prompt,
        'max_tokens' => 2000,
    ]);
    
    return $response['choices'][0]['text'];
}
```

### Option 3: Machine Learning Model

Integrate a pre-trained ML model for personalized recommendations:

```bash
pip install numpy pandas scikit-learn
```

---

## File Structure Summary

```
gym_management_system/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LockerController.php ✅
│   │       └── AIController.php ✅
│   ├── Models/
│   │   ├── Locker.php ✅
│   │   ├── LockerAssignment.php ✅
│   │   ├── WorkoutPlan.php ✅
│   │   ├── DietPlan.php ✅
│   │   └── Member.php (updated) ✅
│   └── Services/
│       ├── LockerService.php ✅
│       ├── AIService.php ✅
│       └── PlanService.php ✅
├── database/
│   └── migrations/
│       ├── 2026_05_04_000001_create_lockers_table.php ✅
│       ├── 2026_05_04_000002_create_locker_assignments_table.php ✅
│       ├── 2026_04_30_000008_create_workout_plans_table.php ✅
│       └── 2026_04_30_000009_create_diet_plans_table.php ✅
├── resources/
│   └── views/
│       ├── lockers/
│       │   ├── index.blade.php ✅
│       │   └── create.blade.php ✅
│       └── plans/
│           ├── generate.blade.php ✅
│           ├── show.blade.php ✅
│           └── pdf.blade.php ✅
├── routes/
│   └── web.php (updated) ✅
└── composer.json (DomPDF included) ✅
```

---

## Quick Start

### 1. Run Migrations

```bash
php artisan migrate
```

### 2. Access Features

- **Locker Management:** `/lockers`
- **AI Plan Generation:** Go to member detail page → "Generate Plans"
- **View Plans:** `/members/{member}/plans`
- **Download PDF:** Click "Download PDF" on plans page

### 3. Generate Sample Data

```bash
php artisan tinker

// Create sample lockers
for ($i = 1; $i <= 20; $i++) {
    \App\Models\Locker::create([
        'locker_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
        'status' => 'available'
    ]);
}
```

---

## Troubleshooting

### Issue: "Class not found" errors

**Solution:** Run `composer dump-autoload`

```bash
composer dump-autoload
```

### Issue: PDF not generating

**Solution:** Ensure DomPDF is installed

```bash
composer require barryvdh/laravel-dompdf
```

### Issue: Locker not releasing on membership expiry

**Solution:** Check that `releaseExpiredAssignments()` is called in your cron job

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        app(\App\Services\LockerService::class)->releaseExpiredAssignments();
    })->daily();
}
```

### Issue: Plan data not saving

**Solution:** Verify `plan_data` is being cast to JSON

```php
// In WorkoutPlan/DietPlan models
protected $casts = ['plan_data' => 'array'];
```

---

## Support & Documentation

- **Laravel Documentation:** https://laravel.com/docs
- **DomPDF Documentation:** https://github.com/barryvdh/laravel-dompdf
- **Pest Testing:** https://pestphp.com/docs/installation

---

**Last Updated:** May 5, 2026
**Status:** ✅ Complete & Production-Ready
