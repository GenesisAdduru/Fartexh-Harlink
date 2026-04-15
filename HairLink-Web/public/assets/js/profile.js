// JS logic for profile has been migrated to blade templates directly retrieving from PostgreSQL backend.

document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('copyCodeBtn');
    const codeEl = document.getElementById('myReferralCode');

    if (copyBtn && codeEl) {
        copyBtn.addEventListener('click', () => {
            const code = codeEl.textContent.trim();
            navigator.clipboard.writeText(code).then(() => {
                copyBtn.innerHTML = "<i class='bx bx-check'></i> Copied!";
                setTimeout(() => {
                    copyBtn.innerHTML = "<i class='bx bx-copy'></i> Copy";
                }, 2000);
            }).catch(() => {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = code;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                copyBtn.innerHTML = "<i class='bx bx-check'></i> Copied!";
                setTimeout(() => {
                    copyBtn.innerHTML = "<i class='bx bx-copy'></i> Copy";
                }, 2000);
            });
        });
    }
});
