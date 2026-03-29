@extends('layouts.dashboard')

@section('title', 'HairLink | Wigmaker Task Detail')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/wigmaker-module.css') }}">
@endpush

@section('content')
    @php
        $taskCode = $taskCode ?? 'WG-00000';
    @endphp

    <section class="section-wrap reveal wigmaker-page">
        <div class="section-title-block">
            <h1>Task {{ $taskCode }}</h1>
            <p>Update production progress and notes for this assigned wig build.</p>
        </div>

        <article class="task-detail-shell">
            <div class="task-detail-grid">
                <div>
                    <h2>Assignment Snapshot</h2>
                    <ul class="task-meta-list">
                        <li><strong>Hair Inventory Ref:</strong> DON-2026-1102</li>
                        <li><strong>Recipient Request Ref:</strong> REC-2026-0448</li>
                        <li><strong>Wig Specification:</strong> Medium / Dark Brown / Straight</li>
                        <li><strong>Assigned By:</strong> Staff User - Maria D.</li>
                        <li><strong>Production Window:</strong> 2026-03-30 to 2026-04-10</li>
                    </ul>
                </div>

                <div>
                    <h2>Progress Timeline</h2>
                    <ol class="timeline-list">
                        <li class="done">Queued</li>
                        <li class="active">In Progress</li>
                        <li>Completed</li>
                    </ol>
                </div>
            </div>

            <div class="conversion-note">
                When this task is marked <strong>Completed</strong>, the assigned hair inventory record is flagged for conversion into an available wig inventory entry for recipient matching.
            </div>
        </article>

        <article class="task-update-shell">
            <h2>Update Production Status</h2>
            <form id="taskUpdateForm" class="task-update-form" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <label for="task-status">Current Stage <span class="required">*</span></label>
                        <select id="task-status" name="taskStatus" required>
                            <option value="queued">Queued</option>
                            <option value="in-progress" selected>In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="updated-at">Update Timestamp <span class="required">*</span></label>
                        <input id="updated-at" name="updatedAt" type="datetime-local" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="progress-notes">Progress Notes <span class="required">*</span></label>
                    <textarea id="progress-notes" name="progressNotes" rows="4" placeholder="Describe what was completed in this stage..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="preview-photo">Optional Progress Photo</label>
                    <input id="preview-photo" name="previewPhoto" type="file" accept=".jpg,.jpeg,.png,.webp">
                </div>

                <div class="form-actions">
                    <button type="submit" class="soft-btn">Save Update</button>
                    <a class="ghost-btn" href="{{ route('wigmaker.dashboard') }}">Back to Dashboard</a>
                </div>
            </form>

            <p class="update-banner" data-update-banner hidden>
                Status saved. Notification has been queued for admin and staff oversight.
            </p>
        </article>

        <article class="task-history-shell">
            <h2>Production Update History</h2>
            <p class="task-history-sub">Recent documented stage updates for oversight and reporting.</p>

            <div class="task-table-wrap">
                <table class="task-table" aria-label="Production update history">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Updated By</th>
                            <th>Stage</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2026-03-25 09:10</td>
                            <td>Wigmaker - Ana P.</td>
                            <td><span class="status-pill status-in-progress">In Progress</span></td>
                            <td>Cap base prepared and initial stitch line completed.</td>
                        </tr>
                        <tr>
                            <td>2026-03-30 08:35</td>
                            <td>Staff - Maria D.</td>
                            <td><span class="status-pill status-queued">Queued</span></td>
                            <td>Task assigned after verification and inventory release approval.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/wigmaker-module.js') }}" defer></script>
@endpush
