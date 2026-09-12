@extends('layouts.app')

@section('title', 'Tour Packages - Puntland Tourism')

@section('content')
<div class="container" style="padding: 3rem 0;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <div class="badge badge-gold" style="margin-bottom:0.5rem;"><i class="fa-solid fa-suitcase"></i> Expedition Packages</div>
        <h1 style="font-size:2.8rem; margin-bottom:0.5rem;">Curated Tour Packages</h1>
        <p style="color:var(--text-muted); font-size:1.05rem;">All-inclusive guided expeditions to Puntland's top natural & historical wonders</p>
    </div>

    <div class="dest-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:2rem;">
        @foreach($tours as $t)
        <div class="glass-card dest-card" style="overflow:hidden;">
            <div class="dest-img-wrap" style="position:relative; height:220px; overflow:hidden;">
                <img src="{{ $t->destination->featured_image ? asset($t->destination->featured_image) : asset('images/cities/' . Str::slug($t->destination->city) . '.jpg') }}" alt="{{ $t->title }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                <div style="position:absolute; bottom:12px; right:12px; background:linear-gradient(135deg, #00b4d8, #0077b6); padding:0.4rem 0.9rem; border-radius:10px; font-weight:800; font-size:1.1rem; color:#fff;">
                    ${{ number_format($t->price_per_person, 0) }} <span style="font-size:0.75rem; font-weight:400;">/ guest</span>
                </div>
            </div>

            <div style="padding:1.5rem;">
                <div style="display:flex; gap:0.5rem; margin-bottom:0.5rem;">
                    <span class="badge badge-gold"><i class="fa-solid fa-clock"></i> {{ $t->duration_days }} Days</span>
                    <span class="badge badge-region"><i class="fa-solid fa-user-group"></i> Max {{ $t->max_capacity }} Seats</span>
                </div>

                <h3 style="font-size:1.2rem; margin-bottom:0.6rem; color:var(--text-heading);">{{ $t->title }}</h3>
                <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1rem;">
                    <i class="fa-solid fa-location-dot text-info"></i> {{ $t->destination->title ?? 'Puntland Destination' }}
                </p>

                <ul style="list-style:none; margin-bottom:1.5rem; font-size:0.85rem; color:var(--text-muted); display:flex; flex-direction:column; gap:0.3rem;">
                    @foreach(array_slice($t->included_services ?? [], 0, 3) as $srv)
                        <li><i class="fa-solid fa-circle-check text-success"></i> {{ $srv }}</li>
                    @endforeach
                </ul>

                <a href="{{ route('tours.show', $t->slug) }}" class="btn btn-gold" style="width:100%; justify-content:center;">View Details & Book <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top:3rem;">
        {{ $tours->links() }}
    </div>
</div>
@endsection
