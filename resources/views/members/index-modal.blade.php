@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="page-header">
    <div style="display: flex; flex-direction: column; gap: 1rem;" class="md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="page-title">مدیریت اعضا</h1>
            <p class="page-subtitle">جستجو و فلتر اعضا</p>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            <a href="{{ route('members.create') }}" class="button">➕ عضو جدید</a>
            <a href="{{ route('members.index', array_merge(request()->except('view_mode'), ['view_mode' => 'dropdown'])) }}" class="button button-outline">👁️ نمایش به صورت لیست</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">جستجو و فلتر</h2>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}">
            <input type="hidden" name="view_mode" value="modal">

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-muted);">جستجو با نام یا شماره تلفن</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..." style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-muted);">فیتر نظر به وضیعیت عضو</label>
                    <select name="filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                        <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>تمام اعضا</option>
                        <option value="active" {{ ($filter ?? 'all') === 'active' ? 'selected' : '' }}>فعال</option>
                        <option value="expired" {{ ($filter ?? 'all') === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                        <option value="expiring_soon" {{ ($filter ?? 'all') === 'expiring_soon' ? 'selected' : '' }}>منقضی شدن به زودی</option>
                        <option value="in_debt" {{ ($filter ?? 'all') === 'in_debt' ? 'selected' : '' }}>بدهکار</option>
                    </select>
                </div>

                <div style="display: flex; align-items: end;">
                    <button type="submit" class="button" style="width: 100%;">🔍 جستجو</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">اعضا</h2>
    </div>
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: var(--surface-soft);">
                    <tr>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">عضو</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">پلان</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">انقضا</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">تمرین</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">رژیم</th>
                        <th style="padding: 0.75rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">عملکرد ها</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr style="border-bottom: 1px solid var(--border); transition: background-color 0.2s;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" style="height: 2.5rem; width: 2.5rem; border-radius: 50%; object-fit: cover;" />
                                    @else
                                        <div style="display: flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 50%; background-color: var(--primary); font-size: 0.75rem; font-weight: 700;">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                    @endif
                                    <div style="min-width: 0;">
                                        <p style="font-weight: 600; margin: 0;">{{ $member->name }}</p>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $member->phone }} · {{ $member->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">{{ $member->plan->name ?? 'N/A' }}</td>
                            <td style="padding: 1rem;">{{ $member->expiry_date?->format('Y-m-d') ?? 'N/A' }}</td>
                            <td style="padding: 1rem;">{{ ucfirst($member->workout_level) }}</td>
                            <td style="padding: 1rem;">{{ ucfirst($member->diet_level) }}</td>
                            <td style="padding: 1rem; text-align: right;">
                                <button type="button"
                                    data-member-id="{{ $member->id }}"
                                    data-member-name="{{ addslashes($member->name) }}"
                                    data-edit-url="{{ route('members.edit', $member) }}"
                                    data-qr-url="{{ route('members.qr', $member) }}"
                                    data-workout-url="{{ route('ai.workout', $member) }}"
                                    data-diet-url="{{ route('ai.diet', $member) }}"
                                    data-workout-level="{{ $member->workout_level }}"
                                    data-diet-level="{{ $member->diet_level }}"
                                    data-delete-url="{{ route('members.destroy', $member) }}"
                                    onclick="openModal(this.dataset)"
                                    class="button button-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                    عملکر ها
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1rem; width: 1rem;" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 12a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 9.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 12z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="action-modal" style="position: fixed; inset: 0; z-index: 50; display: none; align-items: center; justify-content: center; background-color: rgba(15, 23, 42, 0.8); padding: 1rem;">
    <div class="modal-content" style="width: 100%; max-width: 36rem; border-radius: 1.5rem; border: 1px solid var(--border); padding: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
            <div>
                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent);">عملکرد ها</p>
                <h2 id="modal-member-name" style="margin-top: 0.75rem; font-size: 1.5rem; font-weight: 600;">اسم عضو</h2>
                <p style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--text-muted);">انتخاب یک عملکرد برای این عضو.</p>
            </div>
            <button type="button" onclick="closeModal()" class="button button-secondary" style="border-radius: 50%; width: 2.5rem; height: 2.5rem; padding: 0;">✕</button>
        </div>

        <div style="margin-top: 1.5rem; display: grid; gap: 0.75rem;">
            <a id="modal-edit-url" href="#" class="button">✏️ ویرایش</a>
            <a id="modal-qr-url" href="#" class="button button-secondary">🔲 ساخت QR code</a>
            <form id="modal-workout-form" action="#" method="POST" style="display: inline-flex; width: 100%;">
                @csrf
                <input type="hidden" name="age" value="30">
                <input type="hidden" name="weight" value="70">
                <input type="hidden" name="height" value="170">
                <input type="hidden" name="goal" value="general fitness">
                <input type="hidden" name="level" value="">
                <button type="submit" class="button button-secondary" style="width: 100%;">🏋️ Generate Workout Plan</button>
            </form>
            <form id="modal-diet-form" action="#" method="POST" style="display: inline-flex; width: 100%;">
                @csrf
                <input type="hidden" name="age" value="30">
                <input type="hidden" name="weight" value="70">
                <input type="hidden" name="height" value="170">
                <input type="hidden" name="goal" value="general nutrition">
                <input type="hidden" name="level" value="">
                <button type="submit" class="button button-secondary" style="width: 100%;">🥗 Generate Diet Plan</button>
            </form>
        </div>

        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <form id="modal-delete-form" action="#" method="POST" onsubmit="return confirm('Delete this member? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="button button-danger" style="width: 100%;">🗑️حذف عضو</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(data) {
        const modal = document.getElementById('action-modal');
        modal.style.display = 'flex';
        document.getElementById('modal-member-name').textContent = data.memberName || data.name;
        document.getElementById('modal-edit-url').href = data.editUrl;
        document.getElementById('modal-qr-url').href = data.qrUrl;
        const workoutForm = document.getElementById('modal-workout-form');
        const dietForm = document.getElementById('modal-diet-form');

        workoutForm.action = data.workoutUrl;
        dietForm.action = data.dietUrl;
        workoutForm.querySelector('[name="level"]').value = data.workoutLevel || '';
        dietForm.querySelector('[name="level"]').value = data.dietLevel || '';
        document.getElementById('modal-delete-form').action = data.deleteUrl;
    }

    function closeModal() {
        document.getElementById('action-modal').style.display = 'none';
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('action-modal');
        if (!event.target.closest('#action-modal > div') && !event.target.closest('[onclick^="openModal"]') && modal.style.display === 'flex') {
            closeModal();
        }
    });
</script>
@endsection