<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Data Alumni FT</title>
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
            <h1 class="login-title">REGISTER</h1>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                

                <label for="name">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/>
                    </svg>
                    Username
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       placeholder="Masukkan username" autocomplete="name" required autofocus>
                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <label for="email">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm1.4 2L12 12.6 19.6 7H4.4Z"/>
                    </svg>
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="Masukkan email" autocomplete="username" required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <label for="password">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2ZM10 7a2 2 0 0 1 4 0v2h-4V7Z"/>
                    </svg>
                    Password
                </label>
                <input id="password" type="password" name="password"
                       placeholder="Masukkan password" autocomplete="new-password" required>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>

                <button type="submit" class="btn-login">Daftar</button>
            </form>
        </div>
    </main>
</body>
</html>