@extends('layouts.admin')

@section('title', 'Manage Tour Packages - Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <div>
        <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">Tour Package Management</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Manage guided tour itineraries, pricing, and capacity</p>
    </div>
    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create Tour Package</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Rate / Person</th>
                    <th>Max Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tours as $t)
                <tr>
                    <td style="font-weight:600; color:#fff;">{{ $t->title }}</td>
                    <td>{{ $t->destination->title ?? 'N/A' }}</td>
                    <td><span class="badge badge-gold">{{ $t->duration_days }} Days</span></td>
                    <td style="font-weight:700; color:var(--primary-blue);">${{ number_format($t->price_per_person, 2) }}</td>
                    <td>{{ $t->max_capacity }} Guests</td>
                    <td>
                        <span class="status-pill status-{{ $t->status == 'active' ? 'confirmed' : 'pending' }}">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td style="display:flex; gap:0.4rem;">
                        <a href="{{ route('admin.tours.edit', $t->id) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.tours.delete', $t->id) }}" method="POST" onsubmit="return confirm('Delete this package?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">
        {{ $tours->links() }}
    </div>
</div>
@endsection
