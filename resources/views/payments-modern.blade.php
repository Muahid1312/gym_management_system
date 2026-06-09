@extends('layouts.app-modern')

@section('content')
<!-- Toolbar -->
<div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 250px; display: flex; align-items: center; gap: 8px; background-color: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 0 16px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px; color: #94A3B8; flex-shrink: 0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
        </svg>
        <input type="text" placeholder="Search payments..." style="flex: 1; border: none; outline: none; padding: 10px 0; background: none; font-size: 14px;">
    </div>

    <select style="padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 12px; background-color: white; font-size: 14px; cursor: pointer;">
        <option>All Status</option>
        <option>Completed</option>
        <option>Pending</option>
        <option>Failed</option>
        <option>Refunded</option>
    </select>

    <button class="btn btn-primary btn-pill">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Record Payment
    </button>
</div>

<!-- Payment Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
        <div class="stat-icon orange" style="width: 60px; height: 60px; font-size: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008z" />
            </svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Total Revenue</div>
            <div style="font-size: 24px; font-weight: 700; color: #1F2937;">$156,230</div>
        </div>
    </div>

    <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
        <div class="stat-icon green" style="width: 60px; height: 60px; font-size: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Completed</div>
            <div style="font-size: 24px; font-weight: 700; color: #1F2937;">342</div>
        </div>
    </div>

    <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
        <div class="stat-icon" style="width: 60px; height: 60px; font-size: 32px; background-color: #FEF9C3; color: #CA8A04;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M6.72 5.66l11.62 11.62A8.25 8.25 0 105.109 3.109a.75.75 0 111.611.611ZM18 9.75a.75.75 0 100-1.5.75.75 0 000 1.5Z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Pending</div>
            <div style="font-size: 24px; font-weight: 700; color: #1F2937;">18</div>
        </div>
    </div>
</div>

<!-- Payments Table Card -->
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Plan</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #1F2937;">John Doe</div>
                        <div style="font-size: 12px; color: #94A3B8;">john@example.com</div>
                    </td>
                    <td><strong>$299.99</strong></td>
                    <td><span class="badge badge-info">Premium</span></td>
                    <td>June 1, 2026</td>
                    <td>Credit Card</td>
                    <td><span class="badge badge-active">Completed</span></td>
                    <td>
                        <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #1F2937;">Sarah Miller</div>
                        <div style="font-size: 12px; color: #94A3B8;">sarah@example.com</div>
                    </td>
                    <td><strong>$149.99</strong></td>
                    <td><span class="badge badge-info">Standard</span></td>
                    <td>May 28, 2026</td>
                    <td>Bank Transfer</td>
                    <td><span class="badge badge-active">Completed</span></td>
                    <td>
                        <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #1F2937;">Mike Chen</div>
                        <div style="font-size: 12px; color: #94A3B8;">mike@example.com</div>
                    </td>
                    <td><strong>$79.99</strong></td>
                    <td><span class="badge badge-info">Basic</span></td>
                    <td>May 20, 2026</td>
                    <td>Cash</td>
                    <td><span class="badge badge-pending">Pending</span></td>
                    <td>
                        <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #1F2937;">Emma Johnson</div>
                        <div style="font-size: 12px; color: #94A3B8;">emma@example.com</div>
                    </td>
                    <td><strong>$299.99</strong></td>
                    <td><span class="badge badge-info">Premium</span></td>
                    <td>May 15, 2026</td>
                    <td>Credit Card</td>
                    <td><span class="badge badge-expired">Failed</span></td>
                    <td>
                        <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
