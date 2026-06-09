@extends('layouts.app-modern')

@section('content')
<!-- KPI Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <!-- Total Members Card -->
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 001.591-.079 8.988 8.988 0 011.949 1.379M15 19.128v-.008a9.46 9.46 0 00-3.608-9.375m0 0a3.75 3.75 0 11-7.5 0m7.5 0a3.75 3.75 0 11-7.5 0m6 0h.008v.008h-.008v-.008zm0 0h6m-6 0v6m0-6v-6" />
            </svg>
        </div>
        <div class="stat-content">
            <h3>Total Members</h3>
            <p>{{ $totalMembers ?? 1245 }}</p>
            <div class="stat-trend positive">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16.5h6m6-3H9.75m15-3v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 16.5v-12m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V3m0 5.25v12" />
                </svg>
                +5.2% vs last month
            </div>
        </div>
    </div>

    <!-- Active Memberships Card -->
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="stat-content">
            <h3>Active Memberships</h3>
            <p>{{ $activeMemberships ?? 892 }}</p>
            <div class="stat-trend positive">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16.5h6m6-3H9.75m15-3v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 16.5v-12m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V3m0 5.25v12" />
                </svg>
                +3.8% vs last month
            </div>
        </div>
    </div>

    <!-- Revenue This Month Card -->
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008z" />
            </svg>
        </div>
        <div class="stat-content">
            <h3>Revenue This Month</h3>
            <p>${{ number_format($monthlyRevenue ?? 45230, 0) }}</p>
            <div class="stat-trend positive">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16.5h6m6-3H9.75m15-3v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 16.5v-12m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V3m0 5.25v12" />
                </svg>
                +12.5% vs last month
            </div>
        </div>
    </div>

    <!-- Today's Attendance Card -->
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #F3E8FF; color: #7C3AED;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9 9a3 3 0 119.194-1.045 1.5 1.5 0 01-1.02 1.97l-.464.093a1.5 1.5 0 00-1.262 1.889l.158 1.423a1.5 1.5 0 01-1.403 1.762h-.846a1.5 1.5 0 01-1.5-1.5V9a.75.75 0 00-.75-.75H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="stat-content">
            <h3>Today's Attendance</h3>
            <p>{{ $todayAttendance ?? 234 }}</p>
            <div class="stat-trend">
                <span style="color: #64748B;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; display: inline;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 19.5m0 0l-7.5-6m7.5 6V6" />
                    </svg>
                    +8% vs yesterday
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    <!-- Monthly Revenue Chart -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Monthly Revenue</h3>
                <p class="card-subtitle">Last 6 months</p>
            </div>
            <button class="btn btn-secondary btn-pill" style="padding: 6px 16px; font-size: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12" />
                </svg>
                Export
            </button>
        </div>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Membership Types Donut Chart -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">Membership Types</h3>
                <p class="card-subtitle">Distribution</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="membershipChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Members Table -->
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Recent Members</h3>
            <p class="card-subtitle">Latest sign-ups</p>
        </div>
        <a href="/members" class="btn btn-primary">View All</a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Join Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">JD</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">John Doe</div>
                                <div style="font-size: 12px; color: #94A3B8;">john@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Premium - 12 months</td>
                    <td>June 1, 2026</td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                                </svg>
                            </button>
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #EF4444;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.75a1.125 1.125 0 00-2.25 0v.003L9.26 9m-4.788 0l.015-.207a1.126 1.126 0 012.252 0l.015.207M6.75 15.75v2.25" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">SM</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Sarah Miller</div>
                                <div style="font-size: 12px; color: #94A3B8;">sarah@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Standard - 6 months</td>
                    <td>May 28, 2026</td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                                </svg>
                            </button>
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #EF4444;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.75a1.125 1.125 0 00-2.25 0v.003L9.26 9m-4.788 0l.015-.207a1.126 1.126 0 012.252 0l.015.207M6.75 15.75v2.25" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">MC</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Mike Chen</div>
                                <div style="font-size: 12px; color: #94A3B8;">mike@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Basic - 3 months</td>
                    <td>May 15, 2026</td>
                    <td><span class="badge badge-pending">Pending</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                                </svg>
                            </button>
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #EF4444;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.75a1.125 1.125 0 00-2.25 0v.003L9.26 9m-4.788 0l.015-.207a1.126 1.126 0 012.252 0l.015.207M6.75 15.75v2.25" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">EJ</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Emma Johnson</div>
                                <div style="font-size: 12px; color: #94A3B8;">emma@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Premium - 12 months</td>
                    <td>May 10, 2026</td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                                </svg>
                            </button>
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #EF4444;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.75a1.125 1.125 0 00-2.25 0v.003L9.26 9m-4.788 0l.015-.207a1.126 1.126 0 012.252 0l.015.207M6.75 15.75v2.25" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">DB</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">David Brown</div>
                                <div style="font-size: 12px; color: #94A3B8;">david@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Standard - 6 months</td>
                    <td>April 28, 2026</td>
                    <td><span class="badge badge-expired">Expired</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #0F5CFF;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 20.25" />
                                </svg>
                            </button>
                            <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; color: #EF4444;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.75a1.125 1.125 0 00-2.25 0v.003L9.26 9m-4.788 0l.015-.207a1.126 1.126 0 012.252 0l.015.207M6.75 15.75v2.25" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue',
                data: [32000, 38000, 35000, 42000, 41000, 45000],
                borderColor: '#F97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#F97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Membership Chart
    const membershipCtx = document.getElementById('membershipChart').getContext('2d');
    new Chart(membershipCtx, {
        type: 'doughnut',
        data: {
            labels: ['Premium', 'Standard', 'Basic', 'Trial'],
            datasets: [{
                data: [350, 300, 200, 42],
                backgroundColor: ['#F97316', '#1E40AF', '#10B981', '#F3E8FF'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 20
                    }
                }
            }
        }
    });
</script>
@endsection
