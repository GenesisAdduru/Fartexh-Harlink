document.addEventListener('DOMContentLoaded', () => {
    const moduleApi = window.hairlinkDonorModule;
    const form = document.getElementById('donationForm');
    const hairPhoto = document.getElementById('hairPhoto');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileName = document.getElementById('fileName');

    if (!form || !hairPhoto || !uploadBtn || !fileName) return;

    uploadBtn.addEventListener('click', () => hairPhoto.click());

    hairPhoto.addEventListener('change', () => {
        const file = hairPhoto.files?.[0];
        if (!file) {
            fileName.textContent = 'No file selected';
            return;
        }

        const maxBytes = 10 * 1024 * 1024;
        if (file.size > maxBytes) {
            alert('File is too large. Please upload an image up to 10MB.');
            hairPhoto.value = '';
            fileName.textContent = 'No file selected';
            return;
        }

        fileName.textContent = file.name;
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!form.checkValidity()) {
            alert('Please complete all required fields.');
            return;
        }

        if (!hairPhoto.files?.[0]) {
            alert('Please upload a hair photo.');
            return;
        }

        if (!moduleApi) {
            alert('Donation form submitted successfully.');
            form.reset();
            fileName.textContent = 'No file selected';
            return;
        }

        const donation = moduleApi.createDonation({
            fullName: (document.getElementById('fullName')?.value || '').trim(),
            email: (document.getElementById('email')?.value || '').trim(),
            phone: (document.getElementById('phone')?.value || '').trim(),
            hairLength: (document.getElementById('hairLength')?.value || '').trim(),
            hairColor: (document.getElementById('hairColor')?.value || '').trim(),
            treatedHair: Boolean(document.getElementById('treatedHair')?.checked),
            address: (document.getElementById('address')?.value || '').trim(),
            reason: (document.getElementById('reason')?.value || '').trim()
        });

        form.reset();
        fileName.textContent = 'No file selected';
        window.location.href = `/donor/confirmation?ref=${encodeURIComponent(donation.reference)}`;
    });
});
