<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>SIKLASTER | PKM Sawah Lega</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #eef8f7,
                    #f7fbff
                );

            color: #172033;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 28px;
        }

        .login-page {
            width: 100%;
            max-width: 1250px;
            min-height: 700px;

            background: white;

            border-radius: 22px;

            box-shadow:
                0 20px 60px
                rgba(7, 89, 133, 0.13);

            overflow: hidden;

            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* =========================
           BRANDING
        ========================= */

        .branding-panel {
            position: relative;

            padding: 55px 55px 40px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            color: white;

            overflow: hidden;

            background:
                linear-gradient(
                    155deg,
                    #075985 0%,
                    #07899a 45%,
                    #16a34a 100%
                );
        }

        .branding-panel::before {
            content: '';

            position: absolute;

            width: 380px;
            height: 380px;

            border-radius: 50%;

            top: -180px;
            right: -150px;

            background:
                rgba(255,255,255,0.07);
        }

        .branding-panel::after {
            content: '';

            position: absolute;

            width: 360px;
            height: 360px;

            border-radius: 50%;

            bottom: -220px;
            left: -150px;

            background:
                rgba(255,255,255,0.07);
        }

        .branding-content {
            position: relative;
            z-index: 2;

            display: flex;
            flex-direction: column;
            align-items: center;

            text-align: center;
        }

        .logo-login {
            width: 145px;
            height: 145px;

            object-fit: contain;

            display: block;

            margin: 0 auto 28px;

            filter:
                drop-shadow(
                    0 8px 20px
                    rgba(0,0,0,0.15)
                );
        }

        .brand-title {
            margin: 0;

            font-size: 48px;
            line-height: 1;

            letter-spacing: 6px;

            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 12px;

            font-size: 22px;

            letter-spacing: 3px;

            font-weight: bold;

            color: #b9ef72;
        }

        .brand-line {
            width: 110px;
            height: 3px;

            margin: 28px auto;

            border-radius: 20px;

            background:
                linear-gradient(
                    90deg,
                    #22d3ee,
                    #bef264
                );
        }

        .brand-description {
            max-width: 470px;

            margin: 0 auto;

            font-size: 18px;
            line-height: 1.6;

            color: #ecfeff;

            text-align: center;
        }

        .feature-grid {
            position: relative;
            z-index: 2;

            display: grid;
            grid-template-columns:
                repeat(2, 1fr);

            gap: 14px;

            margin-top: 35px;
        }

        .feature-item {
            padding: 16px;

            border-radius: 12px;

            background:
                rgba(255,255,255,0.10);

            border:
                1px solid
                rgba(255,255,255,0.12);

            backdrop-filter:
                blur(4px);
        }

        .feature-icon {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .feature-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .feature-text {
            font-size: 11px;
            line-height: 1.4;
            color: #dff6f3;
        }

        /* =========================
           LOGIN
        ========================= */

        .login-panel {
            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fbfefe
                );
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .lock-icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 22px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;

            color: #0f9f89;

            border:
                1px solid
                #5eead4;

            background: #f0fdfa;
        }

        .login-title {
            margin: 0;

            text-align: center;

            font-size: 30px;

            color: #172033;
        }

        .login-subtitle {
            margin: 10px 0 30px;

            text-align: center;

            color: #64748b;

            font-size: 14px;
        }

        .divider {
            height: 1px;

            background: #e5e7eb;

            margin-bottom: 28px;
        }

        .session-status {
            margin-bottom: 18px;

            padding: 12px 14px;

            border-radius: 8px;

            background: #dcfce7;

            color: #166534;

            font-size: 13px;
        }

        .error-box {
            margin-bottom: 18px;

            padding: 12px 14px;

            border-radius: 8px;

            background: #fee2e2;

            color: #991b1b;

            font-size: 13px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;

            margin-bottom: 8px;

            font-size: 13px;
            font-weight: bold;

            color: #172033;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 15px;
            top: 50%;

            transform:
                translateY(-50%);

            font-size: 17px;

            color: #64748b;

            pointer-events: none;
        }

        .form-input {
            width: 100%;
            height: 52px;

            padding: 0 45px;

            border:
                1px solid
                #cbd5e1;

            border-radius: 9px;

            outline: none;

            font-size: 14px;

            color: #172033;

            background: white;

            transition: 0.2s;
        }

        .form-input:focus {
            border-color: #0ea5a4;

            box-shadow:
                0 0 0 3px
                rgba(14,165,164,0.10);
        }

        .password-toggle {
            position: absolute;

            right: 14px;
            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            cursor: pointer;

            font-size: 16px;

            color: #64748b;

            padding: 5px;
        }

        .login-options {
            margin-top: 2px;
            margin-bottom: 25px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }

        .remember-box {
            display: flex;
            align-items: center;

            gap: 8px;

            font-size: 13px;

            color: #475569;
        }

        .remember-box input {
            width: 17px;
            height: 17px;

            accent-color: #0ea5a4;
        }

        .forgot-link {
            color: #0284c7;

            font-size: 13px;

            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            height: 52px;

            border: none;

            border-radius: 9px;

            cursor: pointer;

            font-size: 16px;
            font-weight: bold;

            color: white;

            background:
                linear-gradient(
                    90deg,
                    #0b75bc,
                    #0ea5a4,
                    #22c55e
                );

            box-shadow:
                0 8px 20px
                rgba(14,165,164,0.18);

            transition:
                transform 0.2s,
                box-shadow 0.2s;
        }

        .login-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 12px 24px
                rgba(14,165,164,0.24);
        }

        /* =========================
           REGISTER
        ========================= */

        .register-section {
            margin-top: 20px;

            text-align: center;
        }

        .register-text {
            margin:
                0 0 10px;

            font-size: 13px;

            color: #64748b;
        }

        .register-link {
            width: 100%;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            text-decoration: none;

            font-size: 14px;
            font-weight: bold;

            color: #0f766e;

            background: #f0fdfa;

            border:
                1px solid
                #5eead4;

            transition: 0.2s;
        }

        .register-link:hover {
            background: #ccfbf1;

            border-color: #2dd4bf;

            transform: translateY(-1px);
        }

        .security-note {
            margin-top: 18px;

            padding: 12px;

            border-radius: 8px;

            text-align: center;

            background: #f8fafc;

            color: #64748b;

            font-size: 11px;

            line-height: 1.5;

            border:
                1px solid
                #e5e7eb;
        }

        /* =========================
           FOOTER
        ========================= */

        .login-footer {
            margin-top: 28px;

            text-align: center;

            font-size: 12px;

            color: #64748b;
        }

        .login-footer div + div {
            margin-top: 7px;
        }

        .login-footer strong {
            font-weight: 800;

            background:
                linear-gradient(
                    90deg,
                    #0b75bc,
                    #0ea5a4,
                    #22c55e
                );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            body {
                padding: 0;
            }

            .login-page {
                min-height: 100vh;

                border-radius: 0;

                grid-template-columns: 1fr;
            }

            .branding-panel {
                min-height: auto;

                padding:
                    35px 30px;
            }

            .logo-login {
                width: 100px;
                height: 100px;

                margin-bottom: 18px;
            }

            .brand-title {
                font-size: 36px;
            }

            .brand-subtitle {
                font-size: 17px;
            }

            .brand-description {
                font-size: 15px;
            }

            .feature-grid {
                display: none;
            }

            .login-panel {
                padding:
                    40px 25px;
            }
        }

        @media (max-width: 500px) {

            .login-options {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand-title {
                font-size: 30px;
                letter-spacing: 4px;
            }
        }
    </style>

</head>

<body>

<div class="login-page">

    {{-- =========================
         BRANDING
    ========================= --}}

    <section class="branding-panel">

        <div class="branding-content">

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="Logo SIKLASTER PKM Sawah Lega"
                class="logo-login"
            >

            <h1 class="brand-title">
                SIKLASTER
            </h1>

            <div class="brand-subtitle">
                PKM SAWAH LEGA
            </div>

            <div class="brand-line"></div>

            <p class="brand-description">
                Sistem Pengelolaan Dokumen Klaster
                Puskesmas Sawah Lega.
                Kelola dokumen dengan lebih terstruktur,
                aman, dan mudah dipantau.
            </p>

        </div>


        <div class="feature-grid">

            <div class="feature-item">

                <div class="feature-icon">
                    📁
                </div>

                <div class="feature-title">
                    Dokumen Terstruktur
                </div>

                <div class="feature-text">
                    Pengelolaan dokumen berdasarkan
                    klaster dan program.
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    🛡️
                </div>

                <div class="feature-title">
                    Aman & Terpantau
                </div>

                <div class="feature-text">
                    Hak akses pengguna dan
                    riwayat dokumen tercatat.
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    ✅
                </div>

                <div class="feature-title">
                    Verifikasi Dokumen
                </div>

                <div class="feature-text">
                    Proses pemeriksaan dan
                    perbaikan dokumen lebih jelas.
                </div>

            </div>


            <div class="feature-item">

                <div class="feature-icon">
                    🔔
                </div>

                <div class="feature-title">
                    Notifikasi
                </div>

                <div class="feature-text">
                    Pengguna mendapat informasi
                    status dokumen secara langsung.
                </div>

            </div>

        </div>

    </section>


    {{-- =========================
         LOGIN
    ========================= --}}

    <section class="login-panel">

        <div class="login-card">

            <div class="lock-icon">
                🔐
            </div>

            <h2 class="login-title">
                Selamat Datang Kembali!
            </h2>

            <p class="login-subtitle">
                Silakan masuk untuk melanjutkan ke SIKLASTER
            </p>

            <div class="divider"></div>


            {{-- SESSION STATUS --}}

            @if(session('status'))

                <div class="session-status">
                    {{ session('status') }}
                </div>

            @endif


            {{-- ERROR LOGIN --}}

            @if($errors->any())

                <div class="error-box">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login') }}"
            >

                @csrf


                {{-- EMAIL --}}

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            ✉
                        </span>

                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                            autofocus
                            autocomplete="username"
                        >

                    </div>

                </div>


                {{-- PASSWORD --}}

                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔑
                        </span>

                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="toggle-password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                </div>


                {{-- OPTIONS --}}

                <div class="login-options">

                    <label
                        for="remember_me"
                        class="remember-box"
                    >

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                        >

                        <span>
                            Ingat saya
                        </span>

                    </label>


                    @if(Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-link"
                        >
                            Lupa password?
                        </a>

                    @endif

                </div>


                {{-- LOGIN BUTTON --}}

                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk
                </button>

            </form>


            {{-- REGISTER --}}

            @if(Route::has('register'))

                <div class="register-section">

                    <p class="register-text">
                        Belum memiliki akun SIKLASTER?
                    </p>

                    <a
                        href="{{ route('register') }}"
                        class="register-link"
                    >
                        Daftar Akun Karyawan
                    </a>

                </div>

            @endif


            <div class="security-note">
                🔒 Khusus karyawan PKM Sawah Lega.
                Silakan daftarkan akun masing-masing
                untuk menggunakan SIKLASTER.
            </div>


            <div class="login-footer">

                <div>
                    &copy; {{ date('Y') }}
                    SIKLASTER PKM Sawah Lega
                </div>

                <div>
                    Powered By
                    <strong>
                        IT Puskesmas Sawah Lega
                    </strong>
                </div>

            </div>

        </div>

    </section>

</div>


<script>
    const passwordInput =
        document.getElementById('password');

    const togglePassword =
        document.getElementById('toggle-password');


    if (passwordInput && togglePassword) {

        togglePassword.addEventListener(
            'click',
            function () {

                const isPassword =
                    passwordInput.type === 'password';

                passwordInput.type =
                    isPassword
                        ? 'text'
                        : 'password';

                togglePassword.textContent =
                    isPassword
                        ? '🙈'
                        : '👁';

                togglePassword.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Sembunyikan password'
                        : 'Tampilkan password'
                );
            }
        );
    }
</script>

</body>

</html>