<!-- REUSABLE COMPONENTS FOR MODERN GYM MANAGEMENT UI -->

<!-- ============================================
     STAT CARD COMPONENT
     ============================================ -->
@component('components.stat-card', [
    'title' => 'Total Members',
    'value' => '1,245',
    'trend' => '+5.2%',
    'trendLabel' => 'vs last month',
    'icon' => 'user',
    'color' => 'blue'
])
@endcomponent

<!-- ============================================
     STATUS BADGE COMPONENT
     ============================================ -->
@component('components.status-badge', [
    'status' => 'active',
    'label' => 'Active'
])
@endcomponent

<!-- Possible status values: active, expired, pending, info -->

<!-- ============================================
     FORM INPUT COMPONENT
     ============================================ -->
@component('components.form-input', [
    'label' => 'Email Address',
    'name' => 'email',
    'type' => 'email',
    'placeholder' => 'Enter your email',
    'required' => true,
    'value' => old('email', '')
])
@endcomponent

<!-- ============================================
     FORM SELECT COMPONENT
     ============================================ -->
@component('components.form-select', [
    'label' => 'Membership Plan',
    'name' => 'plan',
    'options' => [
        'basic' => 'Basic - 3 Months',
        'standard' => 'Standard - 6 Months',
        'premium' => 'Premium - 12 Months',
    ],
    'required' => true,
    'value' => old('plan', '')
])
@endcomponent

<!-- ============================================
     BUTTON VARIANTS
     ============================================ -->
<!-- Primary Button -->
<button class="btn btn-primary btn-pill">Save Changes</button>

<!-- Secondary Button -->
<button class="btn btn-secondary btn-pill">Cancel</button>

<!-- With Icon -->
<button class="btn btn-primary btn-pill">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    Add New
</button>

<!-- ============================================
     TABLE COMPONENT EXAMPLE
     ============================================ -->
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>
                        <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================
     EMPTY STATE COMPONENT
     ============================================ -->
<div style="text-align: center; padding: 60px 24px; background-color: white; border-radius: 12px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);">
    <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
    <h3 style="font-size: 18px; font-weight: 700; color: #1F2937; margin: 0 0 8px 0;">No Members Found</h3>
    <p style="font-size: 14px; color: #94A3B8; margin: 0 0 24px 0;">Start adding members to your gym to see them here.</p>
    <button class="btn btn-primary btn-pill">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add First Member
    </button>
</div>

<!-- ============================================
     LOADING SKELETON
     ============================================ -->
<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .skeleton {
        background-color: #E2E8F0;
        border-radius: 8px;
        animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .skeleton-text {
        height: 12px;
        margin-bottom: 8px;
    }

    .skeleton-card {
        padding: 24px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .skeleton-stat-card {
        padding: 24px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 16px;
    }
</style>

<div class="skeleton-card">
    <div class="skeleton skeleton-text" style="width: 40%;"></div>
    <div class="skeleton skeleton-text" style="width: 100%;"></div>
    <div class="skeleton skeleton-text" style="width: 100%;"></div>
    <div class="skeleton skeleton-text" style="width: 60%;"></div>
</div>

<!-- ============================================
     NOTIFICATION COMPONENT
     ============================================ -->
<div style="position: fixed; top: 20px; right: 20px; background-color: white; border-radius: 12px; padding: 16px 20px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12); display: flex; align-items: flex-start; gap: 12px; max-width: 400px; z-index: 9999;">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; color: #10B981; flex-shrink: 0; margin-top: 2px;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <div>
        <div style="font-weight: 600; color: #1F2937; font-size: 14px;">Success!</div>
        <div style="font-size: 12px; color: #64748B; margin-top: 4px;">Member added successfully</div>
    </div>
    <button style="background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 20px; padding: 0; margin-left: 8px;">×</button>
</div>

<!-- ============================================
     DRAWER/MODAL OVERLAY
     ============================================ -->
<div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1400;" id="overlay"></div>

<!-- ============================================
     RESPONSIVE GRID LAYOUTS
     ============================================ -->

<!-- 4-Column Grid (Desktop) -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
    <!-- Cards here -->
</div>

<!-- 2-Column Grid (Charts) -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Left: Chart (60%) -->
    <!-- Right: Stats (40%) -->
</div>

<!-- Responsive Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <!-- Auto-responsive cards -->
</div>

<!-- ============================================
     RESPONSIVE BEHAVIOR NOTES
     ============================================ -->
<!--
DESKTOP (1200px+):
- Sidebar: 260px fixed, always visible
- Main content: flex 1
- Stat cards: 4 columns
- Charts: 2 columns (60/40)
- Tables: Full width with horizontal scroll

TABLET (768px - 1023px):
- Sidebar: 80px (icon-only)
- Nav labels hidden
- Stat cards: 2 columns
- Charts: Stack to 1 column
- User info in footer hidden

MOBILE (< 768px):
- Sidebar: Hidden by default, hamburger menu
- Search box: Hidden in header
- Stat cards: 1 column
- Drawer: Full width
- Tables: Horizontal scroll with sticky first column

IMPLEMENTATION:
All responsive styles are included in the main layout CSS
using @media queries.
-->

<!-- ============================================
     COLOR REFERENCE
     ============================================ -->
<!--
PRIMARY ACCENT: #F97316 (Electric Orange)
  - Buttons, active nav items, links
  - Usage: btn-primary, active states

SECONDARY: #1E40AF (Deep Blue)
  - Charts, secondary elements
  - Usage: stat icons, secondary badges

SIDEBAR: #0F172A (Dark Navy)
  - Fixed background
  - Text: #E2E8F0 (Light gray)

STATUS COLORS:
  - Active: #16A34A (Green)
  - Expired: #DC2626 (Red)
  - Pending: #CA8A04 (Amber)
  - Info: #1E40AF (Blue)

NEUTRAL:
  - Background: #F8FAFC (Very light blue-gray)
  - Content bg: #FFFFFF (White)
  - Border: #E2E8F0 (Light gray)
  - Text: #1F2937 (Dark gray)
  - Muted: #64748B (Medium gray)

SHADOWS:
  - Regular: 0 4px 24px rgba(0, 0, 0, 0.08)
  - Small: 0 1px 3px rgba(0, 0, 0, 0.05)
  - Hover: 0 8px 32px rgba(0, 0, 0, 0.12)
-->

<!-- ============================================
     ICON USAGE (Heroicons)
     ============================================ -->
<!--
Dashboard: Chart icon
Members: Users/People icon
Trainers: Briefcase icon
Payments: Credit card icon
Attendance: Checkmark circle icon
Schedules: Calendar icon
Reports: Document/Chart icon
Settings: Cog/Gear icon
Plus/Add: Plus icon
Edit: Pencil icon
Delete: Trash icon
Search: Magnifying glass icon
Notifications: Bell icon with badge
Profile: User circle icon
-->
