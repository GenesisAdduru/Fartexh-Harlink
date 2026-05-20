@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Real-time Tracking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <div class="section-title-block">
        <h1>Real-time Tracking Console</h1>
        <p>Monitor hair production and wig fulfillment workflows using separate operational queues.</p>
    </div>

    <!-- Tab Navigation -->
    <div class="staff-tabs-header">
        <button class="staff-tab-btn active" data-tab-trigger="donations">
            <i class='bx bx-package'></i> Hair Donations & Production
        </button>
        <button class="staff-tab-btn" data-tab-trigger="requests">
            <i class='bx bx-user-check'></i> Recipient Fulfillment
        </button>
    </div>

    <!-- Tab Pane 1: Donations -->
    <div class="tab-pane active" id="donations-pane">
        <div class="staff-block" style="border:none; background:transparent; padding:0; box-shadow:none;">
            <div class="staff-bar" style="margin-bottom: 1.5rem;">
                <div class="batch-line" style="margin:0;">
                    <strong>Donation Trackers</strong>
                    <small style="color: #8c7895; font-size: 0.8rem; font-weight: 500;">{{ $donations->count() }} active trackers</small>
                </div>
            </div>
            
            <div data-search-block style="display: flex; flex-direction: column; gap: 1.25rem;">
                @forelse($donations as $donation)
                    @php
                        $normStatus = str_replace(' ', '-', strtolower($donation->status));
                        $wigProd = $wigProductions[$donation->id] ?? null;
                        $assignedWigmaker = $wigProd ? $wigProd->wigmaker : null;
                        $isWigmakerControlled = in_array($donation->status, ['In Queue', 'In Progress']);
                        $isCompleted = $donation->status === 'Completed';
                        $isWigReceived = $donation->status === 'Wig Received';
                    @endphp
                    <article class="tracking-item" data-track-card data-card-id="{{ $donation->reference }}" data-current-status="{{ $normStatus }}" data-card-type="donor" data-search-row>
                        <div class="tracking-head">
                            <strong>Donation # {{ $donation->reference }}</strong>
                            <span class="status-chip" data-status-chip>{{ $donation->status }}</span>
                        </div>
                        <div class="tracking-meta" style="flex-wrap: wrap; gap: 0.5rem 1.5rem;">
                            <span>Donor: <strong>{{ $donation->user->first_name ?? '' }} {{ $donation->user->last_name ?? '' }}</strong></span>
                            <span>Hair Length: <strong>{{ $donation->hair_length }}</strong></span>
                            <span>Hair Color: <strong>{{ $donation->hair_color }}</strong></span>
                        </div>
                        <div class="stage-row" style="margin-top: 1rem; border-top: 1px dashed #f2ebf4; padding-top: 1rem;">
                            <div class="stage" data-stage="verified"><i class='bx bx-check-circle'></i><small>Verified</small></div>
                            <div class="stage" data-stage="received-hair"><i class='bx bx-package'></i><small>Received Hair</small></div>
                            <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                            <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                            <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Done</small></div>
                            <div class="stage" data-stage="wig-received"><i class='bx bx-gift'></i><small>Received</small></div>
                        </div>

                        <div class="track-actions" data-donor-actions style="display: flex; gap: 1.25rem; align-items: stretch; margin-top: 1.25rem;">
                            <div class="action-left-pane" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                @if($donation->status === 'Verified')
                                    @if($donation->donor_delivery_link)
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                                            <div style="background: #dbeafe; padding: 0.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class='bx bx-package' style="font-size: 1.2rem; color: #2563eb;"></i>
                                            </div>
                                            <div style="flex: 1; min-width: 0;">
                                                <strong style="font-size: 0.72rem; color: #1e40af; display: block; margin-bottom: 0.15rem;">Delivery / Shipping Tracking Link</strong>
                                                <a href="{{ $donation->donor_delivery_link }}" target="_blank" rel="noopener noreferrer" 
                                                   style="font-size: 0.82rem; color: #2563eb; word-break: break-all; text-decoration: underline; font-weight: 600;">
                                                    {{ Str::limit($donation->donor_delivery_link, 50) }}
                                                </a>
                                            </div>
                                            <a href="{{ $donation->donor_delivery_link }}" target="_blank" rel="noopener noreferrer" 
                                               style="background: #2563eb; color: #fff; padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.72rem; font-weight: 700; text-decoration: none; white-space: nowrap;">
                                                <i class='bx bx-link-external' style="vertical-align: middle; margin-right: 2px;"></i> Track
                                            </a>
                                        </div>
                                    @else
                                        <div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 12px; padding: 0.6rem 1rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.6rem; width: 100%;">
                                            <i class='bx bx-info-circle' style="color: #d97706; font-size: 1.1rem;"></i>
                                            <small style="color: #92400e; font-weight: 600; font-size: 0.75rem;">Awaiting donor shipping details.</small>
                                        </div>
                                    @endif

                                    <button type="button" class="soft-btn" data-confirm-received style="padding: 0.5rem 1.25rem; font-weight: 700; width: fit-content; margin-inline: auto;">
                                        <i class='bx bx-package'></i> Confirm Hair Received from Donor
                                    </button>
                                @endif

                                @if($donation->status === 'Received Hair')
                                    <div class="assignment-section" style="margin-top: 0; padding-top: 0; border: none;">
                                        <label class="assignment-label" style="font-size: 0.8rem; color: #8c7895;"><i class='bx bx-user-plus'></i> STEP 1: CHOOSE A PARTNER WIGMAKER</label>
                                        <div class="progress-editor" style="background: #fff; border: 1px solid #f2ebf4; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                                            <div class="progress-editor-row" style="grid-template-columns: 1fr auto;">
                                                <select data-wigmaker-assignment style="border: none; background: transparent; font-weight: 700; color: #4a3f4e;">
                                                    <option value="" disabled selected>Select Wigmaker...</option>
                                                    @foreach($wigmakers as $wm)
                                                        <option value="{{ $wm->id }}">{{ $wm->first_name }} {{ $wm->last_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="save-task-btn" data-assign-wigmaker style="border-radius: 8px; padding: 0.5rem 1rem;">Assign Now</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($isWigmakerControlled)
                                    <div class="sync-notice" style="background: #fdf7fb; border: 1px solid #f3e6f0; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 38px; height: 38px; background: #fceef6; border-radius: 50%; display: grid; place-items: center; color: #ad246d; flex-shrink: 0;">
                                            <i class='bx bx-sync bx-spin' style="font-size: 1.3rem;"></i>
                                        </div>
                                        <div style="font-size: 0.82rem; line-height: 1.4; color: #5f5068;">
                                            <div style="font-weight: 800; color: #3b2e43;">Wigmaker Controlled</div>
                                            Status synced with <strong>{{ $assignedWigmaker ? "{$assignedWigmaker->first_name} {$assignedWigmaker->last_name}" : 'partner' }}</strong>.
                                        </div>
                                    </div>
                                @endif

                                @if($isCompleted)
                                    @if($wigProd && $wigProd->delivery_link)
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                                            <div style="background: #dbeafe; padding: 0.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class='bx bx-package' style="font-size: 1.2rem; color: #2563eb;"></i>
                                            </div>
                                            <div style="flex: 1; min-width: 0;">
                                                <strong style="font-size: 0.72rem; color: #1e40af; display: block; margin-bottom: 0.15rem;">Delivery / Shipping Tracking Link (from Wigmaker)</strong>
                                                <a href="{{ $wigProd->delivery_link }}" target="_blank" rel="noopener noreferrer" 
                                                   style="font-size: 0.82rem; color: #2563eb; word-break: break-all; text-decoration: underline; font-weight: 600;">
                                                    {{ Str::limit($wigProd->delivery_link, 50) }}
                                                </a>
                                            </div>
                                            <a href="{{ $wigProd->delivery_link }}" target="_blank" rel="noopener noreferrer" 
                                               style="background: #2563eb; color: #fff; padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.72rem; font-weight: 700; text-decoration: none; white-space: nowrap;"
                                               onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                                                <i class='bx bx-link-external' style="vertical-align: middle; margin-right: 2px;"></i> Track
                                            </a>
                                        </div>
                                    @endif
                                    <button type="button" class="soft-btn" data-confirm-wig-received style="padding: 0.5rem 1.25rem; font-weight: 800; width: fit-content; margin-inline: auto;">
                                        <i class='bx bx-gift'></i> Confirm Wig Received from Wigmaker
                                    </button>
                                @endif

                                @if($isWigReceived)
                                    <div class="final-state-info" style="background: #f8fff9; border: 1px solid #d4edda; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 38px; height: 38px; background: #e9f7ec; border-radius: 50%; display: grid; place-items: center; color: #28a745; flex-shrink: 0;">
                                            <i class='bx bx-check-double' style="font-size: 1.4rem;"></i>
                                        </div>
                                        <div style="font-size: 0.82rem; line-height: 1.4; color: #155724;">
                                            <div style="font-weight: 800;">Workflow Complete</div>
                                            Wig received: <strong>{{ $donation->received_wig_at ? $donation->received_wig_at->format('M d, Y') : 'N/A' }}</strong>.
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @php
                                $latestUpdate = $wigProd ? $wigProd->latestStatusHistory : null;
                            @endphp
                            @if($latestUpdate && ($latestUpdate->preview_photo_url || $latestUpdate->notes))
                                <div class="wigmaker-update-card" style="width: 160px; flex-shrink: 0; background: #fff; border: 1px solid #f2ebf4; border-radius: 14px; padding: 0.75rem; display: flex; flex-direction: column; gap: 0.6rem; box-shadow: 0 4px 15px rgba(173, 36, 109, 0.05);">
                                    <div style="color: #ad246d; font-size: 0.62rem; font-weight: 800; text-transform: uppercase;">Latest Update</div>
                                    @if($latestUpdate->preview_photo_url)
                                        <a href="{{ $latestUpdate->preview_photo_url }}" target="_blank" class="file-thumbnail" style="width: 100%; aspect-ratio: 1.2; margin:0; border-radius: 8px;">
                                            <img src="{{ $latestUpdate->preview_photo_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    @endif
                                    @if($latestUpdate->notes)
                                        <div style="font-size: 0.74rem; color: #4d3f56; line-height: 1.3;">"{{ Str::limit($latestUpdate->notes, 60) }}"</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <p class="tracking-footnote" data-last-updated>Last updated: {{ $donation->updated_at->diffForHumans() }}</p>
                    </article>
                @empty
                    <div class="empty-note">No donations currently in the tracking workflow.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tab Pane 2: Requests -->
    <div class="tab-pane" id="requests-pane">
        <div class="staff-block" style="border:none; background:transparent; padding:0; box-shadow:none;">
            <div class="staff-bar" style="margin-bottom: 1.5rem;">
                <div class="batch-line" style="margin:0;">
                    <strong>Recipient Trackers</strong>
                    <small style="color: #8c7895; font-size: 0.8rem; font-weight: 500;">{{ $requests->count() }} active trackers</small>
                </div>
            </div>
            
            <div data-search-block style="display: flex; flex-direction: column; gap: 1.25rem;">
                @forelse($requests as $request)
                    @php
                        $normStatus = str_replace(' ', '-', strtolower($request->status));
                    @endphp
                    <article class="tracking-item" data-track-card data-card-id="{{ $request->reference }}" data-current-status="{{ $normStatus }}" data-card-type="recipient" data-search-row>
                        <div class="tracking-head">
                            <strong>Request # {{ $request->reference }}</strong>
                            <span class="status-chip" data-status-chip>{{ $request->status }}</span>
                        </div>
                        <div class="tracking-meta" style="flex-wrap: wrap; gap: 0.5rem 1.5rem;">
                            <span>Patient: <strong>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</strong></span>
                            <span>Wig Length: <strong>{{ ucfirst($request->wig_length ?? 'N/A') }}</strong></span>
                            <span>Wig Color: <strong>{{ ucfirst($request->wig_color ?? 'N/A') }}</strong></span>
                        </div>
                        <div class="stage-row" style="margin-top: 1rem; border-top: 1px dashed #f2ebf4; padding-top: 1rem;">
                            <div class="stage" data-stage="validated"><i class='bx bx-check-circle'></i><small>Validated</small></div>
                            <div class="stage" data-stage="matched"><i class='bx bx-user-check'></i><small>Matched</small></div>
                            <div class="stage" data-stage="in-transit"><i class='bx bx-bus'></i><small>In Transit</small></div>
                            <div class="stage" data-stage="completed"><i class='bx bx-check-double'></i><small>Completed</small></div>
                        </div>
                        <div class="track-actions" style="display: flex; gap: 1.25rem; align-items: stretch; margin-top: 1.25rem;">
                            <div class="action-left-pane" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                @if($request->status === 'Validated')
                                    <button type="button" class="soft-btn" onclick="window.location.href='{{ route('staff.rule-matching') }}?ref={{ $request->reference }}'" style="padding: 0.5rem 1.25rem; font-weight: 700; width: fit-content; margin-inline: auto;">
                                        <i class='bx bx-user-check'></i> Match This Recipient
                                    </button>
                                @elseif($request->status === 'Matched')
                                    <div class="shipment-section" style="width: 100%;">
                                        <div class="form-group" style="margin-bottom: 0.8rem;">
                                            <label style="font-size: 0.78rem; color: #8c7895; font-weight: 800; text-transform: uppercase; display: flex; align-items: center; gap: 0.3rem; margin-bottom: 0.4rem;">
                                                <i class='bx bx-link-alt' style="color: #ad246d;"></i> Delivery / Shipping Tracking Link <span style="color: #e74c3c;">*</span>
                                            </label>
                                            <p style="margin: 0 0 0.4rem 0; font-size: 0.75rem; color: #8c7895;">Provide the courier tracking URL so the shipment can be monitored.</p>
                                            <div style="position: relative;">
                                                <i class='bx bx-package' style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #ad246d; font-size: 1.1rem;"></i>
                                                <input type="url" data-delivery-link-input
                                                    placeholder="https://tracking.courier.com/your-tracking-id" 
                                                    required
                                                    style="padding-left: 36px; background: #fdf7fb; border: 1px solid #ead7e8; border-radius: 10px; width: 100%; padding-top: 0.6rem; padding-bottom: 0.6rem; font-size: 0.88rem; transition: border-color 0.2s ease;"
                                                    onfocus="this.style.borderColor='#ad246d'" onblur="this.style.borderColor='#ead7e8'">
                                            </div>
                                        </div>
                                        <button type="button" class="soft-btn" data-ship-wig style="padding: 0.5rem 1.25rem; font-weight: 700; width: fit-content; margin-inline: auto;">
                                            <i class='bx bx-bus'></i> Confirm Shipment / In Transit
                                        </button>
                                    </div>
                                @elseif($request->status === 'In Transit')
                                    @if($request->delivery_tracking_link)
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                                            <div style="background: #dbeafe; padding: 0.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class='bx bx-package' style="font-size: 1.2rem; color: #2563eb;"></i>
                                            </div>
                                            <div style="flex: 1; min-width: 0;">
                                                <strong style="font-size: 0.72rem; color: #1e40af; display: block; margin-bottom: 0.15rem;">Delivery / Shipping Tracking Link</strong>
                                                <a href="{{ $request->delivery_tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                                   style="font-size: 0.82rem; color: #2563eb; word-break: break-all; text-decoration: underline; font-weight: 600;">
                                                    {{ Str::limit($request->delivery_tracking_link, 50) }}
                                                </a>
                                            </div>
                                            <a href="{{ $request->delivery_tracking_link }}" target="_blank" rel="noopener noreferrer" 
                                               style="background: #2563eb; color: #fff; padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.72rem; font-weight: 700; text-decoration: none; white-space: nowrap;"
                                               onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                                                <i class='bx bx-link-external' style="vertical-align: middle; margin-right: 2px;"></i> Track
                                            </a>
                                        </div>
                                    @endif
                                    <div class="sync-notice" style="background: #fdf7fb; border: 1px solid #f3e6f0; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                                        <div style="width: 38px; height: 38px; background: #fceef6; border-radius: 50%; display: grid; place-items: center; color: #ad246d; flex-shrink: 0;">
                                            <i class='bx bx-bus bx-tada' style="font-size: 1.3rem;"></i>
                                        </div>
                                        <div style="font-size: 0.82rem; line-height: 1.4; color: #5f5068;">
                                            <div style="font-weight: 800; color: #3b2e43;">In Transit — Awaiting Recipient Confirmation</div>
                                            Wig has been shipped. Waiting for the recipient to confirm receipt.
                                        </div>
                                    </div>
                                @elseif($request->status === 'Completed')
                                    <div class="final-state-info" style="background: #f8fff9; border: 1px solid #d4edda; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 38px; height: 38px; background: #e9f7ec; border-radius: 50%; display: grid; place-items: center; color: #28a745; flex-shrink: 0;">
                                            <i class='bx bx-check-double' style="font-size: 1.4rem;"></i>
                                        </div>
                                        <div style="font-size: 0.82rem; line-height: 1.4; color: #155724;">
                                            <div style="font-weight: 800;">Workflow Complete</div>
                                            Recipient confirmed wig received{{ $request->wig_received_at ? ' on ' . $request->wig_received_at->format('M d, Y') : '' }}.
                                        </div>
                                    </div>
                                    @if($request->delivery_tracking_link)
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.8rem 1rem; margin-top: 0.6rem; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                                            <div style="background: #dbeafe; padding: 0.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class='bx bx-package' style="font-size: 1.2rem; color: #2563eb;"></i>
                                            </div>
                                            <div style="flex: 1; min-width: 0;">
                                                <strong style="font-size: 0.72rem; color: #1e40af; display: block;">Delivery Link</strong>
                                                <a href="{{ $request->delivery_tracking_link }}" target="_blank" style="font-size: 0.82rem; color: #2563eb; word-break: break-all; text-decoration: underline; font-weight: 600;">{{ Str::limit($request->delivery_tracking_link, 50) }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <p class="tracking-footnote" data-last-updated>Last updated: {{ $request->updated_at->diffForHumans() }}</p>
                    </article>
                @empty
                    <div class="empty-note">No recipient requests currently in tracking.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabBtns = document.querySelectorAll('[data-tab-trigger]');
            const tabPanes = document.querySelectorAll('.tab-pane');

            const switchTab = (target) => {
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));

                const activeBtn = document.querySelector(`[data-tab-trigger="${target}"]`);
                const activePane = document.getElementById(`${target}-pane`);
                
                if (activeBtn) activeBtn.classList.add('active');
                if (activePane) activePane.classList.add('active');
            };

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    switchTab(btn.dataset.tabTrigger);
                });
            });

            // Auto-switch based on URL query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam && (tabParam === 'donations' || tabParam === 'requests')) {
                switchTab(tabParam);
            }
        });
    </script>
@endpush
