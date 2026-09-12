@extends('layouts.admin')

@section('title', 'Manage Bookings - Admin')

@push('styles')
<style>
    .status-rejected { background: rgba(239, 68, 68, 0.25); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.4); }
    .status-pending { background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
    .status-confirmed { background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
    .status-completed { background: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
    .status-cancelled { background: rgba(148, 163, 184, 0.2); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); }

    /* Modal Backdrop */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .modal-content {
        background: #0f1c30;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        color: #fff;
    }
</style>
@endpush

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <div>
        <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">Tour Booking Requests</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Review tourist bookings, approve, reject with reason, edit or modify details</p>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Booking Code</th>
                    <th>Tourist Info & Location</th>
                    <th>Tour Package</th>
                    <th>Travel Date</th>
                    <th>Guests</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Quick Status</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td style="font-weight:700; color:var(--primary-blue);">
                        {{ $b->booking_code }}
                    </td>
                    <td>
                        <div style="font-weight:700; color:#fff;">
                            {{ $b->full_name ?? $b->user->name ?? 'Tourist' }}
                        </div>
                        <div style="font-size:0.8rem; color:#38bdf8; margin-top:2px;">
                            <i class="fa-solid fa-location-dot"></i> {{ $b->current_location ?? 'Puntland' }}
                        </div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                            <i class="fa-solid fa-phone"></i> {{ $b->phone ?? $b->user->phone ?? 'N/A' }} | 
                            <i class="fa-solid fa-envelope"></i> {{ $b->email ?? $b->user->email ?? 'N/A' }}
                        </div>
                        @if($b->emergency_contact)
                            <div style="font-size:0.72rem; color:#94a3b8;">
                                <i class="fa-solid fa-address-book"></i> Alt: {{ $b->emergency_contact }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600; color:#fff;">{{ $b->tourPackage->title ?? 'N/A' }}</div>
                        <span style="font-size:0.75rem; color:var(--text-muted);">{{ $b->tourPackage->destination->city ?? '' }}</span>
                    </td>
                    <td>{{ $b->travel_date ? $b->travel_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $b->number_of_guests }} Guests</td>
                    <td style="font-weight:700; color:var(--accent-green);">${{ number_format($b->total_price, 2) }}</td>
                    <td>
                        <span class="status-pill status-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
                    </td>
                    <td>
                        <span class="badge" style="background:{{ $b->payment_status == 'paid' ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.2)' }}; color:{{ $b->payment_status == 'paid' ? '#10b981' : '#ef4444' }}; font-size:0.75rem;">
                            {{ strtoupper($b->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.status', $b->id) }}" method="POST" style="display:flex; gap:0.3rem; align-items:center;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="search-input" style="padding:0.3rem 0.4rem; font-size:0.78rem;">
                                <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ $b->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ $b->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <select name="payment_status" class="search-input" style="padding:0.3rem 0.4rem; font-size:0.78rem;">
                                <option value="unpaid" {{ $b->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $b->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm" title="Quick Save"><i class="fa-solid fa-check"></i></button>
                        </form>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem; justify-content:center;">
                            <!-- Edit / Modify Button -->
                            <a href="{{ route('admin.bookings.edit', $b->id) }}" class="btn btn-sm btn-primary" title="Edit & Modify Booking">
                                <i class="fa-solid fa-pen-to-square"></i> Modify
                            </a>

                            <!-- Reject Box Button -->
                            @if($b->status !== 'rejected')
                            <button type="button" class="btn btn-sm btn-danger" onclick="openRejectModal({{ $b->id }}, '{{ $b->booking_code }}', '{{ addslashes($b->full_name ?? $b->user->name ?? 'Tourist') }}')" title="Reject with Reason (Reject Box)">
                                <i class="fa-solid fa-ban"></i> Reject
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>

                @if($b->rejection_reason)
                <tr style="background:rgba(239,68,68,0.1); border-left:3px solid #ef4444;">
                    <td colspan="10" style="font-size:0.83rem; color:#fca5a5; padding:0.6rem 1rem;">
                        <i class="fa-solid fa-circle-exclamation"></i> <strong>Rejection Reason:</strong> {{ $b->rejection_reason }}
                    </td>
                </tr>
                @endif

                @if($b->special_requests)
                <tr style="background:rgba(0,0,0,0.2);">
                    <td colspan="10" style="font-size:0.82rem; color:var(--accent-gold); padding:0.5rem 1rem;">
                        <i class="fa-solid fa-comment-dots"></i> <strong>Special Request:</strong> {{ $b->special_requests }}
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:3rem; color:var(--text-muted);">
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $bookings->links() }}
    </div>
</div>

<!-- Reject Box Modal -->
<div id="rejectModal" class="modal-backdrop">
    <div class="modal-content">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem; border-bottom:1px solid var(--border-glass); padding-bottom:0.75rem;">
            <h3 style="font-size:1.2rem; color:#ef4444;"><i class="fa-solid fa-ban"></i> Reject Tour Booking</h3>
            <button onclick="closeRejectModal()" style="background:none; border:none; color:#cbd5e1; font-size:1.2rem; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="rejectForm" method="POST" action="">
            @csrf
            <p style="font-size:0.9rem; color:#cbd5e1; margin-bottom:1rem;">
                Are you sure you want to reject booking <strong id="modalBookingCode" style="color:#38bdf8;"></strong> for <span id="modalTouristName"></span>?
            </p>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; font-weight:700; margin-bottom:0.4rem; color:#f87171;">
                    Rejection Reason <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="rejection_reason" id="rejection_reason_input" rows="4" class="search-input" required placeholder="State the reason for rejection (e.g. Fully booked for this date, adverse weather conditions, maintenance)..." style="width:100%; border:1px solid #ef4444;"></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:0.75rem;">
                <button type="button" onclick="closeRejectModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-ban"></i> Confirm Reject</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openRejectModal(bookingId, code, touristName) {
        document.getElementById('rejectForm').action = "{{ url('admin/bookings') }}/" + bookingId + "/reject";
        document.getElementById('modalBookingCode').textContent = '#' + code;
        document.getElementById('modalTouristName').textContent = touristName;
        document.getElementById('rejection_reason_input').value = '';
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    // Close modal on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target === modal) {
            closeRejectModal();
        }
    }
</script>
@endpush
