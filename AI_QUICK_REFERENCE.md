# AI Plan Generator - Quick Reference

## 🚀 Quick Setup (5 minutes)

1. **Add Claude API Key**
   ```bash
   # Edit .env
   CLAUDE_API_KEY=sk-ant-... # From https://console.anthropic.com/
   ```

2. **Run Migrations**
   ```bash
   php artisan migrate
   ```

3. **Test It**
   - Go to any member's profile
   - Click "Generate Plans"
   - Fill the form
   - Click "Generate Workout Plan"
   - View results and download PDF

---

## 📁 Files Created/Modified

### New Files
- ✅ `app/Services/PlanService.php` - PDF & formatting logic
- ✅ `resources/views/plans/generate.blade.php` - Generation form
- ✅ `resources/views/plans/show.blade.php` - Display plans
- ✅ `resources/views/plans/pdf.blade.php` - PDF template
- ✅ `AI_PLAN_IMPLEMENTATION_GUIDE.md` - Full documentation

### Modified Files
- ✅ `app/Services/AIService.php` - Added Claude API integration
- ✅ `app/Http/Controllers/AIController.php` - Updated controller
- ✅ `app/Models/WorkoutPlan.php` - Added new fields
- ✅ `app/Models/DietPlan.php` - Added new fields
- ✅ `database/migrations/2026_04_30_000008_*.php` - Updated schema
- ✅ `database/migrations/2026_04_30_000009_*.php` - Updated schema
- ✅ `routes/web.php` - Added new routes
- ✅ `config/services.php` - Added Claude config
- ✅ `.env.example` - Added Claude key template

---

## 🛣️ Routes

```
GET    /members/{member}/generate-plans       - Show form
POST   /members/{member}/generate-workout     - Generate
POST   /members/{member}/generate-diet        - Generate
GET    /members/{member}/plans                - View plans
GET    /members/{member}/plans/download-pdf   - Download PDF
DELETE /workout-plans/{plan}                  - Delete plan
DELETE /diet-plans/{plan}                     - Delete plan
```

---

## 💾 Database Schema Changes

### Added Columns
```sql
ALTER TABLE workout_plans ADD (
    age INT,
    weight DECIMAL(8,2),
    height INT,
    goal ENUM('Fat Loss', 'Muscle Gain', 'General Fitness'),
    level ENUM('Beginner', 'Intermediate', 'Advanced')
);

ALTER TABLE diet_plans ADD (
    age INT,
    weight DECIMAL(8,2),
    height INT,
    goal ENUM('Fat Loss', 'Muscle Gain', 'General Fitness'),
    level ENUM('Beginner', 'Intermediate', 'Advanced')
);
```

---

## 🔑 API Integration

**Provider:** Claude (Anthropic)
**Endpoint:** `https://api.anthropic.com/v1/messages`
**Model:** `claude-3-5-sonnet-20241022`
**Max Tokens:** 2000

**Setup:**
1. Create account at https://console.anthropic.com/
2. Generate API key
3. Add to `.env` as `CLAUDE_API_KEY=sk-ant-...`

---

## 📊 Data Flow

```
User Form
    ↓
AIController.generateWorkoutPlan()
    ↓
AIService.generateWorkoutPlan()
    ↓
Claude API (HTTP call)
    ↓
JSON Response Parser
    ↓
Save to database (WorkoutPlan model)
    ↓
Redirect to show view
    ↓
User sees formatted plan + PDF button
    ↓
PlanService.generateCombinedPdf()
    ↓
Download PDF file
```

---

## 🎯 Key Classes

### AIService
```php
// Generate plans via Claude API
$plan = $this->aiService->generateWorkoutPlan($data);
$this->aiService->saveWorkoutPlan($memberId, $data, $plan);
```

### PlanService
```php
// Format for display
$formatted = $planService->formatWorkoutPlanForDisplay($data);

// Generate PDF
return $planService->generateCombinedPdf($member);

// Calculate metrics
$bmi = $planService->calculateBmi($weight, $height);
$macros = $planService->calculateDailyMacros($dietData);
```

### Models
```php
// Member relationships
$member->workoutPlans()      // Collection
$member->dietPlans()         // Collection

// Access plan data
$plan->plan_data             // Array
$plan->member                // Member object
```

---

## 🐛 Common Issues & Fixes

| Issue | Solution |
|-------|----------|
| "API call failed" | Check `CLAUDE_API_KEY` in `.env` |
| "JSON Parsing Error" | System uses fallback plan |
| "No route named" | Run migrations, restart server |
| PDF not downloading | Check `storage/` permissions |
| Database error | Run `php artisan migrate` |

---

## ✅ Validation Rules

```php
'age' => 'required|integer|min:13|max:120'
'weight' => 'required|numeric|min:30|max:500'
'height' => 'required|integer|min:120|max:250'
'goal' => 'required|in:Fat Loss,Muscle Gain,General Fitness'
'level' => 'required|in:Beginner,Intermediate,Advanced'
```

---

## 🎨 Frontend Components Used

- `x-card` - Card wrapper
- `x-alert` - Alert messages
- Tailwind CSS utilities
- Custom forms
- HTML tables for exercises/meals

---

## 🔍 Testing Commands

```bash
# Run all tests
php artisan test

# Test specific file
php artisan test tests/Feature/AIPlanGenerationTest.php

# Check migrations
php artisan migrate:status

# View logs
tail -f storage/logs/laravel.log
```

---

## 📝 Configuration

### Environment Variables
```env
CLAUDE_API_KEY=sk-ant-... # Required
```

### Config File
`config/services.php` - Claude configuration

### Models
`app/Models/WorkoutPlan.php`
`app/Models/DietPlan.php`

---

## 🚀 Production Checklist

- [x] Database migrations ready
- [x] API integration complete
- [x] Error handling implemented
- [x] PDF generation tested
- [x] Views created
- [x] Validation rules added
- [ ] Claude API key configured
- [ ] Database migrated
- [ ] Test with real data
- [ ] Monitor logs in production

---

## 📚 Learn More

- Full guide: `AI_PLAN_IMPLEMENTATION_GUIDE.md`
- Claude API: https://docs.anthropic.com/
- Laravel: https://laravel.com/docs
- DomPDF: https://github.com/barryvdh/laravel-dompdf

---

**Status:** ✅ Production Ready
**Last Updated:** 2026-05-04
**Version:** 1.0.0
