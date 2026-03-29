document.addEventListener('DOMContentLoaded', function() {
    const confirmationReference = document.getElementById('confirmation-reference');
    const confirmationStatus = document.getElementById('confirmation-status');
    const confirmationName = document.getElementById('confirmation-name');
    const confirmationSubmitted = document.getElementById('confirmation-submitted');
    const confirmationDetails = document.getElementById('confirmation-details');

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
    function loadConfirmation() {
        const reference = getReferenceFromUrl();
        
        if (!reference) {
            // Try to get most recent request
            const requests = window.hairlinkRecipientModule.getRequests();
            if (requests.length === 0) {
                window.location.href = '/recipient/dashboard';
                return;
            }
            const request = requests[requests.length - 1];
            displayRequest(request);
        } else {
            const request = window.hairlinkRecipientModule.getRequest(reference);
            if (!request) {
                window.location.href = '/recipient/dashboard';
                return;
            }
            displayRequest(request);
        }
    }

    /**
     * Display request details
     */
    function displayRequest(request) {
        confirmationReference.textContent = request.reference;
        confirmationStatus.textContent = request.status;
        confirmationName.textContent = request.fullName;
        confirmationSubmitted.textContent = window.hairlinkRecipientModule.formatDate(request.createdAt);

        // Build details
        const detailsHTML = `
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">${request.fullName}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Contact Number</span>
                <span class="detail-value">${request.contactNumber}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email Address</span>
                <span class="detail-value">${request.email}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Gender</span>
                <span class="detail-value">${request.gender.charAt(0).toUpperCase() + request.gender.slice(1)}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Your Story</span>
                <span class="detail-value">${request.story}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Documents Submitted</span>
                <span class="detail-value">${request.documents.length} file(s)</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Reference Photo</span>
                <span class="detail-value">${request.additionalPhoto ? request.additionalPhoto.name : 'None'}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Appointment Date & Time</span>
                <span class="detail-value">${window.hairlinkRecipientModule.formatDateTime(request.appointmentAt)}</span>
            </div>
        `;

        confirmationDetails.innerHTML = detailsHTML;
    }

    loadConfirmation();
});
