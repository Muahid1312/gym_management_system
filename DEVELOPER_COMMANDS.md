# Developer Quick Commands Reference

**Copy & paste these commands to quickly work with the new features.**

---

## 🗃️ Database Commands

### Run All Migrations
```bash
php artisan migrate
```

### Rollback Last Batch
```bash
php artisan migrate:rollback
```

### Rollback & Re-run (Fresh)
```bash
php artisan migrate:refresh
```

### Seed Sample Data
```bash
php artisan tinker

# Create 20 sample lockers
for ($i = 1; $i <= 20; $i++) {
    \App\Models\Locker::create([
        'locker_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
        'status' => 'available'
    ]);
}

exit
```

---

## 🧪 Testing Commands

### Run All Tests
```bash
php artisan test
```

### Run Specific Test File
```bash
php artisan test tests/Feature/LockerControllerTest.php
```

### Run with Coverage
```bash
php artisan test --coverage
```

### Run in Verbose Mode
```bash
php artisan test --verbose
```

### Use Pest Testing
```bash
./vendor/bin/pest
```

---

## 🔍 Debugging Commands

### Debug with Tinker
```bash
php artisan tinker

# Check total lockers
\App\Models\Locker::count();

# Check available lockers
\App\Models\Locker::where('status', 'available')->count();

# Get specific member's plans
$member = \App\Models\Member::find(1);
$member->load(['workoutPlans', 'dietPlans', 'lockerAssignment.locker']);
dd($member);

# Check locker history
\App\Models\LockerAssignment::with('member', 'locker')->latest()->get();

exit
```

### View Last 100 Errors
```bash
tail -100 storage/logs/laravel.log
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📊 Database Queries (Tinker)

### List All Lockers with Assignments
```bash
php artisan tinker

\App\Models\Locker::with('activeAssignment.member')->get();

exit
```

### Get Member's Active Locker
```bash
php artisan tinker

$member = \App\Models\Member::find(1);
$member->lockerAssignment()->with('locker')->first();

exit
```

### Get All Workout Plans
```bash
php artisan tinker

\App\Models\WorkoutPlan::with('member')->latest()->get();

exit
```

### Get Specific Member's Plans
```bash
php artisan tinker

$member = \App\Models\Member::find(1);
$member->load(['workoutPlans' => fn($q) => $q->latest(), 'dietPlans' => fn($q) => $q->latest()]);
dd($member->workoutPlans, $member->dietPlans);

exit
```

### Check Expired Lockers
```bash
php artisan tinker

\App\Models\LockerAssignment::active()
    ->where('expiry_date', '<', now()->toDateString())
    ->with('member', 'locker')
    ->get();

exit
```

---

## 🔧 Maintenance Commands

### Release Expired Lockers (Manual)
```bash
php artisan tinker

$count = app(\App\Services\LockerService::class)->releaseExpiredAssignments();
echo "Released {$count} lockers\n";

exit
```

### Generate Sample Plan
```bash
php artisan tinker

$service = app(\App\Services\AIService::class);
$data = [
    'age' => 28,
    'weight' => 75,
    'height' => 180,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate',
];
$plan = $service->generateWorkoutPlan($data);
dd($plan);

exit
```

---

## 🚀 Deployment Commands

### Prepare for Production
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Rollback Production
```bash
php artisan migrate:rollback --force
```

### Production Status Check
```bash
php artisan migrate:status
```

---

## 📱 Web Access

### Development URLs
```
Locker Management:     http://localhost:8000/lockers
Create Locker:         http://localhost:8000/lockers/create
Generate Plans:        http://localhost:8000/members/1/generate-plans
View Plans:            http://localhost:8000/members/1/plans
Download PDF:          http://localhost:8000/members/1/plans/download-pdf
```

---

## 🐍 Python AI Commands (Optional)

### Test Python Script Directly
```bash
python3 resources/python/ai_generator.py workout '{"age": 28, "weight": 75, "height": 180, "goal": "Muscle Gain", "level": "Intermediate"}'
```

### Test Diet Plan Generation
```bash
python3 resources/python/ai_generator.py diet '{"age": 28, "weight": 75, "height": 180, "goal": "Fat Loss", "level": "Beginner"}'
```

### Check Python Installation
```bash
python3 --version
which python3
```

### Install Python Packages
```bash
pip install numpy pandas scikit-learn
```

---

## 📊 Common SQL Queries

### Get Locker Status Summary
```sql
SELECT status, COUNT(*) as count 
FROM lockers 
GROUP BY status;
```

### Get Member with Active Locker
```sql
SELECT m.*, l.locker_number, la.assigned_at 
FROM members m
LEFT JOIN locker_assignments la ON m.id = la.member_id AND la.returned_at IS NULL
LEFT JOIN lockers l ON la.locker_id = l.id;
```

### Get Expired Assignments (Not Released)
```sql
SELECT la.*, m.name, l.locker_number 
FROM locker_assignments la
JOIN members m ON la.member_id = m.id
JOIN lockers l ON la.locker_id = l.id
WHERE la.returned_at IS NULL 
AND (
    DATE(la.expiry_date) < CURDATE() 
    OR DATE(m.expiry_date) < CURDATE()
);
```

### Get All Workout Plans with Member Info
```sql
SELECT wp.*, m.name, m.email 
FROM workout_plans wp
JOIN members m ON wp.member_id = m.id
ORDER BY wp.created_at DESC;
```

---

## 🎨 Frontend Debugging

### Browser Console Tips
```javascript
// Check form submission
console.log('Form data:', new FormData(document.querySelector('form')));

// Monitor AJAX calls
$(document).on('ajaxStart', function() {
    console.log('AJAX call started');
});

// Check for validation errors
console.log('Errors:', document.querySelectorAll('[class*="error"]'));
```

---

## 📈 Performance Monitoring

### Check Query Count
```bash
php artisan tinker

\Illuminate\Support\Facades\DB::enableQueryLog();

// Run your code here
\App\Models\Locker::with('activeAssignment.member')->get();

$queries = \Illuminate\Support\Facades\DB::getQueryLog();
echo count($queries) . " queries executed\n";
foreach ($queries as $query) {
    echo $query['query'] . " - " . $query['time'] . "ms\n";
}

exit
```

### Monitor Memory Usage
```bash
php -r "
\$mem = memory_get_peak_usage();
echo 'Peak Memory: ' . round(\$mem / 1024 / 1024, 2) . ' MB';
"
```

---

## 🐛 Common Issues & Fixes

### Issue: "Class not found" Errors
```bash
composer dump-autoload
```

### Issue: Migration Failed
```bash
php artisan migrate:rollback
php artisan migrate
```

### Issue: PDF not generating
```bash
composer require barryvdh/laravel-dompdf
```

### Issue: Routes not working
```bash
php artisan route:clear
php artisan route:cache
```

### Issue: Views not updating
```bash
php artisan view:clear
```

### Issue: Database connections failing
```bash
php artisan config:clear
php artisan migrate:refresh
```

---

## 📝 Useful Aliases

Add to your `.bashrc` or `.zshrc`:

```bash
alias art='php artisan'
alias artm='php artisan migrate'
alias artt='php artisan test'
alias artc='php artisan tinker'
alias artcc='php artisan cache:clear && php artisan config:clear && php artisan view:clear'
```

Then use:
```bash
art migrate              # Instead of: php artisan migrate
art test                 # Instead of: php artisan test
art tinker              # Instead of: php artisan tinker
artcc                   # Clear all caches
```

---

## 🔗 Useful Links

### Documentation
- [FEATURE_IMPLEMENTATION_COMPLETE.md](FEATURE_IMPLEMENTATION_COMPLETE.md)
- [PYTHON_AI_INTEGRATION.md](PYTHON_AI_INTEGRATION.md)
- [QUICK_REFERENCE.md](QUICK_REFERENCE.md)

### Code Files
- [LockerController](app/Http/Controllers/LockerController.php)
- [AIController](app/Http/Controllers/AIController.php)
- [LockerService](app/Services/LockerService.php)
- [AIService](app/Services/AIService.php)
- [PlanService](app/Services/PlanService.php)

### Views
- [Locker Index](resources/views/lockers/index.blade.php)
- [Plan Generator](resources/views/plans/generate.blade.php)
- [Plan Display](resources/views/plans/show.blade.php)
- [PDF Template](resources/views/plans/pdf.blade.php)

---

## ⚡ One-Liners

### Count Everything
```bash
php artisan tinker --execute='echo "Lockers: " . \App\Models\Locker::count() . ", Assignments: " . \App\Models\LockerAssignment::count() . ", Workout Plans: " . \App\Models\WorkoutPlan::count() . ", Diet Plans: " . \App\Models\DietPlan::count();'
```

### Fresh Database with Sample Data
```bash
php artisan migrate:refresh --seed
```

### Check All Routes
```bash
php artisan route:list | grep -E "(locker|plan|ai)"
```

### Find All TODOs in Code
```bash
grep -r "TODO\|FIXME\|HACK" app/
```

---

**Tips:**
- Use `php artisan tinker` for interactive testing
- Use `--force` on production for migrations
- Always test migrations on staging first
- Monitor logs: `tail -f storage/logs/laravel.log`
- Use query logging for debugging slow queries

**Last Updated:** May 5, 2026
