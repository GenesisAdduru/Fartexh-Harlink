document.addEventListener('DOMContentLoaded', () => {
    const trackingCards = document.querySelectorAll('[data-track-card]');
    const steps = ['received', 'in-queue', 'in-progress', 'completed'];
    const labels = {
        'received': 'Received',
        'in-queue': 'In Queue',
        'in-progress': 'In Progress',
        'completed': 'Completed',
    };

    trackingCards.forEach((card) => {
        const cardId = card.dataset.cardId || 'Unknown';
        const actionBtn = card.querySelector('[data-move-next]');
        const statusChip = card.querySelector('[data-status-chip]');
        const stageItems = card.querySelectorAll('[data-stage]');
        const manualStatus = card.querySelector('[data-manual-status]');
        const issueToggle = card.querySelector('[data-issue-toggle]');
        const issueWrap = card.querySelector('[data-issue-wrap]');
        const issueNote = card.querySelector('[data-issue-note]');
        const saveEdit = card.querySelector('[data-save-edit]');
        const editBanner = card.querySelector('[data-edit-banner]');
        const lastUpdated = card.querySelector('[data-last-updated]');

        const stampUpdate = (reason) => {
            if (!lastUpdated) return;
            const now = new Date().toLocaleString();
            lastUpdated.textContent = `Last updated: ${now} by Staff Demo (${reason}, Donation # ${cardId})`;
        };

        const paint = (status) => {
            const activeIndex = steps.indexOf(status);
            const hasIssue = card.dataset.issue === 'true';
            if (statusChip) {
                statusChip.textContent = hasIssue ? `${labels[status] || status} • Issue` : (labels[status] || status);
                statusChip.classList.toggle('issue-chip', hasIssue);
            }
            stageItems.forEach((item, index) => {
                item.classList.remove('done', 'active');
                if (index < activeIndex) item.classList.add('done');
                if (index === activeIndex) item.classList.add('active');
            });
            if (manualStatus) {
                manualStatus.value = status;
            }
            if (actionBtn) {
                if (status === 'completed' || hasIssue) {
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
            const url = `/api/donations/${cardId}/status`;
            const capitalizedStatus = newStatus.charAt(0).toUpperCase() + newStatus.slice(1).replace('-', ' ');
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: capitalizedStatus,
                        remarks: reason
                    })
                });

                if (response.ok) {
                    paint(newStatus);
                    stampUpdate(reason);
                    return true;
                } else {
                    const data = await response.json();
                    alert(data.message || 'Error updating status');
                    return false;
                }
            } catch (error) {
                console.error(error);
                alert('Network error updating status');
                return false;
            }
        };

        if (actionBtn) {
            actionBtn.addEventListener('click', async () => {
                const current = card.dataset.currentStatus;
                const idx = steps.indexOf(current);
                if (idx >= 0 && idx < steps.length - 1) {
                    const nextStatus = steps[idx + 1];
                    const proceed = window.confirm(`Confirm move of Donation # ${cardId} from ${labels[current]} to ${labels[nextStatus]}?`);
                    if (!proceed) return;

                    actionBtn.disabled = true;
                    const success = await updateBackend(nextStatus, `Quick move to ${labels[nextStatus]}`);
                    actionBtn.disabled = false;
                    
                    if (success) {
                        card.dataset.issue = 'false';
                        if (issueToggle) issueToggle.checked = false;
                        if (issueWrap) issueWrap.hidden = true;
                    }
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
                const nextStatus = manualStatus ? manualStatus.value : card.dataset.currentStatus;
                const flaggedIssue = issueToggle ? issueToggle.checked : false;

                if (flaggedIssue && issueNote && !issueNote.value.trim()) {
                    issueNote.reportValidity();
                    return;
                }

                const changeNote = flaggedIssue
                    ? `${labels[nextStatus]} with issue flag`
                    : labels[nextStatus];
                const proceed = window.confirm(`Save edit for Donation # ${cardId}: set status to ${changeNote}?`);
                if (!proceed) return;

                saveEdit.disabled = true;
                const success = await updateBackend(nextStatus, `Manual edit to ${changeNote}`);
                saveEdit.disabled = false;

                if (success) {
                    card.dataset.issue = flaggedIssue ? 'true' : 'false';
                    if (editBanner) {
                        editBanner.hidden = false;
                        editBanner.textContent = flaggedIssue
                            ? 'Progress edited and issue flagged for follow-up.'
                            : 'Progress edited successfully.';
                    }
                }
            });
        }

        paint(card.dataset.currentStatus || 'received');
    });

    const searchBlocks = document.querySelectorAll('[data-search-block]');
    searchBlocks.forEach((block) => {
        const input = block.querySelector('[data-search-input]');
        const rows = block.querySelectorAll('[data-search-row]');
        if (!input || !rows.length) return;

        input.addEventListener('input', () => {
            const query = input.value.trim().toLowerCase();
            rows.forEach((row) => {
                row.hidden = !row.textContent.toLowerCase().includes(query);
            });
        });
    });

    document.querySelectorAll('[data-print-trigger]').forEach((btn) => {
        btn.addEventListener('click', () => window.print());
    });

    const recipientButtons = document.querySelectorAll('[data-recipient-btn]');
    const recipientName = document.querySelector('[data-recipient-name]');
    const recipientNeed = document.querySelector('[data-recipient-need]');
    const recipientLength = document.querySelector('[data-recipient-length]');
    const recipientColor = document.querySelector('[data-recipient-color]');
    const wigCards = document.querySelectorAll('[data-wig-card]');
    const matchMode = document.querySelector('[data-match-mode]');
    const matchEmpty = document.querySelector('[data-match-empty]');

    let selectedRecipient = null;

    const normalize = (value) => (value || '').trim().toLowerCase();
    const parseStockDate = (value) => {
        const parsed = Date.parse(value || '');
        return Number.isNaN(parsed) ? Number.MAX_SAFE_INTEGER : parsed;
    };

    const sizeDistance = (a, b) => {
        const order = ['short', 'medium', 'long'];
        const ia = order.indexOf(a);
        const ib = order.indexOf(b);
        if (ia < 0 || ib < 0) {
            return 99;
        }
        return Math.abs(ia - ib);
    };

    const isSimilarColor = (a, b) => {
        const left = normalize(a);
        const right = normalize(b);
        if (!left || !right) {
            return false;
        }

        const aliases = {
            'dark brown': 'brown',
            'light brown': 'brown',
            'auburn': 'red',
            'red': 'red',
            'gray': 'gray',
            'grey': 'gray',
            'white': 'gray',
        };

        const l = aliases[left] || left;
        const r = aliases[right] || right;

        if (l === r) {
            return true;
        }

        const similarPairs = [
            ['black', 'brown'],
            ['brown', 'red'],
            ['blonde', 'light'],
            ['gray', 'blonde'],
        ];

        return similarPairs.some(([x, y]) => (l === x && r === y) || (l === y && r === x));
    };

    const computeScore = (card, preferredLength, preferredColor) => {
        const wigLength = normalize(card.dataset.length);
        const wigColor = normalize(card.dataset.color);
        const wantedLength = normalize(preferredLength);
        const wantedColor = normalize(preferredColor);
        const available = card.dataset.available === 'true';

        let sizeScore = 0;
        let colorScore = 0;
        let availabilityScore = 0;

        if (wigLength === wantedLength) {
            sizeScore = 40;
        } else if (sizeDistance(wigLength, wantedLength) === 1) {
            sizeScore = 20;
        }

        if (wigColor === wantedColor) {
            colorScore = 40;
        } else if (isSimilarColor(wigColor, wantedColor)) {
            colorScore = 20;
        }

        if (available) {
            availabilityScore = 20;
        }

        const total = sizeScore + colorScore + availabilityScore;
        return {
            total,
            size: sizeScore,
            color: colorScore,
            availability: availabilityScore,
        };
    };

    const renderMatch = (button) => {
        const name = button.dataset.name;
        const need = button.dataset.need;
        const length = button.dataset.length;
        const color = button.dataset.color;
        const mode = matchMode ? matchMode.value : 'high';
        const threshold = 85;

        if (recipientName) recipientName.textContent = name;
        if (recipientNeed) recipientNeed.textContent = need;
        if (recipientLength) recipientLength.textContent = length;
        if (recipientColor) recipientColor.textContent = color;

        const ranked = Array.from(wigCards).map((card) => {
            const scoreParts = computeScore(card, length, color);
            const score = scoreParts.total;
            const available = card.dataset.available === 'true';
            const stockDate = parseStockDate(card.dataset.stockDate);

            card.querySelector('[data-score]').textContent = `${score}%`;
            const breakdown = card.querySelector('[data-score-breakdown]');
            if (breakdown) {
                breakdown.textContent = `Size ${scoreParts.size} + Color ${scoreParts.color} + Availability ${scoreParts.availability} = ${scoreParts.total}`;
            }
            card.classList.toggle('unavailable', !available);

            return { card, score, available, stockDate };
        });

        ranked.sort((a, b) => {
            if (b.score !== a.score) {
                return b.score - a.score;
            }
            return a.stockDate - b.stockDate;
        });

        ranked.forEach(({ card }, index) => {
            card.style.order = String(index + 1);
        });

        let shown = 0;
        ranked.forEach(({ card, score, available }, index) => {
            let visible = available;
            if (mode === 'high') {
                visible = visible && score >= threshold;
            } else if (mode === 'top3') {
                visible = visible && index < 3;
            }
            card.hidden = !visible;
            if (visible) {
                shown += 1;
            }
        });

        if (matchEmpty) {
            matchEmpty.hidden = shown > 0;
        }
    };

    recipientButtons.forEach((button) => {
        button.addEventListener('click', () => {
            recipientButtons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            selectedRecipient = button;
            renderMatch(button);
        });
    });

    if (matchMode) {
        matchMode.addEventListener('change', () => {
            if (selectedRecipient) {
                renderMatch(selectedRecipient);
            }
        });
    }

    const activeRecipient = document.querySelector('[data-recipient-btn].active');
    if (activeRecipient) {
        selectedRecipient = activeRecipient;
        renderMatch(activeRecipient);
    }

    const verificationForm = document.querySelector('[data-verification-form]');
    const decisionButtons = document.querySelectorAll('[data-decision-btn]');
    const decisionBanner = document.querySelector('[data-decision-banner]');
    const remarks = document.getElementById('decisionRemarks');

    decisionButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            if (!verificationForm || !remarks || !decisionBanner) return;

            const text = remarks.value.trim();
            if (!text) {
                remarks.reportValidity();
                return;
            }

            const decision = button.dataset.decision;
            const status = decision === 'approved' ? (verificationForm.dataset.actionUrl.includes('/donor/') ? 'Received' : 'Validated') : 'Rejected';
            const url = verificationForm.dataset.actionUrl;
            
            button.disabled = true;
            button.innerText = 'Processing...';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status,
                        remarks: text
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    decisionBanner.hidden = false;
                    decisionBanner.classList.remove('approved', 'rejected');
                    decisionBanner.classList.add(decision);
                    decisionBanner.textContent = decision === 'approved' 
                        ? 'Submission approved. Notification queued and workflow updated.' 
                        : 'Submission rejected. Remarks saved and user notification queued.';
                    
                    setTimeout(() => {
                        window.location.href = verificationForm.dataset.actionUrl.includes('/donor/') 
                            ? '/staff/donor-verification' 
                            : '/staff/recipient-verification';
                    }, 1500);
                } else {
                    alert(data.message || 'Error updating status');
                }
            } catch (error) {
                console.error(error);
                alert('A network error occurred.');
            } finally {
                button.disabled = false;
                button.innerText = decision.charAt(0).toUpperCase() + decision.slice(1);
            }
        });
    });
});
