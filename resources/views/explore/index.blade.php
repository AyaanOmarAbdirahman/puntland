@extends('layouts.app')

@section('title', 'Explore Puntland — Cities, Regions & Tour Expeditions')

@push('styles')
<style>
/* ===================== EXPLORE HERO ===================== */
.explore-hero {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 60%, #0c4a6e 100%);
    color: #ffffff;
    padding: 4.5rem 1.5rem 3.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.explore-hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 30px;
    background: linear-gradient(to top, rgba(0,0,0,0.08), transparent);
}
.explore-hero h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    color: #ffffff !important;
}
.explore-hero p {
    font-size: 1.15rem;
    color: #e0f2fe !important;
    max-width: 680px;
    margin: 0 auto 1.5rem;
    line-height: 1.6;
}

/* Search and Filter Bar */
.explore-controls-wrapper {
    max-width: 900px;
    margin: -1.8rem auto 2.5rem;
    padding: 0 1.5rem;
    position: relative;
    z-index: 10;
}
.explore-controls {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.2rem 1.5rem;
    box-shadow: 0 12px 35px rgba(2, 132, 199, 0.12);
    display: flex;
    flex-direction: column;
    gap: 1rem;
    transition: all 0.25s ease;
}
.explore-search-input {
    width: 100%;
    padding: 0.85rem 1.2rem;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    font-size: 1rem;
    outline: none;
    color: #0f172a;
    background: #f8fafc;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.explore-search-input:focus {
    border-color: #0284c7;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
}
.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    align-items: center;
}
.filter-pill {
    padding: 0.45rem 1rem;
    border-radius: 999px;
    font-size: 0.88rem;
    font-weight: 600;
    border: 1px solid #bae6fd;
    background: #f0f9ff;
    color: #0369a1;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}
.filter-pill:hover, .filter-pill.active {
    background: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
}

/* ===================== CITIES GRID ===================== */
.cities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    padding: 0 1.5rem 5rem;
    max-width: 1280px;
    margin: 0 auto;
}

.city-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.28s;
    text-decoration: none;
    color: #0f172a;
    display: flex;
    flex-direction: column;
}
.city-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(2, 132, 199, 0.18);
    border-color: #7dd3fc;
    text-decoration: none;
}

.city-card-header {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: linear-gradient(135deg, #bae6fd, #0284c7);
}
.city-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.city-card:hover .city-card-img {
    transform: scale(1.06);
}
.city-card-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    right: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.region-badge {
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    color: #ffffff;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid rgba(255, 255, 255, 0.2);
}
.pkg-count-badge {
    background: #10b981;
    color: #ffffff;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
}

.city-card-body {
    padding: 1.4rem 1.5rem 1.6rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.city-card-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0c4a6e;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.city-tag {
    font-size: 0.75rem;
    font-weight: 600;
    color: #0284c7;
    background: #e0f2fe;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
}
.city-card-desc {
    font-size: 0.92rem;
    color: #475569;
    flex: 1;
    line-height: 1.65;
    margin: 0.6rem 0 1.2rem;
}
.city-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f1f5f9;
    padding-top: 1rem;
}
.city-stats {
    font-size: 0.82rem;
    color: #64748b;
    display: flex;
    gap: 0.8rem;
}
.city-card-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: linear-gradient(135deg, #0284c7 0%, #00b4d8 100%);
    color: #ffffff !important;
    padding: 0.55rem 1.2rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    transition: all 0.2s ease;
}
.city-card-btn:hover {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    box-shadow: 0 6px 16px rgba(2, 132, 199, 0.38);
    transform: translateX(2px);
    text-decoration: none;
}

/* ===================== DARK MODE OVERRIDES ===================== */
body.dark-mode .explore-controls {
    background: #112240 !important;
    border-color: #1e293b !important;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35) !important;
}
body.dark-mode .explore-search-input {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}
body.dark-mode .explore-search-input:focus {
    border-color: #38bdf8 !important;
    box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25) !important;
}
body.dark-mode .filter-pill {
    background: #0f172a !important;
    border-color: #1e293b !important;
    color: #94a3b8 !important;
}
body.dark-mode .filter-pill:hover, 
body.dark-mode .filter-pill.active {
    background: #0284c7 !important;
    color: #ffffff !important;
    border-color: #38bdf8 !important;
}
body.dark-mode .city-card {
    background: #112240 !important;
    border-color: #1e293b !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
    color: #f8fafc !important;
}
body.dark-mode .city-card:hover {
    border-color: #38bdf8 !important;
    box-shadow: 0 16px 40px rgba(2, 132, 199, 0.25) !important;
}
body.dark-mode .city-card-title {
    color: #f8fafc !important;
}
body.dark-mode .city-tag {
    background: #0c4a6e !important;
    color: #7dd3fc !important;
}
body.dark-mode .city-card-desc {
    color: #cbd5e1 !important;
}
body.dark-mode .city-card-footer {
    border-top-color: #1e293b !important;
}
body.dark-mode .city-stats {
    color: #94a3b8 !important;
}

/* Empty State */
.no-results {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 1.5rem;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}
body.dark-mode .no-results {
    background: #112240 !important;
    border-color: #1e293b !important;
    color: #cbd5e1 !important;
}
</style>
@endpush

@section('content')
<!-- Hero Header -->
<div class="explore-hero">
    <div class="badge badge-gold" style="margin-bottom: 0.8rem; background: rgba(255,255,255,0.18); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">
        <i class="fa-solid fa-compass"></i> Discover All Puntland Regions
    </div>
    <h1><i class="fa-solid fa-map-location-dot me-2"></i> Explore Cities & Tour Expeditions</h1>
    <p>Select any city or region to discover top attractions, GPS navigation, and curated tour packages ready to book.</p>
</div>

<!-- Search & Category Filters -->
<div class="explore-controls-wrapper">
    <div class="explore-controls">
        <input type="text" id="exploreSearch" class="explore-search-input" placeholder="🔍 Search city name, region, or tour type (e.g. Garowe, Cal Madow, Eyl)..." autocomplete="off">
        
        <div class="filter-pills">
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-right: 0.2rem;">
                <i class="fa-solid fa-filter"></i> Categories:
            </span>
            <button type="button" class="filter-pill active" data-category="all">
                <i class="fa-solid fa-border-all"></i> All Cities ({{ count($cities) }})
            </button>
            <button type="button" class="filter-pill" data-category="coastal">
                <i class="fa-solid fa-umbrella-beach"></i> Coastal & Seaports
            </button>
            <button type="button" class="filter-pill" data-category="mountain">
                <i class="fa-solid fa-mountain-sun"></i> Mountains & Highlands
            </button>
            <button type="button" class="filter-pill" data-category="historic">
                <i class="fa-solid fa-fort-awesome"></i> Historic Forts & Castles
            </button>
            <button type="button" class="filter-pill" data-category="urban">
                <i class="fa-solid fa-city"></i> Urban & Trade Centers
            </button>
        </div>
    </div>
</div>

<!-- Cities Grid -->
<div class="cities-grid" id="citiesGrid">
    @foreach($cities as $slug => $city)
    <a href="{{ route('explore.city', $slug) }}" 
       class="city-card" 
       data-name="{{ strtolower($city['name']) }}" 
       data-region="{{ strtolower($city['region']) }}" 
       data-category="{{ $city['category'] ?? 'all' }}"
       data-desc="{{ strtolower($city['desc']) }}">
        
        <div class="city-card-header">
            <img src="{{ asset($city['image']) }}" 
                 alt="{{ $city['name'] }}" 
                 class="city-card-img" 
                 onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
            
            <div class="city-card-badges">
                <span class="region-badge">
                    <i class="fa-solid fa-location-dot me-1"></i> {{ $city['region'] }}
                </span>
                <span style="background:linear-gradient(135deg, #10b981, #059669); color:#fff; padding:0.25rem 0.65rem; border-radius:8px; font-weight:800; font-size:0.82rem; box-shadow:0 2px 8px rgba(16,185,129,0.35);">
                    <i class="fa-solid fa-tag me-1"></i> From ${{ number_format($city['starting_price'] ?? 55, 0) }}
                </span>
            </div>
        </div>

        <div class="city-card-body">
            <div class="city-card-title">
                <span><i class="fa-solid {{ $city['icon'] ?? 'fa-map-pin' }} me-2 text-info"></i> {{ $city['name'] }}</span>
                <span class="city-tag">{{ $city['tag'] ?? $city['region'] }}</span>
            </div>
            
            <div class="city-card-desc">
                {{ $city['desc'] }}
            </div>

            <div class="city-card-footer">
                <div class="city-stats">
                    <span><i class="fa-solid fa-mountain me-1"></i> {{ $city['dest_count'] ?? 0 }} Places</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-ticket me-1"></i> {{ $city['pkg_count'] ?? 0 }} Packages</span>
                </div>
                
                <span class="city-card-btn">
                    Explore <i class="fa-solid fa-arrow-right"></i>
                </span>
            </div>
        </div>
    </a>
    @endforeach

    <div id="noResultsMessage" class="no-results" style="display: none;">
        <i class="fa-solid fa-map-location-dot" style="font-size: 3rem; color: #0284c7; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.4rem; margin-bottom: 0.5rem;">No cities found matching your search</h3>
        <p style="color: var(--text-muted);">Please check the spelling or select another category filter.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('exploreSearch');
    const filterPills = document.querySelectorAll('.filter-pill');
    const cards = document.querySelectorAll('.city-card');
    const noResults = document.getElementById('noResultsMessage');

    let currentCategory = 'all';
    let searchQuery = '';

    function filterCards() {
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const region = card.getAttribute('data-region') || '';
            const category = card.getAttribute('data-category') || '';
            const desc = card.getAttribute('data-desc') || '';

            const matchesCategory = (currentCategory === 'all' || category === currentCategory);
            const matchesSearch = !searchQuery || 
                                  name.includes(searchQuery) || 
                                  region.includes(searchQuery) || 
                                  desc.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            filterCards();
        });
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.getAttribute('data-category');
            filterCards();
        });
    });
});
</script>
@endpush
