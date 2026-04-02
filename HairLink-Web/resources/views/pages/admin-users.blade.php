@extends('layouts.dashboard')

@section('title', 'HairLink | Admin User Management')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">

    <header style="padding:0.6rem 0 0.2rem">
        <p style="font-size:0.72rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#9b2f69;margin-bottom:0.2rem;">Admin · Users</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.1rem);color:#261d2b;">User Management</h1>
        <p style="color:#665772;font-size:0.88rem;margin-top:0.25rem;">View and manage all registered accounts across every role.</p>
    </header>

    {{-- Role summary strip --}}
    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Donors</span>
            <strong>48</strong>
        </div>
        <div class="inv-summary-item">
            <span>Recipients</span>
            <strong>31</strong>
        </div>
        <div class="inv-summary-item">
            <span>Staff</span>
            <strong>6</strong>
        </div>
        <div class="inv-summary-item">
            <span>Wigmakers</span>
            <strong>4</strong>
        </div>
    </div>

    {{-- User table --}}
    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <h2 class="admin-card-head" style="margin-bottom:0;">
                <i class='bx bx-group' style="color:#cf2f84;"></i> All Users
            </h2>
            <div class="admin-tools">
                <input type="text" placeholder="Search name, email, or role…" data-admin-search-input aria-label="Search users">
                <button class="soft-btn" data-admin-search-btn type="button">Search</button>
                <button class="ghost-btn" type="button" data-admin-print>Export</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row>
                        <td data-user-name>Maria Santos</td>
                        <td>m.santos@email.com</td>
                        <td><span class="role-badge donor">Donor</span></td>
                        <td>Jan 05, 2026</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Jose Dela Cruz</td>
                        <td>jdelacruz@mail.com</td>
                        <td><span class="role-badge donor">Donor</span></td>
                        <td>Jan 08, 2026</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Ana Reyes</td>
                        <td>ana.reyes@gmail.com</td>
                        <td><span class="role-badge recipient">Recipient</span></td>
                        <td>Jan 15, 2026</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Roberto Lim</td>
                        <td>rlim@workmail.com</td>
                        <td><span class="role-badge recipient">Recipient</span></td>
                        <td>Jan 18, 2026</td>
                        <td><span class="admin-chip inactive" data-user-chip="inactive">Inactive</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Activate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Carmen Torres</td>
                        <td>c.torres@hrlink.ph</td>
                        <td><span class="role-badge staff">Staff</span></td>
                        <td>Dec 01, 2025</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Miguel Fernandez</td>
                        <td>mfernandez@wigs.ph</td>
                        <td><span class="role-badge wigmaker">Wigmaker</span></td>
                        <td>Nov 15, 2025</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Sofia Tan</td>
                        <td>softan@gmail.com</td>
                        <td><span class="role-badge donor">Donor</span></td>
                        <td>Feb 07, 2026</td>
                        <td><span class="admin-chip active" data-user-chip="active">Active</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Deactivate</button></td>
                    </tr>
                    <tr data-admin-search-row>
                        <td data-user-name>Linda Cruz</td>
                        <td>lcruz@mail.com</td>
                        <td><span class="role-badge recipient">Recipient</span></td>
                        <td>Feb 10, 2026</td>
                        <td><span class="admin-chip pending" data-user-chip="inactive">Pending</span></td>
                        <td><button class="ghost-btn" data-user-toggle type="button">Activate</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="admin-pager">
            <button class="active" type="button">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
            <button type="button">4</button>
            <button type="button">5</button>
        </div>
    </article>

</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush
