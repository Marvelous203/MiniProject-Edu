<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'FlashLearn')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div class="page-shell">
            <header class="topbar">
                <div class="container topbar-inner">
                    <a href="{{ route('home') }}" class="brand">
                        <span class="brand-mark">FL</span>
                        <span>
                            <strong>FlashLearn</strong>
                            <small>Mini LMS bằng Laravel</small>
                        </span>
                    </a>

                    <nav class="nav-links">
                        <a href="{{ route('home') }}">Trang chủ</a>

                        @auth
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <a href="{{ route('flashcard-sets.index') }}">Bộ thẻ</a>
                            <a href="{{ route('progress.index') }}">Tiến độ</a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.index') }}">Quản trị</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-dark">Đăng xuất</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                        @endauth
                    </nav>
                </div>
            </header>

            <main class="container content-area">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <strong>Vui lòng kiểm tra lại dữ liệu:</strong>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
