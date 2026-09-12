@extends('layouts.app')

@section('title', 'Log In - Puntland Tourism')

@section('content')
<div class="container" style="padding: 4rem 1rem; display:flex; justify-content:center; align-items:center;">
    <!-- Solid Pure White Professional Card -->
    <div style="width:100%; max-width:440px; background:#ffffff; border-radius:20px; box-shadow: 0 20px 50px rgba(0, 119, 182, 0.25); padding:2.5rem; border:1px solid #e0f2fe;">
        
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="margin:0 auto 1rem auto; width:56px; height:56px; background:#e0f2fe; color:#0284c7; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.6rem;">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <h2 style="font-size:1.75rem; color:#0f172a; font-weight:800; margin-bottom:0.4rem; font-family:'Outfit';">Welcome Back</h2>
            <p style="color:#64748b; font-size:0.9rem;">Sign in to access your itinerary and bookings</p>
        </div>

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626; padding:0.85rem 1rem; border-radius:12px; font-size:0.88rem; margin-bottom:1.5rem; font-weight:500;">
                <i class="fa-solid fa-circle-exclamation" style="margin-right:0.4rem;"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div style="margin-bottom:1.25rem;">
                <label style="display:block; font-size:0.85rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus style="width:100%; padding:0.8rem 1rem; background:#f8fafc; border:1px solid #cbd5e1; border-radius:10px; color:#0f172a; font-size:0.95rem; outline:none; transition:all 0.2s;" onfocus="this.style.borderColor='#0284c7'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label style="display:block; font-size:0.85rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Password</label>
                <input type="password" name="password" placeholder="••••••••" required style="width:100%; padding:0.8rem 1rem; background:#f8fafc; border:1px solid #cbd5e1; border-radius:10px; color:#0f172a; font-size:0.95rem; outline:none; transition:all 0.2s;" onfocus="this.style.borderColor='#0284c7'; this.style.background='#fff';" onblur="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; font-size:0.85rem;">
                <label style="display:flex; align-items:center; gap:0.5rem; color:#475569; cursor:pointer;">
                    <input type="checkbox" name="remember" style="accent-color:#0284c7;"> Remember me
                </label>
            </div>

            <button type="submit" style="width:100%; background:linear-gradient(135deg, #0284c7 0%, #00b4d8 100%); color:#ffffff; font-weight:700; border:none; padding:0.85rem; border-radius:10px; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.5rem; box-shadow:0 4px 15px rgba(2, 132, 199, 0.35); transition:all 0.25s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="fa-solid fa-right-to-bracket"></i> Sign In
            </button>
        </form>

        <div style="text-align:center; margin-top:1.5rem; font-size:0.9rem; color:#64748b;">
            Don't have an account? <a href="{{ route('register') }}" style="color:#0284c7; font-weight:700; text-decoration:none;">Register now</a>
        </div>

        <div style="margin-top:2rem; padding:1rem; background:#f0f9ff; border:1px solid #bae6fd; border-radius:12px; font-size:0.82rem; color:#0369a1; text-align:center; line-height:1.6;">
            <strong style="color:#0284c7;"><i class="fa-solid fa-key"></i> Demo Credentials:</strong><br>
            Admin: <code>admin@tourism.gov.so</code> / <code>password123</code><br>
            Tourist: <code>tourist@example.com</code> / <code>password123</code>
        </div>
    </div>
</div>
@endsection
