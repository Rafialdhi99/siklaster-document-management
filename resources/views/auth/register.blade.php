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

    <title>Daftar Akun - SIKLASTER</title>

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

        .register-page {
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

        .logo-register {
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

        .steps {
            position: relative;
            z-index: 2;

            margin-top: 35px;

            display: grid;
            gap: 12px;
        }

        .step-item {
            display: flex;
            align-items: center;

            gap: 14px;

            padding: 14px 16px;

            border-radius: 12px;

            background:
                rgba(255,255,255,0.10);

            border:
                1px solid
                rgba(255,255,255,0.12);
        }

        .step-number {
            width: 34px;
            height: 34px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: rgba(255,255,255,0.16);

            font-weight: bold;
        }

        .step-title {
            font-size: 13px;
            font-weight: bold;

            margin-bottom: 3px;
        }

        .step-text {
            font-size: 11px;
            line-height: 1.4;

            color: #dff6f3;
        }

        /* =========================
           FORM REGISTER
        ========================= */

        .form-panel {
            padding: 45px 55px;

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

        .register-card {
            width: 100%;
            max-width: 480px;

            margin: 0 auto;
        }

        .register-icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 18px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;

            border: 1px solid #5eead4;

            background: #f0fdfa;
        }

        .register-title {
            margin: 0;

            text-align: center;

            font-size: 30px;

            color: #172033;
        }

        .register-subtitle {
            margin: 10px 0 24px;

            text-align: center;

            color: #64748b;

            font-size: 14px;

            line-height: 1.5;
        }

        .divider {
            height: 1px;

            background: #e5e7eb;

            margin-bottom: 24px;
        }

        .error-box {
            margin-bottom: 18px;

            padding: 12px 14px;

            border-radius: 8px;

            background: #fee2e2;

            color: #991b1b;

            font-size: 12px;

            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;

            margin-bottom: 7px;

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

            transform: translateY(-50%);

            font-size: 16px;

            color: #64748b;

            pointer-events: none;
        }

        .form-input {
            width: 100%;
            height: 50px;

            padding: 0 45px;

            border: 1px solid #cbd5e1;

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

            transform: translateY(-50%);

            border: none;

            background: transparent;

            cursor: pointer;

            font-size: 15px;

            color: #64748b;

            padding: 5px;
        }

        .register-button {
            width: 100%;
            height: 52px;

            margin-top: 5px;

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

            transition: 0.2s;
        }

        .register-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 12px 24px
                rgba(14,165,164,0.24);
        }

        .login-section {
            margin-top: 18px;

            text-align: center;
        }

        .login-text {
            margin: 0 0 10px;

            font-size: 13px;

            color: #64748b;
        }

        .login-link {
            width: 100%;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            text-decoration: none;

            font-size: 14px;
            font-weight: bold;

            color: #0f766e;

            background: #f0fdfa;

            border: 1px solid #5eead4;

            transition: 0.2s;
        }

        .login-link:hover {
            background: #ccfbf1;

            border-color: #2dd4bf;
        }

        .security-note {
            margin-top: 16px;

            padding: 11px;

            border-radius: 8px;

            text-align: center;

            background: #f8fafc;

            color: #64748b;

            font-size: 11px;
            line-height: 1.5;

            border: 1px solid #e5e7eb;
        }

        .register-footer {
            margin-top: 22px;

            text-align: center;

            font-size: 11px;

            color: #64748b;
        }

        .register-footer div + div {
            margin-top: 6px;
        }

        .register-footer strong {
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

        @media (max-width: 900px) {

            body {
                padding: 0;
            }

            .register-page {
                min-height: 100vh;

                border-radius: 0;

                grid-template-columns: 1fr;
            }

            .branding-panel {
                padding: 35px 30px;
            }

            .logo-register {
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

            .steps {
                display: none;
            }

            .form-panel {
                padding: 40px 25px;
            }
        }

        @media (max-width: 500px) {

            .brand-title {
                font-size: 30px;
                letter-spacing: 4px;
            }
        }
    </style>

</head>

<body>

<div class="register-page">

    {{-- BRANDING --}}

    <section class="branding-panel">

        <div class="branding-content">

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="Logo SIKLASTER PKM Sawah Lega"
                class="logo-register"
            >

            <h1 class="brand-title">
                SIKLASTER
            </h1>

            <div class="brand-subtitle">
                PKM SAWAH LEGA
            </div>

            <div class="brand-line"></div>

            <p class="brand-description">
                Daftarkan akun karyawan untuk mengakses
                Sistem Pengelolaan Dokumen Klaster
                Puskesmas Sawah Lega.
            </p>

        </div>


        <div class="steps">

            <div class="step-item">

                <div class="step-number">
                    1
                </div>

                <div>
                    <div class="step-title">
                        Daftar Akun
                    </div>

                    <div class="step-text">
                        Masukkan nama, email, dan password Anda.
                    </div>
                </div>

            </div>


            <div class="step-item">

                <div class="step-number">
                    2
                </div>

                <div>
                    <div class="step-title">
                        Pilih Penugasan
                    </div>

                    <div class="step-text">
                        Pilih satu atau beberapa program
                        yang menjadi tanggung jawab Anda.
                    </div>
                </div>

            </div>


            <div class="step-item">

                <div class="step-number">
                    3
                </div>

                <div>
                    <div class="step-title">
                        Gunakan SIKLASTER
                    </div>

                    <div class="step-text">
                        Setelah penugasan disimpan,
                        Anda dapat mulai mengelola dokumen.
                    </div>
                </div>

            </div>

        </div>

    </section>


    {{-- REGISTER FORM --}}

    <section class="form-panel">

        <div class="register-card">

            <div class="register-icon">
                👤
            </div>

            <h2 class="register-title">
                Daftar Akun Karyawan
            </h2>

            <p class="register-subtitle">
                Buat akun SIKLASTER menggunakan
                data Anda sendiri.
            </p>

            <div class="divider"></div>


            @if($errors->any())

                <div class="error-box">

                    <strong>
                        Pendaftaran belum berhasil:
                    </strong>

                    @foreach($errors->all() as $error)

                        <div>
                            • {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('register') }}"
            >

                @csrf


                {{-- NAMA --}}

                <div class="form-group">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Nama Lengkap
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            👤
                        </span>

                        <input
                            id="name"
                            class="form-input"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                            autocomplete="name"
                        >

                    </div>

                </div>


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
                            placeholder="Masukkan email aktif"
                            required
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
                            placeholder="Buat password"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-target="password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                </div>


                {{-- KONFIRMASI PASSWORD --}}

                <div class="form-group">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Konfirmasi Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔐
                        </span>

                        <input
                            id="password_confirmation"
                            class="form-input"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-target="password_confirmation"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                </div>


                <button
                    type="submit"
                    class="register-button"
                >
                    Daftar & Lanjutkan
                </button>

            </form>


            <div class="login-section">

                <p class="login-text">
                    Sudah memiliki akun SIKLASTER?
                </p>

                <a
                    href="{{ route('login') }}"
                    class="login-link"
                >
                    Kembali ke Login
                </a>

            </div>


            <div class="security-note">
                🔒 Akun yang dibuat melalui halaman ini
                otomatis terdaftar sebagai pengguna biasa.
                Hak administrator tidak dapat dipilih
                melalui pendaftaran.
            </div>


            <div class="register-footer">

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
    const toggleButtons =
        document.querySelectorAll('.password-toggle');

    toggleButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId =
                button.getAttribute('data-target');

            const input =
                document.getElementById(targetId);

            if (!input) {
                return;
            }

            const isPassword =
                input.type === 'password';

            input.type =
                isPassword
                    ? 'text'
                    : 'password';

            button.textContent =
                isPassword
                    ? '🙈'
                    : '👁';

            button.setAttribute(
                'aria-label',
                isPassword
                    ? 'Sembunyikan password'
                    : 'Tampilkan password'
            );
        });
    });
</script>

</body>

</html>