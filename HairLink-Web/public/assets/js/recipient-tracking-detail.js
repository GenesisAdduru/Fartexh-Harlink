document.addEventListener('DOMContentLoaded', function() {
    const requestReferenceDisplay = document.getElementById('request-reference-display');
    const summaryReference = document.getElementById('summary-reference');
    const summaryStatus = document.getElementById('summary-status');
    const summarySubmitted = document.getElementById('summary-submitted');
    const summaryName = document.getElementById('summary-name');
    const timeline = document.getElementById('request-timeline');
    const requestDetails = document.getElementById('request-details');
    const simulateBtn = document.getElementById('simulate-status-btn');

    /**
     * Get reference from URL
     */
    function getRequestReference() {
        const pathParts = window.location.pathname.split('/');
        return pathParts[pathParts.length - 1];
    }

    /**
     * Render timeline
     */
    function renderTimeline(request) {
        timeline.innerHTML = '';

        const statusHistory = [...request.statusHistory].reverse();

        statusHistory.forEach((historyItem, index) => {
            const item = document.createElement('div');
            const isCompleted = index === 0;
            item.className = `timeline-item ${isCompleted ? 'completed' : 'pending'}`;

            const date = window.hairlinkRecipientModule.formatDateTime(historyItem.timestamp);

            item.innerHTML = `
                <div class="timeline-date">${date}</div>
                <div class="timeline-status">${historyItem.status}</div>
            `;

            timeline.appendChild(item);
        });
    }

    /**
     * Render request details
     */
    function renderDetails(request) {
        requestDetails.innerHTML = `
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">${request.fullName}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Contact Number</span>
                <span class="detail-value">${request.contactNumber}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Gender</span>
                <span class="detail-value">${request.gender.charAt(0).toUpperCase() + request.gender.slice(1)}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">${request.email}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Story</span>
                <span class="detail-value">${request.story}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Appointment</span>
                <span class="detail-value">${window.hairlinkRecipientModule.formatDateTime(request.appointmentAt)}</span>
            </div>
        `;
    }

    /**
     * Load and display request
     */
    async function loadRequest() {
        const reference = getRequestReference();
        let request;
        try {
            request = await window.hairlinkRecipientModule.getRequest(reference);
        } catch (error) {
            console.error('Error loading request:', error);
        }

        if (!request) {
            if (requestReferenceDisplay) requestReferenceDisplay.textContent = 'Request not found';
            return;
        }

        if (requestReferenceDisplay) requestReferenceDisplay.textContent = `Reference #${request.reference}`;
        if (summaryReference) summaryReference.textContent = request.reference;
        if (summaryStatus) summaryStatus.textContent = request.status;
        if (summarySubmitted) summarySubmitted.textContent = window.hairlinkRecipientModule.formatDate(request.createdAt);
        if (summaryName) summaryName.textContent = request.fullName || (request.user ? request.user.name : 'Recipient');

        renderTimeline(request);
        renderDetails(request);
    }

    // Initial load
    loadRequest();

    // Simulate status button
    if (simulateBtn) {
        simulateBtn.addEventListener('click', async () => {
            const reference = getRequestReference();
            try {
                await window.hairlinkRecipientModule.nextStatus(reference);
                await loadRequest(); // Reload to show updated status
            } catch (error) {
                console.error('Error updating status:', error);
            }
        });
    }
});
