@extends('layouts.app')

@section('title', 'Profil')
@section('breadcrumb', 'Profil')
@section('judul', 'Profil')
@section('subjudul', 'Informasi akun, aktivitas terbaru, dan ubah password')

@section('content')
@php
    $wib = fn ($tgl) => $tgl?->copy()->timezone('Asia/Jakarta')->locale('id');

    $mulai = $wib($user->created_at);
    $loginTerakhir = $wib($user->last_login_at);

    $statusLabel = [
        'active' => 'Aktif',
        'pending' => 'Menunggu',
        'rejected' => 'Ditolak',
        'disabled' => 'Nonaktif',
    ][$user->status] ?? ucfirst($user->status);

    if ($user->approver) {
        $asalAkun = 'Disetujui oleh ' . $user->approver->name;
    } elseif ($user->isSuperAdmin()) {
        $asalAkun = 'Akun awal sistem';
    } else {
        $asalAkun = 'Terdaftar mandiri';
    }

    // Dua ikon mata (terlihat / dicoret), dipakai di tiga kolom password
    $ikonMata = '<svg class="mata-buka" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>'
        . '<svg class="mata-coret" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>';
@endphp

@if ($user->must_change_password)
    <div class="pesan-peringatan pesan-halaman">Password Anda masih sementara. Ganti password di bagian bawah halaman ini sebelum melanjutkan.</div>
@endif

@if (session('status_nama'))
    <div class="pesan-sukses pesan-halaman">{{ session('status_nama') }}</div>
@endif

<div class="grid-profil">
    <section class="kartu">
        <div class="profil-atas">
            <div class="avatar avatar-lg">{{ $user->initials() }}</div>
            <div>
                <div class="nama-baris" id="nama-tampil" @if ($errors->has('name')) hidden @endif>
                    <h2 class="profil-nama">{{ $user->name }}</h2>
                    <button type="button" class="ikon-edit" id="btn-edit-nama" title="Ubah nama" aria-label="Ubah nama">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('profil.nama') }}" class="form-nama" id="form-nama" @unless ($errors->has('name')) hidden @endunless>
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="100" required aria-label="Nama">
                    <button type="submit" class="btn-isi btn-kecil">Simpan</button>
                    <button type="button" class="btn-garis btn-kecil" id="batal-nama">Batal</button>
                </form>
                @error('name')
                    <div class="pesan-error">{{ $message }}</div>
                @enderror

                <p class="profil-email">{{ $user->email }}</p>
                <span class="pill {{ $user->isSuperAdmin() ? 'pill-emas' : 'pill-abu' }}">{{ $user->roleLabel() }}</span>
                <span class="pill pill-navy">{{ $statusLabel }}</span>
            </div>
        </div>

        <div class="baris-info">
            <span>Mulai menggunakan aplikasi</span>
            <strong>{{ $mulai?->translatedFormat('d M Y') ?? '-' }}</strong>
        </div>
        <div class="baris-info">
            <span>Login terakhir</span>
            <strong>{{ $loginTerakhir?->translatedFormat('d M Y') ?? '-' }}</strong>
        </div>
        <div class="baris-info">
            <span>Status akun</span>
            <strong>{{ $asalAkun }}</strong>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-keluar">Keluar</button>
        </form>
    </section>

    <section class="kartu">
        <div class="aktivitas-kepala">
            <div>
                <h2 class="judul-kartu">Aktivitas terbaru akun ini</h2>
                <p class="sub-kartu">Tiga aktivitas terakhir yang dilakukan</p>
            </div>
            <a href="#" class="pill-link">Lihat semua</a>
        </div>

        @forelse ($aktivitas as $a)
            <article class="aktivitas-item">
                <div class="atas">
                    <span class="jenis">{{ $a['jenis'] }}</span>
                    <span class="waktu">{{ $a['waktu']->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y.H.i') }}</span>
                </div>
                <p>{{ $a['keterangan'] }}</p>
            </article>
        @empty
            <div class="kosong">Belum ada aktivitas yang tercatat untuk akun ini.</div>
        @endforelse
    </section>
</div>

<section class="kartu form-password">
    <h2 class="judul-kartu">Ubah password</h2>
    <p class="sub-kartu">Gunakan minimal 8 karakter</p>

    @if (session('status_password'))
        <div class="pesan-sukses">{{ session('status_password') }}</div>
    @endif

    <form method="POST" action="{{ route('profil.password') }}">
        @csrf
        @method('PUT')

        <label for="password_lama">Password saat ini</label>
        <div class="pw-wrap">
            <input id="password_lama" type="password" name="password_lama"
                   placeholder="••••••••••" autocomplete="current-password" required>
            <button type="button" class="pw-toggle" aria-label="Tampilkan password">{!! $ikonMata !!}</button>
        </div>
        @error('password_lama')
            <div class="pesan-error">{{ $message }}</div>
        @enderror

        <div class="kolom-2">
            <div>
                <label for="password_baru">Password baru</label>
                <div class="pw-wrap">
                    <input id="password_baru" type="password" name="password_baru"
                           placeholder="••••••••••" autocomplete="new-password" required>
                    <button type="button" class="pw-toggle" aria-label="Tampilkan password">{!! $ikonMata !!}</button>
                </div>
                @error('password_baru')
                    <div class="pesan-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password_baru_confirmation">Ulangi password baru</label>
                <div class="pw-wrap">
                    <input id="password_baru_confirmation" type="password" name="password_baru_confirmation"
                           placeholder="••••••••••" autocomplete="new-password" required>
                    <button type="button" class="pw-toggle" aria-label="Tampilkan password">{!! $ikonMata !!}</button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-simpan">Simpan</button>
    </form>
</section>

<script>
    // Ikon mata: tampilkan / sembunyikan password
    document.querySelectorAll('.pw-toggle').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            var input = tombol.parentElement.querySelector('input');
            var tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            tombol.classList.toggle('tampil', tampil);
            tombol.setAttribute('aria-label', tampil ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });

    // Ubah nama: buka / tutup kolom isian
    var namaTampil = document.getElementById('nama-tampil');
    var formNama = document.getElementById('form-nama');
    document.getElementById('btn-edit-nama').addEventListener('click', function () {
        namaTampil.hidden = true;
        formNama.hidden = false;
        formNama.querySelector('input').focus();
    });
    document.getElementById('batal-nama').addEventListener('click', function () {
        formNama.hidden = true;
        namaTampil.hidden = false;
    });
</script>
@endsection