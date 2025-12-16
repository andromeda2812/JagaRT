<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        h2 { text-align: center; margin-bottom: 15px; }
        .section { margin-bottom: 10px; }
        .label { font-weight: bold; }
        img { max-width: 250px; margin-top: 10px; }
        .line { border-bottom: 1px solid #ccc; margin: 10px 0; }
    </style>
</head>
<body>

<h2>LAPORAN KEJADIAN</h2>

<div class="section">
    <span class="label">Tanggal Kejadian:</span><br>
    {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->translatedFormat('d F Y, H:i') }}
</div>

<div class="section">
    <span class="label">Lokasi:</span><br>
    {{ $laporan->lokasi }}
</div>

<div class="section">
    <span class="label">Deskripsi:</span><br>
    {{ $laporan->deskripsi }}
</div>

<div class="section">
    <span class="label">Status:</span><br>
    {{ ucfirst($laporan->status_laporan) }}
</div>

<div class="section">
    <span class="label">Foto Bukti:</span><br>
    @if($laporan->foto_bukti)
        <img src="{{ public_path('storage/' . $laporan->foto_bukti) }}">
    @else
        Tidak ada bukti
    @endif
</div>

</body>
</html>