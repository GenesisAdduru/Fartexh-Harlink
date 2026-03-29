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
    greetingName.textContent = 'Friend';
    
    // Update active requests count
    function updateActiveRequests() {
        const requests = window.hairlinkRecipientModule.getRequests();
        const activeCount = requests.filter(r => r.status !== 'Completed' && r.status !== 'Rejected').length;
        activeRequestsCount.textContent = activeCount;
    }

    updateActiveRequests();
});
