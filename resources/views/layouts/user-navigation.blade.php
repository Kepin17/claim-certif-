<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;1,9..144,300&family=Geist:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .nav-bar {
        background: #FDFCFA;
        border-bottom: 1px solid rgba(0,0,0,0.07);
        padding: 0 40px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .nav-logo {
        font-family: 'Fraunces', serif;
        font-size: 17px;
        font-weight: 500;
        color: #131210;
        letter-spacing: -0.01em;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .nav-links {
        display: flex;
        gap: 32px;
    }
    .nav-link {
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 400;
        color: #8A877F;
        text-decoration: none;
        transition: color 0.2s;
    }
    .nav-link:hover, .nav-link.active {
        color: #131210;
    }
    .nav-link.active {
        font-weight: 500;
    }
    .nav-admin {
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 400;
        color: #8A877F;
        text-decoration: none;
        transition: color 0.2s;
    }
    .nav-admin:hover {
        color: #131210;
    }
    @media (max-width: 640px) {
        .nav-bar { padding: 0 20px; }
        .nav-links { display: none; }
    }
</style>
<nav class="nav-bar">
    <a href="{{ route('certificate.index') }}" class="nav-logo">
    <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" alt="logo" width="80" height="80">    
    Certificate Claim</a>
    <div class="nav-links">
        <a href="{{ route('certificate.index') }}" class="nav-link {{ request()->is('claim-certificate') ? 'active' : '' }}">Events</a>
        <a href="{{ route('certificate.track') }}" class="nav-link {{ request()->is('track-certificate') ? 'active' : '' }}">Track Status</a>
        <a href="{{ route('certificate.participant-dashboard') }}" class="nav-link {{ request()->is('my-certificates') ? 'active' : '' }}">My Certificates</a>
    </div>
    @if(auth()->check())
    <a href="{{ route('admin.dashboard') }}" class="nav-admin">Admin</a>
    @endif
</nav>
