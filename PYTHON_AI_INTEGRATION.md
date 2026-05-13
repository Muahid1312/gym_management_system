# Python AI Integration Guide

This document explains how to integrate **Python-based AI** for more advanced plan generation in the Gym Management System.

---

## Table of Contents

1. [Setup](#setup)
2. [Python Script](#python-script)
3. [Laravel Integration](#laravel-integration)
4. [Configuration](#configuration)
5. [Testing](#testing)
6. [Troubleshooting](#troubleshooting)

---

## Setup

### Prerequisites

1. **Python 3.8+** installed on the server
2. **Laravel Application** running
3. **Required Python packages**

### Installation Steps

#### Step 1: Install Python Packages

```bash
# On your server/development machine
pip install numpy pandas scikit-learn requests

# Optional: For advanced ML models
pip install tensorflow keras transformers
```

#### Step 2: Create Python Script Directory

```bash
mkdir -p resources/python
cd resources/python
```

#### Step 3: Grant Execute Permissions

```bash
chmod +x resources/python/ai_generator.py
chmod 755 resources/python/
```

---

## Python Script

### Basic Implementation

Create `resources/python/ai_generator.py`:

```python
#!/usr/bin/env python3
"""
AI Workout & Diet Plan Generator
Generates personalized fitness plans based on user input
"""

import json
import sys
from typing import Dict, List, Any


class WorkoutPlanGenerator:
    """Generate personalized workout plans"""
    
    INTENSITY_LEVELS = {
        'Beginner': {'sets': 3, 'reps': '10-12', 'rest': 60},
        'Intermediate': {'sets': 4, 'reps': '8-10', 'rest': 45},
        'Advanced': {'sets': 4, 'reps': '6-8', 'rest': 90},
    }
    
    MUSCLE_GROUPS = {
        'Day 1': 'Chest & Triceps',
        'Day 2': 'Back & Biceps',
        'Day 3': 'Rest / Cardio',
        'Day 4': 'Legs',
        'Day 5': 'Shoulders & Core',
        'Day 6': 'Full Body',
        'Day 7': 'Recovery',
    }
    
    # Exercise templates per muscle group and level
    EXERCISES = {
        'Chest & Triceps': {
            'Beginner': [
                {'name': 'Bench Press', 'sets': 3, 'reps': '10-12'},
                {'name': 'Dumbbell Press', 'sets': 3, 'reps': '10-12'},
                {'name': 'Chest Flyes', 'sets': 3, 'reps': '12-15'},
                {'name': 'Tricep Dips', 'sets': 3, 'reps': '8-10'},
            ],
            'Intermediate': [
                {'name': 'Barbell Bench Press', 'sets': 4, 'reps': '8-10'},
                {'name': 'Incline Dumbbell Press', 'sets': 4, 'reps': '8-10'},
                {'name': 'Chest Cable Flyes', 'sets': 3, 'reps': '10-12'},
                {'name': 'Tricep Rope Pushdown', 'sets': 4, 'reps': '10-12'},
                {'name': 'Close-Grip Bench Press', 'sets': 3, 'reps': '8-10'},
            ],
            'Advanced': [
                {'name': 'Heavy Barbell Bench Press', 'sets': 4, 'reps': '6-8'},
                {'name': 'Incline Barbell Press', 'sets': 4, 'reps': '6-8'},
                {'name': 'Dumbbell Flyes', 'sets': 4, 'reps': '8-10'},
                {'name': 'Dips (Weighted)', 'sets': 4, 'reps': '6-8'},
                {'name': 'Skull Crushers', 'sets': 3, 'reps': '6-8'},
                {'name': 'Cable Crossover', 'sets': 3, 'reps': '10-12'},
            ],
        },
        'Back & Biceps': {
            'Beginner': [
                {'name': 'Assisted Pull-ups', 'sets': 3, 'reps': '8-10'},
                {'name': 'Bent-over Rows', 'sets': 3, 'reps': '10-12'},
                {'name': 'Lat Pulldown', 'sets': 3, 'reps': '10-12'},
                {'name': 'Barbell Curls', 'sets': 3, 'reps': '10-12'},
            ],
            'Intermediate': [
                {'name': 'Pull-ups', 'sets': 4, 'reps': '8-10'},
                {'name': 'Barbell Rows', 'sets': 4, 'reps': '8-10'},
                {'name': 'Lat Pulldown', 'sets': 3, 'reps': '10-12'},
                {'name': 'Dumbbell Rows', 'sets': 3, 'reps': '10-12'},
                {'name': 'Barbell Curls', 'sets': 4, 'reps': '8-10'},
                {'name': 'Hammer Curls', 'sets': 3, 'reps': '10-12'},
            ],
            'Advanced': [
                {'name': 'Weighted Pull-ups', 'sets': 4, 'reps': '6-8'},
                {'name': 'Deadlifts', 'sets': 4, 'reps': '5-6'},
                {'name': 'Barbell Rows (Heavy)', 'sets': 4, 'reps': '6-8'},
                {'name': 'T-Bar Rows', 'sets': 3, 'reps': '8-10'},
                {'name': 'Barbell Curls', 'sets': 4, 'reps': '6-8'},
                {'name': 'Preacher Curls', 'sets': 3, 'reps': '8-10'},
            ],
        },
        'Legs': {
            'Beginner': [
                {'name': 'Leg Press', 'sets': 3, 'reps': '10-12'},
                {'name': 'Leg Extensions', 'sets': 3, 'reps': '12-15'},
                {'name': 'Leg Curls', 'sets': 3, 'reps': '10-12'},
                {'name': 'Leg Raises', 'sets': 3, 'reps': '15-20'},
            ],
            'Intermediate': [
                {'name': 'Squats', 'sets': 4, 'reps': '8-10'},
                {'name': 'Romanian Deadlifts', 'sets': 4, 'reps': '8-10'},
                {'name': 'Leg Press', 'sets': 3, 'reps': '10-12'},
                {'name': 'Leg Extensions', 'sets': 3, 'reps': '12-15'},
                {'name': 'Leg Curls', 'sets': 3, 'reps': '10-12'},
            ],
            'Advanced': [
                {'name': 'Heavy Squats', 'sets': 4, 'reps': '5-6'},
                {'name': 'Deadlifts', 'sets': 4, 'reps': '5-6'},
                {'name': 'Bulgarian Split Squats', 'sets': 4, 'reps': '8-10'},
                {'name': 'Leg Press (Heavy)', 'sets': 3, 'reps': '6-8'},
                {'name': 'Leg Curls', 'sets': 3, 'reps': '8-10'},
                {'name': 'Calf Raises', 'sets': 4, 'reps': '10-15'},
            ],
        },
        'Shoulders & Core': {
            'Beginner': [
                {'name': 'Shoulder Press', 'sets': 3, 'reps': '10-12'},
                {'name': 'Lateral Raises', 'sets': 3, 'reps': '12-15'},
                {'name': 'Plank', 'sets': 3, 'reps': '30-60 sec'},
                {'name': 'Russian Twists', 'sets': 3, 'reps': '20'},
            ],
            'Intermediate': [
                {'name': 'Barbell Shoulder Press', 'sets': 4, 'reps': '8-10'},
                {'name': 'Lateral Raises', 'sets': 4, 'reps': '10-12'},
                {'name': 'Front Raises', 'sets': 3, 'reps': '10-12'},
                {'name': 'Plank Holds', 'sets': 3, 'reps': '60 sec'},
                {'name': 'Weighted Planks', 'sets': 3, 'reps': '45 sec'},
            ],
            'Advanced': [
                {'name': 'Heavy Barbell Press', 'sets': 4, 'reps': '6-8'},
                {'name': 'Machine Shoulder Press', 'sets': 3, 'reps': '8-10'},
                {'name': 'Lateral Raises (Heavy)', 'sets': 4, 'reps': '8-10'},
                {'name': 'Decline Sit-ups', 'sets': 4, 'reps': '15-20'},
                {'name': 'Weighted Leg Raises', 'sets': 3, 'reps': '10-15'},
            ],
        },
    }
    
    def __init__(self, data: Dict[str, Any]):
        self.age = data.get('age', 25)
        self.weight = data.get('weight', 70)
        self.height = data.get('height', 170)
        self.goal = data.get('goal', 'General Fitness')
        self.level = data.get('level', 'Beginner')
    
    def generate(self) -> Dict[str, Any]:
        """Generate complete 7-day workout plan"""
        plan = {}
        intensity = self.INTENSITY_LEVELS.get(self.level, self.INTENSITY_LEVELS['Beginner'])
        
        for day_num, day_name in enumerate(self.MUSCLE_GROUPS, 1):
            muscle_group = self.MUSCLE_GROUPS[day_name]
            exercises = self.EXERCISES.get(muscle_group, {}).get(self.level, [])
            
            plan[day_name] = {
                'muscle_group': muscle_group,
                'exercises': [
                    {
                        'name': ex['name'],
                        'sets': ex['sets'],
                        'reps': ex['reps'],
                        'notes': self._get_exercise_notes(ex['name'], self.goal, self.level),
                    }
                    for ex in exercises
                ]
            }
        
        return plan
    
    def _get_exercise_notes(self, exercise: str, goal: str, level: str) -> str:
        """Get exercise-specific coaching notes"""
        notes = {
            'Fat Loss': 'Focus on controlled movements. Keep rest periods short (30-45 sec) to elevate heart rate.',
            'Muscle Gain': 'Use heavy weight with good form. Rest 60-90 seconds between sets for muscle recovery.',
            'General Fitness': 'Maintain steady pace with proper form. Balance weight and endurance.',
        }
        return notes.get(goal, notes['General Fitness'])


class DietPlanGenerator:
    """Generate personalized diet plans"""
    
    CALORIE_MULTIPLIER = {
        'Beginner': 1.2,
        'Intermediate': 1.35,
        'Advanced': 1.4,
    }
    
    MACRO_RATIOS = {
        'Fat Loss': {'protein': 0.35, 'carbs': 0.40, 'fats': 0.25},
        'Muscle Gain': {'protein': 0.30, 'carbs': 0.50, 'fats': 0.20},
        'General Fitness': {'protein': 0.30, 'carbs': 0.40, 'fats': 0.30},
    }
    
    MEALS = {
        'Fat Loss': {
            'breakfast': {
                'name': 'Egg White Omelette',
                'foods': ['Egg whites (4)', 'Spinach (1 cup)', 'Tomatoes', 'Mushrooms'],
                'notes': 'Minimal oil, maximize protein and fiber.',
            },
            'lunch': {
                'name': 'Grilled Chicken Salad',
                'foods': ['Chicken breast (150g)', 'Mixed greens', 'Cucumber', 'Light dressing'],
                'notes': 'High protein, low calorie density for satiety.',
            },
            'dinner': {
                'name': 'Baked White Fish',
                'foods': ['White fish (150g)', 'Broccoli', 'Carrot', 'Lemon'],
                'notes': 'Lean protein, high fiber vegetables.',
            },
            'snacks': {
                'name': 'Greek Yogurt with Berries',
                'foods': ['Greek yogurt (150g)', 'Blueberries', 'Almonds (1 oz)'],
                'notes': 'High protein, natural sugars for recovery.',
            },
        },
        'Muscle Gain': {
            'breakfast': {
                'name': 'Oatmeal & Eggs',
                'foods': ['Oats (1 cup)', 'Whole eggs (3)', 'Banana', 'Honey'],
                'notes': 'Carbs + protein for muscle building.',
            },
            'lunch': {
                'name': 'Chicken & Rice',
                'foods': ['Chicken breast (200g)', 'White rice (1 cup)', 'Broccoli', 'Olive oil'],
                'notes': 'Balanced macros for energy and recovery.',
            },
            'dinner': {
                'name': 'Salmon & Sweet Potato',
                'foods': ['Salmon (150g)', 'Sweet potato (1 medium)', 'Green beans'],
                'notes': 'Omega-3s and complex carbs.',
            },
            'snacks': {
                'name': 'Peanut Butter Shake',
                'foods': ['Banana', 'Peanut butter (2 tbsp)', 'Whole milk', 'Oats'],
                'notes': 'Calorie-dense snack for muscle building.',
            },
        },
        'General Fitness': {
            'breakfast': {
                'name': 'Whole Grain Toast & Egg',
                'foods': ['Whole grain toast (2)', 'Egg (1)', 'Avocado', 'Berries'],
                'notes': 'Balanced nutrition for steady energy.',
            },
            'lunch': {
                'name': 'Turkey Sandwich',
                'foods': ['Whole grain bread', 'Turkey breast', 'Lettuce', 'Tomato'],
                'notes': 'Moderate portions, nutrient-dense.',
            },
            'dinner': {
                'name': 'Stir-Fry Chicken',
                'foods': ['Chicken (150g)', 'Brown rice (3/4 cup)', 'Mixed vegetables'],
                'notes': 'Variety of nutrients in each meal.',
            },
            'snacks': {
                'name': 'Mixed Nuts & Fruit',
                'foods': ['Almonds (1 oz)', 'Apple', 'Walnuts'],
                'notes': 'Whole foods for sustained energy.',
            },
        },
    }
    
    def __init__(self, data: Dict[str, Any]):
        self.age = data.get('age', 25)
        self.weight = data.get('weight', 70)
        self.height = data.get('height', 170)
        self.goal = data.get('goal', 'General Fitness')
        self.level = data.get('level', 'Beginner')
    
    def generate(self) -> Dict[str, Any]:
        """Generate complete daily diet plan"""
        daily_calories = self._calculate_calories()
        macros = self.MACRO_RATIOS.get(self.goal, self.MACRO_RATIOS['General Fitness'])
        meals = self.MEALS.get(self.goal, self.MEALS['General Fitness'])
        
        plan = {}
        meal_calorie_distribution = {
            'breakfast': 0.25,
            'lunch': 0.34,
            'dinner': 0.30,
            'snacks': 0.11,
        }
        
        for meal_type, distribution in meal_calorie_distribution.items():
            meal_data = meals.get(meal_type, {})
            meal_calories = int(daily_calories * distribution)
            
            plan[meal_type] = {
                'name': meal_data.get('name', 'N/A'),
                'foods': meal_data.get('foods', []),
                'calories': meal_calories,
                'macros': {
                    'protein': max(0, int((meal_calories * macros['protein']) / 4)),
                    'carbs': max(0, int((meal_calories * macros['carbs']) / 4)),
                    'fats': max(0, int((meal_calories * macros['fats']) / 9)),
                },
                'notes': meal_data.get('notes', ''),
            }
        
        return plan
    
    def _calculate_calories(self) -> int:
        """Calculate daily calorie target using Harris-Benedict equation"""
        # Simplified BMR calculation
        bmr = (10 * self.weight) + (6.25 * self.height) - (5 * self.age) + 5
        
        activity_multiplier = self.CALORIE_MULTIPLIER.get(self.level, 1.2)
        tdee = int(bmr * activity_multiplier)
        
        # Adjust based on goal
        if self.goal == 'Fat Loss':
            return max(1200, tdee - 300)
        elif self.goal == 'Muscle Gain':
            return tdee + 300
        else:
            return tdee


def main():
    """Main entry point"""
    try:
        if len(sys.argv) < 3:
            raise ValueError("Missing arguments: action and data required")
        
        action = sys.argv[1]
        data_json = sys.argv[2]
        
        try:
            data = json.loads(data_json)
        except json.JSONDecodeError as e:
            raise ValueError(f"Invalid JSON: {e}")
        
        if action == 'workout':
            generator = WorkoutPlanGenerator(data)
            result = generator.generate()
        elif action == 'diet':
            generator = DietPlanGenerator(data)
            result = generator.generate()
        else:
            raise ValueError(f"Unknown action: {action}")
        
        # Output as JSON
        print(json.dumps(result))
        
    except Exception as e:
        error_response = {
            'error': True,
            'message': str(e)
        }
        print(json.dumps(error_response), file=sys.stderr)
        sys.exit(1)


if __name__ == '__main__':
    main()
```

---

## Laravel Integration

### Step 1: Update AIService

Modify [app/Services/AIService.php](app/Services/AIService.php) to use Python:

```php
<?php

namespace App\Services;

use App\Models\DietPlan;
use App\Models\WorkoutPlan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AIService
{
    /**
     * Use Python AI instead of PHP templates
     * Set to true to enable Python integration
     */
    private bool $usePythonAI = false;

    public function generateWorkoutPlan(array $data): array
    {
        if ($this->usePythonAI) {
            return $this->callPythonAI('workout', $data);
        }
        
        // Fallback to PHP templates
        return $this->generateWorkoutPlanPHP($data);
    }

    public function generateDietPlan(array $data): array
    {
        if ($this->usePythonAI) {
            return $this->callPythonAI('diet', $data);
        }
        
        // Fallback to PHP templates
        return $this->generateDietPlanPHP($data);
    }

    /**
     * Call Python AI script
     */
    private function callPythonAI(string $action, array $data): array
    {
        $pythonScript = base_path('resources/python/ai_generator.py');
        
        if (!file_exists($pythonScript)) {
            throw new \RuntimeException('Python AI script not found: ' . $pythonScript);
        }

        // Build command
        $command = [
            'python3',
            $pythonScript,
            $action,
            json_encode($data),
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(30); // 30 second timeout
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON from Python: ' . json_last_error_msg());
            }

            if (isset($result['error']) && $result['error']) {
                throw new \RuntimeException('Python error: ' . ($result['message'] ?? 'Unknown'));
            }

            return $result;

        } catch (\Throwable $e) {
            \Log::error('Python AI Error', [
                'action' => $action,
                'error' => $e->getMessage(),
            ]);
            
            // Fallback to PHP template
            if ($action === 'workout') {
                return $this->generateWorkoutPlanPHP($data);
            } else {
                return $this->generateDietPlanPHP($data);
            }
        }
    }

    // All existing PHP template methods remain here...
    private function generateWorkoutPlanPHP(array $data): array
    {
        // ... existing code ...
    }

    private function generateDietPlanPHP(array $data): array
    {
        // ... existing code ...
    }

    public function saveWorkoutPlan(int $memberId, array $data, array $plan): WorkoutPlan
    {
        return WorkoutPlan::create([
            'member_id' => $memberId,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'goal' => $data['goal'],
            'level' => $data['level'],
            'plan_data' => $plan,
        ]);
    }

    public function saveDietPlan(int $memberId, array $data, array $plan): DietPlan
    {
        return DietPlan::create([
            'member_id' => $memberId,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'goal' => $data['goal'],
            'level' => $data['level'],
            'plan_data' => $plan,
        ]);
    }
}
```

### Step 2: Configuration

Create `config/ai.php`:

```php
<?php

return [
    'use_python' => env('AI_USE_PYTHON', false),
    'python_path' => env('PYTHON_PATH', 'python3'),
    'script_path' => base_path('resources/python/ai_generator.py'),
    'timeout' => env('AI_TIMEOUT', 30),
];
```

### Step 3: Environment Variables

Add to `.env`:

```env
# AI Configuration
AI_USE_PYTHON=true
PYTHON_PATH=/usr/bin/python3
AI_TIMEOUT=30
```

---

## Configuration

### Enable/Disable Python AI

In `config/ai.php` or `.env`:

```env
# Use Python (true/false)
AI_USE_PYTHON=true

# Path to Python executable
PYTHON_PATH=/usr/bin/python3

# Timeout in seconds
AI_TIMEOUT=30
```

Then use in service:

```php
$this->usePythonAI = config('ai.use_python', false);
```

---

## Testing

### Manual Testing

#### Test Workout Plan Generation

```bash
python3 resources/python/ai_generator.py workout '{"age": 28, "weight": 75, "height": 180, "goal": "Muscle Gain", "level": "Intermediate"}'
```

Expected output (shortened):
```json
{
  "Day 1": {
    "muscle_group": "Chest & Triceps",
    "exercises": [...]
  },
  ...
}
```

#### Test Diet Plan Generation

```bash
python3 resources/python/ai_generator.py diet '{"age": 28, "weight": 75, "height": 180, "goal": "Muscle Gain", "level": "Intermediate"}'
```

### Unit Tests

Create `tests/Unit/PythonAIServiceTest.php`:

```php
<?php

namespace Tests\Unit;

use App\Services\AIService;
use PHPUnit\Framework\TestCase;

class PythonAIServiceTest extends TestCase
{
    protected AIService $aiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->aiService = app(AIService::class);
    }

    public function test_generates_workout_plan()
    {
        $data = [
            'age' => 28,
            'weight' => 75,
            'height' => 180,
            'goal' => 'Muscle Gain',
            'level' => 'Intermediate',
        ];

        $plan = $this->aiService->generateWorkoutPlan($data);

        $this->assertIsArray($plan);
        $this->assertArrayHasKey('Day 1', $plan);
        $this->assertArrayHasKey('exercises', $plan['Day 1']);
    }

    public function test_generates_diet_plan()
    {
        $data = [
            'age' => 28,
            'weight' => 75,
            'height' => 180,
            'goal' => 'Muscle Gain',
            'level' => 'Intermediate',
        ];

        $plan = $this->aiService->generateDietPlan($data);

        $this->assertIsArray($plan);
        $this->assertArrayHasKey('breakfast', $plan);
        $this->assertArrayHasKey('lunch', $plan);
        $this->assertArrayHasKey('dinner', $plan);
        $this->assertArrayHasKey('snacks', $plan);
    }
}
```

Run tests:

```bash
php artisan test tests/Unit/PythonAIServiceTest.php
```

---

## Troubleshooting

### Issue: "Python not found"

```
RuntimeException: The command 'python3 ...' failed
```

**Solution:**

```bash
# Check Python installation
which python3
python3 --version

# Update PATH if needed
export PATH="/usr/bin:$PATH"

# Or specify full path in .env
PYTHON_PATH=/usr/bin/python3
```

### Issue: "Permission denied"

```
Exception: "Permission denied" executing '/path/to/ai_generator.py'
```

**Solution:**

```bash
chmod +x resources/python/ai_generator.py
chmod 755 resources/python/
```

### Issue: "JSON decode error"

```
RuntimeException: Invalid JSON from Python
```

**Solution:**

- Check Python script is outputting valid JSON
- Test script manually: `python3 resources/python/ai_generator.py workout '{"age": 28, ...}'`
- Check error output: Add logging to see stderr

### Issue: "Timeout exceeded"

```
ProcessFailedException: The command exceeded timeout
```

**Solution:**

- Increase timeout in `.env`: `AI_TIMEOUT=60`
- Optimize Python script
- Check system resources

### Issue: "Import error: No module named 'numpy'"

```
ModuleNotFoundError: No module named 'numpy'
```

**Solution:**

```bash
# Install missing package
pip install numpy

# Or use system-wide Python
sudo pip3 install numpy

# Verify installation
python3 -c "import numpy; print(numpy.__version__)"
```

---

## Performance Optimization

### Caching Plans

Cache generated plans to avoid regeneration:

```php
public function generateWorkoutPlan(array $data): array
{
    $cacheKey = 'workout_plan_' . md5(json_encode($data));
    
    return Cache::remember($cacheKey, 86400, function () use ($data) {
        return $this->callPythonAI('workout', $data);
    });
}
```

### Queue Processing

Process plan generation asynchronously:

```bash
php artisan queue:work
```

In your form submission handler:

```php
Bus::dispatch(new GenerateWorkoutPlanJob($member, $data));
Bus::dispatch(new GenerateDietPlanJob($member, $data));
```

---

## Advanced Features

### Custom ML Models

Integrate pre-trained models:

```python
import pickle

# Load pre-trained model
with open('models/workout_classifier.pkl', 'rb') as f:
    model = pickle.load(f)

# Make predictions
prediction = model.predict([[age, weight, height]])
```

### Logging & Analytics

Track AI generations:

```php
\Log::info('AI Plan Generated', [
    'member_id' => $memberId,
    'goal' => $goal,
    'level' => $level,
    'execution_time' => $executionTime,
]);
```

---

**Status:** ✅ Complete Python AI Integration Guide
**Last Updated:** May 5, 2026
