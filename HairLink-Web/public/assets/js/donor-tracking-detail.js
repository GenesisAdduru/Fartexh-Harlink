function timelineItemHtml(entry, formatDateTime) {
    const safeStatus = String(entry.status || 'Unknown');
    const safeDate = entry.at ? formatDateTime(entry.at) : '-';
    return `<li><strong>${safeStatus}</strong><time>${safeDate}</time></li>`;
}

document.addEventListener('DOMContentLoaded', () => {
    const moduleApi = window.hairlinkDonorModule;
    if (!moduleApi) {
        return;
    }

    const root = document.getElementById('trackingDetailRoot');
    const refFromRoute = root?.dataset?.reference || '';
    const params = new URLSearchParams(window.location.search);
    const ref = params.get('ref') || refFromRoute;

    const detailStatus = document.getElementById('detailStatus');
    const detailStatusPill = document.getElementById('detailStatusPill');
    const detailSubmitted = document.getElementById('detailSubmitted');
    const detailDonor = document.getElementById('detailDonor');
    const detailHair = document.getElementById('detailHair');
    const detailTimeline = document.getElementById('detailTimeline');
    const simulateStatusBtn = document.getElementById('simulateStatusBtn');
    const detailCertificateBtn = document.getElementById('detailCertificateBtn');

    function render(reference) {
        const donation = moduleApi.getDonation(reference);
        if (!donation) {
            if (detailTimeline) {
                detailTimeline.innerHTML = '<li><strong>Record not found</strong><time>-</time></li>';
            }
            return;
        }

        if (detailStatus) detailStatus.textContent = donation.currentStatus;
        if (detailSubmitted) detailSubmitted.textContent = moduleApi.formatDateTime(donation.submittedAt);
        if (detailDonor) detailDonor.textContent = donation.fullName;
        if (detailHair) {
            const treated = donation.treatedHair ? 'treated' : 'not treated';
            detailHair.textContent = `${donation.hairLength}, ${donation.hairColor} (${treated})`;
        }

        if (detailStatusPill) {
            detailStatusPill.textContent = donation.currentStatus;
            detailStatusPill.className = `status-pill status-${donation.currentStatus.toLowerCase()}`;
        }

        if (detailTimeline) {
            detailTimeline.innerHTML = donation.statusHistory
                .slice()
                .reverse()
                .map((entry) => timelineItemHtml(entry, moduleApi.formatDateTime))
                .join('');
        }

        if (detailCertificateBtn) {
            detailCertificateBtn.setAttribute('href', `/donor/certificate?ref=${encodeURIComponent(donation.reference)}`);
            if (!donation.certificate) {
                detailCertificateBtn.classList.add('ghost-btn');
            } else {
                detailCertificateBtn.classList.remove('ghost-btn');
            }
        }
    }

    render(ref);

    if (simulateStatusBtn) {
        simulateStatusBtn.addEventListener('click', () => {
            const updated = moduleApi.nextStatus(ref);
            if (!updated) {
                return;
            }
            render(ref);
        });
    }
});
