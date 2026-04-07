<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stunting Balita</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Status Gizi & Stunting Balita</h2>
        <p>Posyandu Desa Bontolohe</p>
        <p>Periode: {{ $bulan_nama }} {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>L/P</th>
                <th>Tgl Lahir</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Status Berat</th>
                <th>Status Stunting</th>
                <th>Asupan Gizi</th>
                <th>Imunisasi Gizi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $item->berat_badan ?? '-' }}</td>
                <td>{{ $item->tinggi_badan ?? '-' }}</td>
                <td>{{ $item->bgm ? 'BGM' : ($item->naik_berat_badan ? 'Naik (N)' : 'Tidak Naik (T)') }}</td>
                <td>{{ $item->status_stunting ?? '-' }}</td>
                <td>{{ $item->asupan_gizi ?? '-' }}</td>
                <td>{{ $item->imunisasi_gizi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
