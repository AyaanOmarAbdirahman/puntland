@extends('layouts.admin')

@section('title', 'Manage Destinations - Admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
    <div>
        <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">Destinations Management</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Add, edit, or remove Puntland tourism landmarks & GIS coordinates</p>
    </div>
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add Destination</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Region / City</th>
                    <th>Category</th>
                    <th>GPS Coordinates</th>
                    <th>Entry Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destinations as $d)
                <tr>
                    <td>
                        <img src="{{ asset($d->featured_image) }}" style="width:50px; height:40px; border-radius:6px; object-fit:cover;">
                    </td>
                    <td style="font-weight:600; color:#fff;">{{ $d->title }}</td>
                    <td>{{ $d->city }}, <span style="color:var(--primary-blue);">{{ $d->region }}</span></td>
                    <td>{{ $d->category->name ?? 'N/A' }}</td>
                    <td style="font-size:0.8rem; color:var(--text-muted);">{{ $d->latitude }}, {{ $d->longitude }}</td>
                    <td style="font-weight:700; color:var(--accent-green);">${{ number_format($d->entry_fee, 2) }}</td>
                    <td style="display:flex; gap:0.4rem;">
                        <a href="{{ route('admin.destinations.edit', $d->id) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.destinations.delete', $d->id) }}" method="POST" onsubmit="return confirm('Delete this destination?')">
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
        {{ $destinations->links() }}
    </div>
</div>
@endsection
