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

    <title>Lupa Password | SIKLASTER</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('favicon.png') }}"
    >

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

        .reset-page {
            width: 100%;
            max-width: 1150px;
            min-height: 650px;

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

            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;

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

            text-align: center;
        }

        .logo-reset {
            width: 135px;
            height: 135px;

            object-fit: contain;

            display: block;

            margin: 0 auto 25px;

            filter:
                drop-shadow(
                    0 8px 20px
                    rgba(0,0,0,0.15)
                );
        }

        .brand-title {
            margin: 0;

            font-size: 44px;

            letter-spacing: 5px;

            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 12px;

            font-size: 20px;

            letter-spacing: 3px;

            font-weight: bold;

            color: #b9ef72;
        }

        .brand-line {
            width: 100px;
            height: 3px;

            margin: 26px auto;

            border-radius: 20px;

            background:
                linear-gradient(
                    90deg,
                    #22d3ee,
                    #bef264
                );
        }

        .brand-description {
            max-width: 430px;

            margin: 0 auto;

            font-size: 16px;
            line-height: 1.7;

            color: #ecfeff;
        }

        /* =========================
           FORM
        ========================= */

        .form-panel {
            padding: 55px;

            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fbfefe
                );
        }

        .form-card {
            width: 100%;
            max-width: 460px;

            margin: 0 auto;
        }

        .icon-circle {
            width: 68px;
            height: 68px;

            margin: 0 auto 22px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 29px;

            background: #f0fdfa;

            color: #0f9f89;

            border:
                1px solid
                #5eead4;
        }

        .form-title {
            margin: 0;

            text-align: center;

            font-size: 29px;

            color: #172033;
        }

        .form-subtitle {
            margin: 12px 0 28px;

            text-align: center;

            color: #64748b;

            font-size: 14px;

            line-height: 1.6;
        }

        .divider {
            height: 1px;

            background: #e5e7eb;

            margin-bottom: 25px;
        }

        .session-status {
            margin-bottom: 18px;

            padding: 13px 15px;

            border-radius: 9px;

            background: #dcfce7;

            color: #166534;

            font-size: 13px;

            line-height: 1.5;
        }

        .error-box {
            margin-bottom: 18px;

            padding: 13px 15px;

            border-radius: 9px;

            background: #fee2e2;

            color: #991b1b;

            font-size: 13px;
        }

        .form-group {
            margin-bottom: 22px;
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

            padding: 0 15px 0 45px;

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

        .reset-button {
            width: 100%;
            height: 52px;

            border: none;

            border-radius: 9px;

            cursor: pointer;

            font-size: 15px;
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

        .reset-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 12px 24px
                rgba(14,165,164,0.24);
        }

        .back-login {
            margin-top: 22px;

            text-align: center;
        }

        .back-login a {
            color: #0284c7;

            font-size: 13px;

            text-decoration: none;

            font-weight: bold;
        }

        .back-login a:hover {
            text-decoration: underline;
        }

        .security-note {
            margin-top: 22px;

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

        .footer {
            margin-top: 25px;

            text-align: center;

            font-size: 11px;

            color: #64748b;
        }

        .footer strong {
            color: #0f766e;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            body {
                padding: 0;
            }

            .reset-page {
                min-height: 100vh;

                border-radius: 0;

                grid-template-columns: 1fr;
            }

            .branding-panel {
                padding:
                    35px 25px;
            }

            .logo-reset {
                width: 95px;
                height: 95px;

                margin-bottom: 16px;
            }

            .brand-title {
                font-size: 34px;
            }

            .brand-subtitle {
                font-size: 16px;
            }

            .brand-description {
                font-size: 14px;
            }

            .form-panel {
                padding:
                    40px 25px;
            }
        }
    </style>
</head>

<body>

<div class="reset-page">

    {{-- =========================
         BRANDING
    ========================= --}}

    <section class="branding-panel">

        <div class="branding-content">

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="Logo SIKLASTER PKM Sawah Lega"
                class="logo-reset"
            >

            <h1 class="brand-title">
                SIKLASTER
            </h1>

            <div class="brand-subtitle">
                PKM SAWAH LEGA
            </div>

            <div class="brand-line"></div>

            <p class="brand-description">
                Pemulihan akses akun SIKLASTER.
                Masukkan email yang terdaftar untuk
                mendapatkan tautan pembuatan password baru.
            </p>

        </div>

    </section>


    {{-- =========================
         RESET PASSWORD
    ========================= --}}

    <section class="form-panel">

        <div class="form-card">

            <div class="icon-circle">
                🔑
            </div>

            <h2 class="form-title">
                Lupa Password?
            </h2>

            <p class="form-subtitle">
                Masukkan alamat email akun SIKLASTER Anda.
                Sistem akan mengirimkan tautan untuk
                membuat password baru.
            </p>

            <div class="divider"></div>


            {{-- SESSION STATUS --}}

            @if(session('status'))

                <div class="session-status">
                    {{ session('status') }}
                </div>

            @endif


            {{-- ERROR --}}

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
                action="{{ route('password.email') }}"
            >

                @csrf


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
                            autocomplete="email"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="reset-button"
                >
                    Kirim Link Reset Password
                </button>

            </form>


            <div class="back-login">

                <a href="{{ route('login') }}">
                    ← Kembali ke halaman Login
                </a>

            </div>


            <div class="security-note">
                🔒 Tautan reset password hanya dikirim
                ke email yang terdaftar pada akun SIKLASTER.
            </div>


            <div class="footer">

                &copy; {{ date('Y') }}
                SIKLASTER PKM Sawah Lega

                <br><br>

                Powered By
                <strong>
                    IT Puskesmas Sawah Lega
                </strong>

            </div>

        </div>

    </section>

</div>

</body>
</html>