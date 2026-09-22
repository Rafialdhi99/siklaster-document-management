<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKLASTER - Klaster Puskesmas</title>
</head>
<body>

    <h1>SIKLASTER</h1>
    <h2>Data Klaster Puskesmas</h2>

    @foreach ($klasters as $klaster)
        <div>
            <h3>{{ $klaster->kode_klaster }} - {{ $klaster->nama_klaster }}</h3>
            <p>{{ $klaster->keterangan }}</p>
        </div>
        <hr>
    @endforeach

</body>
</html>