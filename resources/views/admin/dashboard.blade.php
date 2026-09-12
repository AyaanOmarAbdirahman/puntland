@extends('layouts.admin')

@section('title', 'Admin Analytics Dashboard - Puntland Tourism')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <div>
        <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">Tourism Analytics & Control Center</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Real-time overview of bookings, revenue, destinations, and active tourists</p>
    </div>
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Destination</a>
</div>

<!-- Key Performance Indicators (KPIs) -->
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:1.5rem; margin-bottom:2.5rem;">
    <div class="card" style="display:flex; align-items:center; gap:1rem;">
        <div style="width:50px; height:50px; background:rgba(0,180,216,0.15); color:var(--primary-blue); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <div>
            <div style="font-size:0.8rem; color:var(--text-muted);">Total Bookings</div>
            <div style="font-size:1.6rem; font-weight:800; color:#fff;">{{ $totalBookings }}</div>
        </div>
    </div>

    <div class="card" style="display:flex; align-items:center; gap:1rem;">
        <div style="width:50px; height:50px; background:rgba(16,185,129,0.15); color:var(--accent-green); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div>
            <div style="font-size:0.8rem; color:var(--text-muted);">Total Revenue</div>
            <div style="font-size:1.6rem; font-weight:800; color:var(--accent-green);">${{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>

    <div class="card" style="display:flex; align-items:center; gap:1rem;">
        <div style="width:50px; height:50px; background:rgba(0,180,216,0.15); color:var(--primary-blue); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div>
            <div style="font-size:0.8rem; color:var(--text-muted);">Pending Approvals</div>
            <div style="font-size:1.6rem; font-weight:800; color:var(--primary-blue);">{{ $pendingBookings }}</div>
        </div>
    </div>

    <div class="card" style="display:flex; align-items:center; gap:1rem;">
        <div style="width:50px; height:50px; background:rgba(16,185,129,0.15); color:var(--accent-green); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div style="font-size:0.8rem; color:var(--text-muted);">Registered Tourists</div>
            <div style="font-size:1.6rem; font-weight:800; color:#fff;">{{ $totalTourists }}</div>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:2rem;">
    <!-- Recent Booking Requests -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem;">
            <h3 style="font-size:1.2rem; color:#fff;">Recent Tour Booking Requests</h3>
            <a href="{{ route('admin.bookings') }}" style="color:var(--primary-blue); font-size:0.85rem; text-decoration:none;">View All</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Tourist</th>
                        <th>Tour Package</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $b)
                    <tr>
                        <td style="font-weight:700; color:var(--primary-blue);">{{ $b->booking_code }}</td>
                        <td>{{ $b->user->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($b->tourPackage->title ?? '', 22) }}</td>
                        <td style="font-weight:700; color:var(--accent-green);">${{ number_format($b->total_price, 0) }}</td>
                        <td>
                            <span class="status-pill status-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Destinations -->
    <div class="card">
        <h3 style="font-size:1.2rem; color:#fff; margin-bottom:1.2rem;">Top Rated Destinations</h3>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            @foreach($topDestinations as $td)
            <div style="display:flex; align-items:center; gap:0.75rem; border-bottom:1px solid var(--border-glass); padding-bottom:0.75rem;">
                <img src="{{ asset($td->featured_image) }}" style="width:48px; height:48px; border-radius:8px; object-fit:cover;">
                <div style="flex:1;">
                    <div style="font-weight:600; font-size:0.9rem; color:#fff;">{{ $td->title }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">{{ $td->city }} • ⭐ {{ $td->rating }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
