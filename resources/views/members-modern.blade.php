@extends('layouts.app-modern')

@section('content')
<div x-data="memberManager()">
    <!-- Toolbar -->
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px; display: flex; align-items: center; gap: 8px; background-color: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 0 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px; color: #94A3B8; flex-shrink: 0;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
            </svg>
            <input type="text" placeholder="Search members..." style="flex: 1; border: none; outline: none; padding: 10px 0; background: none; font-size: 14px;">
        </div>

        <select style="padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 12px; background-color: white; font-size: 14px; cursor: pointer;">
            <option>All Plans</option>
            <option>Premium</option>
            <option>Standard</option>
            <option>Basic</option>
            <option>Trial</option>
        </select>

        <select style="padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 12px; background-color: white; font-size: 14px; cursor: pointer;">
            <option>All Status</option>
            <option>Active</option>
            <option>Expired</option>
            <option>Pending</option>
            <option>Inactive</option>
        </select>

        <button class="btn btn-primary btn-pill" @click="openDrawer()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add Member
        </button>
    </div>

    <!-- Members Table Card -->
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Phone</th>
                        <th>Plan</th>
                        <th>Join Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Member Row 1 -->
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
                        <td>+1 (555) 123-4567</td>
                        <td><span class="badge badge-info">Premium</span></td>
                        <td>Jan 15, 2026</td>
                        <td>Jan 15, 2027</td>
                        <td><span class="badge badge-active">Active</span></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;" @click="editMember(1)">
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

                    <!-- Member Row 2 -->
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
                        <td>+1 (555) 234-5678</td>
                        <td><span class="badge badge-info">Standard</span></td>
                        <td>Feb 20, 2026</td>
                        <td>Aug 20, 2026</td>
                        <td><span class="badge badge-active">Active</span></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;" @click="editMember(2)">
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

                    <!-- Member Row 3 -->
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
                        <td>+1 (555) 345-6789</td>
                        <td><span class="badge badge-info">Basic</span></td>
                        <td>Mar 10, 2026</td>
                        <td>Jun 10, 2026</td>
                        <td><span class="badge badge-pending">Pending</span></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;" @click="editMember(3)">
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

                    <!-- Member Row 4 -->
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
                        <td>+1 (555) 456-7890</td>
                        <td><span class="badge badge-info">Premium</span></td>
                        <td>Dec 05, 2025</td>
                        <td>Dec 05, 2026</td>
                        <td><span class="badge badge-active">Active</span></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;" @click="editMember(4)">
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

                    <!-- Member Row 5 -->
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
                        <td>+1 (555) 567-8901</td>
                        <td><span class="badge badge-info">Standard</span></td>
                        <td>Oct 01, 2025</td>
                        <td>Apr 01, 2026</td>
                        <td><span class="badge badge-expired">Expired</span></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button class="icon-button" style="width: 32px; height: 32px; background: none; border: none;" @click="editMember(5)">
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

        <!-- Pagination -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 20px; border-top: 1px solid var(--border-color); margin-top: 20px;">
            <div style="font-size: 12px; color: #94A3B8;">
                Showing <strong>1</strong> to <strong>5</strong> of <strong>127</strong> members
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="btn btn-secondary btn-pill" style="padding: 6px 12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button class="btn btn-primary btn-pill" style="padding: 6px 12px;">1</button>
                <button class="btn btn-secondary btn-pill" style="padding: 6px 12px;">2</button>
                <button class="btn btn-secondary btn-pill" style="padding: 6px 12px;">3</button>
                <button class="btn btn-secondary btn-pill" style="padding: 6px 12px;">...</button>
                <button class="btn btn-secondary btn-pill" style="padding: 6px 12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Member Drawer -->
    <div class="drawer" :class="{ active: showDrawer }" id="memberDrawer">
        <div class="drawer-header">
            <h2 class="drawer-title" x-text="isEditing ? 'Edit Member' : 'Add New Member'"></h2>
            <button class="drawer-close" @click="closeDrawer()">×</button>
        </div>

        <form class="drawer-body" @submit.prevent="saveMember()">
            <!-- Personal Info Section -->
            <div class="form-section">
                <h3 class="form-section-title">Personal Information</h3>

                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" x-model="form.firstName" placeholder="Enter first name" required>
                    <div class="form-error" x-show="errors.firstName" x-text="errors.firstName"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" x-model="form.lastName" placeholder="Enter last name" required>
                    <div class="form-error" x-show="errors.lastName" x-text="errors.lastName"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" x-model="form.email" placeholder="Enter email address" required>
                    <div class="form-error" x-show="errors.email" x-text="errors.email"></div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" x-model="form.phone" placeholder="+1 (555) 000-0000">
                    <div class="form-error" x-show="errors.phone" x-text="errors.phone"></div>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" x-model="form.dob">
                </div>
            </div>

            <!-- Membership Plan Section -->
            <div class="form-section">
                <h3 class="form-section-title">Membership Plan</h3>

                <div class="form-group">
                    <label for="plan">Select Plan</label>
                    <select id="plan" x-model="form.plan" required>
                        <option value="">Choose a plan</option>
                        <option value="basic">Basic - 3 Months</option>
                        <option value="standard">Standard - 6 Months</option>
                        <option value="premium">Premium - 12 Months</option>
                        <option value="trial">Trial - 7 Days</option>
                    </select>
                    <div class="form-error" x-show="errors.plan" x-text="errors.plan"></div>
                </div>

                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" id="startDate" x-model="form.startDate" required>
                    <div class="form-error" x-show="errors.startDate" x-text="errors.startDate"></div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" x-model="form.status" required>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="paused">Paused</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="form-section">
                <h3 class="form-section-title">Payment Information</h3>

                <div class="form-group">
                    <label for="amount">Plan Amount</label>
                    <input type="number" id="amount" x-model="form.amount" placeholder="0.00" step="0.01" required>
                    <div class="form-error" x-show="errors.amount" x-text="errors.amount"></div>
                </div>

                <div class="form-group">
                    <label for="paymentMethod">Payment Method</label>
                    <select id="paymentMethod" x-model="form.paymentMethod" required>
                        <option value="">Select payment method</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="check">Check</option>
                    </select>
                    <div class="form-error" x-show="errors.paymentMethod" x-text="errors.paymentMethod"></div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea id="notes" x-model="form.notes" placeholder="Add any additional notes..." style="resize: vertical; min-height: 80px;"></textarea>
                </div>
            </div>
        </form>

        <div class="drawer-footer">
            <button type="button" class="btn btn-secondary btn-pill" style="flex: 1;" @click="closeDrawer()">Cancel</button>
            <button type="button" class="btn btn-primary btn-pill" style="flex: 1;" @click="saveMember()" x-text="isEditing ? 'Update Member' : 'Add Member'"></button>
        </div>
    </div>

    <!-- Drawer Overlay -->
    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1400; display: none;" :style="showDrawer && 'display: block'" @click="closeDrawer()"></div>
</div>

<script>
    function memberManager() {
        return {
            showDrawer: false,
            isEditing: false,
            form: {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                dob: '',
                plan: '',
                startDate: '',
                status: 'active',
                amount: '',
                paymentMethod: '',
                notes: ''
            },
            errors: {},

            openDrawer() {
                this.isEditing = false;
                this.form = {
                    firstName: '',
                    lastName: '',
                    email: '',
                    phone: '',
                    dob: '',
                    plan: '',
                    startDate: '',
                    status: 'active',
                    amount: '',
                    paymentMethod: '',
                    notes: ''
                };
                this.errors = {};
                this.showDrawer = true;
            },

            editMember(id) {
                this.isEditing = true;
                // Load member data (simulated)
                this.form = {
                    firstName: 'John',
                    lastName: 'Doe',
                    email: 'john@example.com',
                    phone: '+1 (555) 123-4567',
                    dob: '1990-05-15',
                    plan: 'premium',
                    startDate: '2026-01-15',
                    status: 'active',
                    amount: '299.99',
                    paymentMethod: 'card',
                    notes: 'Valued member'
                };
                this.errors = {};
                this.showDrawer = true;
            },

            closeDrawer() {
                this.showDrawer = false;
            },

            saveMember() {
                // Validation
                this.errors = {};
                if (!this.form.firstName) this.errors.firstName = 'First name is required';
                if (!this.form.lastName) this.errors.lastName = 'Last name is required';
                if (!this.form.email) this.errors.email = 'Email is required';
                if (!this.form.plan) this.errors.plan = 'Plan is required';
                if (!this.form.startDate) this.errors.startDate = 'Start date is required';
                if (!this.form.amount) this.errors.amount = 'Amount is required';
                if (!this.form.paymentMethod) this.errors.paymentMethod = 'Payment method is required';

                if (Object.keys(this.errors).length === 0) {
                    // Save member (API call would go here)
                    console.log('Saving member:', this.form);
                    this.showDrawer = false;
                    // Show success notification
                    alert(this.isEditing ? 'Member updated successfully!' : 'Member added successfully!');
                }
            }
        };
    }
</script>
@endsection
