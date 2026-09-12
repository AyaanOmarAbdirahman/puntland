<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Puntland Tourism')</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet GIS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --admin-bg: #051329;
            --admin-sidebar: #051329;
            --admin-card: rgba(255, 255, 255, 0.08);
            --primary-blue: #38bdf8;
            --accent-gold: #ffffff;
            --accent-green: #38bdf8;
            --accent-red: #ef4444;
            --text-light: #ffffff;
            --text-muted: #cbd5e1;
            --border-glass: rgba(255, 255, 255, 0.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #051329 0%, #0a2540 50%, #0d3b66 100%);
            background-attachment: fixed;
            color: var(--text-light);
            display: flex;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            border-right: 1px solid var(--border-glass);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--border-glass);
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(0, 180, 216, 0.15);
            color: var(--primary-blue);
            font-weight: 600;
        }

        .sidebar-menu a i {
            width: 22px;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            height: 70px;
            background: rgba(11, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notif-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.3rem;
            color: var(--text-muted);
        }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--accent-red);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif-dropdown {
            position: absolute;
            top: 45px;
            right: 0;
            width: 320px;
            background: #0f1c30;
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            display: none;
            flex-direction: column;
            z-index: 1000;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        .card {
            background: var(--admin-card);
            border: 1px solid var(--border-glass);
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        }

        /* Tables */
        .table-responsive { overflow-x: auto; }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .table th, .table td {
            padding: 0.9rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-glass);
        }

        .table th {
            color: var(--text-muted);
            font-weight: 600;
            background: rgba(255,255,255,0.02);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; }
        .btn-primary { background: var(--primary-blue); color: #fff; }
        .btn-success { background: var(--accent-green); color: #fff; }
        .btn-warning { background: var(--primary-blue); color: #fff; }
        .btn-danger { background: var(--accent-red); color: #fff; }
        .btn-outline { border: 1px solid var(--border-glass); color: var(--text-light); background: transparent; }

        .status-pill {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .status-pending { background: rgba(0, 180, 216, 0.2); color: var(--primary-blue); }
        .status-confirmed { background: rgba(16, 185, 129, 0.2); color: var(--accent-green); }
        .status-cancelled { background: rgba(239, 68, 68, 0.2); color: var(--accent-red); }

        /* Form Controls */
        .form-control, input, select, textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 8px;
            color: #ffffff !important;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus, input:focus, select:focus, textarea:focus {
            border-color: #38bdf8 !important;
            background: rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25) !important;
        }

        select option {
            background: #0f1c30;
            color: #ffffff;
        }

        /* Toast Alert */
        .alert-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            background: #059669;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Admin Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div style="width:36px; height:36px; background:linear-gradient(135deg, #ffffff, #38bdf8); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#051329; font-size:1.1rem; box-shadow:0 4px 12px rgba(255,255,255,0.3);">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div style="font-weight:800; font-size:1.1rem; background:linear-gradient(135deg, #fff 30%, #7dd3fc 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">PUNTLAND</div>
                <div style="font-size:0.65rem; color:#7dd3fc; font-weight:700;">ADMIN CONTROL CENTER</div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge-high"></i> Analytics Dashboard</a></li>
            <li><a href="{{ route('admin.destinations') }}" class="{{ request()->routeIs('admin.destinations*') ? 'active' : '' }}"><i class="fa-solid fa-map-pin"></i> Manage Destinations</a></li>
            <li><a href="{{ route('admin.tours') }}" class="{{ request()->routeIs('admin.tours*') ? 'active' : '' }}"><i class="fa-solid fa-suitcase"></i> Manage Tour Packages</a></li>
            <li><a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}"><i class="fa-solid fa-receipt"></i> Booking Requests</a></li>
            <li style="margin-top:auto; border-top:1px solid var(--border-glass); padding-top:1rem;">
                <a href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe"></i> View Public Website</a>
            </li>
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div>
                <h3 style="font-size:1.1rem; color:#fff;">Puntland Tourism Authority Management</h3>
            </div>

            <div class="topbar-right">
                <!-- Notification Bell -->
                <div class="notif-bell" onclick="toggleNotifDropdown()">
                    <i class="fa-solid fa-bell"></i>
                    <div class="notif-badge" id="notifBadge">1</div>

                    <div class="notif-dropdown" id="notifDropdown">
                        <div style="padding:0.75rem 1rem; border-bottom:1px solid var(--border-glass); font-weight:700; font-size:0.85rem; display:flex; justify-content:space-between;">
                            <span>Real-Time Alerts</span>
                            <span style="color:var(--primary-blue); font-size:0.75rem;" onclick="markAllRead()">Clear</span>
                        </div>
                        <div style="max-height:260px; overflow-y:auto;" id="notifList">
                            <div style="padding:0.75rem 1rem; font-size:0.82rem; border-bottom:1px solid rgba(255,255,255,0.05);">
                                <strong style="color:var(--primary-blue);">New Booking Received</strong>
                                <p style="color:var(--text-muted); margin-top:0.2rem;">Jamaal Hassan booked Bosaso Coastal Paradise.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Profile -->
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=Admin' }}" style="width:36px; height:36px; border-radius:50%; border:1px solid var(--primary-blue);">
                    <div>
                        <div style="font-weight:600; font-size:0.85rem;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.7rem; color:var(--accent-green);">Super Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert-toast">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Admin Content -->
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <!-- Real-time Polling Script -->
    <script>
        function toggleNotifDropdown() {
            const d = document.getElementById('notifDropdown');
            d.style.display = d.style.display === 'flex' ? 'none' : 'flex';
        }

        function checkNotifications() {
            fetch('{{ route('api.realtime.notifications') }}')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('notifBadge').textContent = data.unread_count;
                    if (data.notifications && data.notifications.length > 0) {
                        const list = document.getElementById('notifList');
                        list.innerHTML = '';
                        data.notifications.forEach(n => {
                            const div = document.createElement('div');
                            div.style.cssText = 'padding:0.75rem 1rem; font-size:0.82rem; border-bottom:1px solid rgba(255,255,255,0.05);';
                            div.innerHTML = `<strong style="color:var(--primary-blue);">${n.title}</strong><p style="color:var(--text-muted); margin-top:0.2rem;">${n.message}</p>`;
                            list.appendChild(div);
                        });
                    }
                });
        }

        setInterval(checkNotifications, 5000);
    </script>
    @stack('scripts')
</body>
</html>
