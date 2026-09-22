<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | SIKLASTER PKM Sawah Lega</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6f9;
            color: #1f2937;
            min-height: 100vh;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
        }

        .brand-panel {
            background:
                linear-gradient(
                    135deg,
                    rgba(6, 95, 70, 0.96),
                    rgba(16, 185, 129, 0.88)
                );
            color: white;
            padding: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }

        .brand-panel::before {
            width: 320px;
            height: 320px;
            top: -110px;
            right: -110px;
        }

        .brand-panel::after {
            width: 240px;
            height: 240px;
            bottom: -90px;
            left: -90px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: rgba(255,255,255,0.96);
            border-radius: 22px;
            padding: 10px;
            margin-bottom: 28px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.16);
        }

        .brand-title {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .brand-subtitle {
            font-size: 21px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .brand-description {
            font-size: 15px;
            line-height: 1.8;
            color: rgba(255,255,255,0.9);
        }

        .form-panel {
            padding: 40px 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 470px;
            background: white;
            border-radius: 22px;
            padding: 36px;
            box-shadow: 0 20px 55px rgba(15,23,42,0.10);
            border: 1px solid #e5e7eb;
        }

        .mobile-logo {
            display: none;
            width: 78px;
            height: 78px;
            object-fit: contain;
            margin: 0 auto 18px;
        }

        .heading {
            text-align: center;
            margin-bottom: 26px;
        }

        .heading h1 {
            font-size: 29px;
            color: #111827;
            margin-bottom: 9px;
        }

        .heading p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 11px;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
            background: white;
        }

        input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.10);
        }

        input[readonly] {
            background: #f8fafc;
            color: #475569;
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 13px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 18px;
            padding: 4px;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 10px;
            padding: 11px 13px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.5;
        }

        .field-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
        }

        .hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
            line-height: 1.5;
        }

        .btn {
            width: 100%;
            border: 0;
            border-radius: 11px;
            padding: 13px 16px;
            background: #047857;
            color: white;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 5px;
        }

        .btn:hover {
            background: #065f46;
            transform: translateY(-1px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #047857;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .footer-note {
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
            margin-top: 24px;
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 24px 16px;
            }

            .mobile-logo {
                display: block;
            }

            .card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <section class="brand-panel">
        <div class="brand-content">

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="Logo PKM Sawah Lega"
                class="brand-logo"
            >

            <div class="brand-title">
                SIKLASTER
            </div>

            <div class="brand-subtitle">
                PKM Sawah Lega
            </div>

            <div class="brand-description">
                Sistem Informasi Klaster untuk pengelolaan,
                penyimpanan, verifikasi, dan pengarsipan
                dokumen secara terpusat.
            </div>

        </div>
    </section>

    <section class="form-panel">

        <div class="card">

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="Logo"
                class="mobile-logo"
            >

            <div class="heading">
                <h1>Buat Password Baru</h1>

                <p>
                    Masukkan password baru untuk akun SIKLASTER Anda.
                </p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Periksa kembali data berikut:</strong>

                    <ul style="margin: 7px 0 0 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('password.store') }}"
            >

                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $request->route('token') }}"
                >

                <div class="form-group">
                    <label for="email">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autocomplete="username"
                        readonly
                    >

                    @error('email')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        Password Baru
                    </label>

                    <div class="password-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('password', this)"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>
                    </div>

                    <div class="hint">
                        Gunakan password yang mudah Anda ingat
                        tetapi tidak mudah ditebak.
                    </div>

                    @error('password')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Konfirmasi Password Baru
                    </label>

                    <div class="password-wrap">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('password_confirmation', this)"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>
                    </div>

                    @error('password_confirmation')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn"
                >
                    Simpan Password Baru
                </button>

            </form>

            <a
                href="{{ route('login') }}"
                class="back-link"
            >
                ← Kembali ke halaman login
            </a>

            <div class="footer-note">
                SIKLASTER PKM Sawah Lega
            </div>

        </div>

    </section>

</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '🙈';
        } else {
            input.type = 'password';
            button.textContent = '👁';
        }
    }
</script>

</body>
</html>