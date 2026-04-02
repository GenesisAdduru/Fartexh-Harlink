function timelineItemHtml(entry, formatDateTime) {
    const safeStatus = String(entry.status || 'Unknown');
    const safeDate = entry.at ? formatDateTime(entry.at) : '-';
    return `<li><strong>${safeStatus}</strong><time>${safeDate}</time></li>`;
}

document.addEventListener('DOMContentLoaded', () => {
    const moduleApi = window.hairlinkDonorModule;
    if (!moduleApi) return;

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

    async function render(reference) {
        let donation;
        try {
            donation = await moduleApi.getDonation(reference);
        } catch (error) {
            console.error('Error fetching donation:', error);
        }

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
                detailCertificateBtn.style.display = 'none';
            } else {
                detailCertificateBtn.style.display = 'inline-flex';
            }
        }

        // Update simulate button text based on current status
        if (simulateStatusBtn) {
            const currentIndex = moduleApi.statusFlow.indexOf(donation.currentStatus);
            if (currentIndex >= 0 && currentIndex < moduleApi.statusFlow.length - 1) {
                const nextStatus = moduleApi.statusFlow[currentIndex + 1];
                simulateStatusBtn.textContent = `Advance to: ${nextStatus}`;
                simulateStatusBtn.disabled = false;
            } else {
                simulateStatusBtn.textContent = 'Status Complete';
                simulateStatusBtn.disabled = true;
            }
        }
    }

    render(ref);

    if (simulateStatusBtn) {
        simulateStatusBtn.addEventListener('click', async () => {
            simulateStatusBtn.disabled = true;
            simulateStatusBtn.textContent = 'Updating...';
            try {
                const updated = await moduleApi.nextStatus(ref);
                if (updated) {
                    await render(ref);
                }
            } catch (error) {
                console.error('Error advancing status:', error);
                alert('Failed to advance status. Please try again.');
                simulateStatusBtn.disabled = false;
            }
        });
    }
});
