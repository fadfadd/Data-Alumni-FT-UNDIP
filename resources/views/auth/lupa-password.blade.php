<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Data Alumni FT</title>
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
            <h1 class="login-title kecil">LUPA PASSWORD</h1>
            <p class="login-petunjuk">Masukkan email kampus Anda. Kami akan mengirim tautan untuk membuat password baru.</p>

            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label for="email">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm1.4 2L12 12.6 19.6 7H4.4Z"/>
                    </svg>
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="Masukkan email" autocomplete="username" required autofocus>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <p class="auth-switch"><a href="{{ route('login') }}">Kembali ke login</a></p>

                <button type="submit" class="btn-login">Kirim Tautan</button>
            </form>
        </div>
    </main>
</body>
</html>