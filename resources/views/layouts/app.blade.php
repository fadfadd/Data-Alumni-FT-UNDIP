<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Data Alumni FT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body class="app-body">
    <div class="app">
        @include('partials.sidebar')

        <div class="app-main">
            <header class="page-head">
                <div>
                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        Fakultas Teknik <span class="sep">›</span> <strong>@yield('breadcrumb')</strong>
                    </nav>
                    <h1 class="page-title">@yield('judul')</h1>
                    <p class="page-sub">@yield('subjudul')</p>
                </div>
                <div class="avatar avatar-sm" title="{{ auth()->user()->name }}">{{ auth()->user()->initials() }}</div>
            </header>

            @yield('content')
        </div>
    </div>
</body>
</html>