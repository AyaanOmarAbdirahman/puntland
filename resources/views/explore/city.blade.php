@extends('layouts.app')

@section('title', $cityName . ' — Travel Expeditions & Attractions')

@push('styles')
<style>
/* ===================== CITY HERO ===================== */
.city-hero {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 60%, #0c4a6e 100%);
    color: #ffffff;
    padding: 4rem 1.5rem 3rem;
    text-align: center;
    position: relative;
}
.city-hero h1 {
    font-size: 2.6rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: #ffffff !important;
}
.city-hero p {
    font-size: 1.1rem;
    color: #e0f2fe !important;
    max-width: 650px;
    margin: 0 auto;
}

.back-bar {
    max-width: 1240px;
    margin: 1.5rem auto 0;
    padding: 0 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #0284c7;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    transition: color 0.2s, transform 0.2s;
}
.back-link:hover {
    color: #0369a1;
    transform: translateX(-3px);
    text-decoration: none;
}

.city-content-wrapper {
    max-width: 1240px;
    margin: 1.5rem auto 5rem;
    padding: 0 1.5rem;
}

/* Overview Card */
.city-overview-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.8rem 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 2.5rem;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    align-items: center;
}
.city-overview-text h3 {
    font-size: 1.4rem;
    color: #0c4a6e;
    margin-bottom: 0.6rem;
}
.city-overview-text p {
    font-size: 0.98rem;
    color: #475569;
    line-height: 1.7;
}
.city-stats-pillbox {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    background: #f0f9ff;
    padding: 1.2rem;
    border-radius: 12px;
    border: 1px solid #bae6fd;
}
.stat-item {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #0f172a;
}
.stat-item strong {
    color: #0284c7;
}

/* Sections Header */
.section-heading {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0c4a6e;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

/* ===================== PACKAGES GRID ===================== */
.pkg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3.5rem;
}
.pkg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 6px 22px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.25s, box-shadow 0.25s;
}
.pkg-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 32px rgba(2, 132, 199, 0.16);
}
.pkg-card-header {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    padding: 1.2rem 1.5rem;
    font-size: 1.2rem;
    font-weight: 800;
    color: #0c4a6e;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    border-bottom: 1px solid #bae6fd;
}
.pkg-card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.pkg-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    margin-bottom: 1.2rem;
}
.pkg-badge {
    background: #f0f9ff;
    color: #0284c7;
    border: 1px solid #bae6fd;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 600;
}
.pkg-price-box {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #f1f5f9;
}
.pkg-price {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0284c7;
}
.pkg-price small {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 500;
}

.services-list {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.services-list li {
    font-size: 0.88rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.services-list li i {
    color: #10b981;
}

/* Booking Form */
.booking-form {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.2rem;
    margin-top: auto;
}
.booking-form label {
    font-size: 0.85rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 0.3rem;
    display: block;
}
.booking-form .form-control {
    width: 100%;
    padding: 0.65rem 0.85rem;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.92rem;
    color: #0f172a;
    background: #ffffff;
    margin-bottom: 0.8rem;
}
.booking-form .form-control:focus {
    border-color: #0284c7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
}
.btn-book-now {
    width: 100%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
}
.btn-book-now:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
    transform: translateY(-1px);
}

/* Auth prompt */
.auth-prompt {
    text-align: center;
    padding: 1rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-top: auto;
}
.auth-prompt p {
    font-size: 0.88rem;
    color: #64748b;
    margin-bottom: 0.8rem;
}
.btn-login-book {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, #0284c7 0%, #00b4d8 100%);
    color: #ffffff !important;
    border-radius: 8px;
    padding: 0.65rem;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    margin-bottom: 0.6rem;
    transition: all 0.2s ease;
}
.btn-login-book:hover {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    text-decoration: none;
}
.btn-register-book {
    display: block;
    width: 100%;
    background: #ffffff;
    color: #0284c7 !important;
    border: 1.5px solid #0284c7;
    border-radius: 8px;
    padding: 0.6rem;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-register-book:hover {
    background: #0284c7;
    color: #ffffff !important;
    text-decoration: none;
}

/* ===================== DESTINATIONS GRID ===================== */
.dest-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.8rem;
}
.dest-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
    transition: transform 0.25s, box-shadow 0.25s;
    text-decoration: none;
    color: #0f172a;
    display: flex;
    flex-direction: column;
}
.dest-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(2,132,199,0.15);
    text-decoration: none;
}
.dest-card-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}
.dest-card-body {
    padding: 1.2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.dest-card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0c4a6e;
    margin-bottom: 0.3rem;
}
.dest-card-desc {
    font-size: 0.86rem;
    color: #64748b;
    line-height: 1.55;
    flex: 1;
    margin-bottom: 1rem;
}

/* Empty States */
.no-items {
    text-align: center;
    padding: 3.5rem 1.5rem;
    background: #ffffff;
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    color: #64748b;
}
.no-items i {
    font-size: 3rem;
    color: #0284c7;
    margin-bottom: 0.8rem;
}

/* ===================== DARK MODE OVERRIDES ===================== */
body.dark-mode .city-overview-card {
    background: #112240 !important;
    border-color: #1e293b !important;
    color: #f8fafc !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
}
body.dark-mode .city-overview-text h3 {
    color: #f8fafc !important;
}
body.dark-mode .city-overview-text p {
    color: #cbd5e1 !important;
}
body.dark-mode .city-stats-pillbox {
    background: #0f172a !important;
    border-color: #1e293b !important;
}
body.dark-mode .stat-item {
    color: #cbd5e1 !important;
}
body.dark-mode .stat-item strong {
    color: #38bdf8 !important;
}
body.dark-mode .section-heading {
    color: #f8fafc !important;
}

body.dark-mode .pkg-card {
    background: #112240 !important;
    border-color: #1e293b !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
}
body.dark-mode .pkg-card-header {
    background: linear-gradient(135deg, #0c4a6e 0%, #075985 100%) !important;
    color: #e0f2fe !important;
    border-bottom-color: #1e293b !important;
}
body.dark-mode .pkg-badge {
    background: #0f172a !important;
    border-color: #1e293b !important;
    color: #7dd3fc !important;
}
body.dark-mode .pkg-price {
    color: #38bdf8 !important;
}
body.dark-mode .pkg-price small {
    color: #94a3b8 !important;
}
body.dark-mode .pkg-price-box {
    border-bottom-color: #1e293b !important;
}
body.dark-mode .services-list li {
    color: #cbd5e1 !important;
}
body.dark-mode .booking-form {
    background: #0f172a !important;
    border-color: #1e293b !important;
}
body.dark-mode .booking-form label {
    color: #cbd5e1 !important;
}
body.dark-mode .booking-form .form-control {
    background: #0b1329 !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
body.dark-mode .auth-prompt {
    background: #0f172a !important;
    border-color: #1e293b !important;
}
body.dark-mode .auth-prompt p {
    color: #94a3b8 !important;
}
body.dark-mode .btn-register-book {
    background: #112240 !important;
    color: #38bdf8 !important;
    border-color: #38bdf8 !important;
}

body.dark-mode .dest-card {
    background: #112240 !important;
    border-color: #1e293b !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3) !important;
    color: #f8fafc !important;
}
body.dark-mode .dest-card-title {
    color: #f8fafc !important;
}
body.dark-mode .dest-card-desc {
    color: #cbd5e1 !important;
}
body.dark-mode .no-items {
    background: #112240 !important;
    border-color: #1e293b !important;
    color: #cbd5e1 !important;
}
body.dark-mode .back-link {
    color: #38bdf8 !important;
}
</style>
@endpush

@section('content')

<!-- City Hero Banner -->
<div class="city-hero">
    <div class="badge badge-gold" style="margin-bottom: 0.8rem; background: rgba(255,255,255,0.18); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">
        <i class="fa-solid fa-map-pin"></i> {{ $cityData['region'] ?? 'Puntland' }} Region
    </div>
    <h1>{{ $cityName }}</h1>
    <p>{{ $cityData['tag'] ?? 'Available travel expeditions & attractions' }}</p>
</div>

<!-- Back Link Navigation -->
<div class="back-bar">
    <a href="{{ route('explore') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Explore Cities
    </a>
    <span style="font-size: 0.88rem; color: var(--text-muted);">
        <i class="fa-solid fa-compass me-1"></i> Explore Puntland / {{ $cityName }}
    </span>
</div>

<div class="city-content-wrapper">

    <!-- City Overview Card -->
    <div class="city-overview-card">
        <div class="city-overview-text">
            <h3><i class="fa-solid fa-circle-info me-2 text-info"></i> About {{ $cityName }}</h3>
            <p>{{ $cityData['desc'] ?? 'The city of ' . $cityName . ' is one of the premier highlights of Puntland State.' }}</p>
        </div>
        <div class="city-stats-pillbox">
            <div class="stat-item">
                <span>Region:</span>
                <strong>{{ $cityData['region'] ?? 'Puntland' }}</strong>
            </div>
            <div class="stat-item">
                <span>Attractions:</span>
                <strong>{{ count($destinations) }} Places</strong>
            </div>
            <div class="stat-item">
                <span>Tour Packages:</span>
                <strong>{{ count($packages) }} Available</strong>
            </div>
        </div>
    </div>

    <!-- Section: Tour Packages -->
    <h2 class="section-heading">
        <i class="fa-solid fa-suitcase-rolling text-info"></i> Curated Tour Packages for {{ $cityName }} ({{ count($packages) }})
    </h2>

    @if($packages->isEmpty())
        <div class="no-items" style="margin-bottom: 3.5rem;">
            <i class="fa-solid fa-suitcase"></i>
            <h4 style="font-size: 1.3rem; margin-bottom: 0.5rem;">No Tour Packages Currently Listed</h4>
            <p>Direct tour packages for this city are being updated. You can explore the attractions below or check other cities.</p>
            <a href="{{ route('explore') }}" class="btn btn-primary btn-sm" style="margin-top: 1rem;">Explore Other Cities</a>
        </div>
    @else
        <div class="pkg-grid">
            @foreach($packages as $pkg)
            <div class="pkg-card">
                <div class="pkg-card-header">
                    <i class="fa-solid fa-plane-departure"></i>
                    {{ $pkg->title }}
                </div>
                
                <div class="pkg-card-body">
                    <div class="pkg-meta">
                        <span class="pkg-badge"><i class="fa-regular fa-clock me-1"></i>{{ $pkg->duration_days }} Days</span>
                        <span class="pkg-badge"><i class="fa-solid fa-users me-1"></i>Max: {{ $pkg->max_capacity }} Guests</span>
                        @if($pkg->destination)
                        <span class="pkg-badge"><i class="fa-solid fa-location-dot me-1"></i>{{ $pkg->destination->title }}</span>
                        @endif
                    </div>

                    <div class="pkg-price-box">
                        <div>
                            <span class="pkg-price">${{ number_format($pkg->price_per_person, 2) }}</span>
                            <small>/ person</small>
                        </div>
                        <span class="badge badge-green" style="background:#dcfce7; color:#15803d; border:1px solid #86efac;">Active Tour</span>
                    </div>

                    @if($pkg->included_services && count($pkg->included_services))
                    <div style="font-size:0.82rem; font-weight:700; color:var(--text-muted); margin-bottom:0.4rem;">Included In Package:</div>
                    <ul class="services-list">
                        @foreach(array_slice($pkg->included_services, 0, 4) as $service)
                            <li><i class="fa-solid fa-circle-check"></i> {{ $service }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <!-- Booking Form / Prompt -->
                    @auth
                        <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
                            @csrf
                            <input type="hidden" name="tour_package_id" value="{{ $pkg->id }}">

                            <div class="mb-2">
                                <label><i class="fa-solid fa-user me-1"></i> Full Name</label>
                                <input type="text" name="full_name" class="form-control"
                                    value="{{ old('full_name', Auth::user()->name) }}" required placeholder="Enter your full name">
                            </div>

                            <div class="row g-2 mb-2" style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem;">
                                <div>
                                    <label><i class="fa-solid fa-envelope me-1"></i> Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email) }}" required placeholder="email@example.com">
                                </div>
                                <div>
                                    <label><i class="fa-solid fa-phone me-1"></i> Phone / WhatsApp</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', Auth::user()->phone ?? '+252 90 7xxxxx') }}" required placeholder="+252 90 ...">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label><i class="fa-solid fa-location-dot text-info me-1"></i> Current City You Are In <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="current_location" class="form-control"
                                    value="{{ old('current_location', $cityName . ', Puntland') }}" required placeholder="e.g. Garowe, Bosaso, Galkacyo, Mogadishu, Hargeisa...">
                                <small style="display:block; color:var(--text-muted); font-size:0.75rem; margin-top:-0.4rem; margin-bottom:0.6rem;">Write the city or area you are currently in</small>
                            </div>

                            <div class="row g-2 mb-2" style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem;">
                                <div>
                                    <label><i class="fa-solid fa-calendar-day me-1"></i> Travel Date</label>
                                    <input type="date" name="travel_date" class="form-control"
                                        min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                                </div>
                                <div>
                                    <label><i class="fa-solid fa-user-group me-1"></i> Guests</label>
                                    <input type="number" name="number_of_guests" class="form-control"
                                        min="1" max="{{ $pkg->max_capacity }}" value="1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label><i class="fa-solid fa-comment-dots me-1"></i> Special Requests (Optional)</label>
                                <textarea name="special_requests" class="form-control" rows="2"
                                    placeholder="Special diet, pickup location, accessibility needs..."></textarea>
                            </div>
                            <button type="submit" class="btn-book-now">
                                <i class="fa-solid fa-circle-check"></i> Book This Tour Now
                            </button>
                        </form>
                    @else
                        <div class="auth-prompt">
                            <p><i class="fa-solid fa-lock me-1"></i> Please log in or register to book this tour:</p>
                            <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="btn-login-book">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Log In
                            </a>
                            <a href="{{ route('register') }}" class="btn-register-book">
                                <i class="fa-solid fa-user-plus me-1"></i> Register New Account
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Section: Associated Destinations -->
    <h2 class="section-heading">
        <i class="fa-solid fa-location-dot text-info"></i> Tourist Attractions in {{ $cityName }} ({{ count($destinations) }})
    </h2>

    @if($destinations->isEmpty())
        <div class="no-items">
            <i class="fa-solid fa-map-location-dot"></i>
            <h4 style="font-size: 1.3rem; margin-bottom: 0.5rem;">No Specific Places Listed Yet</h4>
            <p>Attraction highlights for this location will be added shortly.</p>
        </div>
    @else
        <div class="dest-grid">
            @foreach($destinations as $d)
            <a href="{{ route('destinations.show', $d->slug) }}" class="dest-card">
                <img src="{{ $d->featured_image ? asset($d->featured_image) : asset('images/cities/' . Str::slug($d->city) . '.jpg') }}" 
                     alt="{{ $d->title }}" 
                     class="dest-card-img"
                     onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                
                <div class="dest-card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.3rem;">
                        <span style="font-size: 0.78rem; font-weight: 700; color: #0284c7;">{{ $d->region }} Region</span>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #eab308;"><i class="fa-solid fa-star"></i> {{ number_format($d->rating, 1) }}</span>
                    </div>

                    <div class="dest-card-title">{{ $d->title }}</div>
                    
                    <div class="dest-card-desc">
                        {{ Str::limit($d->description, 90) }}
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 0.8rem; margin-top: auto;">
                        <span style="font-size: 0.82rem; font-weight: 700; color: #10b981;">From ${{ number_format($d->starting_price, 0) }}</span>
                        <span style="font-size: 0.82rem; font-weight: 700; color: #0284c7;">Explore <i class="fa-solid fa-chevron-right ms-1"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif

</div>
@endsection

