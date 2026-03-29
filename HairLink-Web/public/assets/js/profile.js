document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('[data-profile-page]');
    if (!root) {
        return;
    }

    const expectedType = root.dataset.profileType || '';
    const profileRaw = localStorage.getItem('hairlinkUserProfile');
    const fallbackType = localStorage.getItem('hairlinkUserType') || expectedType;
    const fallbackEmail = localStorage.getItem('hairlinkUserEmail') || 'Not set';

    let profile = {};
    if (profileRaw) {
        try {
            profile = JSON.parse(profileRaw) || {};
        } catch (_error) {
            profile = {};
        }
    }

    const userType = (profile.userType || fallbackType || expectedType || 'donor').toLowerCase();
    const fullName = (profile.fullName || '').trim() || 'HairLink User';
    const firstName = (profile.firstName || '').trim();
    const lastName = (profile.lastName || '').trim();
    const initials = `${firstName[0] || fullName[0] || 'H'}${lastName[0] || fullName.split(' ')[1]?.[0] || 'L'}`.toUpperCase();

    const fields = {
        profileInitials: initials,
        profileName: fullName,
        profileRole: userType.charAt(0).toUpperCase() + userType.slice(1),
        profileEmail: profile.email || fallbackEmail,
        profilePhone: profile.phone || 'Not set',
        profileAge: profile.age || 'Not set',
        profileGender: profile.gender || 'Not set',
        profileCountry: profile.country || 'Not set',
        profileRegion: profile.region || 'Not set',
        profilePostalCode: profile.postalCode || 'Not set'
    };

    Object.entries(fields).forEach(([id, value]) => {
        const node = document.getElementById(id);
        if (node) {
            node.textContent = value;
        }
    });

    const profileJoined = document.getElementById('profileJoined');
    if (profileJoined) {
        profileJoined.textContent = new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    const profileTypeBadge = document.getElementById('profileRole');
    if (profileTypeBadge) {
        profileTypeBadge.classList.toggle('status-donor', userType === 'donor');
        profileTypeBadge.classList.toggle('status-recipient', userType === 'recipient');
    }

    const routeHint = document.getElementById('profileRouteHint');
    if (routeHint) {
        routeHint.textContent = expectedType === 'recipient'
            ? 'Use your dashboard to submit and monitor hair requests.'
            : 'Use your dashboard to submit donations and track certificates.';
    }
});
