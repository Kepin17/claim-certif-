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
        @media (max-width: 640px) {
            .nav-bar { padding: 0 20px; }
            .nav-inner { height: 56px; }
            .nav-links { gap: 16px; }
            .nav-link { font-size: 13px; }
            .footer { padding: 24px 20px; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="nav-bar">
        <div class="nav-inner">
            <a href="{{ route('admin.dashboard') }}" class="nav-logo">Admin Dashboard</a>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">Events</a>
                <a href="{{ route('admin.pending') }}" class="nav-link {{ request()->routeIs('admin.pending') ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.generated') }}" class="nav-link {{ request()->routeIs('admin.generated*') ? 'active' : '' }}">Generated</a>
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
