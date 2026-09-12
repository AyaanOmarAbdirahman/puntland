@extends('layouts.app')

@section('title', $tour->title . ' - Puntland Tourism')

@section('content')
<div style="position:relative; height:400px; background:linear-gradient(180deg, rgba(10,25,47,0.4) 0%, rgba(10,25,47,0.95) 100%), url('{{ $tour->destination->featured_image ? asset($tour->destination->featured_image) : asset('images/cities/' . Str::slug($tour->destination->city) . '.jpg') }}') center/cover no-repeat;">
    <div class="container" style="height:100%; display:flex; align-items:flex-end; padding-bottom:3rem;">
        <div>
            <div style="display:flex; gap:0.5rem; margin-bottom:0.75rem;">
                <span class="badge badge-gold"><i class="fa-solid fa-clock"></i> {{ $tour->duration_days }} Days Expedition</span>
                <span class="badge badge-region"><i class="fa-solid fa-user-group"></i> Max Capacity: {{ $tour->max_capacity }} Guests</span>
            </div>
            <h1 style="font-size:3rem; margin-bottom:0.5rem; color:#fff;">{{ $tour->title }}</h1>
            <p style="font-size:1.1rem; color:#cbd5e1;"><i class="fa-solid fa-location-dot text-info"></i> {{ $tour->destination->title ?? '' }}, {{ $tour->destination->region ?? '' }} Region</p>
        </div>
    </div>
</div>

<div class="container" style="padding: 3rem 0;">
    <div style="display:grid; grid-template-columns: 1.8fr 1.2fr; gap:2.5rem;">
        <!-- Left Content -->
        <div>
            <!-- Itinerary Section -->
            <div class="glass-card" style="padding:2rem; margin-bottom:2rem;">
                <h3 style="font-size:1.5rem; margin-bottom:1.5rem; color:var(--text-heading);"><i class="fa-solid fa-route text-info"></i> Day-by-Day Expedition Itinerary</h3>

                <div style="display:flex; flex-direction:column; gap:1.2rem;">
                    @foreach($tour->itinerary ?? [] as $day)
                    <div style="background:var(--bg-card-subtle); border:1px solid var(--border-color); border-radius:12px; padding:1.2rem;">
                        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.5rem;">
                            <div style="background:var(--primary-blue); color:#fff; font-weight:800; padding:0.25rem 0.75rem; border-radius:8px; font-size:0.85rem;">
                                DAY {{ $day['day'] ?? '1' }}
                            </div>
                            <h4 style="font-size:1.1rem; color:var(--text-heading);">{{ $day['title'] ?? '' }}</h4>
                        </div>
                        <p style="font-size:0.92rem; color:var(--text-main); margin-left:2.8rem;">{{ $day['desc'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Inclusions Section -->
            <div class="glass-card" style="padding:2rem;">
                <h3 style="font-size:1.4rem; margin-bottom:1rem; color:var(--text-heading);"><i class="fa-solid fa-circle-check text-success"></i> What's Included in Package</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    @foreach($tour->included_services ?? [] as $srv)
                    <div style="display:flex; align-items:center; gap:0.6rem; font-size:0.95rem; color:var(--text-main);">
                        <i class="fa-solid fa-check text-success"></i> {{ $srv }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Booking Form Card -->
        <div>
            <div class="glass-card" style="padding:2rem; position:sticky; top:100px;">
                <div style="border-bottom:1px solid var(--border-glass); padding-bottom:1rem; margin-bottom:1.5rem;">
                    <div style="font-size:0.85rem; color:var(--text-muted);">Package Rate</div>
                    <div style="font-size:2.2rem; font-weight:800; color:var(--primary-blue);">
                        ${{ number_format($tour->price_per_person, 2) }} <span style="font-size:0.9rem; font-weight:400; color:var(--text-muted);">/ person</span>
                    </div>
                </div>

                @auth
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tour_package_id" value="{{ $tour->id }}">

                    <h4 style="font-size:1.1rem; margin-bottom:1rem; color:var(--primary-blue);"><i class="fa-solid fa-user-pen"></i> Traveler Information</h4>

                    <!-- Full Name -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Full Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="full_name" class="search-input" value="{{ old('full_name', Auth::user()->name) }}" required placeholder="Enter your full name">
                    </div>

                    <!-- Email & Phone Grid -->
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-bottom:1rem;">
                        <div>
                            <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Email Address <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" class="search-input" value="{{ old('email', Auth::user()->email) }}" required placeholder="email@example.com">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Phone / WhatsApp <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="phone" class="search-input" value="{{ old('phone', Auth::user()->phone) }}" required placeholder="+252 90 ...">
                        </div>
                    </div>

                    <!-- Current Location & Emergency Contact -->
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-bottom:1rem;">
                        <div>
                            <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);"><i class="fa-solid fa-location-dot text-info"></i> Current City You Are In <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="current_location" class="search-input" value="{{ old('current_location') }}" required placeholder="e.g. Garowe, Bosaso, Galkacyo, Mogadishu, Nairobi...">
                            <small style="display:block; color:var(--text-muted); font-size:0.75rem; margin-top:3px;">Write the city where you are currently staying</small>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);"><i class="fa-solid fa-phone text-warning"></i> Emergency Contact (Optional)</label>
                            <input type="text" name="emergency_contact" class="search-input" value="{{ old('emergency_contact') }}" placeholder="Alternative phone or family contact">
                            <small style="display:block; color:var(--text-muted); font-size:0.75rem; margin-top:3px;">Alternative phone number for safety</small>
                        </div>
                    </div>

                    <h4 style="font-size:1.1rem; margin-top:1.2rem; margin-bottom:1rem; color:var(--primary-blue);"><i class="fa-solid fa-calendar-days"></i> Expedition Details</h4>

                    <!-- Travel Date -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Travel Date <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="travel_date" class="search-input" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required min="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Number of Guests -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Number of Guests <span style="color:#ef4444;">*</span></label>
                        <select name="number_of_guests" id="guestSelect" class="search-input" onchange="calculateTotal()">
                            @for($i=1; $i<=$tour->max_capacity; $i++)
                                <option value="{{ $i }}">{{ $i }} Guest{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Special Requests -->
                    <div style="margin-bottom:1.2rem;">
                        <label style="display:block; font-size:0.85rem; margin-bottom:0.3rem; color:var(--text-muted);">Special Requests / Notes (Optional)</label>
                        <textarea name="special_requests" rows="2" class="search-input" placeholder="Dietary restrictions, preferred pickup location, special accommodations..."></textarea>
                    </div>

                    <div style="background:rgba(0,180,216,0.1); border:1px solid rgba(0,180,216,0.3); border-radius:10px; padding:1rem; margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:center;">
                        <span>Total Estimated Amount:</span>
                        <strong id="totalDisplay" style="font-size:1.3rem; color:var(--accent-gold);">${{ number_format($tour->price_per_person, 2) }}</strong>
                    </div>

                    <button type="submit" class="btn btn-gold" style="width:100%; justify-content:center; padding:0.9rem;"><i class="fa-solid fa-bolt"></i> Submit Booking Request</button>
                </form>
                @else
                <div style="text-align:center; padding:1rem 0;">
                    <p style="color:var(--text-muted); margin-bottom:1rem;">Please log in or register to complete your tour reservation.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%; justify-content:center;">Log In to Book</a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function calculateTotal() {
        const guests = parseInt(document.getElementById('guestSelect').value) || 1;
        const rate = {{ $tour->price_per_person }};
        const total = guests * rate;
        document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
    }
</script>
@endpush
