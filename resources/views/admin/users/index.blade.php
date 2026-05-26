@extends('layouts.admin-layout')

@section('title', 'User Management')

@section('content')
<style>
    .main-content { max-width: 1200px; margin: 0 auto; padding: 48px 40px 80px; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
    }

    .page-title {
        font-family: 'Fraunces', serif; font-size: 30px; font-weight: 300;
        color: var(--ink); letter-spacing: -0.02em;
    }

    .btn-create {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 20px; background: var(--ink); color: #fff;
        font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500;
        border-radius: var(--radius-sm); text-decoration: none;
        transition: background 0.2s;
    }
    .btn-create:hover { background: #2A2821; }

    /* Alert */
    .alert {
        padding: 14px 18px; border-radius: var(--radius-sm);
        font-size: 14px; margin-bottom: 20px;
    }
    .alert-success { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }
    .alert-error   { background: var(--danger-lt); color: var(--danger); border: 1px solid rgba(140,44,26,0.15); }

    /* Filters */
    .filters {
        display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;
    }

    .filter-input {
        flex: 1; min-width: 200px; padding: 9px 14px;
        font-family: 'Geist', sans-serif; font-size: 13px; color: var(--ink);
        background: var(--card); border: 1px solid rgba(0,0,0,0.1);
        border-radius: var(--radius-sm);
    }
    .filter-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,80,22,0.08); }

    .filter-select {
        padding: 9px 14px; font-family: 'Geist', sans-serif; font-size: 13px;
        color: var(--ink); background: var(--card);
        border: 1px solid rgba(0,0,0,0.1); border-radius: var(--radius-sm); cursor: pointer;
    }

    .filter-btn {
        padding: 9px 18px; background: var(--ink); color: #fff;
        border: none; border-radius: var(--radius-sm); font-family: 'Geist', sans-serif;
        font-size: 13px; font-weight: 500; cursor: pointer;
    }

    /* Table */
    .table-wrap {
        background: var(--card); border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg); overflow: hidden;
    }

    .user-table { width: 100%; border-collapse: collapse; }

    .user-table th {
        font-size: 11px; font-weight: 500; letter-spacing: 0.07em;
        text-transform: uppercase; color: var(--ink-muted);
        padding: 13px 20px; text-align: left;
        border-bottom: 1px solid rgba(0,0,0,0.06); background: var(--surface);
    }

    .user-table td {
        padding: 14px 20px; font-size: 14px; color: var(--ink-mid);
        border-bottom: 1px solid rgba(0,0,0,0.04); vertical-align: middle;
    }

    .user-table tr:last-child td { border-bottom: none; }
    .user-table tr:hover td { background: var(--surface); }

    .user-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--accent-lt); color: var(--accent);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 600; text-transform: uppercase;
        margin-right: 10px; flex-shrink: 0; vertical-align: middle;
    }

    .user-name { font-weight: 500; color: var(--ink); vertical-align: middle; }

    .role-badge {
        display: inline-block; font-size: 10px; font-weight: 600;
        letter-spacing: 0.07em; text-transform: uppercase;
        padding: 3px 9px; border-radius: 100px;
    }
    .role-badge.admin      { background: rgba(59,130,246,0.12); color: #2563EB; }
    .role-badge.superadmin { background: rgba(139,92,246,0.12); color: #7C3AED; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 600; letter-spacing: 0.05em;
        text-transform: uppercase; padding: 4px 10px; border-radius: 100px;
        cursor: pointer; border: none; font-family: 'Geist', sans-serif;
        transition: opacity 0.2s;
    }
    .status-pill:hover { opacity: 0.8; }
    .status-pill.active   { background: var(--accent-lt); color: var(--accent); }
    .status-pill.inactive { background: rgba(0,0,0,0.06); color: var(--ink-muted); }
    .status-pill .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

    .actions { display: flex; align-items: center; gap: 8px; }

    .btn-edit {
        font-size: 12px; font-weight: 500; color: var(--accent);
        text-decoration: none; padding: 5px 12px;
        border: 1px solid rgba(45,80,22,0.2); border-radius: 6px;
        transition: background 0.15s;
    }
    .btn-edit:hover { background: var(--accent-lt); }

    .btn-delete {
        font-size: 12px; font-weight: 500; color: var(--danger);
        background: none; padding: 5px 12px;
        border: 1px solid rgba(140,44,26,0.2); border-radius: 6px;
        cursor: pointer; font-family: 'Geist', sans-serif;
        transition: background 0.15s;
    }
    .btn-delete:hover { background: var(--danger-lt); }

    .you-badge {
        font-size: 10px; font-weight: 600; letter-spacing: 0.05em;
        text-transform: uppercase; padding: 2px 7px; border-radius: 100px;
        background: rgba(251,191,36,0.15); color: #92400E;
        margin-left: 6px; vertical-align: middle;
    }

    .empty-state { text-align: center; padding: 56px; color: var(--ink-muted); font-size: 14px; }

    @media (max-width: 768px) {
        .main-content { padding: 28px 20px 60px; }
        .user-table th:nth-child(4),
        .user-table td:nth-child(4) { display: none; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">User Management</h1>
        <a href="{{ route('admin.users.create') }}" class="btn-create">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}" class="filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…" class="filter-input">
        <select name="role" class="filter-select">
            <option value="">All Roles</option>
            <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
            <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        </select>
        <select name="status" class="filter-select">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if(request('search') || request('role') || request('status'))
            <a href="{{ route('admin.users.index') }}" style="padding:9px 14px;font-size:13px;color:var(--ink-muted);text-decoration:none;">Clear</a>
        @endif
    </form>

    <div class="table-wrap">
        @if($users->count() === 0)
            <div class="empty-state">No users found.</div>
        @else
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="user-avatar">{{ mb_substr($user->name, 0, 1) }}</span>
                            <span class="user-name">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                                <span class="you-badge">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="role-badge {{ $user->role }}">{{ $user->role }}</span></td>
                        <td style="font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="status-pill {{ $user->is_active ? 'active' : 'inactive' }}" title="Click to toggle">
                                        <span class="dot"></span>
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            @else
                                <span class="status-pill active" style="cursor:default;">
                                    <span class="dot"></span>Active
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                          onsubmit="return confirm('Delete user {{ addslashes($user->name) }}? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:16px 20px;">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
