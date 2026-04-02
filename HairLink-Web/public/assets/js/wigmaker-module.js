document.addEventListener('DOMContentLoaded', () => {
    const statusSelects = document.querySelectorAll('[data-status-select]');
    const note = document.querySelector('[data-progress-note]');
    const filterButtons = document.querySelectorAll('[data-filter]');
    const taskRows = document.querySelectorAll('[data-task-row]');

    const applyTaskFilter = (value) => {
        taskRows.forEach((row) => {
            const rowStatus = row.dataset.taskStatus;
            const visible = value === 'all' || rowStatus === value;
            row.hidden = !visible;
        });
    };

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((item) => item.classList.remove('active'));
            button.classList.add('active');
            applyTaskFilter(button.dataset.filter);
        });
    });

    statusSelects.forEach((select) => {
        const row = select.closest('tr');
        const pill = row ? row.querySelector('[data-status-pill]') : null;

        select.addEventListener('change', () => {
            if (pill) {
                const next = select.value;
                pill.classList.remove('status-queued', 'status-in-progress', 'status-completed');
                pill.classList.add(`status-${next}`);
                pill.textContent = next.replace('-', ' ').replace(/\b\w/g, (char) => char.toUpperCase());
            }

            if (row) {
                row.dataset.taskStatus = select.value;
            }

            if (note) {
                note.hidden = false;
                clearTimeout(note.dataset.timerId);
                const timerId = setTimeout(() => {
                    note.hidden = true;
                }, 2400);
                note.dataset.timerId = String(timerId);
            }

            const activeFilter = document.querySelector('[data-filter].active');
            if (activeFilter) {
                applyTaskFilter(activeFilter.dataset.filter);
            }
        });
    });

    const taskUpdateForm = document.getElementById('taskUpdateForm');
    const updateBanner = document.querySelector('[data-update-banner]');

    if (taskUpdateForm) {
        const now = new Date();
        const localNow = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0, 16);
        const updatedAtInput = document.getElementById('updated-at');
        if (updatedAtInput && !updatedAtInput.value) {
            updatedAtInput.value = localNow;
        }

        taskUpdateForm.addEventListener('submit', (event) => {
            event.preventDefault();

            if (!taskUpdateForm.checkValidity()) {
                taskUpdateForm.reportValidity();
                return;
            }

            if (updateBanner) {
                updateBanner.hidden = false;
            }
        });
    }
});
