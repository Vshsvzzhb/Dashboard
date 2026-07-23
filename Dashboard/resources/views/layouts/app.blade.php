<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VetenCall 2026</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon" style="background: transparent; border: none; width: 28px; height: 28px;">
                    <img src="{{ asset('images/VetenCall.png') }}" alt="VetenCall" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <span>VetenCall</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" style="width: 22px; height: 22px;"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/phonebook" class="nav-item {{ request()->is('phonebook') ? 'active' : '' }}">
                    <i data-lucide="users" style="width: 22px; height: 22px;"></i>
                    <span>Phonebook</span>
                </a>
                <a href="/campaigns" class="nav-item {{ request()->is('campaigns') ? 'active' : '' }}">
                    <i data-lucide="radio" style="width: 22px; height: 22px;"></i>
                    <span>Campaigns</span>
                </a>
                <a href="/wa-groups" class="nav-item {{ request()->is('wa-groups') ? 'active' : '' }}">
                    <i data-lucide="users-2" style="width: 22px; height: 22px;"></i>
                    <span>WA Groups</span>
                </a>
                <a href="/quick-blast" class="nav-item {{ request()->is('quick-blast') ? 'active' : '' }}" style="{{ request()->is('quick-blast') ? '' : 'position:relative;' }}">
                    <i data-lucide="zap" style="width: 22px; height: 22px;"></i>
                    <span>Quick Blast</span>
                    <span style="margin-left: auto; background: var(--accent-orange); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 4px 8px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px;">NEW</span>
                </a>
                <a href="/blast-history" class="nav-item {{ request()->is('blast-history*') ? 'active' : '' }}">
                    <i data-lucide="history" style="width: 22px; height: 22px;"></i>
                    <span>Blast History</span>
                </a>
                <a href="/webrtc" class="nav-item {{ request()->is('webrtc') ? 'active' : '' }}">
                    <i data-lucide="phone-call" style="width: 22px; height: 22px;"></i>
                    <span>WebRTC Phone</span>
                </a>
                <div style="flex: 1;"></div>
                <a href="/settings" class="nav-item {{ request()->is('settings') ? 'active' : '' }}">
                    <i data-lucide="settings" style="width: 22px; height: 22px;"></i>
                    <span>Settings</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 4px;">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left; font-family: inherit;">
                        <i data-lucide="log-out" style="width: 22px; height: 22px; color: #DC2626;"></i>
                        <span style="color: #DC2626; font-weight: 700;">Log Out</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="top-header">
                <div class="header-left" style="display: flex; align-items: center; gap: 12px;">
                    <button id="sidebar-toggle" style="background: transparent; border: none; cursor: pointer; color: var(--text-primary); display: none; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; border: 1px solid var(--surface-border);">
                        <i data-lucide="menu" style="width: 24px; height: 24px;"></i>
                    </button>
                </div>
                
                <div class="header-right" style="display: flex; gap: 24px; align-items: center;">
                    <div class="server-status" id="server-status-btn">
                        <div class="status-indicator"></div>
                        <span>Live Sync</span>
                    </div>
                    
                    <div class="admin-badge" title="Super User Profile">
                        SU
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle for mobile
        const toggleBtn = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('open');
            });
            document.addEventListener('click', (e) => {
                if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== toggleBtn) {
                    sidebar.classList.remove('open');
                }
            });
        }

        // Server status toggle animation
        const statusBtn = document.getElementById('server-status-btn');
        let isConnected = true;
        statusBtn.addEventListener('click', () => {
            isConnected = !isConnected;
            if(isConnected) {
                statusBtn.classList.remove('disconnected');
                statusBtn.querySelector('span').innerText = 'LIVE SYNC';
            } else {
                statusBtn.classList.add('disconnected');
                statusBtn.querySelector('span').innerText = 'OFFLINE';
            }
        });
    </script>
</body>
</html>
