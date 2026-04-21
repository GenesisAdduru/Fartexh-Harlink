@extends('layouts.dashboard')

@section('title', 'HairLink | Recipient Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
    <section class="section-wrap profile-shell reveal" data-profile-page data-profile-type="recipient">
        <header class="profile-head">
            <h1>My Profile</h1>
            <p>View your recipient account details and contact information.</p>
        </header>

        <article class="profile-card">
            <div class="profile-hero">
                <div class="profile-avatar" id="profileInitials">{{ $initials }}</div>
                <div>
                    <p class="profile-name" id="profileName">{{ $fullName }}</p>
                    <span class="profile-role status-recipient" id="profileRole">{{ ucfirst($user->role ?? 'Recipient') }}</span>
                </div>
            </div>

            <div class="profile-actions">
                <button class="soft-btn" type="button" onclick="document.getElementById('editProfileModal').style.display='flex'">
                    <i class='bx bx-edit'></i> Edit Profile
                </button>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <small>Email Address</small>
                    <strong id="profileEmail">{{ $user->email }}</strong>
                </div>
                <div class="profile-item">
                    <small>Phone Number</small>
                    <strong id="profilePhone">{{ $user->phone ?? 'Not set' }}</strong>
                </div>
                <div class="profile-item">
                    <small>Age</small>
                    <strong id="profileAge">{{ $user->age ?? 'Not set' }}</strong>
                </div>
                <div class="profile-item">
                    <small>Gender</small>
                    <strong id="profileGender">{{ ucfirst($user->gender ?? 'Not set') }}</strong>
                </div>
                <div class="profile-item">
                    <small>Country</small>
                    <strong id="profileCountry">{{ strtoupper($user->country ?? 'Not set') }}</strong>
                </div>
                <div class="profile-item">
                    <small>Region / Province</small>
                    <strong id="profileRegion">{{ $user->region ?? 'Not set' }}</strong>
                </div>
                <div class="profile-item">
                    <small>Postal Code</small>
                    <strong id="profilePostalCode">{{ $user->postal_code ?? 'Not set' }}</strong>
                </div>
                <div class="profile-item" style="grid-column: span 1;">
                    <small>Member Since</small>
                    <strong id="profileJoined">{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</strong>
                </div>
                <div class="profile-item" style="grid-column: span 2;">
                    <small>Short Bio</small>
                    <strong id="profileBio" style="font-style: italic; font-weight: 500;">
                        {{ $user->bio ?? 'No bio provided.' }}
                    </strong>
                </div>
            </div>
        </article>

        <article class="referral-code-card">
            <div class="referral-code-head">
                <i class='bx bxs-gift'></i>
                <div>
                    <h3>Your Referral Code</h3>
                    <p>Share this code with friends to earn star points!</p>
                </div>
            </div>
            <div class="referral-code-display">
                <span id="myReferralCode">HL-{{ strtoupper(substr(md5('hairlink-referral-' . $user->id), 0, 8)) }}</span>
                <button class="copy-code-btn" id="copyCodeBtn" type="button">
                    <i class='bx bx-copy'></i> Copy Code
                </button>
            </div>
        </article>

        <article class="profile-stats">
            <div class="profile-stat">
                <small>Account Type</small>
                <strong>{{ ucfirst($user->role) }}</strong>
            </div>
            <div class="profile-stat">
                <small>Member Status</small>
                <strong>Active Recipient</strong>
            </div>
            <div class="profile-stat">
                <small>Quick Tip</small>
                <strong>Use your dashboard to submit and monitor hair requests.</strong>
            </div>
        </article>

        <!-- Edit Profile Modal -->
        <div id="editProfileModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4 hidden" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 10000; display: none; align-items: center; justify-content: center; padding: 1rem;">
            <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden" style="background: #fff; border-radius: 20px; width: 100%; max-width: 500px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
                <header style="padding: 1rem 1.5rem; border-bottom: 1px solid #f2ebf4; display: flex; justify-content: space-between; align-items: center; background: #fdf7fb;">
                    <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 800; color: #ad246d; margin: 0;">Edit Your Profile</h2>
                    <button type="button" style="background: none; border: none; color: #8c7895; cursor: pointer; font-size: 1.5rem;" onclick="document.getElementById('editProfileModal').style.display='none'">
                        <i class='bx bx-x'></i>
                    </button>
                </header>
                
                <form id="profileUpdateForm" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #ad246d;">First Name</label>
                            <input type="text" name="first_name" value="{{ $user->first_name }}" style="padding: 0.6rem; border: 2px solid #ead7e8; border-radius: 10px; outline: none; font-weight: 600;">
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #ad246d;">Last Name</label>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" style="padding: 0.6rem; border: 2px solid #ead7e8; border-radius: 10px; outline: none; font-weight: 600;">
                        </div>
                    </div>

                    <div class="form-group" style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #ad246d;">Phone Number</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" style="padding: 0.6rem; border: 2px solid #ead7e8; border-radius: 10px; outline: none; font-weight: 600;">
                    </div>

                    <div class="form-group" style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <label style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #ad246d;">Quick Bio</label>
                        <textarea name="bio" rows="3" style="padding: 0.6rem; border: 2px solid #ead7e8; border-radius: 10px; outline: none; font-weight: 500; resize: none;">{{ $user->bio }}</textarea>
                    </div>

                    <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem;">
                        <button type="submit" class="soft-btn" style="flex: 1; padding: 0.8rem; font-size: 0.85rem;">Save Changes</button>
                        <button type="button" class="ghost-btn" style="padding: 0.8rem; font-size: 0.85rem;" onclick="document.getElementById('editProfileModal').style.display='none'">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/profile.js') }}" defer></script>
@endpush
