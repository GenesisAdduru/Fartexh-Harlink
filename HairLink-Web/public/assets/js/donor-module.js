(function(window) {
    'use strict';

    const STATUS_FLOW = ['Submitted', 'Received', 'Validated', 'Processing', 'Completed'];

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    async function apiCall(url, method = 'GET', body = null) {
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        };

        if (body) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(body);
        }

        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`API Error: ${response.status} ${response.statusText}`);
        }
        return await response.json();
    }

    /**
     * Map backend snake_case model to frontend camelCase expectations
     */
    function mapDonation(data) {
        if (!data) return null;
        return {
            ...data,
            fullName: data.user?.name || 'Donor',
            hairLength: data.hair_length,
            hairColor: data.hair_color,
            treatedHair: data.treated_hair,
            submittedAt: data.created_at,
            currentStatus: data.status,
            statusHistory: (data.status_histories || []).map(sh => ({
                status: sh.status,
                at: sh.created_at
            })),
            certificate: data.certificate_no ? {
                certificateNo: data.certificate_no,
                issuedAt: data.updated_at
            } : null,
            dropOff: {
                location: data.dropoff_location,
                appointmentAt: data.appointment_at
            }
        };
    }

    function formatDateTime(value) {
        if (!value) return '';
        const date = new Date(value);
        return date.toLocaleString();
    }

    const donorModule = {
        statusFlow: STATUS_FLOW,
        formatDateTime,

        async getAllDonations() {
            const data = await apiCall('/api/donations');
            return data.map(mapDonation);
        },

        async getDonation(reference) {
            const data = await apiCall(`/api/donations/${reference}`);
            return mapDonation(data);
        },

        async createDonation(payload) {
            const backendPayload = {
                reference: payload.reference || `HD-${Date.now().toString().slice(-6)}${Math.floor(Math.random() * 900 + 100)}`,
                hair_length: payload.hairLength,
                hair_color: payload.hairColor,
                treated_hair: Boolean(payload.treatedHair),
                address: payload.address,
                reason: payload.reason,
                dropoff_location: 'Manila Downtown YMCA, 945 Sabino Padilla St, Binondo, Manila',
                appointment_at: new Date(Date.now() + 3 * 24 * 60 * 60 * 1000).toISOString()
            };
            const data = await apiCall('/api/donations', 'POST', backendPayload);
            return mapDonation(data);
        },

        async getLatestDonation() {
            const donations = await this.getAllDonations();
            return donations[0] || null;
        },

        async setStatus(reference, status) {
            if (!STATUS_FLOW.includes(status)) return null;
            const data = await apiCall(`/api/donations/${reference}/status`, 'POST', { status });
            return mapDonation(data);
        },

        async nextStatus(reference) {
            const donation = await this.getDonation(reference);
            if (!donation) return null;

            const currentIndex = STATUS_FLOW.indexOf(donation.currentStatus);
            if (currentIndex >= 0 && currentIndex < STATUS_FLOW.length - 1) {
                return await this.setStatus(reference, STATUS_FLOW[currentIndex + 1]);
            }
            return donation;
        }
    };

    window.hairlinkDonorModule = donorModule;

})(window);
