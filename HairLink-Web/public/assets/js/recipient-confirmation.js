document.addEventListener('DOMContentLoaded', async function() {
    const confirmationReference = document.getElementById('confirmation-reference');
    const confirmationStatus = document.getElementById('confirmation-status');
    const confirmationName = document.getElementById('confirmation-name');
    const confirmationSubmitted = document.getElementById('confirmation-submitted');
    const confirmationDetails = document.getElementById('confirmation-details');

    const recipientModule = window.hairlinkRecipientModule;
    if (!recipientModule) {
        console.error('Recipient module not loaded');
        return;
    }

    /**
     * Get reference from URL query param
     */
    function getReferenceFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('ref');
    }

    /**
     * Load and display confirmation
     */
    async function loadConfirmation() {
        const reference = getReferenceFromUrl();
        let request;

        try {
            if (reference) {
                request = await recipientModule.getRequest(reference);
            } else {
                // Get most recent request
                const requests = await recipientModule.getRequests();
                if (!requests || requests.length === 0) {
                    window.location.href = '/recipient/dashboard';
                    return;
                }
                request = requests[0]; // Already sorted desc by created_at
            }
        } catch (error) {
            console.error('Error loading request:', error);
            window.location.href = '/recipient/dashboard';
            return;
        }

        if (!request) {
            window.location.href = '/recipient/dashboard';
            return;
        }

        displayRequest(request);
    }

    /**
     * Display request details
     */
    function displayRequest(request) {
        if (confirmationReference) confirmationReference.textContent = request.reference || '-';
        if (confirmationStatus) confirmationStatus.textContent = request.status || 'Submitted';

        // Use the user relation name from the API, fallback to profile name
        const userName = (request.user && request.user.name)
            ? request.user.name
            : (request.fullName || 'Recipient');
        if (confirmationName) confirmationName.textContent = userName;

        if (confirmationSubmitted) {
            confirmationSubmitted.textContent = recipientModule.formatDate(request.createdAt || request.created_at);
        }

        // Build details - only show fields that exist in the API response
        let detailsHTML = '';

        if (userName) {
            detailsHTML += `
                <div class="detail-item">
                    <span class="detail-label">Full Name</span>
                    <span class="detail-value">${userName}</span>
                </div>`;
        }

        if (request.contactNumber || request.contact_number) {
            detailsHTML += `
                <div class="detail-item">
                    <span class="detail-label">Contact Number</span>
                    <span class="detail-value">${request.contactNumber || request.contact_number}</span>
                </div>`;
        }

        if (request.gender) {
            detailsHTML += `
                <div class="detail-item">
                    <span class="detail-label">Gender</span>
                    <span class="detail-value">${request.gender.charAt(0).toUpperCase() + request.gender.slice(1)}</span>
                </div>`;
        }

        if (request.story) {
            detailsHTML += `
                <div class="detail-item">
                    <span class="detail-label">Your Story</span>
                    <span class="detail-value">${request.story}</span>
                </div>`;
        }

        const docs = request.documents || [];
        detailsHTML += `
            <div class="detail-item">
                <span class="detail-label">Documents Submitted</span>
                <span class="detail-value">${docs.length} file(s)</span>
            </div>`;

        const photoPath = request.additionalPhoto || request.additional_photo;
        detailsHTML += `
            <div class="detail-item">
                <span class="detail-label">Reference Photo</span>
                <span class="detail-value">${photoPath ? 'Uploaded' : 'None'}</span>
            </div>`;

        if (request.appointmentAt || request.appointment_at) {
            detailsHTML += `
                <div class="detail-item">
                    <span class="detail-label">Appointment Date & Time</span>
                    <span class="detail-value">${recipientModule.formatDateTime(request.appointmentAt || request.appointment_at)}</span>
                </div>`;
        }

        if (confirmationDetails) confirmationDetails.innerHTML = detailsHTML;
    }

    await loadConfirmation();
});
