
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
            background: #fff;
            color: #253047;
        }

        /* SIDEBAR */
        .sidebar {
            width: 268px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #102d56, #194b80);
            color: #9aafc9;
            z-index: 100;
        }

        .brand {
            padding: 27px 15px 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .brand-logo {
            display: block;
            width: 100px;
            height: 115px;
            margin: 0 auto 10px;
            object-fit: contain;
        }

        .brand h2 {
            color: white;
            font-family: Georgia, serif;
            font-size: 17px;
            line-height: 1.12;
            font-weight: normal;
            letter-spacing: .4px;
        }

        .sidebar-nav {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding: 5px 14px 15px;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-section {
            margin: 18px 15px 9px;
            color: #8da4c0;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .nav-link {
            min-height: 36px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 11px;
            margin-bottom: 3px;
            border-radius: 8px;
            color: #91a8c5;
            text-decoration: none;
            font-size: 12px;
            transition: .2s;
        }

        .nav-link:hover:not(.nav-disabled) {
            background: rgba(5, 29, 61, .5);
            color: white;
        }

        .nav-link.active {
            background: #0a2851;
            color: #f4ca46;
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

        .nav-disabled {
            cursor: default;
        }

        .nav-badge {
            min-width: 16px;
            height: 16px;
            margin-left: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f5d77b;
            color: #594719;
            font-size: 9px;
            font-weight: bold;
        }

        /* PROFIL SIDEBAR */
        .sidebar-bottom {
            flex-shrink: 0;
            padding: 10px 13px 12px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px;
            border-radius: 9px;
            background: #f6f8fc;
        }

        .user-avatar {
            width: 29px;
            height: 29px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #193d78;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }

        .user-info {
            min-width: 0;
        }

        .user-name {
            overflow: hidden;
            color: #263650;
            font-size: 10px;
            font-weight: bold;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-role {
            margin-top: 4px;
            color: #8491a8;
            font-size: 9px;
        }

        .sidebar-version {
            margin-top: 9px;
            color: #8298b4;
            text-align: center;
            font-size: 8px;
        }

        /* MAIN CONTENT */
        .app-main {
            min-height: 100vh;
            margin-left: 268px;
        }

        /* TOPBAR */
        .topbar {
            height: 62px;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #929292;
            font-size: 12px;
        }

        .breadcrumb strong {
            color: #173966;
            font-size: 14px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 17px;
        }

        .topbar-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #173966;
        }

        .notification-count {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #c93636;
            color: white;
            font-size: 9px;
        }

        .topbar-avatar {
            width: 41px;
            height: 41px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #173966;
            color: white;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .15);
        }

        .page-content {
            padding: 0 32px 28px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
            }

            .app-main {
                margin-left: 220px;
            }

            .page-content {
                padding-left: 20px;
                padding-right: 20px;
            }

            .topbar {
                padding: 0 20px;
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

        <symbol id="icon-shield" viewBox="0 0 24 24">
            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
            <path d="m9 12 2 2 4-4"/>
        </symbol>

        <symbol id="icon-history" viewBox="0 0 24 24">
            <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
            <path d="M3 3v5h5M12 7v5l3 2"/>
        </symbol>

        <symbol id="icon-trash" viewBox="0 0 24 24">
            <path d="M3 6h18M8 6V4h8v2m3 0-1 15H6L5 6"/>
            <path d="M10 11v6m4-6v6"/>
        </symbol>

        <symbol id="icon-bell" viewBox="0 0 24 24">
            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
            <path d="M10 21h4"/>
        </symbol>

        <symbol id="icon-user" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21a8 8 0 0 1 16 0"/>
        </symbol>

    </svg>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            <img
                src="{{ asset('images/logo-undip.png') }}"
                alt="Logo Universitas Diponegoro"
                class="brand-logo"
            >

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

            <div class="nav-section">Operasional</div>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-clipboard"/></svg>
                Verifikasi Data
                <span class="nav-badge">5</span>
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
                <svg class="nav-icon"><use href="#icon-shield"/></svg>
                Kelola Admin
            </span>

            <span class="nav-link nav-disabled">
                <svg class="nav-icon"><use href="#icon-user"/></svg>
                Profil
            </span>

        </nav>

        <div class="sidebar-bottom">

            <div class="user-card">
                <div class="user-avatar">{{ $sidebarInitials }}</div>

                <div class="user-info">
                    <div class="user-name">{{ $sidebarName }}</div>
                    <div class="user-role">Super Admin</div>
                </div>
            </div>

            <div class="sidebar-version">SIGMA 2026</div>

        </div>

    </aside>

    <!-- MAIN AREA -->
    <main class="app-main">

        <header class="topbar">

            <div class="breadcrumb">
                <span>Fakultas Teknik</span>
                <span>›</span>
                <strong>@yield('breadcrumb', 'Dashboard')</strong>
            </div>

            <div class="topbar-actions">

                <span class="topbar-icon notification">
                    <svg class="nav-icon" style="width:22px;height:22px">
                        <use href="#icon-bell"/>
                    </svg>
                    <span class="notification-count">4</span>
                </span>

                <div class="topbar-avatar">
                    {{ $sidebarInitials }}
                </div>

            </div>

        </header>

        <section class="page-content">
            @yield('content')
        </section>

    </main>

    @stack('scripts')

</body>
</html>