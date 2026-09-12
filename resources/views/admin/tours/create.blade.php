@extends('layouts.admin')

@section('title', 'Create Tour Package - Admin')

@section('content')
<div style="max-width:750px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <h1 style="font-size:1.6rem;">Create Tour Package</h1>
        <a href="{{ route('admin.tours') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="card">
        <form action="{{ route('admin.tours.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Package Title</label>
                <input type="text" name="title" class="search-input" placeholder="e.g. Bosaso Coastal Paradise Expedition" required style="width:100%;">
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Destination</label>
                <select name="destination_id" class="search-input" style="width:100%;" required>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}">{{ $d->title }} ({{ $d->city }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Duration (Days)</label>
                    <input type="number" name="duration_days" class="search-input" value="3" min="1" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Price per Person ($)</label>
                    <input type="number" step="0.01" name="price_per_person" class="search-input" value="350.00" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Max Capacity</label>
                    <input type="number" name="max_capacity" class="search-input" value="15" min="1" required style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Included Services (Comma separated)</label>
                <input type="text" name="included_services" class="search-input" value="Resort Stay, Dhow Boat Tour, Meals & Transfers" style="width:100%;">
            </div>

            <button type="submit" class="btn btn-primary" style="padding:0.8rem 2rem;"><i class="fa-solid fa-save"></i> Save Tour Package</button>
        </form>
    </div>
</div>
@endsection
