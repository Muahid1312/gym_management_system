@extends('layouts.app')

@section('title', 'صفحه نمونه')

@section('content')
<div class="page-header">
    <h1 class="page-title">صفحه نمونه</h1>
    <p class="page-subtitle">نمونه‌ای از جدول و فرم در چیدمان راست‌چین</p>
</div>

<div class="card">
    <div class="card-header">
        فرم نمونه
    </div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label class="form-label">نام</label>
                <input type="text" class="form-input" placeholder="نام خود را وارد کنید">
            </div>
            <div class="form-group">
                <label class="form-label">ایمیل</label>
                <input type="email" class="form-input" placeholder="ایمیل خود را وارد کنید">
            </div>
            <div class="form-group">
                <label class="form-label">پیام</label>
                <textarea class="form-input" rows="4" placeholder="پیام خود را وارد کنید"></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" class="btn btn-outline">لغو</button>
                <button type="submit" class="btn btn-success">ارسال</button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        جدول نمونه
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>علی محمدی</td>
                    <td>ali@example.com</td>
                    <td><span class="status-badge status-success">فعال</span></td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn btn-outline btn-sm">ویرایش</button>
                            <button class="btn btn-danger btn-sm">حذف</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>فاطمه احمدی</td>
                    <td>fateme@example.com</td>
                    <td><span class="status-badge status-warning">معلق</span></td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn btn-outline btn-sm">ویرایش</button>
                            <button class="btn btn-danger btn-sm">حذف</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>حسن رضایی</td>
                    <td>hasan@example.com</td>
                    <td><span class="status-badge status-error">غیرفعال</span></td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button class="btn btn-outline btn-sm">ویرایش</button>
                            <button class="btn btn-danger btn-sm">حذف</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection