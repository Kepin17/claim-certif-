<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard for Certificate Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/png" href="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;1,9..144,300&family=Geist:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:        #131210;
            --ink-mid:    #4A4740;
            --ink-muted:  #8A877F;
            --ink-faint:  #C5C2BB;
            --surface:    #F5F2EC;
            --card:       #FDFCFA;
            --accent:     #2D5016;
            --accent-lt:  #EBF2E3;
            --accent-mid: #4A8022;
            --danger:     #8C2C1A;
            --danger-lt:  #F9EDE9;
            --radius-sm:  6px;
            --radius-md:  12px;
            --radius-lg:  18px;
        }

        body {
            font-family: 'Geist', sans-serif;
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Nav */
        .nav-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--card);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 0 40px;
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .nav-logo {
            font-family: 'Fraunces', serif;
            font-size: 17px;
            font-weight: 500;
            color: var(--ink);
            letter-spacing: -0.01em;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-link {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--ink);
        }

        .nav-link.active {
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -22px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
        }

        .nav-logout {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 100px;
        border: 1px solid var(--danger);
        background: transparent;
        color: var(--danger);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.15s;
        cursor: pointer;
        }
        .nav-logout:hover { background: var(--danger-lt); }

        /* Mobile Menu Button */
        .nav-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            color: var(--ink);
        }

        .nav-menu-btn svg {
            width: 24px;
            height: 24px;
        }

        /* Mobile Menu */
        .nav-mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--card);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 16px 20px;
            flex-direction: column;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .nav-mobile-menu.open {
            display: flex;
        }

        .nav-mobile-menu .nav-link {
            padding: 10px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .nav-mobile-menu .nav-link:last-child {
            border-bottom: none;
        }

        .nav-mobile-menu .nav-link.active::after {
            display: none;
        }

        .nav-mobile-menu .nav-link.active {
            color: var(--accent);
        }

        .nav-mobile-menu .nav-logout {
            width: 100%;
            justify-content: center;
            margin-top: 8px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
            padding: 16px 0;
        }

        .pagination .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination .pagination li {
            display: flex;
        }

        .pagination .pagination li a,
        .pagination .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-muted);
            text-decoration: none;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(0,0,0,0.08);
            background: var(--card);
            transition: all 0.2s;
        }

        .pagination .pagination li a:hover {
            background: var(--surface);
            color: var(--ink);
            border-color: rgba(0,0,0,0.12);
        }

        .pagination .pagination li.active span {
            background: var(--accent);
            color: #FFFFFF;
            border-color: var(--accent);
        }

        .pagination .pagination li.disabled span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .pagination .pagination li.disabled span:hover {
            background: var(--card);
            color: var(--ink-muted);
            border-color: rgba(0,0,0,0.08);
        }


        /* Main */
        .main {
            flex: 1;
            overflow-y: auto;
        }

        /* Override for individual views */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 48px 40px 80px;
        }

        /* Footer */
        .footer {
            background: var(--ink);
            padding: 32px 40px;
            margin-top: auto;
         
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-copyright {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }

        .footer-support {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }

        .footer-support a {
            color: #A8D88A;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .footer-support a:hover {
            color: #A8D88A;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-bar { padding: 0 20px; }
            .nav-inner { height: 56px; }
            .nav-links { display: none; }
            .nav-menu-btn { display: block; }
            .nav-bar { position: relative; }
            .footer { padding: 24px 20px; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="nav-bar">
        <div class="nav-inner">
            <a href="{{ route('admin.dashboard') }}" class="nav-logo">Admin Dashboard</a>
            <button class="nav-menu-btn" onclick="document.querySelector('.nav-mobile-menu').classList.toggle('open')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">Events</a>
                <a href="{{ route('admin.pending') }}" class="nav-link {{ request()->routeIs('admin.pending') ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.rejected') }}" class="nav-link {{ request()->routeIs('admin.rejected*') ? 'active' : '' }}">Rejected</a>
                <a href="{{ route('admin.generated') }}" class="nav-link {{ request()->routeIs('admin.generated*') ? 'active' : '' }}">Generated</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('admin.activity-log') }}" class="nav-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}">Log</a>
                <form action="{{ route('admin.search') }}" method="GET" style="display:flex;align-items:center;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="padding:6px 12px;font-size:13px;font-family:'Geist',sans-serif;background:rgba(0,0,0,0.06);border:1px solid rgba(0,0,0,0.08);border-radius:6px;color:var(--ink);width:140px;transition:width 0.2s;" onfocus="this.style.width='200px'" onblur="this.style.width='140px'">
                </form>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-logout">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="nav-mobile-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Dashboard</a>
            <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Events</a>
            <a href="{{ route('admin.pending') }}" class="nav-link {{ request()->routeIs('admin.pending') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Pending</a>
            <a href="{{ route('admin.rejected') }}" class="nav-link {{ request()->routeIs('admin.rejected*') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Rejected</a>
            <a href="{{ route('admin.generated') }}" class="nav-link {{ request()->routeIs('admin.generated*') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Generated</a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Users</a>
            <a href="{{ route('admin.activity-log') }}" class="nav-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}" onclick="document.querySelector('.nav-mobile-menu').classList.remove('open')">Log</a>
            <form action="{{ route('admin.search') }}" method="GET" style="padding:4px 0;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search claims…" style="width:100%;padding:10px 14px;font-size:14px;font-family:'Geist',sans-serif;background:rgba(0,0,0,0.06);border:1px solid rgba(0,0,0,0.08);border-radius:6px;color:var(--ink);">
            </form>
            <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-copyright">
                © {{ date('Y') }} Certificate Claim System
            </div>
            <div class="footer-support">
                Support by <a href="https://kevienstudio.my.id" target="_blank">kevienstudio.my.id</a>
            </div>
        </div>
    </footer>

    @stack('scripts')

</body>
</html>
