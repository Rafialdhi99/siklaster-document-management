<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'SIKLASTER')
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {

            position: fixed;

            left: 0;
            top: 0;

            width: 240px;
            height: 100vh;

            background: #172033;

            color: white;

            padding: 25px 15px;

        }


        .logo {

            padding: 0 10px 25px;

            border-bottom:
                1px solid rgba(255,255,255,0.1);

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

            color: #aeb8ca;

        }


        .menu-title {

            font-size: 11px;

            color: #7f8aa0;

            padding: 0 15px;

            margin-bottom: 8px;

            text-transform: uppercase;

            letter-spacing: 1px;

        }


        .menu a {

            display: flex;

            align-items: center;

            justify-content: space-between;

            color: #cbd5e1;

            text-decoration: none;

            padding: 13px 15px;

            margin-bottom: 5px;

            border-radius: 8px;

            transition: 0.2s;

        }


        .menu a:hover,
        .menu a.active {

            background: #2563eb;

            color: white;

        }


        /* =========================
   BADGE NOTIFIKASI
========================= */

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

            min-height: 100vh;

        }


        .topbar {

            background: white;

            height: 75px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 35px;

            border-bottom:
                1px solid #e5e7eb;

        }


        .topbar h1 {

            margin: 0;

            font-size: 22px;

        }


        .topbar span {

            color: #6b7280;

            font-size: 14px;

        }


        .content {

            padding: 30px 35px;

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

        }


        @media (max-width: 650px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;

            }

            .main {

                margin-left: 0;

            }

            .content {

                padding: 20px;

            }

            .topbar {

                padding: 0 20px;

            }

        }

    </style>

    @stack('styles')

</head>


<body>


    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">


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


            <a href="{{ url('/dashboard') }}">

                <span>
                    🏠 Dashboard
                </span>

            </a>


            <a href="{{ url('/dokumens') }}">

                <span>
                    📁 Dokumen
                </span>

            </a>


            <a href="{{ url('/dokumens/upload') }}">

                <span>
                    ⬆️ Upload Dokumen
                </span>

            </a>


            <a href="{{ url('/verifikasi') }}">

                <span>
                    ✅ Verifikasi Dokumen
                </span>


                @if(isset($jumlahMenungguVerifikasi) && $jumlahMenungguVerifikasi > 0)

                    <span class="badge-verifikasi">

                        {{ $jumlahMenungguVerifikasi }}

                    </span>

                @endif


            </a>


        </nav>


    </aside>



    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <main class="main">


        <header class="topbar">


            <h1>

                @yield('page-title', 'SIKLASTER')

            </h1>


            <span>

                Sistem Pengelolaan Dokumen Klaster

            </span>


        </header>



        <section class="content">


            @yield('content')


        </section>


    </main>


    @stack('scripts')


</body>

</html>