@extends('layouts.app')

@section('title', 'Add New Member')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">عضو جدید</h1>
        <p class="page-subtitle">ساختن پروفایل برای عضو جدید</p>
    </div>
    <a href="{{ route('members.index') }}" class="btn-outline">← برگشت به صفحه اعضا</a>
</div>

<div class="card">
    <div class="card-header">معلومات فرد</div>
    <div class="card-body">
        <form method="POST" action="{{ route('members.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="first_name">اسم *</label>
                    <input type="text" id="first_name" name="first_name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="last_name">تخلص *</label>
                    <input type="text" id="last_name" name="last_name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">اسم پدر *</label>
                    <input type="text" id="email" name="email" class="form-input" required placeholder="Father's full name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">شماره تماش</label>
                    <input type="tel" id="phone" name="phone" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_birth">تاریخ تولد</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label" for="gender">جنسیت</label>
                    <select id="gender" name="gender" class="form-input">
                        <option value="">انتخاب جنسیت</option>
                        <option value="male">مرد</option>
                        <option value="female">زن</option>
                        <option value="other">سایر</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label" for="address">آدرس</label>
                    <textarea id="address" name="address" class="form-input" rows="3" style="resize: vertical;"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="emergency_contact">تماس اضطراری</label>
                    <input type="text" id="emergency_contact" name="emergency_contact" class="form-input" placeholder="نام و شماره تلفن">
                </div>

                <div class="form-group">
                    <label class="form-label" for="medical_conditions">شرایط پزشکی</label>
                    <input type="text" id="medical_conditions" name="medical_conditions" class="form-input" placeholder="هر شرایط پزشکی مرتبط">
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid var(--border); margin: 24px 0;">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="plan_id">پلان عضویت *</label>
                    <select id="plan_id" name="plan_id" class="form-input" required>
                        <option value="">انتخاب پلان</option>
                        <option value="1">پلان مبتدی - AF 2,000/month</option>
                        <option value="2">پریمیم - AF 3,500/month</option>
                        <option value="3">شاگردی - AF 1,500/month</option>
                        <option value="4">فامیلی - AF 5,000/month</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="start_date">تاریخ آغاز *</label>
                    <input type="date" id="start_date" name="start_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="payment_method">روش پرداخت</label>
                    <select id="payment_method" name="payment_method" class="form-input">
                        <option value="cash">نقد</option>
                        <option value="card">کارت</option>
                        <option value="bank_transfer">انتقال بانکی</option>
                        <option value="mobile_money">پول موبایل</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="initial_payment">پرداخت اولیه (AF)</label>
                    <input type="number" id="initial_payment" name="initial_payment" class="form-input" min="0" step="0.01">
                </div>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" id="terms_accepted" name="terms_accepted" required>
                    <span style="font-size: 14px;">من به تمام قوانین باشگاه موافقم!</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn">ساخت عضو</button>
                <a href="{{ route('members.index') }}" class="btn-outline">لغو</a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-calculate plan duration and end date
document.getElementById('plan_id').addEventListener('change', function() {
    const planSelect = this;
    const startDateInput = document.getElementById('start_date');

    if (planSelect.value && startDateInput.value) {
        // In a real app, you'd fetch plan details via AJAX
        // For demo, we'll just show the concept
        console.log('Plan selected:', planSelect.value);
    }
});

document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const planSelect = document.getElementById('plan_id');

    if (planSelect.value && startDate) {
        // Calculate end date (assuming 1 month plans for demo)
        const endDate = new Date(startDate);
        endDate.setMonth(endDate.getMonth() + 1);

        // In a real app, you'd update a hidden end_date field
        console.log('End date would be:', endDate.toISOString().split('T')[0]);
    }
});
</script>
@endsection