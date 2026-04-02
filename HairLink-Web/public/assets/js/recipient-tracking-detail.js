document.addEventListener('DOMContentLoaded', function() {
    const requestReferenceDisplay = document.getElementById('request-reference-display');
    const summaryReference = document.getElementById('summary-reference');
    const summaryStatus = document.getElementById('summary-status');
    const summarySubmitted = document.getElementById('summary-submitted');
    const summaryName = document.getElementById('summary-name');
    const timeline = document.getElementById('request-timeline');
    const requestDetails = document.getElementById('request-details');
    const simulateBtn = document.getElementById('simulate-status-btn');

    const recipientModule = window.hairlinkRecipientModule;
    if (!recipientModule) {
        console.error('Recipient module not loaded');
        return;
    }

    /**
     * Get reference from URL path
     */
    function getRequestReference() {
        const pathParts = window.location.pathname.split('/');
        return decodeURIComponent(pathParts[pathParts.length - 1]);
    }

    /**
     * Render timeline
     */
    function renderTimeline(request) {
        if (!timeline) return;
        timeline.innerHTML = '';

        const statusHistory = [...(request.statusHistory || [])].reverse();

        statusHistory.forEach((historyItem, index) => {
            const item = document.createElement('div');
            const isCompleted = index === 0;
            item.className = `timeline-item ${isCompleted ? 'completed' : 'pending'}`;

            const date = recipientModule.formatDateTime(historyItem.timestamp);

            item.innerHTML = `
                <div class="timeline-date">${date}</div>
                <div class="timeline-status">${historyItem.status}</div>
            `;

            timeline.appendChild(item);
        });
    }

    /**
     * Render request details — only fields that exist in the API
     */
    function renderDetails(request) {
        if (!requestDetails) return;

        const userName = (request.user && request.user.name) ? request.user.name : 'Recipient';
        const contactNumber = request.contactNumber || request.contact_number || '-';
        const gender = request.gender
            ? request.gender.charAt(0).toUpperCase() + request.gender.slice(1)
            : '-';
        const story = request.story || '-';
        const appointment = request.appointmentAt || request.appointment_at;

        requestDetails.innerHTML = `
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">${userName}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Contact Number</span>
                <span class="detail-value">${contactNumber}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Gender</span>
                <span class="detail-value">${gender}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Story</span>
                <span class="detail-value">${story}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Appointment</span>
                <span class="detail-value">${appointment ? recipientModule.formatDateTime(appointment) : '-'}</span>
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
            request = await recipientModule.getRequest(reference);
        } catch (error) {
            console.error('Error loading request:', error);
        }

        if (!request) {
            if (requestReferenceDisplay) requestReferenceDisplay.textContent = 'Request not found';
            return;
        }

        const userName = (request.user && request.user.name) ? request.user.name : 'Recipient';

        if (requestReferenceDisplay) requestReferenceDisplay.textContent = `Reference #${request.reference}`;
        if (summaryReference) summaryReference.textContent = request.reference;
        if (summaryStatus) summaryStatus.textContent = request.status;
        if (summarySubmitted) summarySubmitted.textContent = recipientModule.formatDate(request.createdAt || request.created_at);
        if (summaryName) summaryName.textContent = userName;

        renderTimeline(request);
        renderDetails(request);

        // Update simulate button text based on current status
        if (simulateBtn) {
            const currentIndex = recipientModule.STATUS_FLOW.indexOf(request.status);
            if (currentIndex >= 0 && currentIndex < recipientModule.STATUS_FLOW.length - 1) {
                const nextStatus = recipientModule.STATUS_FLOW[currentIndex + 1];
                simulateBtn.textContent = `Advance to: ${nextStatus}`;
                simulateBtn.disabled = false;
            } else {
                simulateBtn.textContent = 'Status Complete';
                simulateBtn.disabled = true;
            }
        }
    }

    // Initial load
    loadRequest();

    // Simulate status button
    if (simulateBtn) {
        simulateBtn.addEventListener('click', async () => {
            simulateBtn.disabled = true;
            simulateBtn.textContent = 'Updating...';
            const reference = getRequestReference();
            try {
                await recipientModule.nextStatus(reference);
                await loadRequest();
            } catch (error) {
                console.error('Error updating status:', error);
                alert('Failed to advance status. Please try again.');
                simulateBtn.disabled = false;
            }
        });
    }
});
