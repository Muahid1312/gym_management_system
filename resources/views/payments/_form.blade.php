@props(["action", "method" => 'POST', "payment" => null, "members" => [], "plans" => [], "partners" => []])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="member_id" class="block text-gray-400 font-semibold mb-2">انتخاب  عضو</label>
        <select id="member_id" name="member_id" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            <option value="">انتخاب عضو...</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}" {{ (is_array(old('member_id')) ? false : old('member_id', optional($payment)->member_id)) == $member->id ? 'selected' : '' }}>
                    {{ $member->name }} ({{ $member->phone ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('member_id')
            <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
        @enderror
    </div>

    <div>
        <label for="plan_id" class="block text-gray-400 font-semibold mb-2">انتخاب پلان</label>
        <select id="plan_id" name="plan_id" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            <option value="">انتخاب پلان...</option>
            @foreach($plans as $plan)
                <option value="{{ $plan->id }}" {{ (is_array(old('plan_id')) ? false : old('plan_id', optional($payment)->plan_id)) == $plan->id ? 'selected' : '' }}>
                    {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                </option>
            @endforeach
        </select>
        @error('plan_id')
            <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label for="amount" class="block text-gray-400 font-semibold mb-2">مقدار ($)</label>
            <input id="amount" name="amount" type="number" step="0.01" value="{{ old('amount', optional($payment)->amount) }}" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" placeholder="0.00" />
            @error('amount')
                <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
            @enderror
        </div>

        <div>
            <label for="payment_method" class="block text-gray-400 font-semibold mb-2">روش پرداخت</label>
            <select id="payment_method" name="payment_method" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                <option value="cash" {{ (is_array(old('payment_method')) ? 'cash' : old('payment_method', optional($payment)->payment_method ?: 'cash')) == 'cash' ? 'selected' : '' }}>💵 نقد</option>
                <option value="online" {{ (is_array(old('payment_method')) ? false : old('payment_method', optional($payment)->payment_method)) == 'online' ? 'selected' : '' }}>💳 آنلاین</option>
            </select>
            @error('payment_method')
                <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="paid_at" class="block text-gray-400 font-semibold mb-2">تاریخ و ساعت پرداخت</label>
        <input id="paid_at" name="paid_at" type="datetime-local" value="{{ old('paid_at', optional($payment)->paid_at ? optional($payment->paid_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
        @error('paid_at')
            <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
        @enderror
    </div>

    <div>
        <label for="partner_id" class="block text-gray-400 font-semibold mb-2">شریک (اختیاری)</label>
        <select id="partner_id" name="partner_id" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            <option value="">-- بدون کمیسشن پارتنرک --</option>
            @foreach($partners as $partner)
                <option value="{{ $partner->id }}" {{ (is_array(old('partner_id')) ? false : old('partner_id', optional($payment)->partner_id)) == $partner->id ? 'selected' : '' }}>
                    {{ $partner->name }} ({{ number_format($partner->commission_percentage, 2) }}%)
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="notes" class="block text-gray-400 font-semibold mb-2">یاداشت برای پرداخت</label>
        <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" placeholder="یادداشت  برای این پرداخت اضافه کنید!">{{ old('notes', optional($payment)->notes) }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <input id="is_partial" name="is_partial" type="checkbox" value="1" {{ (old('is_partial', optional($payment)->is_partial) && !is_array(old('is_partial'))) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-blue-600 transition focus:ring-2 focus:ring-blue-500" />
        <label for="is_partial" class="text-gray-400 font-semibold cursor-pointer">علامت گذاری به عنوان پرداخت جزئی</label>
    </div>

    <div class="flex gap-3 pt-4">
        <button type="submit" class="flex-1 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">💾 {{ strtoupper($method) === 'POST' ? 'ذخیره پرداخت' : 'ذخیره تغییرات' }}</button>
        <a href="{{ route('payments.index') }}" class="flex-1 rounded-xl bg-slate-700 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-600">Cancel</a>
    </div>
</form>
