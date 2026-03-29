document.addEventListener('DOMContentLoaded', () => {
    const user = {
        name: 'Fiona Can',
        points: 38,
        goal: 100,
    };

    const greetingText = document.getElementById('greetingText');
    const progressFill = document.getElementById('progressFill');
    const progressStar = document.getElementById('progressStar');
    const pointValue = document.getElementById('pointValue');
    const rewardLine = document.getElementById('rewardLine');
    const submitCodeBtn = document.getElementById('submitCodeBtn');
    const referralCode = document.getElementById('referralCode');

    function getGreeting() {
        const hour = new Date().getHours();
        if (hour < 12) return 'Good Morning';
        if (hour < 18) return 'Good Afternoon';
        return 'Good Evening';
    }

    function renderPoints() {
        const percent = Math.min((user.points / user.goal) * 100, 100);
        progressFill.style.width = `${percent}%`;
        progressStar.style.left = `${percent}%`;
        pointValue.textContent = String(user.points);
        rewardLine.textContent = user.points >= user.goal
            ? 'Congratulations! You can now claim your free wig reward.'
            : `Free wig for every ${user.goal} star points`;
    }

    if (greetingText) {
        greetingText.textContent = `${getGreeting()}, ${user.name}!`;
    }

    renderPoints();

    if (progressStar) {
        progressStar.addEventListener('click', () => {
            user.points = Math.min(user.points + 10, user.goal);
            renderPoints();
        });
    }

    if (submitCodeBtn && referralCode) {
        submitCodeBtn.addEventListener('click', () => {
            const code = referralCode.value.trim();
            if (!code) {
                alert('Please enter a referral code.');
                return;
            }
            alert('Referral code submitted successfully.');
            referralCode.value = '';
        });
    }
});
