<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .item { padding: 10px; border-bottom: 1px solid #aaa; margin-bottom: 10px; }
        .label { font-weight: bold; }
        img { max-width: 200px; margin-top: 5px; }
    </style>
</head>
<body>

<h2>LAPORAN KEJADIAN (FILTER)</h2>

<p>
    <strong>Filter:</strong>
    @if($request->start) Dari: {{ $request->start }} @endif
    @if($request->end) | Sampai: {{ $request->end }} @endif
    @if($request->status) | Status: {{ ucfirst($request->status) }} @endif
</p>

<hr>

@forelse($laporan as $item)
<div class="item">
    <p><span class="label">Tanggal:</span><br>
       {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y, H:i') }}</p>

    <p><span class="label">Lokasi:</span><br>{{ $item->lokasi }}</p>

    <p><span class="label">Deskripsi:</span><br>{{ $item->deskripsi }}</p>

    <p><span class="label">Status:</span> {{ ucfirst($item->status_laporan) }}</p>

    <p>
        <span class="label">Foto Bukti:</span><br>
        @if($item->foto_bukti)
            <img src="{{ public_path('storage/' . $item->foto_bukti) }}">
        @else
            Tidak ada bukti
        @endif
    </p>
</div>
@empty
<p>Tidak ada laporan yang sesuai filter.</p>
@endforelse

</body>
</html>