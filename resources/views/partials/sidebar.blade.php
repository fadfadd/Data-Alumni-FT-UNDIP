@php
    $pengguna = auth()->user();

    // href '#' = halamannya belum dibuat. Ganti dengan route('...') kalau sudah jadi.
    // Untuk melihat lencana angka seperti desain, ganti 'badge' => null menjadi 'badge' => 5.
    $menu = [
        'Ringkasan' => [
            ['label' => 'Dashboard', 'ikon' => 'home', 'href' => route('dashboard'), 'aktif' => request()->routeIs('dashboard')],
        ],
        'Data Alumni' => [
            ['label' => 'Data Alumni', 'ikon' => 'users', 'href' => '#'],
            ['label' => 'Program Studi', 'ikon' => 'file', 'href' => '#'],
        ],
        'Operasional' => [
            ['label' => 'Verifikasi Data', 'ikon' => 'check', 'href' => '#', 'badge' => null],
            ['label' => 'Laporan dan Grafik', 'ikon' => 'clipboard', 'href' => '#'],
            ['label' => 'Riwayat Aktivitas', 'ikon' => 'clock', 'href' => '#'],
            ['label' => 'Sampah', 'ikon' => 'trash', 'href' => '#'],
        ],
        'Administrasi' => array_filter([
            $pengguna->isSuperAdmin()
                ? [
                    'label' => 'Kelola Admin',
                    'ikon' => 'shield',
                    'href' => Route::has('akun.index') ? route('akun.index') : '#',
                    'aktif' => request()->routeIs('akun.*'),
                    'badge' => \App\Models\User::where('status', \App\Models\User::STATUS_PENDING)->count() ?: null,
                ]
                : null,
            ['label' => 'Profil', 'ikon' => 'person', 'href' => route('profil'), 'aktif' => request()->routeIs('profil')],
        ]),
    ];
@endphp

<aside class="sidebar">
    <div class="sb-logo">
        <img class="lambang" src="{{ asset('images/logo-undip-lambang.png') }}" alt="Lambang Universitas Diponegoro">
        <img class="tulisan" src="{{ asset('images/logo-undip-tulisan.png') }}" alt="Universitas Diponegoro">
    </div>

    <nav class="sb-nav" aria-label="Menu utama">
        @foreach ($menu as $judul => $daftar)
            <p class="sb-judul">{{ $judul }}</p>
            @foreach ($daftar as $item)
                <a href="{{ $item['href'] }}"
                   class="sb-item {{ ! empty($item['aktif']) ? 'aktif' : '' }}"
                   @if (! empty($item['aktif'])) aria-current="page" @endif>
                    <x-icon :nama="$item['ikon']" />
                    <span>{{ $item['label'] }}</span>
                    @if (! empty($item['badge']))
                        <span class="sb-badge">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endforeach
        @endforeach
    </nav>

    <div class="sb-user">
        <div class="avatar avatar-xs">{{ $pengguna->initials() }}</div>
        <div>
            <strong>{{ $pengguna->name }}</strong>
            <span>{{ $pengguna->roleLabel() }}</span>
        </div>
    </div>
    <p class="sb-foot">SIGMA {{ now()->year }}</p>
</aside>