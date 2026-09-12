@extends('layouts.admin')

@section('title', 'Edit Tour Package - Admin')

@section('content')
<div style="max-width:750px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <h1 style="font-size:1.6rem;">Edit Tour Package: {{ $tour->title }}</h1>
        <a href="{{ route('admin.tours') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="card">
        <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Package Title</label>
                <input type="text" name="title" class="search-input" value="{{ $tour->title }}" required style="width:100%;">
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Destination</label>
                <select name="destination_id" class="search-input" style="width:100%;" required>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}" {{ $tour->destination_id == $d->id ? 'selected' : '' }}>{{ $d->title }} ({{ $d->city }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Duration (Days)</label>
                    <input type="number" name="duration_days" class="search-input" value="{{ $tour->duration_days }}" min="1" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Price per Person ($)</label>
                    <input type="number" step="0.01" name="price_per_person" class="search-input" value="{{ $tour->price_per_person }}" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Max Capacity</label>
                    <input type="number" name="max_capacity" class="search-input" value="{{ $tour->max_capacity }}" min="1" required style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Included Services (Comma separated)</label>
                <input type="text" name="included_services" class="search-input" value="{{ is_array($tour->included_services) ? implode(',', $tour->included_services) : $tour->included_services }}" style="width:100%;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Status</label>
                <select name="status" class="search-input" style="width:100%;">
                    <option value="active" {{ $tour->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $tour->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="padding:0.8rem 2rem;"><i class="fa-solid fa-save"></i> Update Package</button>
        </form>
    </div>
</div>
@endsection
