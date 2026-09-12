<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Puntland Tourism & Navigation System')</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet GIS Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --bg-page: #f4f9ff;
            --bg-card: #ffffff;
            --bg-card-subtle: #f8fafc;
            --primary-blue: #0284c7;
            --primary-hover: #0369a1;
            --accent-green: #10b981;
            --accent-green-hover: #059669;
            --accent-gold: #f59e0b;
            --accent-gold-hover: #d97706;
            --text-heading: #0f172a;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-glass: #e0f2fe;
            --nav-bg: #ffffff;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-text: #0f172a;
            --badge-bg: #e0f2fe;
            --badge-text: #0369a1;
            --badge-border: #bae6fd;
            --table-header-bg: #f8fafc;
            --table-border: #f1f5f9;
            --shadow-card: 0 10px 30px rgba(0, 119, 182, 0.08);
            --section-alt-bg: #f0f9ff;
        }

        body.dark-mode {
            --bg-page: #0a192f;
            --bg-card: #112240;
            --bg-card-subtle: #1a2f55;
            --primary-blue: #38bdf8;
            --primary-hover: #0284c7;
            --accent-green: #34d399;
            --accent-green-hover: #10b981;
            --accent-gold: #fbbf24;
            --accent-gold-hover: #f59e0b;
            --text-heading: #f8fafc;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: #1e293b;
            --border-glass: #233554;
            --nav-bg: #0a192f;
            --input-bg: #0b1728;
            --input-border: #334155;
            --input-text: #f8fafc;
            --badge-bg: rgba(56, 189, 248, 0.15);
            --badge-text: #38bdf8;
            --badge-border: rgba(56, 189, 248, 0.3);
            --table-header-bg: #0b1728;
            --table-border: #1e293b;
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.4);
            --section-alt-bg: #0d1e38;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--text-heading);
        }

        p {
            color: var(--text-muted);
        }

        /* Glassmorphism & Solid Card Style */
        .glass-card, .city-card, .stat-card, .dest-card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px;
            box-shadow: var(--shadow-card) !important;
            color: var(--text-main) !important;
            transition: all 0.25s ease;
        }

        .glass-nav {
            background: var(--nav-bg) !important;
            border-bottom: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-card) !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background 0.3s ease;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #00b4d8 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
            color: #ffffff !important;
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.45);
        }

        .btn-green, .btn-gold {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-green:hover, .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            color: #ffffff !important;
        }

        .btn-outline {
            background: var(--bg-card);
            border: 1.5px solid var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn-outline:hover {
            background: var(--primary-blue);
            color: #ffffff !important;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-region, .badge-green, .badge-gold {
            background: var(--badge-bg) !important;
            color: var(--badge-text) !important;
            border: 1px solid var(--badge-border) !important;
        }

        /* Top Weather Bar */
        .top-bar {
            background: linear-gradient(90deg, #0284c7 0%, #00b4d8 100%);
            padding: 0.45rem 0;
            font-size: 0.85rem;
            color: #ffffff;
        }

        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .weather-ticker {
            display: flex;
            gap: 1.5rem;
        }

        .weather-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 75px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-heading);
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #0284c7 0%, #00b4d8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.3);
        }

        .logo-text {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary-blue);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--primary-blue);
            font-weight: 700;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Inputs & Dropdowns */
        .search-input, input, select, textarea {
            background: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus, input:focus, select:focus, textarea:focus {
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2) !important;
        }

        .search-dropdown {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-card) !important;
        }

        .dropdown-item {
            color: var(--text-main) !important;
        }

        .dropdown-item:hover {
            background: var(--bg-card-subtle) !important;
            color: var(--primary-blue) !important;
        }

        .quick-city-tag {
            background: var(--bg-card) !important;
            color: var(--primary-blue) !important;
            border: 1px solid var(--badge-border) !important;
        }

        .quick-city-tag:hover, .quick-city-tag.active {
            background: var(--primary-blue) !important;
            color: #ffffff !important;
            border-color: var(--primary-blue) !important;
        }

        /* Main Content */
        main {
            flex: 1;
        }

        /* Toast Alert */
        .alert-toast {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
        }
        .alert-success { background: #10b981; color: #fff; }
        .alert-info { background: #0284c7; color: #fff; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-top: 4px solid #10b981;
            padding: 3.5rem 0 1.5rem 0;
            margin-top: 4rem;
            color: #ffffff;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 2.5rem;
            margin-bottom: 2.5rem;
        }

        .footer-link {
            color: #e0f2fe;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .footer-link:hover {
            color: #10b981;
            padding-left: 4px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.18);
            padding-top: 1.5rem;
            text-align: center;
            color: #e0f2fe;
            font-size: 0.85rem;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Weather Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div class="weather-ticker">
                <span class="weather-item"><i class="fa-solid fa-cloud-sun" style="color:#bae6fd;"></i> <strong>Bosaso:</strong> 32°C Sunny</span>
                <span class="weather-item"><i class="fa-solid fa-sun" style="color:#fef08a;"></i> <strong>Garowe:</strong> 28°C Clear</span>
                <span class="weather-item"><i class="fa-solid fa-wind" style="color:#bae6fd;"></i> <strong>Eyl:</strong> 26°C Breezy</span>
                <span class="weather-item"><i class="fa-solid fa-mountain" style="color:#a7f3d0;"></i> <strong>Cal Madow:</strong> 21°C Mist</span>
            </div>
            <div style="color: #ffffff; font-weight: 600;">
                <i class="fa-solid fa-globe"></i> Welcome to Puntland
            </div>
        </div>
    </div>

    <!-- Glassmorphic Navbar -->
    <header class="glass-nav">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-compass"></i>
                </div>
                <div>
                    <div class="logo-text">PUNTLAND</div>
                    <div style="font-size:0.65rem; letter-spacing: 0.15em; color: #64748b; font-weight:700;">TOURISM & NAVIGATION</div>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="{{ route('explore') }}" class="{{ request()->routeIs('explore*') ? 'active' : '' }}"><i class="fa-solid fa-compass"></i> Explore</a></li>
                <li><a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'active' : '' }}"><i class="fa-solid fa-location-dot"></i> Destinations</a></li>
                <li><a href="{{ route('map') }}" class="{{ request()->routeIs('map') ? 'active' : '' }}"><i class="fa-solid fa-map-location-dot"></i> Map</a></li>
                <li><a href="{{ route('tours.index') }}" class="{{ request()->routeIs('tours.*') ? 'active' : '' }}"><i class="fa-solid fa-suitcase"></i> Tour Packages</a></li>
                <li><a href="{{ route('culture') }}" class="{{ request()->routeIs('culture') ? 'active' : '' }}"><i class="fa-solid fa-landmark"></i> Cultural Heritage</a></li>
            </ul>

            <div class="nav-actions">
                <!-- Dark Mode Toggle Button -->
                <button id="theme-toggle" class="btn" style="background:#f1f5f9; border:1px solid #cbd5e1; color:#0284c7; padding:0.6rem 0.9rem; border-radius:10px; cursor:pointer;" title="Toggle Dark/Light Mode">
                    <i id="theme-icon" class="fa-solid fa-moon"></i>
                </button>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-gold" style="padding:0.6rem 1rem;"><i class="fa-solid fa-gauge-high"></i> Admin Panel</a>
                    @endif
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline"><i class="fa-solid fa-user-circle"></i> My Itinerary</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn" style="background:#f1f5f9; border:1px solid #cbd5e1; color:#0284c7; font-weight:700; padding:0.6rem 1rem; border-radius:8px;" title="Log Out"><i class="fa-solid fa-right-from-bracket"></i></button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert-toast alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert-toast alert-info">
            <i class="fa-solid fa-circle-info"></i> {{ session('info') }}
        </div>
    @endif

    <!-- Main View Content -->
    <main>
        @yield('content')
    </main>

    <!-- Beautiful Organized 3-Color Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
                        <div style="width:36px; height:36px; background:#ffffff; color:#0284c7; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; font-weight:bold;">
                            <i class="fa-solid fa-compass"></i>
                        </div>
                        <span style="font-size:1.35rem; font-weight:800; font-family:'Outfit'; color:#ffffff; letter-spacing:0.02em;">PUNTLAND TOURISM</span>
                        <span style="background:#10b981; color:#ffffff; font-size:0.65rem; padding:0.2rem 0.6rem; border-radius:999px; font-weight:800;">OFFICIAL</span>
                    </div>
                    <p style="color:#e0f2fe; font-size:0.9rem; max-width:320px; line-height:1.65;">
                        Promoting and preserving Puntland's majestic coastal wonders, mountain ranges, historical stone forts, and vibrant cultural heritage.
                    </p>
                </div>
                <div>
                    <h4 style="margin-bottom:1.2rem; color:#ffffff; font-size:1.05rem; position:relative; padding-bottom:0.4rem;">
                        Quick Explore
                        <span style="position:absolute; bottom:0; left:0; width:30px; height:3px; background:#10b981; border-radius:2px;"></span>
                    </h4>
                    <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
                        <li><a href="{{ route('destinations.index') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="color:#10b981; font-size:0.75rem; margin-right:0.3rem;"></i> Destinations</a></li>
                        <li><a href="{{ route('map') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="color:#10b981; font-size:0.75rem; margin-right:0.3rem;"></i> Map</a></li>
                        <li><a href="{{ route('tours.index') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="color:#10b981; font-size:0.75rem; margin-right:0.3rem;"></i> Tour Packages</a></li>
                        <li><a href="{{ route('culture') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="color:#10b981; font-size:0.75rem; margin-right:0.3rem;"></i> Culture & History</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom:1.2rem; color:#ffffff; font-size:1.05rem; position:relative; padding-bottom:0.4rem;">
                        Key Regions
                        <span style="position:absolute; bottom:0; left:0; width:30px; height:3px; background:#10b981; border-radius:2px;"></span>
                    </h4>
                    <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem; color:#e0f2fe;">
                        <li><i class="fa-solid fa-location-dot" style="color:#10b981; margin-right:0.4rem;"></i> Bari (Bosaso)</li>
                        <li><i class="fa-solid fa-location-dot" style="color:#10b981; margin-right:0.4rem;"></i> Nugaal (Garowe/Eyl)</li>
                        <li><i class="fa-solid fa-location-dot" style="color:#10b981; margin-right:0.4rem;"></i> Sanaag (Cal Madow)</li>
                        <li><i class="fa-solid fa-location-dot" style="color:#10b981; margin-right:0.4rem;"></i> Gardafuul (Ras Hafun)</li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom:1.2rem; color:#ffffff; font-size:1.05rem; position:relative; padding-bottom:0.4rem;">
                        Official Contact
                        <span style="position:absolute; bottom:0; left:0; width:30px; height:3px; background:#10b981; border-radius:2px;"></span>
                    </h4>
                    <p style="color:#e0f2fe; font-size:0.9rem; margin-bottom:0.5rem;"><i class="fa-solid fa-envelope" style="color:#10b981; width:20px;"></i> info@tourism.gov.so</p>
                    <p style="color:#e0f2fe; font-size:0.9rem; margin-bottom:0.5rem;"><i class="fa-solid fa-phone" style="color:#10b981; width:20px;"></i> +252 90 7xxxxx</p>
                    <p style="color:#e0f2fe; font-size:0.9rem;"><i class="fa-solid fa-building" style="color:#10b981; width:20px;"></i> Garowe, Puntland State, Somalia</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Puntland Tourism & GIS Navigation System. All Rights Reserved. Built with Laravel 12.
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        @auth
        // SSE Real-Time Stream Receiver
        if (typeof(EventSource) !== "undefined") {
            const source = new EventSource("{{ route('api.realtime.stream') }}");
            source.addEventListener('notification', function(event) {
                console.log('Realtime Event:', event.data);
            });
        }
        @endauth
    </script>
<script>
// Dark mode toggle functionality
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('theme-toggle');
    const icon = document.getElementById('theme-icon');
    // Initialize theme based on localStorage or system preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.body.classList.add('dark-mode');
        if (icon) icon.classList.replace('fa-moon', 'fa-sun');
    }
    // Toggle handler
    if (toggle) {
        toggle.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            if (icon) {
                if (isDark) {
                    icon.classList.replace('fa-moon', 'fa-sun');
                    localStorage.setItem('theme', 'dark');
                } else {
                    icon.classList.replace('fa-sun', 'fa-moon');
                    localStorage.setItem('theme', 'light');
                }
            }
        });
    }
});
</script>
@stack('scripts')
</body>
</html>

