@extends('layouts.app')

@section('title', 'My Itinerary & Portal - Puntland Tourism')

@section('content')
<div class="container" style="padding: 3rem 0;">
    <!-- Welcome Header -->
    <div class="glass-card" style="padding:2rem; margin-bottom:2.5rem; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; align-items:center; gap:1.2rem;">
            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" style="width:64px; height:64px; border-radius:50%; border:2px solid var(--primary-blue);">
            <div>
                <h1 style="font-size:1.8rem; margin-bottom:0.2rem;">Welcome, {{ Auth::user()->name }}!</h1>
                <p style="color:var(--text-muted); font-size:0.95rem;">Manage your tour expeditions, saved attractions, and reservation status</p>
            </div>
        </div>
        <a href="{{ route('tours.index') }}" class="btn btn-gold"><i class="fa-solid fa-compass"></i> Discover New Tours</a>
    </div>

    <!-- Active Tour Bookings -->
    <div class="glass-card" style="padding:2rem; margin-bottom:2.5rem;">
        <h3 style="font-size:1.3rem; margin-bottom:1.5rem;"><i class="fa-solid fa-receipt text-info"></i> My Tour Bookings</h3>

        <div class="table-responsive">
            <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border-color); color:var(--text-muted); text-align:left;">
                        <th style="padding:0.75rem;">Booking Code</th>
                        <th style="padding:0.75rem;">Tour Package</th>
                        <th style="padding:0.75rem;">Traveler & City</th>
                        <th style="padding:0.75rem;">Travel Date</th>
                        <th style="padding:0.75rem;">Guests</th>
                        <th style="padding:0.75rem;">Total</th>
                        <th style="padding:0.75rem;">Status</th>
                        <th style="padding:0.75rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:0.9rem; font-weight:700; color:var(--primary-blue);">{{ $b->booking_code }}</td>
                        <td style="padding:0.9rem; font-weight:600; color:var(--text-heading);">
                            {{ $b->tourPackage->title ?? 'N/A' }}
                            <div style="font-size:0.75rem; color:var(--text-muted);">{{ $b->tourPackage->destination->city ?? '' }}</div>
                        </td>
                        <td style="padding:0.9rem; font-size:0.82rem;">
                            <div style="font-weight:600; color:var(--text-heading);">{{ $b->full_name ?? Auth::user()->name }}</div>
                            <div style="color:var(--primary-blue);"><i class="fa-solid fa-location-dot"></i> {{ $b->current_location ?? 'Puntland' }}</div>
                            <div style="color:var(--text-muted);"><i class="fa-solid fa-phone"></i> {{ $b->phone ?? Auth::user()->phone ?? 'N/A' }}</div>
                        </td>
                        <td style="padding:0.9rem; color:var(--text-main);">{{ $b->travel_date ? $b->travel_date->format('M d, Y') : 'N/A' }}</td>
                        <td style="padding:0.9rem; color:var(--text-main);">{{ $b->number_of_guests }} Guest{{ $b->number_of_guests > 1 ? 's' : '' }}</td>
                        <td style="padding:0.9rem; font-weight:700; color:var(--accent-green);">${{ number_format($b->total_price, 2) }}</td>
                        <td style="padding:0.9rem;">
                            @if($b->status === 'confirmed')
                                <span class="badge" style="background:rgba(16,185,129,0.2); color:#10b981;">Confirmed</span>
                            @elseif($b->status === 'pending')
                                <span class="badge" style="background:rgba(245,158,11,0.2); color:#f59e0b;">Pending Review</span>
                            @elseif($b->status === 'rejected')
                                <span class="badge" style="background:rgba(239,68,68,0.2); color:#ef4444;">Rejected</span>
                            @elseif($b->status === 'completed')
                                <span class="badge" style="background:rgba(56,189,248,0.2); color:#0284c7;">Completed</span>
                            @else
                                <span class="badge" style="background:rgba(148,163,184,0.2); color:#64748b;">{{ ucfirst($b->status) }}</span>
                            @endif
                        </td>
                        <td style="padding:0.9rem;">
                            @if($b->status !== 'cancelled' && $b->status !== 'rejected')
                            <form action="{{ route('bookings.cancel', $b->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.15); color:#ef4444;">Cancel</button>
                            </form>
                            @else
                            <span style="font-size:0.8rem; color:var(--text-muted);">-</span>
                            @endif
                        </td>
                    </tr>

                    @if($b->status === 'rejected' && $b->rejection_reason)
                    <tr style="background:rgba(239,68,68,0.06); border-bottom:1px solid rgba(239,68,68,0.2);">
                        <td colspan="8" style="padding:0.75rem 1rem; color:#dc2626; font-size:0.85rem;">
                            <i class="fa-solid fa-circle-xmark"></i> <strong>Rejection Note:</strong> {{ $b->rejection_reason }}
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            You have no active tour bookings. <a href="{{ route('tours.index') }}" style="color:var(--primary-blue);">Explore packages here</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Saved Places -->
    <div class="glass-card" style="padding:2rem;">
        <h3 style="font-size:1.3rem; margin-bottom:1.5rem; color:var(--text-heading);"><i class="fa-solid fa-bookmark text-success"></i> Saved Destinations (My Itinerary)</h3>

        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1.5rem;">
            @forelse($savedPlaces as $sp)
            @if($sp->destination)
            <div style="background:var(--bg-card-subtle); border:1px solid var(--border-color); border-radius:12px; overflow:hidden;">
                <img src="{{ $sp->destination->featured_image ? asset($sp->destination->featured_image) : asset('images/cities/' . Str::slug($sp->destination->city) . '.jpg') }}" style="width:100%; height:140px; object-fit:cover;" onerror="this.src='{{ asset('images/cities/garowe.jpg') }}'">
                <div style="padding:1rem;">
                    <strong style="font-size:1rem; color:var(--text-heading); display:block; margin-bottom:0.2rem;">{{ $sp->destination->title }}</strong>
                    <span style="font-size:0.8rem; color:var(--text-muted);"><i class="fa-solid fa-location-dot"></i> {{ $sp->destination->city }}</span>
                    <a href="{{ route('destinations.show', $sp->destination->slug) }}" class="btn btn-primary btn-sm" style="width:100%; justify-content:center; margin-top:0.75rem;">Explore</a>
                </div>
            </div>
            @endif
            @empty
            <div style="grid-column:span 3; text-align:center; padding:2rem; color:var(--text-muted);">
                You haven't saved any destinations yet. Click "Save to My Itinerary" on any attraction!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
