document.addEventListener('DOMContentLoaded', function() {
    const greetingName = document.getElementById('greeting-name');
    const activeRequestsCount = document.getElementById('active-requests-count');

    // Generate greeting based on time
    function getGreeting() {
        const hour = new Date().getHours();
        if (hour < 12) return 'Good Morning';
        if (hour < 18) return 'Good Afternoon';
        return 'Good Evening';
    }

    // Set greeting
    const greetingTitle = document.getElementById('greeting-title');
    const userName = greetingTitle ? greetingTitle.dataset.name : 'Friend';
    if (greetingTitle) {
        greetingTitle.innerHTML = `${getGreeting()}, <span id="greeting-name">${userName}</span>!`;
    }
});
