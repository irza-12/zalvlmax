<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('superadmin.dashboard') }}" class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div class="sidebar-logo-text">Zalvlma<span>X</span></div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('superadmin.dashboard') }}"
            class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section">Manajemen</div>
        <a href="{{ route('superadmin.users.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Kelola User</span>
        </a>
        <a href="{{ route('superadmin.categories.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-collection-fill"></i>
            <span>Kategori</span>
        </a>
        <a href="{{ route('superadmin.quizzes.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.quizzes.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Kuis</span>
        </a>

        <div class="nav-section">Monitoring</div>
        <a href="{{ route('superadmin.monitor.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.monitor.*') ? 'active' : '' }}">
            <i class="bi bi-broadcast"></i>
            <span>Live Monitor</span>
        </a>
        <a href="{{ route('superadmin.leaderboard.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.leaderboard.*') ? 'active' : '' }}">
            <i class="bi bi-trophy-fill"></i>
            <span>Leaderboard</span>
        </a>

        <div class="nav-section">Laporan</div>
        <a href="{{ route('superadmin.statistics.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.statistics.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i>
            <span>Statistik</span>
        </a>

        <div class="nav-section">Sistem</div>
        <a href="{{ route('superadmin.settings.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Pengaturan</span>
        </a>
        <a href="{{ route('superadmin.activity-logs.index') }}"
            class="nav-link {{ request()->routeIs('superadmin.activity-logs.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Activity Log</span>
        </a>
    </nav>
</aside>