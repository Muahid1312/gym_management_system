@extends('layouts.app-modern')

@section('content')
<!-- Toolbar -->
<div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 250px; display: flex; align-items: center; gap: 8px; background-color: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 0 16px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px; color: #94A3B8; flex-shrink: 0;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
        </svg>
        <input type="text" placeholder="Search trainers..." style="flex: 1; border: none; outline: none; padding: 10px 0; background: none; font-size: 14px;">
    </div>

    <select style="padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 12px; background-color: white; font-size: 14px; cursor: pointer;">
        <option>All Specialties</option>
        <option>Strength Training</option>
        <option>Cardio</option>
        <option>Yoga</option>
        <option>CrossFit</option>
    </select>

    <button class="btn btn-primary btn-pill">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add Trainer
    </button>
</div>

<!-- Trainers Table Card -->
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Trainer</th>
                    <th>Specialty</th>
                    <th>Clients</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">AK</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Alex Khan</div>
                                <div style="font-size: 12px; color: #94A3B8;">alex@gym.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Strength Training</td>
                    <td><strong>18</strong> clients</td>
                    <td>8 years</td>
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
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px; background: linear-gradient(135deg, #F97316, #7C3AED);">RP</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Rachel Park</div>
                                <div style="font-size: 12px; color: #94A3B8;">rachel@gym.com</div>
                            </div>
                        </div>
                    </td>
                    <td>Yoga & Flexibility</td>
                    <td><strong>24</strong> clients</td>
                    <td>5 years</td>
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
                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px; background: linear-gradient(135deg, #1E40AF, #10B981);">MC</div>
                            <div>
                                <div style="font-weight: 600; color: #1F2937;">Marcus Chen</div>
                                <div style="font-size: 12px; color: #94A3B8;">marcus@gym.com</div>
                            </div>
                        </div>
                    </td>
                    <td>CrossFit</td>
                    <td><strong>12</strong> clients</td>
                    <td>6 years</td>
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
            </tbody>
        </table>
    </div>
</div>
@endsection
