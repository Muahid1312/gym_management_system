# راهنمای کامل یکپارچه‌سازی UI

## 📋 نقشه راه کامل

### مرحله ۱: آماده‌سازی (تکمیل شده ✅)
- [x] طراحی سیستم CSS (متغیرها و کلاس‌ها)
- [x] اجزای اساسی (کارت، دکمه، ورودی، جدول)
- [x] طرح‌بندی اصلی با RTL

### مرحله ۲: صفحات نمونه (درحال اجرا)
- [x] `attendance.blade.php` - صفحه حضور و غیاب
- [x] `dashboard-unified.blade.php` - صفحه داشبورد
- [ ] باقی صفحات (پرداخت‌ها، مصارف، گزارش‌ها، تنظیمات)

### مرحله ۳: تمیز‌کاری (آینده)
- [ ] حذف فایل‌های قدیم (`*-modern.blade.php`, `*-minimal.blade.php`)
- [ ] حذف تمام استایل‌های inline غیرضروری
- [ ] اطمینان از یکپارچگی کامل

---

## 🎨 الگو‌های طراحی

### الگوی صفحات
```blade
@extends('layouts.app')

@section('title', 'عنوان صفحه')

@section('content')
    <!-- هدر صفحه -->
    <div class="page-header">
        <h1 class="page-title">عنوان صفحه</h1>
        <p class="page-subtitle">توضیح کوتاه</p>
    </div>

    <!-- کارت‌های آماری -->
    <div class="grid">
        <div class="stat-card">
            <!-- محتوا -->
        </div>
    </div>

    <!-- کارت‌های محتوا -->
    <x-ui-card title="عنوان">
        <!-- محتوا -->
    </x-ui-card>

    <!-- جدول‌ها -->
    <div class="table-card">
        <table><!-- جدول --></table>
    </div>

    <!-- دکمه‌ها -->
    <x-ui-button type="primary">عنوان</x-ui-button>
@endsection
```

### قوانین ضروری
1. **بدون inline styles**: تمام استایل‌ها از `layouts/app.blade.php` باشند
2. **بدون hardcoded strings**: هر متن فارسی
3. **با اجزا**: از `<x-ui-*>` استفاده کنید
4. **RTL**: همیشه راست‌به‌چپ
5. **طراحی سیستم**: فقط رنگ‌ها و فاصله‌گذاری استاندارد

---

## 📄 صفحات مورد نیاز تعمیر

### ۱. صفحات اعضا
- **فایل**: `resources/views/members/index.blade.php`
- **وضعیت**: جزئی تکمیل ✅ (نیاز به بهبود)
- **دستورات**:
  ```blade
  <!-- جایگزینی جدول manual با -->
  <div class="table-card">
      <table>
          <thead><tr><th>نام</th><th>پلن</th><th>وضعیت</th><th>عملیات</th></tr></thead>
          <tbody>
              @foreach($members as $member)
              <tr>
                  <td>{{ $member->name }}</td>
                  <td>{{ $member->plan->name ?? '—' }}</td>
                  <td><span class="status-chip status-success">فعال</span></td>
                  <td>
                      <x-ui-button type="outline" href="{{ route('members.show', $member) }}">مشاهده</x-ui-button>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
  ```

### ۲. صفحات پرداخت‌ها
- **فایل**: `resources/views/payments/index.blade.php`
- **اجزای لازم**: جدول، فیلتر، دکمه‌های عملیات
- **الگو**: مشابه attendance و members

### ۳. صفحات مصارف
- **فایل**: `resources/views/expenses/index.blade.php`
- **الگو**: مشابه payments

### ۴. صفحات گزارش‌ها
- **فایل**: `resources/views/reports/index.blade.php`
- **اجزای خاص**: نمودار‌ها (placeholder ممکن است)

### ۵. صفحات تنظیمات
- **فایل**: `resources/views/settings/index.blade.php`
- **اجزای لازم**: فرم‌ها، toggle‌ها

---

## 🛠️ دستورالعمل‌های تعمیر

### برای هر صفحه:

1. **چک کنید** آیا از `layouts.app` گسترش می‌یابد:
   ```blade
   @extends('layouts.app')
   @section('title', 'عنوان فارسی')
   ```

2. **هدر صفحه اضافه کنید**:
   ```blade
   <div class="page-header">
       <h1 class="page-title">عنوان</h1>
       <p class="page-subtitle">توضیح</p>
   </div>
   ```

3. **هر inline style را حذف کنید**:
   ```html
   <!-- بدون: style="color: blue; margin: 20px;" -->
   <!-- بجای آن: استفاده از کلاس‌های طراحی سیستم -->
   ```

4. **از اجزا استفاده کنید**:
   ```blade
   <!-- جایگزینی دستی جدول -->
   <x-ui-table :headers="$headers" :rows="$rows" />
   
   <!-- جایگزینی دستی دکمه‌ها -->
   <x-ui-button type="primary">کلیک کنید</x-ui-button>
   
   <!-- جایگزینی دستی form input -->
   <x-ui-input name="name" label="نام" />
   ```

5. **تمام متن‌ها فارسی کنید**:
   ```blade
   <!-- بدون: "Search" -->
   <!-- بجای آن: "جستجو" -->
   ```

6. **وضعیت‌ها را درست کنید**:
   ```blade
   <!-- بدون: <span style="color: green">Active</span> -->
   <!-- بجای آن: -->
   <span class="status-chip status-success">فعال</span>
   <span class="status-chip status-error">منقضی</span>
   <span class="status-chip status-warning">هشدار</span>
   ```

---

## 🎯 چک‌لیست برای هر صفحه

- [ ] از `layouts.app` گسترش می‌یابد
- [ ] `@section('title', 'فارسی')` دارد
- [ ] `page-header` دارد
- [ ] بدون inline styles
- [ ] تمام متن‌ها فارسی
- [ ] از اجزا استفاده می‌کند
- [ ] جدول‌ها صحیح format هستند
- [ ] دکمه‌ها صحیح نوع هستند
- [ ] وضعیت‌ها با `status-chip` هستند
- [ ] تمام رنگ‌ها از سیستم هستند

---

## 📝 نمونه‌های کامل

### جدول بهتر
```blade
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>نام</th>
                <th>پلن</th>
                <th>تماس</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->plan->name ?? '—' }}</td>
                <td>{{ $item->phone ?? '—' }}</td>
                <td>
                    @if($item->is_active)
                    <span class="status-chip status-success">فعال</span>
                    @else
                    <span class="status-chip status-error">منقضی</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <x-ui-button type="outline" href="{{ route('item.show', $item) }}">مشاهده</x-ui-button>
                        <x-ui-button type="danger" href="{{ route('item.delete', $item) }}">حذف</x-ui-button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--muted);">
                    هیچ رکوردی موجود نیست
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

### فرم بهتر
```blade
<x-ui-card title="فرم">
    <form method="POST" action="{{ route('item.store') }}">
        @csrf
        <div style="display: grid; gap: 16px;">
            <x-ui-input name="name" label="نام" placeholder="نام" />
            <x-ui-input name="email" label="ایمیل" type="email" />
            <x-ui-input name="phone" label="تماس" />
            
            <div class="form-group">
                <label>وضعیت</label>
                <select name="status" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--input-border);">
                    <option value="active">فعال</option>
                    <option value="inactive">غیرفعال</option>
                </select>
            </div>

            <div class="button-group">
                <x-ui-button type="primary" tag="submit">ذخیره</x-ui-button>
                <x-ui-button type="secondary" href="{{ route('items.index') }}">انصراف</x-ui-button>
            </div>
        </div>
    </form>
</x-ui-card>
```

---

## 🚀 مراحل اجرا

### روز اول:
1. ✅ آماده‌سازی (تکمیل شد)
2. ✅ صفحات نمونه (تکمیل شد)

### روز دوم:
3. تعمیر `members/index.blade.php`
4. تعمیر `payments/index.blade.php`
5. تعمیر `expenses/index.blade.php`

### روز سوم:
6. تعمیر `reports/index.blade.php`
7. تعمیر `settings/index.blade.php`
8. تعمیر صفحات show/edit

### روز چهارم:
9. حذف فایل‌های قدیم
10. آزمایش و تصحیح
11. بررسی نهایی

---

## ⚡ سرعت بخشیدن

### دستورات جستجو مفید:
```bash
# یافتن تمام inline styles
grep -r 'style="' resources/views/

# یافتن تمام کلمات انگلیسی
grep -r 'Search\|Name\|Status\|Action' resources/views/

# یافتن صفحات قدیم
find resources/views -name '*-modern.blade.php'
find resources/views -name '*-minimal.blade.php'
```

### قالب تبدیل سریع:
```blade
<!-- OLD -->
<div style="padding: 20px; background: white; border: 1px solid #ccc; border-radius: 8px;">

<!-- NEW -->
<x-ui-card>
```

---

## 💡 نکات مهم

1. **هدر لازمی است**: هر صفحه باید `page-header` داشته باشد
2. **رنگ و فاصله ثابت**: فقط از طراحی سیستم
3. **RTL همیشه**: `dir="rtl"` در layout اعمال می‌شود
4. **فارسی شامل**: هر عنوان، لیبل، placeholder، دکمه
5. **بدون تکرار**: از اجزا استفاده کنید تا خود را تکرار نکنید

---

## 📞 درخواست کمک

اگر مشکلی داشتید:
1. الگو را در `dashboard-unified.blade.php` و `attendance.blade.php` بررسی کنید
2. کلاس‌های طراحی سیستم را در `layouts/app.blade.php` بررسی کنید
3. اجزا را در `resources/views/components/ui-*` بررسی کنید

---

**حالت**: آماده برای اجرا
**آخرین بروزرسانی**: الآن
**نسخه**: ۱.۰
