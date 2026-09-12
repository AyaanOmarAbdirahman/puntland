@extends('layouts.admin')

@section('title', 'Modify & Edit Booking #' . $booking->booking_code . ' - Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <div>
        <a href="{{ route('admin.bookings') }}" class="btn btn-outline btn-sm" style="margin-bottom:0.5rem;"><i class="fa-solid fa-arrow-left"></i> Back to Bookings</a>
        <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">Edit & Modify Booking #{{ $booking->booking_code }}</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Modify customer details, travel date, payment status, approval or rejection notes.</p>
    </div>
</div>

<div class="card" style="max-width:900px;">
    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">
            <!-- Tour Package -->
            <div style="grid-column: span 2;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Tour Package <span style="color:var(--accent-red);">*</span></label>
                <select name="tour_package_id" class="search-input" required style="width:100%;">
                    @foreach($tourPackages as $pkg)
                        <option value="{{ $pkg->id }}" {{ $booking->tour_package_id == $pkg->id ? 'selected' : '' }}>
                            {{ $pkg->title }} (${{ number_format($pkg->price_per_person, 2) }}/person - {{ $pkg->destination->city ?? 'Puntland' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Customer Full Name -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Customer Full Name <span style="color:var(--accent-red);">*</span></label>
                <input type="text" name="full_name" class="search-input" value="{{ old('full_name', $booking->full_name ?? $booking->user->name ?? '') }}" required style="width:100%;">
            </div>

            <!-- Customer Email -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Customer Email <span style="color:var(--accent-red);">*</span></label>
                <input type="email" name="email" class="search-input" value="{{ old('email', $booking->email ?? $booking->user->email ?? '') }}" required style="width:100%;">
            </div>

            <!-- Customer Phone -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Phone Number / WhatsApp <span style="color:var(--accent-red);">*</span></label>
                <input type="text" name="phone" class="search-input" value="{{ old('phone', $booking->phone ?? $booking->user->phone ?? '') }}" required style="width:100%;">
            </div>

            <!-- Current Location -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Current Location / Stay <span style="color:var(--accent-red);">*</span></label>
                <input type="text" name="current_location" class="search-input" value="{{ old('current_location', $booking->current_location ?? 'Garowe, Puntland') }}" placeholder="e.g. Garowe, Bosaso, Hargeisa, Nairobi, Dubai" required style="width:100%;">
            </div>

            <!-- Emergency Contact -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Emergency Contact (Optional)</label>
                <input type="text" name="emergency_contact" class="search-input" value="{{ old('emergency_contact', $booking->emergency_contact ?? '') }}" placeholder="Alternative phone or contact person" style="width:100%;">
            </div>

            <!-- Travel Date -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Travel Date <span style="color:var(--accent-red);">*</span></label>
                <input type="date" name="travel_date" class="search-input" value="{{ old('travel_date', $booking->travel_date ? $booking->travel_date->format('Y-m-d') : '') }}" required style="width:100%;">
            </div>

            <!-- Number of Guests -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Number of Guests <span style="color:var(--accent-red);">*</span></label>
                <input type="number" name="number_of_guests" class="search-input" min="1" max="50" value="{{ old('number_of_guests', $booking->number_of_guests) }}" required style="width:100%;">
            </div>

            <!-- Total Price ($) -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Total Price ($) <span style="color:var(--accent-red);">*</span></label>
                <input type="number" step="0.01" name="total_price" class="search-input" value="{{ old('total_price', $booking->total_price) }}" required style="width:100%;">
            </div>

            <!-- Status -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Booking Status <span style="color:var(--accent-red);">*</span></label>
                <select name="status" id="statusSelect" class="search-input" required style="width:100%;" onchange="toggleRejectionBox()">
                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Payment Status -->
            <div>
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Payment Status <span style="color:var(--accent-red);">*</span></label>
                <select name="payment_status" class="search-input" required style="width:100%;">
                    <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <!-- Special Requests -->
            <div style="grid-column: span 2;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Special Requests / Notes</label>
                <textarea name="special_requests" rows="2" class="search-input" style="width:100%;">{{ old('special_requests', $booking->special_requests) }}</textarea>
            </div>

            <!-- Reject Box (Rejection Reason) -->
            <div id="rejectBoxWrapper" style="grid-column: span 2; display: {{ $booking->status === 'rejected' ? 'block' : 'none' }}; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:1.2rem;">
                <label style="display:block; font-size:0.9rem; font-weight:700; margin-bottom:0.4rem; color:#ef4444;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Rejection Reason:
                </label>
                <textarea name="rejection_reason" id="rejection_reason" rows="3" class="search-input" placeholder="State reason why this booking is rejected (e.g. Destination reached maximum capacity, adverse weather forecast, maintenance)..." style="width:100%; border-color:#ef4444;">{{ old('rejection_reason', $booking->rejection_reason) }}</textarea>
            </div>
        </div>

        <div style="display:flex; gap:1rem; justify-content:flex-end; border-top:1px solid var(--border-glass); padding-top:1.5rem;">
            <a href="{{ route('admin.bookings') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save & Update Booking</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleRejectionBox() {
        const status = document.getElementById('statusSelect').value;
        const rejectBox = document.getElementById('rejectBoxWrapper');
        if (status === 'rejected') {
            rejectBox.style.display = 'block';
        } else {
            rejectBox.style.display = 'none';
        }
    }
</script>
@endpush
