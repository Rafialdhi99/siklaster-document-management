<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIKLASTER | PKM Sawah Lega</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        :root {
            --blue: #075985;
            --cyan: #0ea5a4;
            --green: #22c55e;
            --green-dark: #15803d;
            --bg: #f3f9f8;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: var(--bg);
            color: #1f2937;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;

            width: 240px;
            height: 100vh;

            padding: 25px 12px;

            background: linear-gradient(
                180deg,
                #075985 0%,
                #087f8c 48%,
                #15803d 100%
            );

            color: white;

            overflow-y: auto;

            z-index: 1000;

            transition: transform 0.28s ease, width 0.28s ease;
        }

        .logo {
            padding: 0 10px 25px;

            border-bottom:
                1px solid rgba(255,255,255,0.15);

            margin-bottom: 20px;

            text-align: center;
        }

        .logo-image {
            width: 105px;
            height: 105px;

            object-fit: contain;

            display: block;

            margin: 0 auto 15px;
        }

        .logo h2 {
            margin: 0;

            font-size: 23px;

            letter-spacing: 1px;
        }

        .logo p {
            margin: 6px 0 0;

            font-size: 12px;

            color: #d9f3ee;
        }

        .menu-title {
            font-size: 11px;

            color: #bfe8df;

            padding: 0 15px;

            margin-bottom: 8px;

            text-transform: uppercase;

            letter-spacing: 1px;
        }

        .menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;

            color: #e2f3f2;

            text-decoration: none;

            padding: 13px 15px;

            margin-bottom: 5px;

            border-radius: 8px;

            transition: 0.2s;
        }

        .menu a:hover {
            background: rgba(255,255,255,0.12);

            color: white;
        }

        .menu a.active {
            background: linear-gradient(
                90deg,
                #0ea5a4,
                #22c55e
            );

            color: white;

            box-shadow:
                0 4px 12px
                rgba(0,0,0,0.15);
        }

        .menu-icon {
            width: 24px;

            display: inline-block;

            text-align: center;

            margin-right: 4px;
        }


        /* =========================
           SIDEBAR TOGGLE
        ========================= */

        .sidebar-toggle {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 10px;
            background: #e0f2fe;
            color: #075985;
            cursor: pointer;
            font-size: 23px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: 0.2s;
        }

        .sidebar-toggle:hover {
            background: #bae6fd;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .sidebar-overlay {
            display: none;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.sidebar-collapsed .main,
        body.sidebar-collapsed .app-footer {
            margin-left: 0;
        }


        /* =========================
           BADGE
        ========================= */

        .badge-verifikasi,
        .badge-notifikasi {
            background: #ef4444;
            color: white;

            min-width: 22px;
            height: 22px;

            padding: 0 6px;

            border-radius: 999px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            font-size: 12px;
            font-weight: bold;
        }


        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 240px;

            min-height: calc(100vh - 55px);

            transition: margin-left 0.28s ease;
        }

        .topbar {
            height: 75px;

            background: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 35px;

            border-bottom:
                1px solid #e5e7eb;

            box-shadow:
                0 2px 10px
                rgba(7,89,133,0.05);
        }

        .topbar h1 {
            margin: 0;

            font-size: 22px;
        }

        .content {
            padding: 30px 35px;
        }


        /* =========================
           FOOTER
        ========================= */

        .app-footer {
            margin-left: 240px;

            transition: margin-left 0.28s ease;

            padding: 18px 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            font-size: 12px;

            color: #64748b;

            border-top:
                1px solid #dcebea;

            background:
                rgba(255,255,255,0.45);
        }

        .app-footer strong {
            font-weight: 800;

            background: linear-gradient(
                90deg,
                #0b75bc,
                #0ea5a4,
                #22c55e
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            background-clip: text;
        }

        .footer-separator {
            color: #22c55e;

            font-weight: bold;
        }


        /* =========================
           GLOBAL LOADER
        ========================= */

        #global-loader {
            position: fixed;
            inset: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                rgba(255,255,255,0.94);

            backdrop-filter: blur(3px);

            opacity: 0;
            visibility: hidden;

            transition:
                opacity 0.25s ease,
                visibility 0.25s ease;

            z-index: 99999;
        }

        #global-loader.show {
            opacity: 1;
            visibility: visible;
        }

        .loader-box {
            text-align: center;
        }

        .loader-logo-wrap {
            position: relative;

            width: 120px;
            height: 120px;

            margin:
                0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-ring {
            position: absolute;

            inset: 0;

            border:
                5px solid #dbeafe;

            border-top-color:
                #0b75bc;

            border-right-color:
                #0ea5a4;

            border-bottom-color:
                #22c55e;

            border-radius: 50%;

            animation:
                loaderSpin
                0.9s linear infinite;
        }

        .loader-logo {
            width: 85px;
            height: 85px;

            object-fit: contain;

            animation:
                logoPulse
                1.3s ease-in-out infinite;
        }

        .loader-title {
            font-size: 15px;

            font-weight: 800;

            letter-spacing: 0.3px;

            background: linear-gradient(
                90deg,
                #0b75bc,
                #0ea5a4,
                #22c55e
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            background-clip: text;
        }

        .loader-subtitle {
            margin-top: 5px;

            font-size: 11px;

            color: #64748b;
        }

        .loader-progress {
            position: relative;

            width: 180px;
            height: 4px;

            margin:
                16px auto 0;

            overflow: hidden;

            border-radius: 999px;

            background: #e2e8f0;
        }

        .loader-progress::after {
            content: '';

            position: absolute;

            top: 0;
            bottom: 0;

            width: 45%;

            border-radius: 999px;

            background: linear-gradient(
                90deg,
                #0b75bc,
                #0ea5a4,
                #22c55e
            );

            animation:
                progressMove
                1s ease-in-out infinite;
        }


        @keyframes loaderSpin {

            from {
                transform:
                    rotate(0deg);
            }

            to {
                transform:
                    rotate(360deg);
            }
        }


        @keyframes logoPulse {

            0%,
            100% {
                transform:
                    scale(0.97);
            }

            50% {
                transform:
                    scale(1.04);
            }
        }


        @keyframes progressMove {

            from {
                left: -50%;
            }

            to {
                left: 110%;
            }
        }


        /* =========================
           PAGE FADE
        ========================= */

        .page-fade {
            animation:
                pageFadeIn
                0.35s ease;
        }

        @keyframes pageFadeIn {

            from {
                opacity: 0.35;

                transform:
                    translateY(3px);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0);
            }
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 190px;
            }

            .main {
                margin-left: 190px;
            }

            .app-footer {
                margin-left: 190px;
            }

            body.sidebar-collapsed .main,
            body.sidebar-collapsed .app-footer {
                margin-left: 0;
            }
        }


        @media (max-width: 650px) {

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 260px;
                max-width: 85vw;
                height: 100vh;
                transform: translateX(-100%);
                box-shadow: 10px 0 30px rgba(15, 23, 42, 0.25);
            }

            body.sidebar-mobile-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.25s ease, visibility 0.25s ease;
                z-index: 999;
            }

            body.sidebar-mobile-open .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }

            .main,
            body.sidebar-collapsed .main {
                margin-left: 0;
            }

            .app-footer,
            body.sidebar-collapsed .app-footer {
                margin-left: 0;
                flex-wrap: wrap;
                text-align: center;
            }

            .content {
                padding: 20px;
            }

            .topbar {
                padding: 0 15px;
            }

            .topbar h1 {
                font-size: 18px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .sidebar-toggle {
                width: 38px;
                height: 38px;
                font-size: 21px;
            }
        }

        


    </style>

    @stack('styles')

</head>


<body>


{{-- =========================
     GLOBAL LOADER
========================= --}}

<div id="global-loader">

    <div class="loader-box">

        <div class="loader-logo-wrap">

            <div class="loader-ring"></div>

            <img
                src="{{ asset('storage/images/d.png') }}"
                alt="SIKLASTER"
                class="loader-logo"
            >

        </div>

    </div>

</div>



{{-- =========================
     SIDEBAR
========================= --}}

<aside class="sidebar" id="appSidebar">

    <div class="logo">

        <img
            src="{{ asset('storage/images/d.png') }}"
            alt="Logo Puskesmas Sawah Lega"
            class="logo-image"
        >

        <h2>
            SIKLASTER
        </h2>

        <p>
            PKM SAWAH LEGA
        </p>

    </div>


    <div class="menu-title">
        Menu Utama
    </div>


    @php

        $jumlahNotifikasiBelumDibaca = 0;

        if (auth()->check()) {

            $jumlahNotifikasiBelumDibaca =
                \App\Models\Notifikasi::where(
                    'user_id',
                    auth()->id()
                )
                ->where(
                    'dibaca',
                    false
                )
                ->count();
        }

    @endphp


    <nav class="menu">


        {{-- DASHBOARD --}}

<a
    href="{{ url('/dashboard') }}"
    class="{{ request()->is('dashboard') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            🏠
        </span>

        Dashboard
    </span>
</a>


{{-- DOKUMEN --}}

<a
    href="{{ url('/dokumens') }}"
    class="{{ request()->is('dokumens') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            📁
        </span>

        Dokumen
    </span>
</a>


{{-- ARSIP DOKUMEN --}}

<a
    href="{{ route('arsip.index') }}"
    class="{{ request()->is('arsip*') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            🗄️
        </span>

        Arsip Dokumen
    </span>
</a>


{{-- UPLOAD DOKUMEN --}}

<a
    href="{{ url('/dokumens/upload') }}"
    class="{{ request()->is('dokumens/upload') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            ⬆️
        </span>

        Upload Dokumen
    </span>
</a>


{{-- NOTIFIKASI --}}

<a
    href="{{ route('notifikasi.index') }}"
    class="{{ request()->is('notifikasi*') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            🔔
        </span>

        Notifikasi
    </span>

    @if($jumlahNotifikasiBelumDibaca > 0)

        <span class="badge-notifikasi">
            {{ $jumlahNotifikasiBelumDibaca }}
        </span>

    @endif
</a>


{{-- PROFIL SAYA --}}

<a
    href="{{ route('profile.edit') }}"
    class="{{ request()->is('profile') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            👤
        </span>

        Profil Saya
    </span>
</a>



        {{-- =========================
             KHUSUS ADMIN
        ========================= --}}

        @if(auth()->user()->role === 'admin')


            {{-- VERIFIKASI --}}

            <a
                href="{{ url('/verifikasi') }}"
                class="{{ request()->is('verifikasi*') ? 'active' : '' }}"
            >

                <span>

                    <span class="menu-icon">
                        ✅
                    </span>

                    Verifikasi Dokumen

                </span>


                @if(
                    isset($jumlahMenungguVerifikasi)
                    &&
                    $jumlahMenungguVerifikasi > 0
                )

                    <span class="badge-verifikasi">

                        {{ $jumlahMenungguVerifikasi }}

                    </span>

                @endif

            </a>



            {{-- PENGGUNA --}}

<a
    href="{{ url('/users') }}"
    class="{{ request()->is('users*') ? 'active' : '' }}"
>

    <span>

        <span class="menu-icon">
            👥
        </span>

        Pengguna

    </span>

</a>


{{-- BACKUP DATA --}}

<a
    href="{{ route('backup.index') }}"
    class="{{ request()->is('backup*') ? 'active' : '' }}"
>

    <span>

        <span class="menu-icon">
            💾
        </span>

        Backup Data

    </span>

</a>

{{-- AUDIT TRAIL --}}

<a
    href="{{ route('activity-logs.index') }}"
    class="{{ request()->is('activity-logs*') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            📋
        </span>

        Audit Trail
    </span>
</a>


{{-- SAMPAH DOKUMEN --}}

<a
    href="{{ route('dokumens.sampah') }}"
    class="{{ request()->is('dokumens-sampah*') ? 'active' : '' }}"
>
    <span>
        <span class="menu-icon">
            🗑️
        </span>

        Sampah Dokumen
    </span>
</a>


@endif

    </nav>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>



{{-- =========================
     MAIN
========================= --}}

<main class="main">

    <header class="topbar">

        <div class="topbar-left">

            <button
                type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Buka atau tutup sidebar"
                title="Buka / Tutup Menu"
            >
                ☰
            </button>

            <h1>
                @yield('page-title', 'SIKLASTER')
            </h1>

        </div>


        <div style="
            display:flex;
            align-items:center;
            gap:15px;
        ">


            {{-- USER INFO --}}

            <div style="
                text-align:right;
                line-height:1.3;
            ">

                <div style="
                    font-size:14px;
                    font-weight:bold;
                    color:#075985;
                ">

                    {{ auth()->user()->name }}

                </div>


                <div style="
                    font-size:11px;
                    color:#64748b;
                    text-transform:uppercase;
                ">

                    {{ auth()->user()->role }}

                </div>

            </div>



            {{-- LOGOUT --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
                style="margin:0;"
            >

                @csrf

                <button
                    type="submit"
                    style="
                        background:#dc2626;
                        color:white;
                        border:none;
                        padding:9px 14px;
                        border-radius:6px;
                        font-size:12px;
                        font-weight:bold;
                        cursor:pointer;
                    "
                >
                    Logout
                </button>

            </form>

        </div>

    </header>



    {{-- CONTENT --}}

    <section
        class="content page-fade"
        id="page-content"
    >

        @yield('content')

    </section>

</main>



{{-- =========================
     FOOTER
========================= --}}

<footer class="app-footer">

    <span>

        &copy; {{ date('Y') }}
        SIKLASTER PKM Sawah Lega

    </span>


    <span class="footer-separator">
        &bull;
    </span>


    <span>

        Powered By

        <strong>
            IT Puskesmas Sawah Lega
        </strong>

    </span>

</footer>



@stack('scripts')


<script>
document.addEventListener('DOMContentLoaded', function () {

    const loader = document.getElementById('global-loader');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR TOGGLE
    |--------------------------------------------------------------------------
    */

    function isMobileSidebar() {
        return window.innerWidth <= 650;
    }

    function applySavedSidebarState() {

        if (isMobileSidebar()) {
            document.body.classList.remove('sidebar-collapsed');
            document.body.classList.remove('sidebar-mobile-open');
            return;
        }

        const collapsed =
            localStorage.getItem('siklaster-sidebar-collapsed') === '1';

        document.body.classList.toggle(
            'sidebar-collapsed',
            collapsed
        );
    }

    function toggleSidebar() {

        if (isMobileSidebar()) {
            document.body.classList.toggle('sidebar-mobile-open');
            return;
        }

        document.body.classList.toggle('sidebar-collapsed');

        localStorage.setItem(
            'siklaster-sidebar-collapsed',
            document.body.classList.contains('sidebar-collapsed') ? '1' : '0'
        );
    }

    function closeMobileSidebar() {
        document.body.classList.remove('sidebar-mobile-open');
    }

    applySavedSidebarState();

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    window.addEventListener('resize', function () {

        if (isMobileSidebar()) {
            document.body.classList.remove('sidebar-collapsed');
        } else {
            document.body.classList.remove('sidebar-mobile-open');
            applySavedSidebarState();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | GLOBAL LOADER
    |--------------------------------------------------------------------------
    */

    if (!loader) {
        return;
    }

    function showLoader() {
        loader.classList.add('show');
    }

    function hideLoader() {
        loader.classList.remove('show');
    }

    window.addEventListener('load', hideLoader);
    window.addEventListener('pageshow', hideLoader);


    /*
    |--------------------------------------------------------------------------
    | LINK / MENU
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        const link = event.target.closest('a');

        if (!link) {
            return;
        }

        const href = link.getAttribute('href');

        if (
            !href ||
            href === '#' ||
            href.startsWith('#') ||
            href.startsWith('javascript:') ||
            link.target === '_blank' ||
            link.hasAttribute('download') ||
            href.includes('/download')
        ) {
            return;
        }

        if (isMobileSidebar()) {
            closeMobileSidebar();
        }

        showLoader();
    });


    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    document.addEventListener('submit', function () {
        showLoader();
    });

});
</script>


</body>

</html>