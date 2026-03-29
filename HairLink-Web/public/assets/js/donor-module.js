(() => {
    const STORAGE_KEY = 'hairlinkDonationsV1';
    const LATEST_KEY = 'hairlinkLatestDonationRef';
    const STATUS_FLOW = ['Submitted', 'Received', 'Validated', 'Processing', 'Completed'];

    function parse(raw) {
        try {
            const value = JSON.parse(raw);
            return Array.isArray(value) ? value : [];
        } catch {
            return [];
        }
    }

    function readAll() {
        return parse(localStorage.getItem(STORAGE_KEY));
    }

    function writeAll(items) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    }

    function buildReference() {
        const stamp = Date.now().toString().slice(-6);
        const rand = Math.floor(Math.random() * 900 + 100);
        return `HD-${stamp}${rand}`;
    }

    function formatDateTime(value) {
        const date = new Date(value);
        return date.toLocaleString();
    }

    function buildDefaultAppointment() {
        const date = new Date();
        date.setDate(date.getDate() + 3);
        date.setHours(10, 0, 0, 0);
        return date.toISOString();
    }

    function ensureSeedData() {
        const items = readAll();
        if (items.length > 0) {
            return;
        }

        const now = Date.now();
        const sampleCompletedRef = 'HD-240001001';
        const samplePendingRef = 'HD-240001002';

        const sample = [
            {
                reference: sampleCompletedRef,
                fullName: 'Fiona Can',
                email: 'fiona@example.com',
                hairLength: '15 to 20 inches',
                hairColor: 'Black',
                submittedAt: new Date(now - 1000 * 60 * 60 * 24 * 10).toISOString(),
                currentStatus: 'Completed',
                statusHistory: [
                    { status: 'Submitted', at: new Date(now - 1000 * 60 * 60 * 24 * 10).toISOString() },
                    { status: 'Received', at: new Date(now - 1000 * 60 * 60 * 24 * 9).toISOString() },
                    { status: 'Validated', at: new Date(now - 1000 * 60 * 60 * 24 * 8).toISOString() },
                    { status: 'Processing', at: new Date(now - 1000 * 60 * 60 * 24 * 7).toISOString() },
                    { status: 'Completed', at: new Date(now - 1000 * 60 * 60 * 24 * 6).toISOString() }
                ],
                certificate: {
                    certificateNo: 'CERT-2026-0001',
                    issuedAt: new Date(now - 1000 * 60 * 60 * 24 * 6).toISOString()
                }
            },
            {
                reference: samplePendingRef,
                fullName: 'Fiona Can',
                email: 'fiona@example.com',
                hairLength: '10 to 14 inches',
                hairColor: 'Brown',
                submittedAt: new Date(now - 1000 * 60 * 60 * 24 * 2).toISOString(),
                currentStatus: 'Received',
                statusHistory: [
                    { status: 'Submitted', at: new Date(now - 1000 * 60 * 60 * 24 * 2).toISOString() },
                    { status: 'Received', at: new Date(now - 1000 * 60 * 60 * 24).toISOString() }
                ],
                certificate: null
            }
        ];

        writeAll(sample);
        localStorage.setItem(LATEST_KEY, samplePendingRef);
    }

    function createDonation(payload) {
        const items = readAll();
        const nowIso = new Date().toISOString();
        const donation = {
            reference: buildReference(),
            fullName: payload.fullName,
            email: payload.email,
            phone: payload.phone || '',
            hairLength: payload.hairLength,
            hairColor: payload.hairColor,
            treatedHair: Boolean(payload.treatedHair),
            address: payload.address || '',
            reason: payload.reason || '',
            submittedAt: nowIso,
            dropOff: {
                location: 'Manila Downtown YMCA, 945 Sabino Padilla St, Binondo, Manila',
                appointmentAt: buildDefaultAppointment()
            },
            currentStatus: 'Submitted',
            statusHistory: [{ status: 'Submitted', at: nowIso }],
            certificate: null
        };

        items.unshift(donation);
        writeAll(items);
        localStorage.setItem(LATEST_KEY, donation.reference);
        return donation;
    }

    function getAllDonations() {
        return readAll().sort((a, b) => new Date(b.submittedAt) - new Date(a.submittedAt));
    }

    function getDonation(reference) {
        return getAllDonations().find((item) => item.reference === reference) || null;
    }

    function getLatestDonation() {
        const latestRef = localStorage.getItem(LATEST_KEY);
        if (latestRef) {
            const donation = getDonation(latestRef);
            if (donation) {
                return donation;
            }
        }
        return getAllDonations()[0] || null;
    }

    function setStatus(reference, status) {
        if (!STATUS_FLOW.includes(status)) {
            return null;
        }

        const items = getAllDonations();
        const donation = items.find((item) => item.reference === reference);
        if (!donation) {
            return null;
        }

        donation.currentStatus = status;
        const lastStatus = donation.statusHistory[donation.statusHistory.length - 1]?.status;
        if (lastStatus !== status) {
            donation.statusHistory.push({ status, at: new Date().toISOString() });
        }

        if (status === 'Completed' && !donation.certificate) {
            donation.certificate = {
                certificateNo: `CERT-${new Date().getFullYear()}-${donation.reference.slice(-6)}`,
                issuedAt: new Date().toISOString()
            };
        }

        writeAll(items);
        return donation;
    }

    function nextStatus(reference) {
        const donation = getDonation(reference);
        if (!donation) {
            return null;
        }

        const index = STATUS_FLOW.indexOf(donation.currentStatus);
        if (index < 0 || index >= STATUS_FLOW.length - 1) {
            return donation;
        }

        return setStatus(reference, STATUS_FLOW[index + 1]);
    }

    ensureSeedData();

    window.hairlinkDonorModule = {
        statusFlow: STATUS_FLOW,
        formatDateTime,
        createDonation,
        getAllDonations,
        getDonation,
        getLatestDonation,
        setStatus,
        nextStatus
    };
})();
