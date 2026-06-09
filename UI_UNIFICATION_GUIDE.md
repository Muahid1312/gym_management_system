# یکپارچه‌سازی UI سیستم مدیریت باشگاه

## معماری UI

### 1. طرح‌بندی اصلی (Layout)
- **فایل**: `resources/views/layouts/app.blade.php`
- **ویژگی‌ها**:
  - RTL مکمل
  - طراحی سیستم داخل‌آرشیو (رنگ‌ها، فاصله‌گذاری، تایپوگرافی)
  - نوار جانبی ثابت در سمت راست
  - نوار بالایی چسبنده
  - حمایت از تم‌های متعدد

### 2. سیستم طراحی (متغیرهای CSS)

```css
--space-8: 8px
--space-12: 12px
--space-16: 16px
--space-24: 24px

--color-primary: #0f5cff (آبی)
--color-success: #10b981 (سبز)
--color-danger: #ef4444 (قرمز)
--color-bg: #ffffff (سفید)
--color-border: #e5e7eb (خاکستری روشن)

--title-size: 18px
--subtitle-size: 14px
--text-size: 12px

--font-family: 'Vazir', sans-serif
```

### 3. اجزای اساسی

#### `<x-ui-card>` - کارت
```blade
<x-ui-card title="عنوان">
    محتوای کارت
</x-ui-card>
```

#### `<x-ui-button>` - دکمه
```blade
<x-ui-button type="primary">بیا</x-ui-button>
<x-ui-button type="secondary">لغو</x-ui-button>
<x-ui-button type="danger">حذف</x-ui-button>
<x-ui-button type="success">ذخیره</x-ui-button>
<x-ui-button type="outline">خطی</x-ui-button>
```

#### `<x-ui-input>` - ورودی
```blade
<x-ui-input name="name" label="نام" placeholder="نام خود را وارد کنید" />
```

#### `<x-ui-table>` - جدول
```blade
<x-ui-table 
    :headers="['نام', 'پلن', 'شماره تماس']"
    :rows="$data"
/>
```

### 4. کلاس‌های کمکی

| کلاس | توضیح |
|------|-------|
| `.page-header` | هدر صفحه با عنوان و توضیح |
| `.page-title` | عنوان اصلی صفحه |
| `.page-subtitle` | توضیح صفحه |
| `.grid` | شبکه واجب (خودکار) |
| `.stat-card` | کارت آمار |
| `.button-group` | گروه دکمه‌ها |
| `.table-card` | جدول درون کارت |
| `.alert alert-success` | هشدار موفقیت |
| `.alert alert-danger` | هشدار خطا |
| `.status-chip` | نشان وضعیت |

### 5. رنگ‌های وضعیت

| وضعیت | رنگ | مثال |
|------|-----|-----|
| موفقیت | سبز (#10b981) | `<span class="status-chip status-success">فعال</span>` |
| خطر | قرمز (#ef4444) | `<span class="status-chip status-error">منقضی</span>` |
| هشدار | زرد (#f59e0b) | `<span class="status-chip status-warning">پایانی</span>` |
| اطلاع | آبی (#0f5cff) | `<span class="status-chip status-info">جدید</span>` |

### 6. فرمت صفحات

```blade
@extends('layouts.app')

@section('title', 'عنوان صفحه')

@section('content')
<div class="page-header">
    <h1 class="page-title">عنوان صفحه</h1>
    <p class="page-subtitle">توضیح صفحه</p>
</div>

<x-ui-card title="بخش">
    محتوا
</x-ui-card>

@endsection
```

### 7. راهنمای انتقال

هر صفحه قدیم باید:
1. `extends('layouts.app')` استفاده کند
2. تمام استایل‌های inline را حذف کند
3. از اجزا استفاده کند
4. همه متن را فارسی کند
5. از کلاس‌های طراحی سیستم استفاده کند

### 8. چک‌لیست تکمیل

- [ ] صفحه از `layouts.app` گسترش می‌یابد
- [ ] بدون استایل inline
- [ ] از اجزای UI استفاده می‌کند
- [ ] متن تمام‌ فارسی است
- [ ] رنگ‌ها از سیستم هستند
- [ ] فاصله‌گذاری استاندارد است
- [ ] جدول‌ها صحیح format هستند
- [ ] دکمه‌ها صحیح نوع هستند
