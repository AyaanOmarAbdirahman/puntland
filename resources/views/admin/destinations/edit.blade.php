@extends('layouts.admin')

@section('title', 'Edit Destination - Admin')

@section('content')
<div style="max-width:800px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <h1 style="font-size:1.6rem;">Edit Destination: {{ $destination->title }}</h1>
        <a href="{{ route('admin.destinations') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="card">
        <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Destination Title</label>
                <input type="text" name="title" class="search-input" value="{{ $destination->title }}" required style="width:100%;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Category</label>
                    <select name="category_id" class="search-input" style="width:100%;" required>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $destination->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Region</label>
                    <select name="region" class="search-input" style="width:100%;" required>
                        @foreach($regions as $r)
                            <option value="{{ $r }}" {{ $destination->region == $r ? 'selected' : '' }}>{{ $r }} Region</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">City / Location</label>
                    <input type="text" name="city" class="search-input" value="{{ $destination->city }}" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Entry Fee ($)</label>
                    <input type="number" step="0.01" name="entry_fee" class="search-input" value="{{ $destination->entry_fee }}" required style="width:100%;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Latitude (GPS)</label>
                    <input type="number" step="0.0000001" name="latitude" class="search-input" value="{{ $destination->latitude }}" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Longitude (GPS)</label>
                    <input type="number" step="0.0000001" name="longitude" class="search-input" value="{{ $destination->longitude }}" required style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Featured Image</label>
                <input type="file" name="image" class="search-input" style="width:100%;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-size:0.85rem; margin-bottom:0.4rem; color:var(--text-muted);">Detailed Description</label>
                <textarea name="description" rows="5" class="search-input" style="width:100%;" required>{{ $destination->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="padding:0.8rem 2rem;"><i class="fa-solid fa-save"></i> Update Destination</button>
        </form>
    </div>
</div>
@endsection
