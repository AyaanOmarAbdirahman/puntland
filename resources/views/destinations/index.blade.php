@extends('layouts.app')

@section('title', 'Cities & Tourist Destinations - Puntland Tourism')

@push('styles')
<style>
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
        margin-bottom: 2rem;
        align-items: center;
        justify-content: center;
    }
    .quick-city-tag {
        background: #ffffff;
        color: #0284c7;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #bae6fd;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .quick-city-tag:hover, .quick-city-tag.active {
        background: var(--primary-blue);
        color: #fff;
        border-color: var(--primary-blue);
    }
</style>
@endpush

@section('content')
<div class="container" style="padding: 3rem 0;">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <div class="badge badge-gold" style="margin-bottom:0.5rem;"><i class="fa-solid fa-compass"></i> Discover Puntland</div>
        <h1 style="font-size:2.8rem; margin-bottom:0.5rem;">All Cities & Tourist Destinations</h1>
        <p style="color:var(--text-muted); font-size:1.05rem;">Explore Puntland cities, geographic regions, and varied tourism attractions</p>
    </div>

    <!-- Filter Form with Autocomplete -->
    <form action="{{ route('destinations.index') }}" method="GET" class="glass-card" style="padding:1.2rem; margin-bottom:1.5rem; display:grid; grid-template-columns: 2fr 1.5fr 1.5fr 1fr; gap:1rem; position:relative;">
        <div style="position:relative;">
            <input type="text" name="search" id="destSearchInput" class="search-input" placeholder="Search city or destination (e.g. Garowe, Bosaso, Eyl)..." value="{{ request('search') }}" autocomplete="off">
            <div id="destSearchResultsDropdown" class="search-dropdown"></div>
        </div>
        
        <select name="region" class="search-input">
            <option value="">All Regions</option>
            @foreach($regions as $r)
                <option value="{{ $r }}" {{ request('region') == $r ? 'selected' : '' }}>{{ $r }} Region</option>
            @endforeach
        </select>

        <select name="category_id" class="search-input">
            <option value="">All Categories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary" style="justify-content:center;"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>

    <!-- Quick City Tags -->
    <div class="quick-city-tags">
        <span style="font-size:0.85rem; font-weight:700; color:var(--text-muted);"><i class="fa-solid fa-city"></i> Cities:</span>
        <a href="{{ route('destinations.index', ['search' => 'Garowe']) }}" class="quick-city-tag {{ request('search') == 'Garowe' ? 'active' : '' }}">Garowe</a>
        <a href="{{ route('destinations.index', ['search' => 'Bosaso']) }}" class="quick-city-tag {{ request('search') == 'Bosaso' ? 'active' : '' }}">Bosaso</a>
        <a href="{{ route('destinations.index', ['search' => 'Galkacyo']) }}" class="quick-city-tag {{ request('search') == 'Galkacyo' ? 'active' : '' }}">Galkacyo</a>
        <a href="{{ route('destinations.index', ['search' => 'Eyl']) }}" class="quick-city-tag {{ request('search') == 'Eyl' ? 'active' : '' }}">Eyl</a>
        <a href="{{ route('destinations.index', ['search' => 'Qandala']) }}" class="quick-city-tag {{ request('search') == 'Qandala' ? 'active' : '' }}">Qandala</a>
        <a href="{{ route('destinations.index', ['search' => 'Hafun']) }}" class="quick-city-tag {{ request('search') == 'Hafun' ? 'active' : '' }}">Hafun</a>
        <a href="{{ route('destinations.index', ['search' => 'Cal Madow']) }}" class="quick-city-tag {{ request('search') == 'Cal Madow' ? 'active' : '' }}">Cal Madow</a>
        <a href="{{ route('destinations.index', ['search' => 'Taleex']) }}" class="quick-city-tag {{ request('search') == 'Taleex' ? 'active' : '' }}">Taleex</a>
        <a href="{{ route('destinations.index', ['search' => 'Qardho']) }}" class="quick-city-tag {{ request('search') == 'Qardho' ? 'active' : '' }}">Qardho</a>
        <a href="{{ route('destinations.index', ['search' => 'Badhan']) }}" class="quick-city-tag {{ request('search') == 'Badhan' ? 'active' : '' }}">Badhan</a>
        <a href="{{ route('destinations.index', ['search' => 'Las Khorey']) }}" class="quick-city-tag {{ request('search') == 'Las Khorey' ? 'active' : '' }}">Las Khorey</a>
        <a href="{{ route('destinations.index', ['search' => 'Iskushuban']) }}" class="quick-city-tag {{ request('search') == 'Iskushuban' ? 'active' : '' }}">Iskushuban</a>
        @if(request('search') || request('region') || request('category_id'))
            <a href="{{ route('destinations.index') }}" class="quick-city-tag" style="background:#fee2e2; color:#ef4444; border-color:#fca5a5;"><i class="fa-solid fa-xmark"></i> Clear All</a>
        @endif
    </div>

    <!-- Destinations Grid -->
    <div class="dest-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:2rem;">
        @forelse($destinations as $d)
        <div class="glass-card dest-card" style="overflow:hidden;">
            <div class="dest-img-wrap" style="position:relative; height:240px; overflow:hidden;">
                <img src="{{ $d->featured_image ? asset($d->featured_image) : asset('images/cities/' . Str::slug($d->city) . '.jpg') }}" alt="{{ $d->title }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                <div style="position:absolute; top:12px; left:12px;">
                    <span class="badge badge-region">{{ $d->region }}</span>
                </div>
                <div style="position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.6); backdrop-filter:blur(8px); padding:0.25rem 0.6rem; border-radius:999px; font-size:0.8rem; font-weight:700; color:var(--accent-gold);">
                    ⭐ {{ number_format($d->rating, 1) }}
                </div>
            </div>

            <div style="padding:1.5rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                    <span style="font-size:0.8rem; color:var(--primary-blue); font-weight:600;"><i class="fa-solid fa-location-dot"></i> {{ $d->city }}</span>
                    <span style="font-size:0.85rem; color:var(--accent-green); font-weight:700;">From ${{ number_format($d->starting_price, 0) }}</span>
                </div>

                <h3 style="font-size:1.2rem; margin-bottom:0.5rem; color:var(--text-heading);">{{ $d->title }}</h3>
                <p style="font-size:0.88rem; color:var(--text-muted); margin-bottom:1.2rem;">{{ Str::limit($d->description, 100) }}</p>

                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border-color); padding-top:1rem;">
                    <span style="font-size:0.8rem; color:var(--text-muted);"><i class="fa-solid fa-folder"></i> {{ $d->category->name ?? 'Tour' }}</span>
                    <a href="{{ route('destinations.show', $d->slug) }}" class="btn btn-primary btn-sm">Explore <i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: span 3; text-align:center; padding:4rem; color:var(--text-muted);">
            <i class="fa-solid fa-map-location-dot" style="font-size:3rem; margin-bottom:1rem; color:var(--primary-blue);"></i>
            <h3 style="margin-bottom:0.5rem;">No cities or destinations found</h3>
            <p>Try searching for other locations like Garowe, Bosaso, Galkacyo, Eyl, Hafun, or Qandala.</p>
            <a href="{{ route('destinations.index') }}" class="btn btn-primary btn-sm" style="margin-top:1rem;">View All Destinations</a>
        </div>
        @endforelse
    </div>

    <div style="margin-top:3rem;">
        {{ $destinations->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('destSearchInput');
        const dropdown = document.getElementById('destSearchResultsDropdown');
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
                                html = `<div style="padding:1rem; text-align:center; color:#64748b; font-size:0.88rem;">No results found for "${query}".</div>`;
                            }

                            dropdown.innerHTML = html;
                            dropdown.style.display = 'block';
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

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush
