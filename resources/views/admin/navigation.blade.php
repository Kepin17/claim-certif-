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
    .nav-logout {
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 400;
        color: #8C2C1A;
        text-decoration: none;
        transition: color 0.2s;
    }
    .nav-logout:hover {
        color: #6B1F12;
    }
    @media (max-width: 640px) {
        .nav-bar { padding: 0 20px; }
        .nav-links { display: none; }
    }
</style>
<nav class="nav-bar">
    <a href="{{ route('admin.dashboard') }}" class="nav-logo">Admin Dashboard</a>
    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->is('admin/events*') ? 'active' : '' }}">Events</a>
        <a href="{{ route('admin.pending') }}" class="nav-link {{ request()->is('admin/pending') ? 'active' : '' }}">Pending</a>
        <a href="{{ route('admin.approved') }}" class="nav-link {{ request()->is('admin/approved') ? 'active' : '' }}">Approved</a>
        <a href="{{ route('admin.generated') }}" class="nav-link {{ request()->is('admin/generated') ? 'active' : '' }}">Generated</a>
    </div>
    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="nav-logout" style="background: none; border: none; cursor: pointer; font-family: 'Geist', sans-serif; font-size: 13px;">Logout</button>
    </form>
</nav>
