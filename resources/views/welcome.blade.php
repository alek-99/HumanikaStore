<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUMANIKA STORE - Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @include('partials.welcome.portal')
</head>
<body>
<div class="container">
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="logo">HUMANIKA STORE</div>
        <p class="tagline">
            Platform terpercaya untuk kebutuhan belanja online Anda dengan layanan terbaik dan produk berkualitas.
        </p>
        <div class="feature-list">
            <div class="feature-item">Produk berkualitas tinggi</div>
            <div class="feature-item">Pengiriman cepat & aman</div>
            <div class="feature-item">Pembayaran yang mudah</div>
            <div class="feature-item">Customer service 24/7</div>
            <div class="feature-item">Bisa Pre Order</div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="header-mobile">
            <h1>HUMANIKA STORE</h1>
            <p>Selamat datang di platform kami</p>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="switchTab('login')">Login</button>
            <button class="tab" onclick="switchTab('register')">Register</button>
        </div>

        <!-- LOGIN FORM -->
        <div id="login-form" class="form-container active">
            @if ($errors->any() && request()->is('login'))
                <div id="login-alert" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="form-title">Selamat Datang Kembali</h2>
            <p class="form-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-input"
                           placeholder="nama@email.com"
                           value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-input"
                           placeholder="Masukkan password" required autocomplete="current-password">
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="checkbox-group">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Ingat saya</label>
                </div>

                <button type="submit" class="btn-submit">Masuk</button>

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    @else
                        <a href="#" onclick="alert('Fitur lupa password akan segera hadir!'); return false;">
                            Lupa password?
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div id="register-form" class="form-container">
            @if ($errors->any() && request()->is('register'))
                <div id="register-alert" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Daftar untuk memulai pengalaman belanja Anda</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" class="form-input"
                           placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email_register">Email</label>
                    <input id="email_register" type="email" name="email" class="form-input"
                           placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_register">Password</label>
                    <input id="password_register" type="password" name="password" class="form-input"
                           placeholder="Minimal 8 karakter" required minlength="8" autocomplete="new-password">
                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-input"
                           placeholder="Ulangi password" required minlength="8" autocomplete="new-password">
                </div>

                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>
        </div>
    </div>
</div>

@include('partials.welcome.scriptjs')
</body>
</html>
