<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Certificate Claim System - Claim and verify your certificates easily">
    <meta name="keywords" content="certificate, verification, claim, event, training">
    <meta name="robots" content="index, follow">
    <title>@yield('title', 'Certificate Claim System')</title>
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

        /* ── NAV ── */
        .nav-bar {
            position: sticky;
            top: 0;
            z-index: 200;
            background: var(--card);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        /* Logo */
        .nav-logo {
            font-family: 'Fraunces', serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--ink);
            letter-spacing: -0.01em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .nav-logo img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            border-radius: 8px;
        }

        /* Desktop links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink-muted);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            transition: color 0.15s, background 0.15s;
            position: relative;
            white-space: nowrap;
        }

        .nav-link:hover {
            color: var(--ink);
            background: rgba(0,0,0,0.04);
        }

        .nav-link.active {
            color: var(--ink);
            background: var(--accent-lt);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 12px;
            right: 12px;
            height: 2px;
            background: var(--accent);
            border-radius: 2px 2px 0 0;
        }

        /* Hamburger button */
        .nav-hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: var(--radius-sm);
            background: transparent;
            cursor: pointer;
            color: var(--ink-mid);
            transition: background 0.15s, color 0.15s;
            flex-shrink: 0;
        }

        .nav-hamburger:hover {
            background: rgba(0,0,0,0.04);
            color: var(--ink);
        }

        .nav-hamburger svg {
            transition: transform 0.2s;
        }

        .nav-hamburger.open svg.icon-menu  { display: none; }
        .nav-hamburger.open svg.icon-close { display: block; }
        .nav-hamburger svg.icon-close { display: none; }

        /* Mobile drawer */
        .nav-drawer {
            display: none;
            flex-direction: column;
            background: var(--card);
            border-top: 1px solid rgba(0,0,0,0.06);
            padding: 12px 20px 20px;
            gap: 2px;
            /* slide-down animation */
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .nav-drawer.open {
            display: flex;
        }

        .drawer-link {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink-muted);
            text-decoration: none;
            padding: 11px 14px;
            border-radius: var(--radius-md);
            transition: color 0.15s, background 0.15s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .drawer-link:hover {
            color: var(--ink);
            background: rgba(0,0,0,0.04);
        }

        .drawer-link.active {
            color: var(--accent);
            background: var(--accent-lt);
        }

        .drawer-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.6;
        }

        .drawer-link.active svg {
            opacity: 1;
        }

        .drawer-divider {
            height: 1px;
            background: rgba(0,0,0,0.06);
            margin: 8px 0;
        }

        /* Content grow */
        .content-wrap {
            flex: 1;
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--ink);
            padding: 32px 40px;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-logo {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            letter-spacing: -0.01em;
        }

        .footer-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .footer-copyright {
            font-size: 12px;
            color: rgba(255,255,255,0.35);
        }

        .footer-support {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
        }

        .footer-support a {
            color: #A8D88A;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.15s;
        }

        .footer-support a:hover {
            opacity: 0.75;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .nav-inner {
                padding: 0 20px;
                height: 56px;
            }

            .nav-links {
                display: none; /* replaced by drawer */
            }

            .nav-hamburger {
                display: flex;
            }

            .footer {
                padding: 24px 20px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .footer-right {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
        }

        @media (max-width: 400px) {
            .nav-logo span {
                display: none; /* icon only on very small screens */
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="nav-bar">
        <div class="nav-inner">

            <!-- Logo -->
            <a href="{{ route('certificate.index') }}" class="nav-logo">
                <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" alt="Logo">
                <span>Certificate Claim</span>
            </a>

            <!-- Desktop links -->
            <div class="nav-links">
                <a href="{{ route('certificate.index') }}"
                   class="nav-link {{ request()->routeIs('certificate.index') ? 'active' : '' }}">
                    Events
                </a>
                <a href="{{ route('certificate.track') }}"
                   class="nav-link {{ request()->routeIs('certificate.track') ? 'active' : '' }}">
                    Track Status
                </a>
                <a href="{{ route('certificate.participant-dashboard') }}"
                   class="nav-link {{ request()->routeIs('certificate.participant-dashboard') ? 'active' : '' }}">
                    My Certificates
                </a>
                @if(auth()->check())
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Admin
                </a>
                @endif
            </div>

            <!-- Hamburger (mobile) -->
            <button class="nav-hamburger" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                <svg class="icon-menu" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
                <svg class="icon-close" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6"  y1="6" x2="18" y2="18"/>
                </svg>
            </button>

        </div>

        <!-- Mobile drawer -->
        <div class="nav-drawer" id="navDrawer" role="menu">
            <a href="{{ route('certificate.index') }}"
               class="drawer-link {{ request()->routeIs('certificate.index') ? 'active' : '' }}"
               role="menuitem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Events
            </a>
            <a href="{{ route('certificate.track') }}"
               class="drawer-link {{ request()->routeIs('certificate.track') ? 'active' : '' }}"
               role="menuitem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/>
                </svg>
                Track Status
            </a>
            <a href="{{ route('certificate.participant-dashboard') }}"
               class="drawer-link {{ request()->routeIs('certificate.participant-dashboard') ? 'active' : '' }}"
               role="menuitem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
                My Certificates
            </a>
            @if(auth()->check())
            <div class="drawer-divider"></div>
            <a href="{{ route('admin.dashboard') }}"
               class="drawer-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               role="menuitem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Admin
            </a>
            @endif
        </div>
    </nav>

    <!-- Content -->
    <div class="content-wrap">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-logo">Certificate Claim</div>
            <div class="footer-right">
                <span class="footer-copyright">© {{ date('Y') }} Certificate Claim System</span>
                <span class="footer-support">Support by <a href="https://kevienstudio.my.id" target="_blank">kevienstudio.my.id</a></span>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        const toggle  = document.getElementById('navToggle');
        const drawer  = document.getElementById('navDrawer');

        toggle.addEventListener('click', () => {
            const isOpen = drawer.classList.toggle('open');
            toggle.classList.toggle('open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen);
        });

        // Close drawer when a link is tapped
        drawer.querySelectorAll('.drawer-link').forEach(link => {
            link.addEventListener('click', () => {
                drawer.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', false);
            });
        });

        // Close drawer on outside click
        document.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !drawer.contains(e.target)) {
                drawer.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', false);
            }
        });
    </script>

</body>
</html>