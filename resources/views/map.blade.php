@extends('layouts.app')

@section('title', 'Full GIS Navigation Map - Puntland Tourism')

@push('styles')
<style>
    .map-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        height: calc(100vh - 120px);
    }
    .map-sidebar {
        background: #091526;
        border-right: 1px solid var(--border-glass);
        padding: 1.5rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .map-item {
        padding: 1rem;
        border-radius: 12px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border-glass);
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .map-item:hover {
        border-color: var(--primary-blue);
    }
    #fullMap {
        width: 100%;
        height: 100%;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="map-layout">
    <!-- Sidebar Controls -->
    <div class="map-sidebar">
        <div>
            <h2 style="font-size:1.4rem; margin-bottom:0.4rem;"><i class="fa-solid fa-map-location-dot text-info"></i> GIS Map Guide</h2>
            <p style="font-size:0.85rem; color:var(--text-muted);">Select a destination to focus GPS location</p>
        </div>

        <input type="text" id="mapSearch" class="search-input" placeholder="Search map markers..." onkeyup="filterMapItems()">

        <div id="mapItemList" style="display:flex; flex-direction:column; gap:0.75rem;">
            @foreach($destinations as $d)
            <div class="map-item" onclick="focusDestination({{ $d->latitude }}, {{ $d->longitude }}, '{{ addslashes($d->title) }}')">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.3rem;">
                    <strong style="font-size:0.95rem; color:#fff;">{{ $d->title }}</strong>
                    <span class="badge badge-region" style="font-size:0.65rem;">{{ $d->region }}</span>
                </div>
                <div style="font-size:0.8rem; color:var(--text-muted);">
                    <i class="fa-solid fa-building"></i> {{ $d->city }} • ⭐ {{ $d->rating }}
                </div>
                <div style="font-size:0.75rem; color:var(--primary-blue); margin-top:0.4rem;">
                    GPS: {{ $d->latitude }}° N, {{ $d->longitude }}° E
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Map Canvas -->
    <div id="fullMap"></div>
</div>
@endsection

@push('scripts')
<script>
    let map;
    let markers = [];

    document.addEventListener("DOMContentLoaded", function() {
        map = L.map('fullMap').setView([9.5, 49.0], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const destinations = @json($destinations);

        destinations.forEach(d => {
            if (d.latitude && d.longitude) {
                const popup = `
                    <div style="color:#000; font-family:sans-serif; width:220px;">
                        <img src="${d.featured_image ? '/' + d.featured_image : '/images/cities/' + d.city.toLowerCase().replace(/\s+/g, '-') + '.jpg'}" style="width:100%; height:100px; object-fit:cover; border-radius:6px; margin-bottom:6px;" onerror="this.src='/images/cities/garowe.jpg'">
                        <strong style="font-size:0.95rem; color:#0a192f;">${d.title}</strong>
                        <div style="font-size:0.8rem; color:#64748b;">${d.city}, ${d.region} Region</div>
                        <div style="font-size:0.8rem; margin-top:4px; font-weight:bold; color:#10b981;">Tours from $${d.starting_price || d.entry_fee}</div>
                        <a href="/destinations/${d.slug}" style="display:inline-block; margin-top:6px; background:#00b4d8; color:#fff; text-decoration:none; padding:4px 10px; border-radius:4px; font-size:0.75rem; font-weight:bold;">View Destination</a>
                    </div>
                `;
                const m = L.marker([d.latitude, d.longitude]).addTo(map).bindPopup(popup);
                markers.push({ id: d.id, title: d.title.toLowerCase(), marker: m, lat: d.latitude, lng: d.longitude });
            }
        });
    });

    function focusDestination(lat, lng, title) {
        map.flyTo([lat, lng], 13, { duration: 1.5 });
        const found = markers.find(m => Math.abs(m.lat - lat) < 0.0001 && Math.abs(m.lng - lng) < 0.0001);
        if (found) {
            found.marker.openPopup();
        }
    }

    function filterMapItems() {
        const query = document.getElementById('mapSearch').value.toLowerCase();
        const items = document.querySelectorAll('.map-item');
        items.forEach(item => {
            const txt = item.innerText.toLowerCase();
            item.style.display = txt.includes(query) ? 'block' : 'none';
        });
    }
</script>
@endpush
