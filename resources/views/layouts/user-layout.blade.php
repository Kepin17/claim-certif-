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
            font-size: 25px;
            font-weight: 500;
            color: var(--ink);
            letter-spacing: -0.01em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
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
            <a href="{{ route('certificate.index') }}" class="nav-logo">
                <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" alt="logo" width="70" height="70">       
            Certificate Claim</a>
            <div class="nav-links">
                <a href="{{ route('certificate.index') }}" class="nav-link {{ request()->routeIs('certificate.index') ? 'active' : '' }}">Events</a>
                <a href="{{ route('certificate.track') }}" class="nav-link {{ request()->routeIs('certificate.track') ? 'active' : '' }}">Track Status</a>
                <!-- <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Admin</a> -->
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

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
