<!-- Topbar -->
<div class="topbar">
    <div class="topbar-left">
        <h5>@yield('page_title', 'Dashboard')</h5>
    </div>

    <div class="topbar-right">
        <div class="search-box">
            <input type="text" placeholder="Cari...">
            <i class="fas fa-search"></i>
        </div>

        <div class="user-menu">
            <button class="notification-icon" title="Notifikasi">
                <i class="fas fa-bell"></i>
            </button>
            <button class="settings-icon" title="Pengaturan">
                <i class="fas fa-sliders-h"></i>
            </button>
            <a href="#" class="user-avatar" title="Profil">
                {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
            </a>
        </div>
    </div>
</div>
