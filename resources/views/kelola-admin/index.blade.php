@extends('layouts.app')
@use('App\Models\User')

@section('title', 'Kelola Admin')
@section('breadcrumb', 'Kelola Admin')
@section('judul', 'Kelola Admin')
@section('subjudul', 'Buat dan atur akun Admin Universitas. Akun dinonaktifkan (bukan dihapus) agar riwayat aktivitas tetap utuh')

@section('content')
@php
    $wib = fn ($tgl) => $tgl?->copy()->timezone('Asia/Jakarta')->locale('id');
@endphp

@if (session('sukses'))
    <div class="pesan-sukses pesan-halaman">{{ session('sukses') }}</div>
@endif
@if (session('galat'))
    <div class="pesan-galat pesan-halaman">{{ session('galat') }}</div>
@endif

<div class="statistik">
    <div class="stat">
        <div class="stat-ikon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
        </div>
        <div class="stat-isi">
            <span>Total akun</span>
            <small>Aktif dan nonaktif</small>
        </div>
        <strong>{{ $statistik['total'] }}</strong>
    </div>
    <div class="stat stat-hijau">
        <div class="stat-ikon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="stat-isi">
            <span>Aktif</span>
            <small>Bisa login</small>
        </div>
        <strong>{{ $statistik['aktif'] }}</strong>
    </div>
    <div class="stat stat-merah">
        <div class="stat-ikon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
            </svg>
        </div>
        <div class="stat-isi">
            <span>Nonaktif</span>
            <small>Tidak bisa login</small>
        </div>
        <strong>{{ $statistik['nonaktif'] }}</strong>
    </div>
</div>

<section class="kartu kartu-tabel">
    <div class="tabel-bungkus">
        <table class="tabel tabel-besar">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Login terakhir</th>
                    <th class="tengah">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($akun as $u)
                    @php
                        $diriSendiri = $u->is(auth()->user());
                        $loginAkhir = $wib($u->last_login_at);
                    @endphp
                    <tr>
                        <td>
                            <div class="sel-nama">
                                <span class="avatar-kecil">{{ $u->initials() }}</span>
                                <div>
                                    <strong>{{ $u->name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td class="redup">{{ $u->email }}</td>
                        <td>
                            <span class="label-peran {{ $u->isSuperAdmin() ? 'peran-super' : 'peran-staf' }}">
                                {{ $u->isSuperAdmin() ? 'Super Admin' : 'Admin Universitas' }}
                            </span>
                        </td>
                        <td>
                            @if ($u->status === User::STATUS_ACTIVE)
                                <span class="label-status status-aktif"><x-icon nama="centang-lingkar" class="ikon-garis" /> Aktif</span>
                            @else
                                <span class="label-status status-nonaktif"><x-icon nama="silang-lingkar" class="ikon-garis" /> Nonaktif</span>
                            @endif
                        </td>
                        <td class="redup">{{ $wib($u->created_at)?->translatedFormat('j M Y') ?? '-' }}</td>
                        <td class="redup">
                            {{ $loginAkhir ? $loginAkhir->translatedFormat('j M Y') . ' • ' . $loginAkhir->format('H.i') : '-' }}
                        </td>
                        <td class="tengah">
                            <div class="aksi">
                                @if ($u->status === User::STATUS_ACTIVE)
                                    <form method="POST" action="{{ route('akun.status', $u) }}"
                                          data-konfirmasi="Nonaktifkan akun {{ $u->name }}? Pengguna ini tidak bisa login sampai diaktifkan lagi.">
                                        @csrf
                                        <button type="submit" class="btn-garis" @disabled($diriSendiri)>Nonaktifkan</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('akun.status', $u) }}">
                                        @csrf
                                        <button type="submit" class="btn-isi">Aktifkan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="kosong-tabel">Belum ada akun.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<h2 class="judul-seksi">Konfirmasi Akun</h2>
<section class="kartu kartu-tabel kartu-konfirmasi">
    <div class="tabel-bungkus">
        <table class="tabel tabel-besar">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                    <th class="tengah">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pending as $p)
                    <tr>
                        <td>
                            <div class="sel-nama">
                                <span class="avatar-kecil">{{ $p->initials() }}</span>
                                <strong>{{ $p->name }}</strong>
                            </div>
                        </td>
                        <td class="redup">{{ $p->email }}</td>
                        <td class="redup">{{ $wib($p->created_at)?->translatedFormat('j M Y') ?? '-' }}</td>
                        <td class="tengah">
                            <div class="aksi">
                                <form method="POST" action="{{ route('akun.konfirmasi', $p) }}">
                                    @csrf
                                    <button type="submit" class="btn-isi btn-kecil">Konfirmasi</button>
                                </form>
                                <form method="POST" action="{{ route('akun.tolak', $p) }}"
                                      data-konfirmasi="Tolak pendaftaran {{ $p->name }}?">
                                    @csrf
                                    <button type="submit" class="btn-tolak btn-kecil">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="kosong-tabel">Tidak ada akun yang menunggu konfirmasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<script>
    document.querySelectorAll('form[data-konfirmasi]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm(form.dataset.konfirmasi)) { e.preventDefault(); }
        });
    });
</script>
@endsection