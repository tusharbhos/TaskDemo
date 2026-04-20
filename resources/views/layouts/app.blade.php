<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RBAC System') — {{ config('app.name') }}</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
        }

        body { background: #f1f5f9; font-family: 'Segoe UI', sans-serif; }

        /* ── Navbar ── */
        .navbar-brand span { font-weight: 700; color: var(--primary); }
        .navbar { box-shadow: 0 1px 4px rgba(0,0,0,.1); }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 56px; left: 0;
            width: var(--sidebar-width); height: calc(100vh - 56px);
            background: #1e1b4b; overflow-y: auto;
            transition: transform .3s ease;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #c7d2fe; border-radius: 8px; margin: 2px 10px;
            padding: 10px 14px; font-size: .9rem;
            transition: background .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--primary); color: #fff;
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .sidebar-heading {
            font-size: .7rem; text-transform: uppercase;
            letter-spacing: .1em; color: #818cf8;
            padding: 16px 20px 6px;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 28px 32px;
            min-height: calc(100vh - 56px);
        }

        /* ── Cards ── */
        .stat-card {
            border-radius: 14px; border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.12); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px 16px; }
        }

        /* ── Alerts ── */
        .alert { border-radius: 10px; }

        /* ── Tables ── */
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; }
        .table td { vertical-align: middle; }
        .badge-role { font-size: .78rem; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

{{-- ── Top Navbar ── --}}
<nav class="navbar navbar-expand-md bg-white sticky-top">
    <div class="container-fluid">
        <button class="btn btn-sm me-2 d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <a class="navbar-brand" href="#">
            <i class="bi bi-shield-lock-fill text-primary me-1"></i>
            <span>RBAC System</span>
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                {{ ucfirst(auth()->user()->role->name) }}
            </span>
            <span class="text-muted small">{{ auth()->user()->full_name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ── Sidebar ── --}}
<aside class="sidebar" id="sidebar">
    <div class="py-3">
        <p class="sidebar-heading">Navigation</p>

        @if(auth()->user()->isDealer())
            <a href="{{ route('dealer.dashboard') }}"
               class="nav-link {{ request()->routeIs('dealer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('dealer.profile') }}"
               class="nav-link {{ request()->routeIs('dealer.profile') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> My Profile
            </a>
        @elseif(auth()->user()->isEmployee())
            <a href="{{ route('employee.dashboard') }}"
               class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('employee.dashboard') }}"
               class="nav-link {{ request()->routeIs('employee.dealer.view') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Dealers
            </a>
        @endif
    </div>
</aside>

{{-- ── Main Content ── --}}
<main class="main-content">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('open');
    });
</script>
@stack('scripts')
</body>
</html>
