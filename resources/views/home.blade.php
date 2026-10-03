@extends('layouts.app')

@section('title', 'Puntland Tourism & GIS Navigation System')

@push('styles')
<style>
    /* Hero Banner */
    .hero {
        position: relative;
        min-height: 85vh;
        background: linear-gradient(180deg, rgba(10, 25, 47, 0.45) 0%, rgba(10, 25, 47, 0.95) 100%),
                    url('{{ asset('images/destinations/bosaso_port.jpg') }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        padding: 4rem 0;
    }

    .hero-title {
        font-size: 3.8rem;
        line-height: 1.15;
        font-weight: 800;
        margin-bottom: 1.2rem;
        background: linear-gradient(135deg, #ffffff 20%, #7dd3fc 60%, #38bdf8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .search-box-wrapper {
        position: relative;
        margin-top: 2rem;
    }

    .search-box {
        background: #ffffff;
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 1.2rem 1.5rem;
        display: grid;
        grid-template-columns: 2fr 1.3fr 1.3fr 1fr;
        gap: 1rem;
        align-items: center;
        box-shadow: 0 20px 50px rgba(0, 119, 182, 0.22);
    }

    .search-input-group {
        position: relative;
    }

    .search-input {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        padding: 0.85rem 1.2rem;
        border-radius: 12px;
        color: #0f172a;
        font-size: 0.95rem;
        outline: none;
        width: 100%;
    }

    .search-input:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.2);
    }

    /* Live Search Results Dropdown */
    .search-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        max-height: 380px;
        overflow-y: auto;
        z-index: 999;
        display: none;
        padding: 0.75rem;
    }

    .dropdown-group-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--primary-blue);
        letter-spacing: 0.05em;
        padding: 0.4rem 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 0.85rem;
        border-radius: 10px;
        color: #0f172a;
        text-decoration: none;
        transition: all 0.15s ease;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #f0f9ff;
        color: var(--primary-blue);
        transform: translateX(4px);
    }

    .quick-city-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
        align-items: center;
    }

    .quick-city-tag {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        color: #ffffff;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .quick-city-tag:hover {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-top: 2.5rem;
    }

    .stat-card {
        padding: 1.5rem;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e0f2fe;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #0284c7;
    }

    /* Category Cards */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .cat-card {
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s;
        text-decoration: none;
        color: #0f172a;
        display: block;
        background: #ffffff;
        border: 1px solid #e0f2fe;
    }
    .cat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-blue);
    }
    .cat-icon {
        width: 60px;
        height: 60px;
        background: rgba(0, 180, 216, 0.15);
        color: var(--primary-blue);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 1rem auto;
    }

    /* Destination Grid */
    .dest-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }
    .dest-card {
        overflow: hidden;
        transition: transform 0.3s;
    }
    .dest-card:hover {
        transform: translateY(-8px);
    }
    .dest-img-wrap {
        position: relative;
        height: 240px;
        overflow: hidden;
    }
    .dest-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .dest-card:hover .dest-img {
        transform: scale(1.08);
    }
    .dest-body {
        padding: 1.5rem;
    }

    /* Section Titles */
    .section-title {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }
    .section-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
    }

    /* GIS Map Container */
    #homeMap {
        height: 450px;
        border-radius: 20px;
        z-index: 10;
    }

    /* City Showcase Cards */
    .city-card {
        background: #ffffff;
        border: 1px solid #e0f2fe;
        border-radius: 14px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        color: #0f172a;
        transition: all 0.25s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }
    .city-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-blue);
        box-shadow: 0 8px 25px rgba(2, 132, 199, 0.15);
    }
    .city-icon-box {
        width: 46px;
        height: 46px;
        background: linear-gradient(135deg, #0284c7, #00b4d8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* Responsive Media Queries */
    @media (max-width: 991px) {
        .hero-title { font-size: 2.8rem; }
        .search-box { grid-template-columns: 1fr 1fr; gap: 0.8rem; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
        .dest-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 2.2rem; }
        .search-box { grid-template-columns: 1fr; }
        .search-input { margin-bottom: 0.5rem; }
        .btn-primary { width: 100%; justify-content: center; margin-top: 0.5rem; }
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        .cat-grid { grid-template-columns: 1fr; }
        .dest-grid { grid-template-columns: 1fr; }
        .section-title { font-size: 1.8rem; }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div style="max-width: 820px;">
            <div class="badge badge-gold" style="margin-bottom:1rem;">
                <i class="fa-solid fa-star"></i> Discover the Beauty & Heritage of Puntland
            </div>
            <h1 class="hero-title">Puntland Tourism & GIS Navigation System</h1>
            <p style="font-size: 1.15rem; color: #cbd5e1; max-width: 720px;">
                Explore all Puntland cities, coastal beaches, Cal Madow highlands, historical stone fortresses, with real-time GPS navigation and seamless tour bookings.
            </p>

            <!-- Search Box Wrapper with Live Search Dropdown -->
            <div class="search-box-wrapper">
                <form action="{{ route('destinations.index') }}" method="GET" class="search-box" id="heroSearchForm">
                    <div class="search-input-group" style="position:relative;">
                        <input type="text" name="search" id="citySearchInput" class="search-input" placeholder="Search city name, destination, or district..." autocomplete="off" value="{{ request('search') }}">
                        
                        <!-- Live Search Results Dropdown -->
                        <div id="searchResultsDropdown" class="search-dropdown">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                    
                    <select name="region" id="regionSelect" class="search-input">
                        <option value="">All Regions</option>
                        @foreach($regions as $r)
                            <option value="{{ $r }}">{{ $r }} Region</option>
                        @endforeach
                    </select>

                    <select name="category_id" class="search-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary" style="height: 100%; justify-content:center;">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>

                <!-- Quick Click Puntland Cities -->
                <div class="quick-city-tags">
                    <span style="color:#e0f2fe; font-size:0.82rem; font-weight:700;"><i class="fa-solid fa-bolt text-warning"></i> Cities:</span>
                    <a href="{{ route('destinations.index', ['search' => 'Garowe']) }}" class="quick-city-tag">Garowe</a>
                    <a href="{{ route('destinations.index', ['search' => 'Raas_casyr']) }}" class="quick-city-tag">Raas_casyr</a>
                    <a href="{{ route('destinations.index', ['search' => 'Ceerigaabo']) }}" class="quick-city-tag">Ceerigaabo</a>
                    <a href="{{ route('destinations.index', ['search' => 'Calmadow']) }}" class="quick-city-tag">Calmadow</a>
                    <a href="{{ route('destinations.index', ['search' => 'Laas_qoray']) }}" class="quick-city-tag">Laas_qoray</a>
                    <a href="{{ route('destinations.index', ['search' => 'Qandala']) }}" class="quick-city-tag">Qandala</a>
                    <a href="{{ route('destinations.index', ['search' => 'Boosaaso']) }}" class="quick-city-tag">Boosaaso</a>
                    <a href="{{ route('destinations.index', ['search' => 'Eyl']) }}" class="quick-city-tag">Eyl</a>
                    <a href="{{ route('destinations.index', ['search' => 'Gaalkacyo']) }}" class="quick-city-tag">Gaalkacyo</a>
                    <a href="{{ route('destinations.index', ['search' => 'Qardho']) }}" class="quick-city-tag">Qardho</a>
                    <a href="{{ route('destinations.index', ['search' => 'Taleex']) }}" class="quick-city-tag">Taleex</a>
                    <a href="{{ route('destinations.index', ['search' => 'Badhan']) }}" class="quick-city-tag">Badhan</a>
                    <a href="{{ route('destinations.index', ['search' => 'Galdogob']) }}" class="quick-city-tag">Galdogob</a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="glass-card stat-card">
                    <div class="stat-number">9+</div>
                    <div style="color:var(--text-muted); font-size:0.85rem;">Puntland Regions</div>
                </div>
                <div class="glass-card stat-card">
                    <div class="stat-number">30+</div>
                    <div style="color:var(--text-muted); font-size:0.85rem;">Cities & Destinations</div>
                </div>
                <div class="glass-card stat-card">
                    <div class="stat-number">100%</div>
                    <div style="color:var(--text-muted); font-size:0.85rem;">Certified Guides</div>
                </div>
                <div class="glass-card stat-card">
                    <div class="stat-number">4.9 ★</div>
                    <div style="color:var(--text-muted); font-size:0.85rem;">Tourist Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Puntland All Cities & Hubs Showcase Section -->
<section style="padding: 4.5rem 0; background: var(--section-alt-bg);">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom: 2rem;">
            <div>
                <div class="badge badge-region" style="margin-bottom:0.5rem;"><i class="fa-solid fa-city"></i> Puntland Cities</div>
                <h2 class="section-title">All Puntland Cities & Regional Centers</h2>
                <p class="section-subtitle">Click any city to view all attractions, GPS navigation, and available tour packages</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="btn btn-outline">View All Destinations <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:1.2rem;">
            <!-- Render dynamically instead of hardcoding -->
            @foreach(\App\Models\Destination::all() as $d)
            <a href="{{ route('explore.city', Str::slug($d->city)) }}" class="city-card">
                <div class="city-icon-box"><i class="fa-solid fa-map-location-dot"></i></div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:1.05rem; color:var(--text-heading);">{{ $d->city }}</strong>
                        <span style="font-size:0.75rem; font-weight:700; color:var(--accent-green);">From ${{ number_format($d->entry_fee, 0) }}</span>
                    </div>
                    <span style="font-size:0.8rem; color:var(--text-muted);">{{ $d->region }} Region</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 class="section-title">Explore by Tourism Category</h2>
            <p class="section-subtitle">Choose your preferred experience across Puntland State</p>
        </div>

        <div class="cat-grid">
            @foreach($categories as $cat)
            <a href="{{ route('destinations.index', ['category_id' => $cat->id]) }}" class="glass-card cat-card">
                <div class="cat-icon">
                    <i class="fa-solid {{ $cat->icon ?? 'fa-compass' }}"></i>
                </div>
                <h3 style="font-size:1.15rem; margin-bottom:0.4rem; color:var(--text-heading);">{{ $cat->name }}</h3>
                <p style="font-size:0.82rem; color:var(--text-muted);">{{ Str::limit($cat->description, 70) }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Destinations Section -->
<section style="padding: 3rem 0 5rem 0; background: var(--section-alt-bg);">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem;">
            <div>
                <div class="badge badge-region" style="margin-bottom:0.5rem;">Top Attractions</div>
                <h2 class="section-title">Featured Destinations</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="btn btn-outline">View All Destinations <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="dest-grid">
            @foreach($destinations as $d)
            <div class="glass-card dest-card">
                <div class="dest-img-wrap">
                    <img src="{{ $d->featured_image ? asset($d->featured_image) : asset('images/cities/' . Str::slug($d->city) . '.jpg') }}" alt="{{ $d->title }}" class="dest-img" onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                    <div style="position:absolute; top:12px; left:12px;">
                        <span class="badge badge-region">{{ $d->region }} Region</span>
                    </div>
                    <div style="position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.6); backdrop-filter:blur(8px); padding:0.25rem 0.6rem; border-radius:999px; font-size:0.8rem; font-weight:700; color:#fbbf24;">
                        <i class="fa-solid fa-star"></i> {{ number_format($d->rating, 1) }}
                    </div>
                </div>

                <div class="dest-body">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                        <span style="font-size:0.8rem; color:var(--primary-blue); font-weight:600;"><i class="fa-solid fa-building"></i> {{ $d->city }}</span>
                        <span style="font-size:0.85rem; color:var(--accent-green); font-weight:700;">From: ${{ number_format($d->starting_price, 0) }}</span>
                    </div>

                    <h3 style="font-size:1.25rem; margin-bottom:0.5rem; color:var(--text-heading);">{{ $d->title }}</h3>
                    <p style="font-size:0.88rem; color:var(--text-muted); margin-bottom:1.2rem;">
                        {{ Str::limit($d->description, 90) }}
                    </p>

                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:1rem;">
                        <span style="font-size:0.8rem; color:var(--text-muted);"><i class="fa-solid fa-sun text-success"></i> Best: {{ $d->best_season ?? 'All Year' }}</span>
                        <a href="{{ route('destinations.show', $d->slug) }}" class="btn btn-primary btn-sm">Explore <i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- GIS Navigation Map Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem;">
            <div>
                <div class="badge badge-gold" style="margin-bottom:0.5rem;"><i class="fa-solid fa-location-crosshairs"></i> Interactive GIS Map</div>
                <h2 class="section-title">Puntland Interactive Navigation Guide</h2>
                <p class="section-subtitle">Click on any landmark pin to view coordinates, ratings, and travel routes</p>
            </div>
            <a href="{{ route('map') }}" class="btn btn-gold">Full Screen GIS Map <i class="fa-solid fa-expand"></i></a>
        </div>

        <div class="glass-card" style="padding:1rem;">
            <div id="homeMap"></div>
        </div>
    </div>
</section>

<!-- Featured Tour Packages -->
<section style="padding: 5rem 0; background: var(--section-alt-bg);">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 class="section-title">Curated Tour Packages</h2>
            <p class="section-subtitle">All-inclusive guided expeditions with transport, lodging, and local guides</p>
        </div>

        <div class="dest-grid">
            @foreach($featuredTours as $t)
            <div class="glass-card dest-card">
                <div class="dest-img-wrap" style="height:200px;">
                    <img src="{{ $t->destination->featured_image ? asset($t->destination->featured_image) : asset('images/cities/' . Str::slug($t->destination->city) . '.jpg') }}" class="dest-img" onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                    <div style="position:absolute; bottom:12px; right:12px; background:linear-gradient(135deg, #00b4d8, #0077b6); padding:0.4rem 0.9rem; border-radius:10px; font-weight:800; font-size:1.1rem; color:#fff;">
                        ${{ number_format($t->price_per_person, 0) }} <span style="font-size:0.75rem; font-weight:400;">/ person</span>
                    </div>
                </div>

                <div class="dest-body">
                    <div style="display:flex; gap:0.5rem; margin-bottom:0.5rem;">
                        <span class="badge badge-gold"><i class="fa-solid fa-clock"></i> {{ $t->duration_days }} Days</span>
                        <span class="badge badge-region"><i class="fa-solid fa-user-group"></i> Max {{ $t->max_capacity }} Tourists</span>
                    </div>

                    <h3 style="font-size:1.2rem; margin-bottom:0.6rem; color:var(--text-heading);">{{ $t->title }}</h3>

                    <ul style="list-style:none; margin-bottom:1.2rem; font-size:0.85rem; color:var(--text-muted); display:flex; flex-direction:column; gap:0.3rem;">
                        @foreach(array_slice($t->included_services ?? [], 0, 3) as $srv)
                            <li><i class="fa-solid fa-circle-check text-success"></i> {{ $srv }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ route('tours.show', $t->slug) }}" class="btn btn-gold" style="width:100%; justify-content:center;">Book Package <i class="fa-solid fa-calendar-check"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Interactive GIS Map Initializer
        if (document.getElementById('homeMap')) {
            const map = L.map('homeMap').setView([9.5, 49.0], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const destinations = @json($destinations);

            destinations.forEach(d => {
                if (d.latitude && d.longitude) {
                    const popupContent = `
                        <div style="color:#000; font-family:sans-serif; width:200px;">
                            <strong style="font-size:1rem; color:#0a192f;">${d.title}</strong>
                            <div style="font-size:0.8rem; color:#64748b; margin-top:2px;">${d.city}, ${d.region} Region</div>
                            <div style="font-size:0.8rem; margin-top:4px; color:#10b981; font-weight:700;">Rating: ⭐ ${d.rating} | Tours from $${d.starting_price || d.entry_fee}</div>
                            <a href="/destinations/${d.slug}" style="display:inline-block; margin-top:8px; background:#00b4d8; color:#fff; text-decoration:none; padding:4px 8px; border-radius:4px; font-size:0.75rem; font-weight:bold;">View Details</a>
                        </div>
                    `;
                    L.marker([d.latitude, d.longitude]).addTo(map).bindPopup(popupContent);
                }
            });
        }

        // 2. Dynamic City Live Search Box & Dropdown
        const searchInput = document.getElementById('citySearchInput');
        const dropdown = document.getElementById('searchResultsDropdown');
        let debounceTimer;

        if (searchInput && dropdown) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(debounceTimer);

                if (query.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`/api/cities/search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            let html = '';
                            
                            // 1. Puntland Cities
                            if (data.cities && data.cities.length > 0) {
                                html += `<div class="dropdown-group-title"><i class="fa-solid fa-city"></i> Puntland Cities (${data.cities.length})</div>`;
                                data.cities.forEach(c => {
                                    html += `
                                        <a href="/destinations?search=${encodeURIComponent(c.city)}" class="dropdown-item">
                                            <div>
                                                <strong style="color:#0284c7;"><i class="fa-solid fa-location-dot"></i> ${c.city}</strong>
                                                <div style="font-size:0.75rem; color:#64748b;">${c.desc}</div>
                                            </div>
                                            <span style="font-size:0.72rem; background:#e0f2fe; color:#0369a1; padding:0.2rem 0.5rem; border-radius:6px; font-weight:700;">${c.region}</span>
                                        </a>
                                    `;
                                });
                            }

                            // 2. Destinations
                            if (data.destinations && data.destinations.length > 0) {
                                html += `<div class="dropdown-group-title" style="margin-top:0.6rem;"><i class="fa-solid fa-compass"></i> Tourist Destinations (${data.destinations.length})</div>`;
                                data.destinations.forEach(d => {
                                    html += `
                                        <a href="/destinations/${d.slug}" class="dropdown-item">
                                            <div>
                                                <strong style="color:#0f172a;"><i class="fa-solid fa-mountain"></i> ${d.title}</strong>
                                                <div style="font-size:0.75rem; color:#64748b;">${d.city} (${d.region})</div>
                                            </div>
                                            <span style="font-size:0.72rem; color:#eab308; font-weight:700;">⭐ ${d.rating}</span>
                                        </a>
                                    `;
                                });
                            }

                            if (!html) {
                                html = `<div style="padding:1rem; text-align:center; color:#64748b; font-size:0.88rem;">No cities or destinations found for "${query}".</div>`;
                            }

                            dropdown.innerHTML = html;
                            dropdown.style.display = 'block';
                        })
                        .catch(err => {
                            console.error('Search error:', err);
                        });
                }, 200);
            });

            // Focus shows all Puntland cities immediately
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length === 0) {
                    fetch('/api/cities/search')
                        .then(res => res.json())
                        .then(data => {
                            let html = `<div class="dropdown-group-title"><i class="fa-solid fa-city"></i> All Puntland Cities</div>`;
                            data.cities.slice(0, 10).forEach(c => {
                                html += `
                                    <a href="/destinations?search=${encodeURIComponent(c.city)}" class="dropdown-item">
                                        <div>
                                            <strong style="color:#0284c7;"><i class="fa-solid fa-location-dot"></i> ${c.city}</strong>
                                            <div style="font-size:0.75rem; color:#64748b;">${c.desc}</div>
                                        </div>
                                        <span style="font-size:0.72rem; background:#e0f2fe; color:#0369a1; padding:0.2rem 0.5rem; border-radius:6px; font-weight:700;">${c.region}</span>
                                    </a>
                                `;
                            });
                            dropdown.innerHTML = html;
                            dropdown.style.display = 'block';
                        });
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush


