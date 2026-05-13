# PDF English Implementation - Quick Reference

## ⚡ How It Works

### Automatic Locale Override
Every PDF generation automatically:
1. Sets locale to English (`app()->setLocale('en')`)
2. Loads Blade templates that use translation keys
3. Renders with LTR layout and DejaVu Sans font
4. Returns English PDF regardless of UI language

## 🔄 PDF Generation Points

### Controllers that generate PDFs:

```php
// AIController - Fitness Plan PDFs
downloadPdf(Member $member)           // Combined compact PDF
downloadPdfProfessional(Member $member)  // Professional 2-page PDF

// ReportController
exportPdf()                            // Gym reports PDF
```

All automatically force English locale.

## 📝 Using Translations in PDF Templates

### Instead of hardcoded text:
```blade
<!-- ❌ WRONG -->
<div>برنامه تمرین و تغذیه</div>

<!-- ✅ CORRECT -->
<div>{{ __('messages.pdf_combined_plan') }}</div>
```

### Available translation keys:
- `__('messages.pdf_combined_plan')` → "Workout & Diet Plan"
- `__('messages.pdf_workout_plan')` → "Workout Plan"
- `__('messages.pdf_diet_plan')` → "Diet Plan"
- `__('messages.pdf_day')` → "Day"
- `__('messages.pdf_muscle_group')` → "Muscle Group"
- `__('messages.pdf_exercises')` → "Exercises"
- `__('messages.pdf_calories')` → "Calories"
- `__('messages.pdf_protein')` → "Protein"
- And many more...

## 🎨 PDF Layout Requirements

### For LTR (English PDFs):
```css
html {
  direction: ltr;
  text-align: left;
}

/* Use left/right correctly */
.item {
  padding-left: 12px;   /* ✅ CORRECT for LTR */
  margin-right: 10px;   /* ✅ CORRECT for LTR */
}
```

### Font:
```css
body {
  font-family: 'DejaVu Sans', Arial, sans-serif;
}
```

## 🔍 Adding New PDF Translation

1. **Add to `resources/lang/en/messages.php`:**
```php
'pdf_my_new_key' => 'My English Text',
```

2. **Use in Blade template:**
```blade
{{ __('messages.pdf_my_new_key') }}
```

## 🚀 Creating a New PDF Template

1. **Create new Blade file:**
   - Location: `resources/views/plans/pdf-*.blade.php`
   - Use `lang="en"`, `direction: ltr`, `text-align: left`

2. **Add service method:**
```php
public function generateMyPdf(Member $member): Response
{
    app()->setLocale('en');  // Force English
    
    $data = [...];
    $pdf = Pdf::loadView('plans.pdf-mytemplate', $data);
    return $pdf->download('filename.pdf');
}
```

3. **Add controller method:**
```php
public function downloadMyPdf(Member $member): Response
{
    try {
        app()->setLocale('en');  // Double-ensure
        return $this->planService->generateMyPdf($member);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
```

## 📊 Tested Scenarios

| Scenario | Result |
|----------|--------|
| UI in Persian, Generate PDF | ✅ PDF in English |
| UI in English, Generate PDF | ✅ PDF in English |
| Multiple PDF downloads | ✅ All in English |
| Report export | ✅ English report |

## 🐛 Troubleshooting

### PDF still shows Persian text?
- Check if translation key is used: `__('messages.key')`
- Verify key exists in `resources/lang/en/messages.php`
- Clear view cache: `php artisan view:clear`

### PDF layout is RTL?
- Check CSS has `direction: ltr;`
- Verify `text-align: left;`
- Check no `direction: rtl;` remains

### Characters not rendering?
- Ensure font-family includes `'DejaVu Sans'` first
- Don't use external fonts (DomPDF limitation)
- Use built-in DomPDF fonts only

## 📞 Key Files Reference

| File | Purpose |
|------|---------|
| `resources/lang/en/messages.php` | Translation keys |
| `app/Http/Controllers/AIController.php` | Fitness plan PDFs |
| `app/Http/Controllers/ReportController.php` | Report PDFs |
| `app/Services/PlanService.php` | PDF generation logic |
| `resources/views/plans/pdf-compact.blade.php` | Compact fitness plan |
| `resources/views/plans/pdf-professional.blade.php` | Professional fitness plan |

## ✅ Complete Checklist

- [x] Locale forced to English in controllers
- [x] Locale forced to English in service
- [x] All templates use `lang="en"`
- [x] All templates use `direction: ltr`
- [x] All CSS updated for LTR
- [x] All hardcoded Persian text replaced with translation keys
- [x] DejaVu Sans font specified
- [x] View cache cleared
- [x] Documentation created

---

**Last Updated:** 2026-05-08
**Status:** Ready for Production ✅
