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
                <input id="password" type="password" name="password"
                       placeholder="Masukkan password" autocomplete="current-password" required>

                {{-- Belum ada fungsinya, lihat catatan di bawah --}}
                <a href="#" class="forgot">Lupa password?</a>

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
</body>
</html>