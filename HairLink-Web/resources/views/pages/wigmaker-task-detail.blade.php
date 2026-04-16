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
            <h1>Task {{ $task->task_code }}</h1>
            <p>Update production progress and notes for this assigned wig build.</p>
        </div>

        <article class="task-detail-shell">
            <div class="task-detail-grid">
                <div class="assignment-snapshot-pane">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem;">
                        <i class='bx bxs-info-circle' style="color: #ad246d; font-size: 1.4rem;"></i>
                        <h2 style="margin: 0;">Assignment Snapshot</h2>
                    </div>
                    
                    <ul class="task-meta-list" style="background: #fdf7fb; padding: 1rem; border-radius: 12px; border: 1px solid #f2ebf4;">
                        <li>
                            <i class='bx bx-hash' style="color: #ad246d;"></i>
                            <strong>Hair Inventory Ref:</strong> 
                            <span style="color: #ad246d; font-weight: 800;">{{ $task->donation ? $task->donation->reference : 'N/A' }}</span>
                        </li>
                        @php
                            $len = $task->target_length;
                            if (str_contains(strtolower($len), '10 to 14')) $len = 'Short';
                            if (str_contains(strtolower($len), '15 to 20')) $len = 'Medium';
                            if (str_contains(strtolower($len), 'more than 20')) $len = 'Long';
                        @endphp
                        <li>
                            <i class='bx bx-cut' style="color: #ad246d;"></i>
                            <strong>Wig Specification:</strong> 
                            <span>{{ ucfirst($len) }} / {{ ucfirst(str_replace('-', ' ', $task->target_color)) }}</span>
                        </li>
                        <li>
                            <i class='bx bx-user-check' style="color: #ad246d;"></i>
                            <strong>Assigned By:</strong> <span>Staff Operations</span>
                        </li>
                        <li>
                            <i class='bx bx-calendar-event' style="color: #ad246d;"></i>
                            <strong>Production Window:</strong> 
                            <span style="font-size: 0.8rem;">{{ $task->created_at->format('M d, Y') }} — {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'TBD' }}</span>
                        </li>
                    </ul>
                </div>

                <div class="timeline-pane">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem;">
                        <i class='bx bx-git-commit' style="color: #ad246d; font-size: 1.4rem;"></i>
                        <h2 style="margin: 0;">Task Roadmap</h2>
                    </div>
                    <ol class="timeline-list" style="background: #fff; padding: 1rem 1rem 1rem 2.2rem; border-radius: 12px; border: 1px solid #f2ebf4;">
                        @php $stat = strtolower(trim($task->status)); @endphp
                        <li class="{{ in_array($stat, ['assigned', 'processing', 'completed']) ? 'done' : 'active' }}">
                            <div style="font-weight: 700;">Stage 1: Assigned</div>
                            <small>Material delivery confirmed</small>
                        </li>
                        <li class="{{ $stat === 'processing' ? 'active' : ($stat === 'completed' ? 'done' : '') }}">
                            <div style="font-weight: 700;">Stage 2: In Progress</div>
                            <small>Wig construction & styling</small>
                        </li>
                        <li class="{{ $stat === 'completed' ? 'active' : '' }}">
                            <div style="font-weight: 700;">Stage 3: Completed</div>
                            <small>Quality check & delivery</small>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="conversion-note" style="background: linear-gradient(to right, #fdf7fb, #fff); border-left: 4px solid #ad246d;">
                <i class='bx bx-bulb' style="color: #ad246d;"></i>
                When this task is marked <strong>Completed</strong>, the assigned hair inventory record is automatically flagged for conversion into an available wig entry for recipient matching.
            </div>
        </article>

        <article class="task-update-shell">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;">
                <i class='bx bx-edit-alt' style="color: #ad246d; font-size: 1.5rem;"></i>
                <h2 style="margin: 0;">Update Production Status</h2>
            </div>
            
            <form id="taskUpdateForm" class="task-update-form" data-action-url="{{ route('wigmaker.task.update', $task->task_code) }}" novalidate>
                @if($task->status !== 'completed')
                    <div class="form-row">
                        <div class="form-group">
                            @php
                                $normalizedStatus = strtolower(trim($task->status));
                                
                                // Direct linear transition logic
                                if (in_array($normalizedStatus, ['assigned', 'in-queue', 'in queue'])) {
                                    $nextStatus = 'processing';
                                    $nextLabel = 'In Progress';
                                } elseif (in_array($normalizedStatus, ['processing', 'in-progress', 'in progress'])) {
                                    $nextStatus = 'completed';
                                    $nextLabel = 'Completed';
                                } else {
                                    $nextStatus = 'completed';
                                    $nextLabel = 'Completed';
                                }
                            @endphp
                            <label for="task-status-display">Transitioning To <span class="required">*</span></label>
                            <div style="position: relative;">
                                <i class='bx bx-right-arrow-alt' style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #ad246d; font-size: 1.2rem;"></i>
                                <input type="text" id="task-status-display" value="{{ $nextLabel }}" readonly style="background:#fdf7fb; border: 1px solid #f1a8cf; color: #ad246d; font-weight: 800; padding-right: 40px;">
                            </div>
                            <input type="hidden" name="status" value="{{ $nextStatus }}">
                        </div>
                        <div class="form-group">
                            <label for="updated-at">Update Timestamp <span class="required">*</span></label>
                            <input id="updated-at" name="updatedAt" type="datetime-local" required value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="progress-notes">Progress Message <span class="required">*</span></label>
                        <textarea id="progress-notes" name="progressNotes" rows="3" placeholder="Describe your current progress for staff review..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="preview-photo">Attach Progress Photo (Optional)</label>
                        <div style="border: 2px dashed #ead7e8; border-radius: 12px; padding: 1.5rem; text-align: center; background: #fafafa; position: relative; transition: all 0.2s ease;">
                            <i class='bx bx-image-add' style="font-size: 2.2rem; color: #ad246d; margin-bottom: 0.5rem; display: block;"></i>
                            <span style="font-size: 0.85rem; color: #7f6b88;">Click to upload or drag and drop</span>
                            <input id="preview-photo" name="previewPhoto" type="file" accept=".jpg,.jpeg,.png,.webp" style="position: absolute; inset: 0; opacity: 0; cursor: pointer;">
                        </div>
                    </div>

                    <div class="form-actions" id="formActions" style="margin-top: 1rem;">
                        <button type="submit" class="soft-btn" style="padding: 0.8rem 2rem; font-weight: 800; background: linear-gradient(135deg, #ad246d 0%, #cf2f84 100%); color: #fff; border: none;">Save Production Update</button>
                        <a class="ghost-btn" href="{{ route('wigmaker.dashboard') }}">Cancel</a>
                    </div>
                @else
                    <div class="completion-banner" style="background: #f0fdf4; color: #166534; padding: 2rem; border-radius: 16px; border: 1px solid #bbf7d0; margin-bottom: 2rem; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 4px 12px rgba(22, 101, 52, 0.05);">
                        <div style="background: #dcfce7; padding: 0.8rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class='bx bxs-check-circle' style="font-size: 2.5rem; color: #16a34a;"></i>
                        </div>
                        <div>
                            <strong style="font-size: 1.25rem; display: block; margin-bottom: 0.25rem;">Production Completed</strong>
                            <p style="margin: 0; font-size: 1rem; color: #166534; opacity: 0.9;">This task has been finalized and synced with the inventory system. No further updates are required of you.</p>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 2rem;">
                        <a class="soft-btn" href="{{ route('wigmaker.dashboard') }}" style="min-width: 200px; text-align: center;">Back to Workspace Dashboard</a>
                    </div>
                @endif
            </form>

            <p class="update-banner" data-update-banner hidden></p>
        </article>

        <article class="task-history-shell">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.4rem;">
                <i class='bx bx-history' style="color: #ad246d; font-size: 1.5rem;"></i>
                <h2 style="margin: 0;">Production Update History</h2>
            </div>
            <p class="task-history-sub">Detailed log of your stage updates for staff oversight.</p>

            <div class="table-wrap" style="margin-top: 1rem;">
                <table class="task-table" aria-label="Production update history">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th style="width: 70px; text-align: center;">Photo</th>
                            <th>Stage</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                        <tr>
                            <td style="vertical-align: middle;">{{ $history->created_at->format('Y-m-d h:i A') }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if(isset($history->metadata['preview_photo']))
                                    <a href="{{ asset('storage/' . $history->metadata['preview_photo']) }}" target="_blank" class="file-thumbnail">
                                        <img src="{{ asset('storage/' . $history->metadata['preview_photo']) }}" alt="Preview">
                                        <div class="preview-overlay"><i class='bx bx-search'></i></div>
                                    </a>
                                @else
                                    <span style="color: #ccc;">---</span>
                                @endif
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="status-pill status-{{ $history->status === 'processing' ? 'in-progress' : $history->status }}">
                                    {{ $history->status === 'processing' ? 'In Progress' : str_replace('-', ' ', ucfirst($history->status)) }}
                                </span>
                            </td>
                            <td style="vertical-align: middle;">{{ $history->notes ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;color:#7a687f;padding: 3rem;">No production history recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/wigmaker-module.js') }}" defer></script>
@endpush
