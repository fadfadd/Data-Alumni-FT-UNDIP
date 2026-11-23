
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIGMA Alumni | Fakultas Teknik UNDIP')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #253047;
        }

        /* ===== SIDEBAR ===== */

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #102e57, #194a7d);
            color: #c3d0e1;
            z-index: 100;
        }

        .brand {
            padding: 28px 18px 20px;
            text-align: center;
        }

        .brand-logo {
            width: 90px;
            height: 105px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .brand-mark {
            width: 88px;
            height: 88px;
            margin: 0 auto 14px;
            border: 3px solid #e5b930;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f6d46d;
            font-weight: bold;
            font-size: 25px;
        }

        .brand h2 {
            font-family: Georgia, serif;
            font-size: 18px;
            line-height: 1.15;
            letter-spacing: 1px;
            color: white;
            font-weight: normal;
        }

        .sidebar-nav {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0 14px 15px;

            /* menyembunyikan scrollbar */
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        /* chrome, edge, dan safari */
        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-section {
            margin: 17px 10px 9px;
            color: #8299b6;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-link {
            min-height: 39px;
            padding: 0 11px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 11px;
            border-radius: 8px;
            text-decoration: none;
            color: #91a6c0;
            font-size: 12px;
            transition: 0.2s;
        }

        .nav-link:hover:not(.nav-disabled) {
            background: rgba(7, 32, 65, 0.45);
            color: white;
        }

        .nav-link.active {
            background: #0c2850;
            color: #f3cb46;
            font-weight: bold;
        }

        .nav-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nav-link.active .nav-icon {
            color: white;
        }

        .nav-disabled {
            cursor: default;
        }

        .nav-badge {
            min-width: 17px;
            height: 17px;
            margin-left: auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5d77b;
            color: #57451b;
            font-size: 9px;
            font-weight: bold;
        }

        /* ===== PROFIL SIDEBAR ===== */

        .sidebar-bottom {
            padding: 10px 12px 13px;
            flex-shrink: 0;
        }

        .user-card {
            background: #f5f7fb;
            border-radius: 9px;
            padding: 10px 9px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 29px;
            height: 29px;
            border-radius: 50%;
            background: #1b3d77;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .user-info {
            min-width: 0;
        }

        .user-name {
            color: #263650;
            font-size: 10px;
            font-weight: bold;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-role {
            margin-top: 4px;
            color: #8491a8;
            font-size: 9px;
        }

        .sidebar-version {
            text-align: center;
            color: #8298b4;
            font-size: 8px;
            margin-top: 9px;
        }

        /* ===== MAIN CONTENT ===== */

        .app-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */

        .topbar {
            height: 68px;
            padding: 0 25px;
            background: white;
            border-bottom: 1px solid #e8edf4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #8995a9;
        }

        .breadcrumb strong {
            color: #26334a;
            font-size: 14px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 17px;
        }

        .sample-status {
            padding: 9px 13px;
            border: 1px solid #e4eaf2;
            border-radius: 25px;
            color: #7d8ca3;
            font-size: 11px;
        }

        .topbar-icon {
            color: #71819b;
            font-size: 18px;
        }

        .notification {
            position: relative;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            background: #c93636;
            color: white;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            background: #1b3d77;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        .page-content {
            padding: 28px;
        }

        /* ===== RESPONSIVE ===== */

        @media (max-width: 850px) {
            .sidebar {
                width: 220px;
            }

            .app-main {
                margin-left: 220px;
            }

            .page-content {
                padding: 20px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .sidebar-nav {
                max-height: 300px;
            }

            .app-main {
                margin-left: 0;
            }

            .topbar {
                padding: 0 15px;
            }

            .sample-status {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $sidebarName = auth()->user()?->name ?? 'Admin SIGMA';
        $sidebarInitials = strtoupper(substr($sidebarName, 0, 2));
    @endphp

    <!-- ICON LIBRARY -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display:none">

        <symbol id="icon-home" viewBox="0 0 24 24">
            <path d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9 21v-7h6v7"/>
        </symbol>

        <symbol id="icon-users" viewBox="0 0 24 24">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M20 8a3 3 0 0 1-2 2.8M18 14h1a3 3 0 0 1 3 3v2"/>
        </symbol>

        <symbol id="icon-building" viewBox="0 0 24 24">
            <path d="M3 21h18M5 21V5l7-3 7 3v16"/>
            <path d="M9 8h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/>
        </symbol>

        <symbol id="icon-clipboard" viewBox="0 0 24 24">
            <path d="M8 4h8l1 2h3v15H4V6h3l1-2z"/>
            <path d="m8 13 2 2 5-5"/>
        </symbol>

        <symbol id="icon-calendar" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="16" rx="2"/>
            <path d="M16 3v4M8 3v4M3 10h18"/>
        </symbol>

        <symbol id="icon-map" viewBox="0 0 24 24">
            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0z"/>
            <circle cx="12" cy="10" r="2.5"/>
        </symbol>

        <symbol id="icon-bell" viewBox="0 0 24 24">
            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
            <path d="M10 21h4"/>
        </symbol>

        <symbol id="icon-shield" viewBox="0 0 24 24">
            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
            <path d="m9 12 2 2 4-4"/>
        </symbol>

        <symbol id="icon-chart" viewBox="0 0 24 24">
            <path d="M3 3v18h18"/>
            <rect x="7" y="12" width="3" height="6"/>
            <rect x="13" y="7" width="3" height="11"/>
            <rect x="19" y="4" width="2" height="14"/>
        </symbol>

        <symbol id="icon-history" viewBox="0 0 24 24">
            <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
            <path d="M3 3v5h5M12 7v5l3 2"/>
        </symbol>

        <symbol id="icon-trash" viewBox="0 0 24 24">
            <path d="M3 6h18M8 6V4h8v2m3 0-1 15H6L5 6"/>
            <path d="M10 11v6m4-6v6"/>
        </symbol>

        <symbol id="icon-settings" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.8 3.1-.2-.1a1.7 1.7 0 0 0-1.8.1l-.2.1h-3.6l-.1-.2a1.7 1.7 0 0 0-1.6-1l-.2.1-3.2-1.8.1-.2a1.7 1.7 0 0 0-.2-1.8l-.1-.2v-3.6l.2-.1a1.7 1.7 0 0 0 1-1.6l-.1-.2 1.8-3.2.2.1a1.7 1.7 0 0 0 1.8-.2l.2-.1h3.6l.1.2a1.7 1.7 0 0 0 1.6 1l.2-.1 3.2 1.8-.1.2a1.7 1.7 0 0 0 .2 1.8l.1.2v3.6z"/>
        </symbol>

        <symbol id="icon-user" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21a8 8 0 0 1 16 0"/>
        </symbol>

    </svg>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            @if (file_exists(public_path('images/logo-undip.png')))
                <img
                    src="{{ asset('images/logo-undip.png') }}"
                    alt="Logo UNDIP"
                    class="brand-logo"
                >
            @else
                <div class="brand-mark">UD</div>
            @endif

            <h2>UNIVERSITAS<br>DIPONEGORO</h2>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section">Ringkasan</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-home"/></svg>
                Dashboard
            </span>

            <div class="nav-section">Data Alumni</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-users"/></svg>
                Data Alumni
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-building"/></svg>
                Program Studi
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-clipboard"/></svg>
                Data Belum Lengkap
            </span>

            <div class="nav-section">Analitik</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-calendar"/></svg>
                Kalender Kelulusan
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-map"/></svg>
                Peta Sebaran
            </span>

            <div class="nav-section">Operasional</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-bell"/></svg>
                Notifikasi
                <span class="nav-badge">4</span>
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-shield"/></svg>
                Verifikasi Data
                <span class="nav-badge">5</span>
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-chart"/></svg>
                Laporan dan Grafik
            </span>

            <a
                href="{{ route('activity-logs.index') }}"
                class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
            >
                <svg class="nav-icon"><use href="#icon-history"/></svg>
                Riwayat Aktivitas
            </a>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-trash"/></svg>
                Sampah
            </span>

            <div class="nav-section">Administrasi</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-users"/></svg>
                Kelola Admin
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-settings"/></svg>
                Pengaturan Fakultas
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-user"/></svg>
                Profil
            </span>

        </nav>

        <!-- PROFIL ADMIN -->
        <div class="sidebar-bottom">

            <div class="user-card">
                <div class="user-avatar">
                    {{ $sidebarInitials }}
                </div>

                <div class="user-info">
                    <div class="user-name">{{ $sidebarName }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>

            <div class="sidebar-version">
                SIGMA Alumni • Data contoh
            </div>

        </div>

    </aside>

    <!-- MAIN AREA -->
    <main class="app-main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="breadcrumb">
                <span>▦</span>
                <span>Fakultas Teknik</span>
                <span>›</span>
                <strong>@yield('breadcrumb', 'Dashboard')</strong>
            </div>

            <div class="topbar-actions">

                <span class="sample-status">
                    ☁ Data contoh aktif
                </span>

                <span class="topbar-icon">☾</span>

                <span class="topbar-icon notification">
                    ♧
                    <span class="notification-count">4</span>
                </span>

                <span class="topbar-icon">
                    <svg class="nav-icon"><use href="#icon-settings"/></svg>
                </span>

                <div class="topbar-avatar">
                    {{ $sidebarInitials }}
                </div>

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <section class="page-content">
            @yield('content')
        </section>

    </main>

    @stack('scripts')

</body>
</html>
