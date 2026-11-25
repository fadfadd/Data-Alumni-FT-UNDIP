<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Data Alumni FT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-page">
    <header class="login-logo">
        <img src="{{ asset('images/logo_undip.png') }}" alt="Universitas Diponegoro">
    </header>

    <main class="login-main">
        <h2 class="login-heading">
            Kelola dan Akses Data Alumni<br>
            Fakultas Teknik
        </h2>
        <div class="login-card">
            <h1 class="login-title">LOGIN</h1>

            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <label for="email">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm1.4 2L12 12.6 19.6 7H4.4Z"/>
                    </svg>
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="Masukkan email" autocomplete="username" required autofocus>

                <label for="password">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2ZM10 7a2 2 0 0 1 4 0v2h-4V7Z"/>
                    </svg>
                    Password
                </label>
                <div class="pw-wrap">
                    <input id="password" type="password" name="password"
                           placeholder="Masukkan password" autocomplete="current-password" required>
                    <button type="button" class="pw-toggle" aria-label="Tampilkan password">
                        <svg class="mata-buka" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        <svg class="mata-coret" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                    </button>
                </div>

                <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>

                <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></p>

                @error('email')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </main>

    <script>
        document.querySelectorAll('.pw-toggle').forEach(function (tombol) {
            tombol.addEventListener('click', function () {
                var input = tombol.parentElement.querySelector('input');
                var tampil = input.type === 'password';
                input.type = tampil ? 'text' : 'password';
                tombol.classList.toggle('tampil', tampil);
                tombol.setAttribute('aria-label', tampil ? 'Sembunyikan password' : 'Tampilkan password');
            });
        });
    </script>
</body>
</html>