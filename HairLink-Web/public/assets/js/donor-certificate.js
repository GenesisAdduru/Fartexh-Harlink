document.addEventListener('DOMContentLoaded', async () => {
    const moduleApi = window.hairlinkDonorModule;
    if (!moduleApi) {
        return;
    }

    const params = new URLSearchParams(window.location.search);
    const ref = params.get('ref');
    let donation;
    try {
        donation = ref ? await moduleApi.getDonation(ref) : await moduleApi.getLatestDonation();
    } catch (error) {
        console.error('Error fetching donation:', error);
    }

    const certName = document.getElementById('certName');
    const certReference = document.getElementById('certReference');
    const certNumber = document.getElementById('certNumber');
    const certIssued = document.getElementById('certIssued');
    const certStatus = document.getElementById('certStatus');
    const statusNote = document.getElementById('certificateStatusNote');
    const printBtn = document.getElementById('printCertificateBtn');

    if (!donation) {
        if (statusNote) {
            statusNote.textContent = 'No donation record found. Submit a donation first.';
        }
        return;
    }

    if (certName) certName.textContent = donation.fullName;
    if (certReference) certReference.textContent = donation.reference;
    if (certStatus) certStatus.textContent = donation.currentStatus;

    if (donation.certificate) {
        if (certNumber) certNumber.textContent = donation.certificate.certificateNo;
        if (certIssued) certIssued.textContent = moduleApi.formatDateTime(donation.certificate.issuedAt);
        if (statusNote) {
            statusNote.textContent = 'Certificate is ready. You may print or save it as PDF.';
        }
    } else {
        if (certNumber) certNumber.textContent = 'Pending';
        if (certIssued) certIssued.textContent = 'Pending completion';
        if (statusNote) {
            statusNote.textContent = 'Certificate is currently unavailable until donation status is Completed.';
        }
    }

    if (printBtn) {
        printBtn.addEventListener('click', () => {
            if (!donation.certificate) {
                alert('Certificate is not available yet. Complete donation processing first.');
                return;
            }
            window.print();
        });
    }
});
