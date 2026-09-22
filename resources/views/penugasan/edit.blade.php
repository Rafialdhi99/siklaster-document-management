@extends('layouts.app')

@section('title', 'Penugasan Saya')
@section('page-title', 'Lengkapi Penugasan')

@section('content')

<div style="max-width: 1100px; margin: 0 auto;">

    <div style="
        background: white;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        margin-bottom: 24px;
    ">

        <h2 style="
            margin: 0 0 8px 0;
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
        ">
            Pilih Program Tanggung Jawab Anda
        </h2>

        <p style="
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        ">
            Silakan pilih satu atau beberapa program sesuai dengan penugasan Anda.
            Anda dapat memilih program dari lebih dari satu klaster.
        </p>

    </div>

    @if ($errors->any())
        <div style="
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        ">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('penugasan.update') }}">

        @csrf
        @method('PUT')

        @foreach ($klasters as $klaster)

            <div style="
                background: white;
                border-radius: 14px;
                margin-bottom: 20px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            ">

                <div style="
                    padding: 16px 20px;
                    background: #f8fafc;
                    border-bottom: 1px solid #e5e7eb;
                ">
                    <h3 style="
                        margin: 0;
                        font-size: 17px;
                        font-weight: 700;
                        color: #0f766e;
                    ">
                        {{ $klaster->nama_klaster }}
                    </h3>
                </div>

                <div style="
                    padding: 20px;
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 12px;
                ">

                    @forelse ($klaster->programs as $program)

                        <label style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 14px 16px;
                            border: 1px solid #dbe3ea;
                            border-radius: 10px;
                            cursor: pointer;
                            background: #ffffff;
                        ">

                            <input
                                type="checkbox"
                                name="programs[]"
                                value="{{ $program->id }}"
                                {{ in_array(
                                    $program->id,
                                    old('programs', $programTerpilih)
                                ) ? 'checked' : '' }}
                                style="
                                    width: 18px;
                                    height: 18px;
                                    cursor: pointer;
                                "
                            >

                            <span style="
                                font-size: 14px;
                                color: #374151;
                                font-weight: 500;
                            ">
                                {{ $program->nama_program }}
                            </span>

                        </label>

                    @empty

                        <p style="
                            color: #9ca3af;
                            font-size: 14px;
                            margin: 0;
                        ">
                            Belum ada program pada klaster ini.
                        </p>

                    @endforelse

                </div>

            </div>

        @endforeach

        <div style="
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
            margin-bottom: 30px;
        ">

            <button
                type="submit"
                style="
                    border: none;
                    background: #0f766e;
                    color: white;
                    padding: 12px 24px;
                    border-radius: 9px;
                    font-size: 14px;
                    font-weight: 700;
                    cursor: pointer;
                "
            >
                Simpan Penugasan
            </button>

        </div>

    </form>

</div>

@endsection