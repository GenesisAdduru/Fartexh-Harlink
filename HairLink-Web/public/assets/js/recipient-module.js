(function(window) {
    'use strict';

    const STORAGE_KEY = 'hairlinkRequestsV1';
    
    // Status flow for recipient requests
    const STATUS_FLOW = [
        'Submitted',
        'Under Review',
        'Matched',
        'Ready for Pickup',
        'Completed'
    ];

    /**
     * Generate unique reference number for requests
     */
    function generateReference() {
        const timestamp = Date.now().toString().slice(-6);
        const random = Math.random().toString(36).substr(2, 5).toUpperCase();
        return `REQ-${random}-${timestamp}`;
    }

    /**
     * Generate default appointment for pickup (3 days from submission)
     */
    function buildDefaultAppointment() {
        const date = new Date();
        date.setDate(date.getDate() + 3);
        return date.toISOString();
    }

    /**
     * Initialize localStorage with seed data if empty
     */
    function initializeStorage() {
        const existing = localStorage.getItem(STORAGE_KEY);
        if (!existing) {
            const seedData = [
                {
                    id: 'REQ-ABC12-234567',
                    reference: 'REQ-ABC12-234567',
                    fullName: 'Maria Santos',
                    contactNumber: '0917-234-5678',
                    gender: 'female',
                    email: 'maria.santos@email.com',
                    story: 'I started experiencing hair loss 2 years ago due to alopecia. This has affected my confidence significantly...',
                    status: 'Matched',
                    createdAt: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString(),
                    statusHistory: [
                        { status: 'Submitted', timestamp: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString() },
                        { status: 'Under Review', timestamp: new Date(Date.now() - 25 * 24 * 60 * 60 * 1000).toISOString() },
                        { status: 'Matched', timestamp: new Date(Date.now() - 15 * 24 * 60 * 60 * 1000).toISOString() }
                    ],
                    appointmentAt: new Date(Date.now() + 5 * 24 * 60 * 60 * 1000).toISOString()
                },
                {
                    id: 'REQ-XYZ78-891234',
                    reference: 'REQ-XYZ78-891234',
                    fullName: 'Juan Dela Cruz',
                    contactNumber: '0916-123-4567',
                    gender: 'male',
                    email: 'juan.delacruz@email.com',
                    story: 'Hair loss started after medical treatment. Looking forward to regaining my confidence...',
                    status: 'Under Review',
                    createdAt: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(),
                    statusHistory: [
                        { status: 'Submitted', timestamp: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString() },
                        { status: 'Under Review', timestamp: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString() }
                    ],
                    appointmentAt: buildDefaultAppointment()
                }
            ];
            localStorage.setItem(STORAGE_KEY, JSON.stringify(seedData));
        }
    }

    /**
     * Get all requests
     */
    function getRequests() {
        initializeStorage();
        const data = localStorage.getItem(STORAGE_KEY);
        return data ? JSON.parse(data) : [];
    }

    /**
     * Get single request by reference
     */
    function getRequest(reference) {
        const requests = getRequests();
        return requests.find(r => r.reference === reference);
    }

    /**
     * Create new request
     */
    function createRequest(data) {
        const requests = getRequests();
        const reference = generateReference();
        const appointment = buildDefaultAppointment();
        
        const newRequest = {
            id: reference,
            reference: reference,
            fullName: data.fullName,
            contactNumber: data.contactNumber,
            gender: data.gender,
            email: data.email,
            story: data.story,
            documents: data.documents || [],
            additionalPhoto: data.additionalPhoto || null,
            status: 'Submitted',
            createdAt: new Date().toISOString(),
            statusHistory: [
                {
                    status: 'Submitted',
                    timestamp: new Date().toISOString()
                }
            ],
            appointmentAt: appointment,
            notes: ''
        };

        requests.push(newRequest);
        localStorage.setItem(STORAGE_KEY, JSON.stringify(requests));
        
        return newRequest;
    }

    /**
     * Update request status
     */
    function updateRequestStatus(reference, newStatus) {
        const requests = getRequests();
        const request = requests.find(r => r.reference === reference);
        
        if (request) {
            request.status = newStatus;
            request.statusHistory.push({
                status: newStatus,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem(STORAGE_KEY, JSON.stringify(requests));
            return request;
        }
        
        return null;
    }

    /**
     * Move to next status in flow
     */
    function nextStatus(reference) {
        const request = getRequest(reference);
        if (!request) return null;

        const currentIndex = STATUS_FLOW.indexOf(request.status);
        if (currentIndex < STATUS_FLOW.length - 1) {
            const nextStatusValue = STATUS_FLOW[currentIndex + 1];
            return updateRequestStatus(reference, nextStatusValue);
        }

        return request;
    }

    /**
     * Format date for display
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    /**
     * Format date and time
     */
    function formatDateTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Public API
    window.hairlinkRecipientModule = {
        getRequests,
        getRequest,
        createRequest,
        updateRequestStatus,
        nextStatus,
        formatDate,
        formatDateTime,
        STATUS_FLOW
    };

})(window);
