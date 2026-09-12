@extends('layouts.app')

@section('title', $destination->title . ' - Puntland Tourism')

@section('content')
<!-- Destination Banner -->
<div style="position:relative; height:450px; background:linear-gradient(180deg, rgba(10,25,47,0.3) 0%, rgba(10,25,47,0.95) 100%), url('{{ $destination->featured_image ? asset($destination->featured_image) : asset('images/cities/' . Str::slug($destination->city) . '.jpg') }}') center/cover no-repeat;">
    <div class="container" style="height:100%; display:flex; align-items:flex-end; padding-bottom:3rem;">
        <div style="max-width:800px;">
            <div style="display:flex; gap:0.5rem; margin-bottom:0.75rem;">
                <span class="badge badge-region">{{ $destination->region }} Region</span>
                <span class="badge badge-gold"><i class="fa-solid fa-folder"></i> {{ $destination->category->name }}</span>
            </div>
            <h1 style="font-size:3.2rem; margin-bottom:0.5rem; color:#fff;">{{ $destination->title }}</h1>
            <p style="font-size:1.1rem; color:#cbd5e1;"><i class="fa-solid fa-location-dot text-info"></i> {{ $destination->city }}, {{ $destination->region }} Region, Puntland Somalia</p>
        </div>
    </div>
</div>

<div class="container" style="padding: 3rem 0;">
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:2.5rem;">
        <!-- Left Details -->
        <div>
            <div class="glass-card" style="padding:2rem; margin-bottom:2rem;">
                <h3 style="font-size:1.5rem; margin-bottom:1rem; color:var(--text-heading);">About Destination</h3>
                <p style="font-size:1.05rem; color:var(--text-main); line-height:1.8; margin-bottom:1.5rem;">
                    {{ $destination->description }}
                </p>

                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; border-top:1px solid var(--border-color); padding-top:1.5rem;">
                    <div>
                        <div style="color:var(--text-muted); font-size:0.85rem;">Tour Rates From</div>
                        <div style="font-size:1.3rem; font-weight:800; color:var(--accent-green);">${{ number_format($destination->starting_price, 0) }} <span style="font-size:0.75rem; font-weight:400; color:var(--text-muted);">/ person</span></div>
                    </div>
                    <div>
                        <div style="color:var(--text-muted); font-size:0.85rem;">Rating</div>
                        <div style="font-size:1.3rem; font-weight:800; color:var(--accent-gold);">⭐ {{ number_format($destination->rating, 1) }} / 5.0</div>
                    </div>
                    <div>
                        <div style="color:var(--text-muted); font-size:0.85rem;">Best Visit Season</div>
                        <div style="font-size:1.1rem; font-weight:700; color:var(--text-heading);">{{ $destination->best_season ?? 'All Year' }}</div>
                    </div>
                </div>
            </div>

            <!-- GPS Interactive Map -->
            <div class="glass-card" style="padding:1.5rem; margin-bottom:2rem;">
                <h3 style="font-size:1.3rem; margin-bottom:1rem; color:var(--text-heading);"><i class="fa-solid fa-map-pin text-info"></i> GPS Coordinates & GIS Map</h3>
                <div id="destMap" style="height:320px; border-radius:12px;"></div>
                <div style="display:flex; justify-content:space-between; margin-top:0.75rem; font-size:0.85rem; color:var(--text-muted);">
                    <span>Latitude: {{ $destination->latitude }}° N</span>
                    <span>Longitude: {{ $destination->longitude }}° E</span>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="glass-card" style="padding:2rem;">
                <h3 style="font-size:1.4rem; margin-bottom:1.5rem; color:var(--text-heading);">Tourist Reviews & Ratings</h3>

                <div style="display:flex; flex-direction:column; gap:1.2rem; margin-bottom:2rem;">
                    @forelse($destination->reviews as $rev)
                    <div style="background:var(--bg-card-subtle); border:1px solid var(--border-color); border-radius:12px; padding:1.2rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                            <strong style="color:var(--primary-blue);">{{ $rev->user->name ?? 'Anonymous Tourist' }}</strong>
                            <span style="color:var(--accent-gold);">{{ str_repeat('★', $rev->rating) }}</span>
                        </div>
                        <p style="font-size:0.92rem; color:var(--text-main);">{{ $rev->comment }}</p>
                        <span style="font-size:0.75rem; color:var(--text-muted); display:block; margin-top:0.4rem;">{{ $rev->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <p style="color:var(--text-muted);">No reviews submitted yet. Be the first to review!</p>
                    @endforelse
                </div>

                @auth
                <form action="{{ route('destinations.review', $destination->id) }}" method="POST" style="border-top:1px solid var(--border-color); padding-top:1.5rem;">
                    @csrf
                    <h4 style="margin-bottom:1rem; color:var(--text-heading);">Leave a Review</h4>
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Rating (1 to 5 Stars)</label>
                        <select name="rating" class="search-input" style="width:200px;">
                            <option value="5">5 Stars - Exceptional</option>
                            <option value="4">4 Stars - Very Good</option>
                            <option value="3">3 Stars - Average</option>
                            <option value="2">2 Stars - Poor</option>
                            <option value="1">1 Star - Terrible</option>
                        </select>
                    </div>
                    <div style="margin-bottom:1rem;">
                        <textarea name="comment" rows="3" class="search-input" placeholder="Share your travel experience..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Submit Review</button>
                </form>
                @else
                <p style="color:var(--text-muted);"><a href="{{ route('login') }}" style="color:var(--primary-blue);">Log in</a> to post a review.</p>
                @endauth
            </div>
        </div>

        <!-- Right Sidebar (Available Tour Packages & Actions) -->
        <div>
            <!-- Save to Itinerary Card -->
            <div class="glass-card" style="padding:1.5rem; margin-bottom:2rem; text-align:center;">
                <button id="saveBtn" onclick="toggleSave()" class="btn {{ $isSaved ? 'btn-gold' : 'btn-outline' }}" style="width:100%; justify-content:center;">
                    <i class="fa-solid fa-bookmark"></i> {{ $isSaved ? 'Saved in Itinerary' : 'Save to My Itinerary' }}
                </button>
            </div>

            <!-- Associated Packages -->
            <div class="glass-card" style="padding:1.5rem;">
                <h4 style="font-size:1.2rem; margin-bottom:1rem; color:var(--text-heading);">Available Tour Packages</h4>
                <div style="display:flex; flex-direction:column; gap:1rem;">
                    @forelse($destination->tourPackages as $pkg)
                    <div style="background:var(--bg-card-subtle); border:1px solid var(--border-color); border-radius:10px; padding:1rem;">
                        <h5 style="font-size:1rem; margin-bottom:0.3rem; color:var(--text-heading);">{{ $pkg->title }}</h5>
                        <div style="font-size:0.85rem; color:var(--accent-gold); font-weight:700; margin-bottom:0.5rem;">
                            ${{ number_format($pkg->price_per_person, 0) }} / person • {{ $pkg->duration_days }} Days
                        </div>
                        <a href="{{ route('tours.show', $pkg->slug) }}" class="btn btn-primary btn-sm" style="width:100%; justify-content:center;">View Package</a>
                    </div>
                    @empty
                    <p style="color:var(--text-muted); font-size:0.88rem;">No packages currently listed for this destination.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('destMap').setView([{{ $destination->latitude }}, {{ $destination->longitude }}], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([{{ $destination->latitude }}, {{ $destination->longitude }}]).addTo(map)
            .bindPopup("<b>{{ $destination->title }}</b><br>{{ $destination->city }}").openPopup();
    });

    function toggleSave() {
        fetch('{{ route('destinations.save', $destination->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'unauthenticated') {
                window.location.href = '{{ route('login') }}';
            } else {
                alert(data.message);
                location.reload();
            }
        });
    }
</script>
@endpush
