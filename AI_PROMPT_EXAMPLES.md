# AI Prompt Examples & Response Formats

## Workout Plan Generation

### Example Request Data
```php
$data = [
    'age' => 28,
    'weight' => 75.5,
    'height' => 178,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate'
];
```

### Generated Prompt
```
Generate a personalized 7-day workout plan in JSON format. 

Member Details:
- Age: 28 years
- Weight: 75.5 kg
- Height: 178 cm
- Goal: Muscle Gain
- Experience Level: Intermediate

Requirements:
1. Create a 7-day plan with day names as keys
2. For each day include:
   - muscle_group: Target muscle groups
   - exercises: Array of 4-6 exercises
   - each exercise should have: name, sets, reps, notes
3. Adjust intensity based on experience level
4. Consider the fitness goal
5. Include rest days if appropriate

Return ONLY valid JSON, no markdown or extra text. Example structure:
{
  "Day 1": {
    "muscle_group": "Chest & Triceps",
    "exercises": [
      {
        "name": "Bench Press",
        "sets": 4,
        "reps": "8-10",
        "notes": "Focus on controlled movement"
      }
    ]
  }
}

Generate the complete plan now:
```

### Example JSON Response
```json
{
  "Day 1": {
    "muscle_group": "Chest & Triceps",
    "exercises": [
      {
        "name": "Barbell Bench Press",
        "sets": 4,
        "reps": "6-8",
        "notes": "Main compound for chest. Focus on progressive overload."
      },
      {
        "name": "Incline Dumbbell Press",
        "sets": 3,
        "reps": "8-10",
        "notes": "Targets upper chest"
      },
      {
        "name": "Cable Flyes",
        "sets": 3,
        "reps": "10-12",
        "notes": "Isolation for chest pump"
      },
      {
        "name": "Tricep Rope Pushdowns",
        "sets": 3,
        "reps": "10-12",
        "notes": "Controlled reps for tricep definition"
      },
      {
        "name": "Overhead Tricep Extension",
        "sets": 3,
        "reps": "8-10",
        "notes": "Stretch triceps under load"
      }
    ]
  },
  "Day 2": {
    "muscle_group": "Back & Biceps",
    "exercises": [
      {
        "name": "Deadlifts",
        "sets": 4,
        "reps": "5-6",
        "notes": "Primary back compound. Prioritize form."
      },
      {
        "name": "Barbell Rows",
        "sets": 4,
        "reps": "6-8",
        "notes": "Secondary back compound"
      },
      {
        "name": "Assisted Pull-ups",
        "sets": 3,
        "reps": "8-10",
        "notes": "Build lat strength"
      },
      {
        "name": "Barbell Curls",
        "sets": 3,
        "reps": "8-10",
        "notes": "Core bicep builder"
      },
      {
        "name": "Dumbbell Curls",
        "sets": 3,
        "reps": "10-12",
        "notes": "Unilateral work"
      }
    ]
  },
  "Day 3": {
    "muscle_group": "Rest/Light Cardio",
    "exercises": [
      {
        "name": "Light Cardio",
        "sets": 1,
        "reps": "20-30 mins",
        "notes": "Walking, cycling, or swimming for recovery"
      }
    ]
  },
  "Day 4": {
    "muscle_group": "Legs",
    "exercises": [
      {
        "name": "Barbell Squats",
        "sets": 4,
        "reps": "6-8",
        "notes": "Main leg compound"
      },
      {
        "name": "Romanian Deadlifts",
        "sets": 3,
        "reps": "8-10",
        "notes": "Hamstring focus"
      },
      {
        "name": "Leg Press",
        "sets": 3,
        "reps": "8-10",
        "notes": "Secondary compound"
      },
      {
        "name": "Leg Curls",
        "sets": 3,
        "reps": "10-12",
        "notes": "Hamstring isolation"
      },
      {
        "name": "Leg Extensions",
        "sets": 3,
        "reps": "10-12",
        "notes": "Quadricep isolation"
      }
    ]
  },
  "Day 5": {
    "muscle_group": "Shoulders",
    "exercises": [
      {
        "name": "Military Press",
        "sets": 4,
        "reps": "6-8",
        "notes": "Main shoulder compound"
      },
      {
        "name": "Lateral Raises",
        "sets": 3,
        "reps": "12-15",
        "notes": "Shoulder width building"
      },
      {
        "name": "Reverse Pec Deck",
        "sets": 3,
        "reps": "12-15",
        "notes": "Rear deltoid work"
      },
      {
        "name": "Shrugs",
        "sets": 3,
        "reps": "10-12",
        "notes": "Trapezius development"
      }
    ]
  },
  "Day 6": {
    "muscle_group": "Full Body / Arms",
    "exercises": [
      {
        "name": "Compound Circuit",
        "sets": 3,
        "reps": "30 mins",
        "notes": "Mix of lighter compounds and isolation"
      }
    ]
  },
  "Day 7": {
    "muscle_group": "Complete Rest",
    "exercises": [
      {
        "name": "Rest Day",
        "sets": 1,
        "reps": "Recovery",
        "notes": "No gym training. Focus on nutrition and sleep."
      }
    ]
  }
}
```

---

## Diet Plan Generation

### Example Request Data
```php
$data = [
    'age' => 28,
    'weight' => 75.5,
    'height' => 178,
    'goal' => 'Muscle Gain',
    'level' => 'Intermediate'
];
```

### Generated Prompt
```
Generate a personalized daily diet plan in JSON format.

Member Details:
- Age: 28 years
- Weight: 75.5 kg
- Height: 178 cm
- Goal: Muscle Gain
- Experience Level: Intermediate

Requirements:
1. Create daily meals with sections: breakfast, lunch, dinner, snacks
2. For each meal include:
   - name: Meal name
   - foods: Array of foods
   - macros: estimated protein, carbs, fats
   - calories: estimated total
   - notes: Preparation tips
3. Use simple, affordable foods
4. Adjust calories/macros based on goal and weight
5. Make it realistic and easy to follow

Return ONLY valid JSON, no markdown or extra text. Example structure:
{
  "breakfast": {
    "name": "Oatmeal with Berries",
    "foods": ["Oatmeal", "Banana", "Blueberries"],
    "macros": {
      "protein": 15,
      "carbs": 45,
      "fats": 8
    },
    "calories": 300,
    "notes": "Mix with water or milk"
  }
}

Generate the complete daily meal plan now:
```

### Example JSON Response
```json
{
  "breakfast": {
    "name": "Protein Pancakes with Fruits",
    "foods": [
      "Oats (50g)",
      "Whole Eggs (3)",
      "Banana (1 large)",
      "Blueberries (100g)",
      "Honey (1 tbsp)"
    ],
    "macros": {
      "protein": 25,
      "carbs": 60,
      "fats": 12
    },
    "calories": 475,
    "notes": "Blend oats into flour, mix with eggs, cook as pancakes. Add fruits and honey on top."
  },
  "lunch": {
    "name": "Grilled Chicken with Rice & Broccoli",
    "foods": [
      "Chicken Breast (200g)",
      "White Rice (150g cooked)",
      "Broccoli (250g)",
      "Olive Oil (1 tbsp)",
      "Salt & Pepper"
    ],
    "macros": {
      "protein": 48,
      "carbs": 65,
      "fats": 15
    },
    "calories": 650,
    "notes": "Grill seasoned chicken, steam broccoli, cook rice separately. Mix with olive oil."
  },
  "snack_1": {
    "name": "Greek Yogurt with Granola",
    "foods": [
      "Greek Yogurt (200g)",
      "Granola (50g)",
      "Honey (1 tbsp)",
      "Almonds (20g)"
    ],
    "macros": {
      "protein": 20,
      "carbs": 45,
      "fats": 10
    },
    "calories": 380,
    "notes": "Mix yogurt, top with granola and honey. Add almonds for crunch."
  },
  "dinner": {
    "name": "Salmon Filet with Sweet Potato",
    "foods": [
      "Salmon Filet (220g)",
      "Sweet Potato (250g)",
      "Asparagus (200g)",
      "Olive Oil (1 tbsp)",
      "Lemon (1/2)"
    ],
    "macros": {
      "protein": 42,
      "carbs": 50,
      "fats": 16
    },
    "calories": 620,
    "notes": "Bake salmon at 400°F for 12-15 mins. Roast sweet potato. Steam asparagus. Finish with lemon."
  },
  "snack_2": {
    "name": "Casein Protein Shake",
    "foods": [
      "Casein Protein (40g)",
      "Milk (250ml)",
      "Peanut Butter (1 tbsp)",
      "Banana (1 medium)"
    ],
    "macros": {
      "protein": 35,
      "carbs": 35,
      "fats": 12
    },
    "calories": 420,
    "notes": "Blend all ingredients until smooth. Consume before bed for sustained protein release."
  }
}
```

### Daily Totals (Muscle Gain Focus)
```
Total Calories: 2,545 kcal
Total Protein: 170g
Total Carbs: 255g
Total Fats: 65g

Macro Percentages:
- Protein: 27% (ideal for muscle gain)
- Carbs: 40% (energy for workouts)
- Fats: 23% (hormone support)
```

---

## Alternative Scenarios

### Fat Loss Goal (Age 30, 80kg, 175cm, Beginner)
```json
{
  "breakfast": {
    "name": "Egg White Scramble with Vegetables",
    "foods": ["Egg Whites (6)", "Spinach (100g)", "Tomato (1)", "Mushrooms (100g)", "Toast (1 slice)"],
    "macros": {"protein": 20, "carbs": 25, "fats": 5},
    "calories": 220,
    "notes": "Cook in non-stick pan with minimal oil"
  },
  "lunch": {
    "name": "Lean Turkey Breast with Vegetables",
    "foods": ["Turkey Breast (200g)", "Brown Rice (100g cooked)", "Carrots (150g)", "Cauliflower (150g)"],
    "macros": {"protein": 45, "carbs": 40, "fats": 8},
    "calories": 420,
    "notes": "Steam vegetables, cook turkey separately"
  },
  "dinner": {
    "name": "White Fish with Sweet Potato",
    "foods": ["Tilapia (220g)", "Sweet Potato (150g)", "Green Beans (200g)"],
    "macros": {"protein": 40, "carbs": 30, "fats": 6},
    "calories": 360,
    "notes": "Bake fish, steam vegetables"
  }
}
```

### General Fitness (Age 35, 70kg, 170cm, Intermediate)
```json
{
  "breakfast": {
    "name": "Oatmeal with Almonds",
    "foods": ["Oats (50g)", "Almond Milk (300ml)", "Almonds (25g)", "Honey (1 tbsp)"],
    "macros": {"protein": 12, "carbs": 45, "fats": 10},
    "calories": 320,
    "notes": "Cook oats, top with almonds"
  },
  "lunch": {
    "name": "Balanced Chicken Meal",
    "foods": ["Chicken Breast (150g)", "Pasta (80g dry)", "Tomato Sauce (100g)", "Olive Oil (1 tbsp)"],
    "macros": {"protein": 35, "carbs": 55, "fats": 10},
    "calories": 480,
    "notes": "Cook pasta, mix with sauce and chicken"
  },
  "dinner": {
    "name": "Beef & Vegetables",
    "foods": ["Lean Ground Beef (180g)", "Brown Rice (80g cooked)", "Bell Pepper (150g)", "Onion (100g)"],
    "macros": {"protein": 35, "carbs": 40, "fats": 12},
    "calories": 450,
    "notes": "Stir-fry beef and vegetables, serve with rice"
  }
}
```

---

## Data Formatting in Code

### Workout Plan Usage
```php
// In controller
$plan = $this->aiService->generateWorkoutPlan($data);
// Returns: array with Day 1-7 keys

// In view
foreach ($formattedWorkout as $day => $details) {
    // $day = "Day 1"
    // $details['muscle_group'] = "Chest & Triceps"
    // $details['exercises'] = array of exercises
}
```

### Diet Plan Usage
```php
// In controller
$plan = $this->aiService->generateDietPlan($data);
// Returns: array with meal types

// In view
foreach ($formattedDiet as $mealType => $meal) {
    // $mealType = "breakfast", "lunch", etc.
    // $meal['foods'] = ["Food 1", "Food 2", ...]
    // $meal['macros'] = ['protein' => 20, 'carbs' => 45, 'fats' => 10]
    // $meal['calories'] = 475
}
```

---

## Tips for Custom Prompts

### Adjust Intensity
```php
// Increase difficulty for Advanced users
"Adjust intensity based on experience level. For {$data['level']} athletes, prioritize..."
```

### Dietary Restrictions
```php
// Add restrictions (future enhancement)
"Avoid: nuts, dairy, gluten, etc."
```

### Equipment Constraints
```php
// Home workout vs gym
"Equipment available: Dumbbells only" or "Full gym access"
```

### Recovery Focus
```php
// Emphasize recovery
"Include recovery days and mobility work"
```

---

## Response Validation in Code

```php
// In AIService.php
private function extractJson(string $text): string {
    if (preg_match('/\{.*\}/s', $text, $matches)) {
        return $matches[0];  // Extract JSON object
    }
    throw new Exception('No JSON found in response');
}

// Validate structure
$parsed = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception('Invalid JSON: ' . json_last_error_msg());
}
```

---

## Common Response Patterns

### Valid Response
```
I'll create a personalized 7-day workout plan...

{
  "Day 1": { ... }
}
```

### Response with Explanation
```
Based on your intermediate level and muscle gain goal, I recommend a push/pull/legs split...

{
  "Day 1": { ... }
}
```

### Short Response (Fallback Used)
If Claude returns less than expected, the system uses fallback plans automatically.

---

**Last Updated:** 2026-05-04
**Status:** ✅ Ready for Use
