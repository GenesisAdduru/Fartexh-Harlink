document.addEventListener('DOMContentLoaded', () => {

    // ── Amount pills ──
    const pills = document.querySelectorAll('.pill-btn');
    const customInput = document.getElementById('custom-amount');
    const amountNumber = document.getElementById('amount-number');

    pills.forEach(btn => {
        btn.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            if (customInput) customInput.value = '';
            if (amountNumber) {
                amountNumber.value = Number(btn.dataset.amount).toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });
    });

    if (customInput) {
        customInput.addEventListener('input', () => {
            pills.forEach(p => p.classList.remove('active'));
            if (amountNumber && customInput.value) {
                amountNumber.value = Number(customInput.value).toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });
    }

    // ── Payment tabs ──
    const tabBtns = document.querySelectorAll('.tab-btn');
    const bankCards = {
        bank: document.getElementById('bank-card-bank'),
        instapay: document.getElementById('bank-card-instapay'),
    };

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            const tab = btn.dataset.tab;
            Object.keys(bankCards).forEach(key => {
                if (bankCards[key]) {
                    bankCards[key].classList.toggle('hidden', key !== tab);
                }
            });
        });
    });

    // ── Proof of donation file display ──
    const proofInput = document.getElementById('proof-donation');
    const fileList = document.getElementById('proof-file-list');

    if (proofInput && fileList) {
        proofInput.addEventListener('change', () => {
            fileList.innerHTML = '';
            Array.from(proofInput.files).forEach(file => {
                const item = document.createElement('span');
                item.className = 'file-item';
                item.textContent = file.name;
                fileList.appendChild(item);
            });
        });
    }

    // ── Form submit ──
    const form = document.getElementById('monetary-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            alert('Thank you for your monetary donation! We will verify your submission shortly.');
        });
    }
});
