document.addEventListener('DOMContentLoaded', () => {
    const trackingCards = document.querySelectorAll('[data-track-card]');
    const donorSteps = ['received', 'in-queue', 'in-progress', 'completed', 'wig-received'];
    
    const labels = {
        'received': 'Received',
        'in-queue': 'In Queue',
        'in-progress': 'In Progress',
        'completed': 'Completed',
        'wig-received': 'Wig Received'
    };

    trackingCards.forEach((card) => {
        const cardId = card.dataset.cardId || 'Unknown';
        const steps = donorSteps;
        
        const actionBtn = card.querySelector('[data-move-next]');
        const statusChip = card.querySelector('[data-status-chip]');
        const stageItems = card.querySelectorAll('[data-stage]');
        const issueToggle = card.querySelector('[data-issue-toggle]');
        const issueWrap = card.querySelector('[data-issue-wrap]');
        const issueNote = card.querySelector('[data-issue-note]');
        const saveEdit = card.querySelector('[data-save-edit]');
        const editBanner = card.querySelector('[data-edit-banner]');
        const lastUpdated = card.querySelector('[data-last-updated]');

        const stampUpdate = (reason) => {
            if (!lastUpdated) return;
            const now = new Date().toLocaleString();
            lastUpdated.textContent = `Last updated: ${now} by Wigmaker (${reason}, Task # ${cardId})`;
        };

        const paint = (status) => {
            const activeIndex = steps.indexOf(status);
            const hasIssue = card.dataset.issue === 'true';
            
            if (statusChip) {
                const label = labels[status] || status;
                statusChip.textContent = hasIssue ? `${label} • Issue` : label;
                statusChip.classList.toggle('issue-chip', hasIssue);
            }
            
            stageItems.forEach((item, index) => {
                item.classList.remove('done', 'active');
                if (index < activeIndex) item.classList.add('done');
                if (index === activeIndex) item.classList.add('active');
            });

            if (actionBtn) {
                const isLastStep = activeIndex >= steps.indexOf('completed');
                if (isLastStep || hasIssue) {
                    actionBtn.hidden = true;
                } else {
                    const next = steps[activeIndex + 1];
                    actionBtn.hidden = false;
                    actionBtn.textContent = `Move to ${labels[next]} >`;
                }
            }
            card.dataset.currentStatus = status;
        };

        const updateBackend = async (newStatus, reason) => {
            // Map the unified UI status back to the WigProduction model statuses
            let backendStatus = newStatus;
            if (newStatus === 'in-queue') backendStatus = 'assigned';
            if (newStatus === 'in-progress') backendStatus = 'processing';
            
            const url = `/wigmaker/tasks/${cardId}/update`;
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: backendStatus,
                        notes: reason
                    })
                });

                if (response.ok) {
                    paint(newStatus);
                    stampUpdate(reason);
                    return true;
                } else {
                    const data = await response.json();
                    alert(data.message || 'Error updating task status');
                    return false;
                }
            } catch (error) {
                console.error(error);
                alert('Network error updating task');
                return false;
            }
        };

        // Initialize UI
        paint(card.dataset.currentStatus);

        if (actionBtn) {
            actionBtn.addEventListener('click', async () => {
                const currentStatus = card.dataset.currentStatus;
                const currentIndex = steps.indexOf(currentStatus);
                if (currentIndex < steps.length - 1) {
                    const nextStatus = steps[currentIndex + 1];
                    actionBtn.disabled = true;
                    await updateBackend(nextStatus, `Advanced to ${labels[nextStatus]}`);
                    actionBtn.disabled = false;
                }
            });
        }

        if (issueToggle) {
            issueToggle.addEventListener('change', () => {
                if (issueWrap) {
                    issueWrap.hidden = !issueToggle.checked;
                }
            });
        }

        if (saveEdit) {
            saveEdit.addEventListener('click', async () => {
                const currentStatus = card.dataset.currentStatus;
                const flaggedIssue = issueToggle ? issueToggle.checked : false;

                if (flaggedIssue && issueNote && !issueNote.value.trim()) {
                    issueNote.reportValidity();
                    return;
                }

                const msg = flaggedIssue ? 'Flagging production issue...' : 'Updating info...';
                const proceed = window.confirm(`Update task # ${cardId}?`);
                if (!proceed) return;

                saveEdit.disabled = true;
                const success = await updateBackend(currentStatus, flaggedIssue ? `ISSUE: ${issueNote.value}` : 'Info updated');
                saveEdit.disabled = false;

                if (success) {
                    card.dataset.issue = flaggedIssue ? 'true' : 'false';
                    paint(currentStatus); // Refresh chip
                    if (editBanner) {
                        editBanner.hidden = false;
                        editBanner.textContent = flaggedIssue ? 'Issue flagged.' : 'Saved successfully.';
                        setTimeout(() => { editBanner.hidden = true; }, 3000);
                    }
                }
            });
        }
    });

    // Simple search filter
    const searchInput = document.querySelector('[data-search-input]');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.trim().toLowerCase();
            trackingCards.forEach(card => {
                card.hidden = !card.textContent.toLowerCase().includes(query);
            });
        });
    }
});
