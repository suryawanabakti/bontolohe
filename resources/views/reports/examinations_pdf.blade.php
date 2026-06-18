<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeriksaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN RIWAYAT PEMERIKSAAN KESEHATAN</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Tgl Periksa</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Detail Khusus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examinations as $index => $exam)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $exam->patient->nama }} ({{ $exam->patient->kategori }})</td>
                    <td>{{ $exam->tanggal_pemeriksaan }}</td>
                    <td>{{ $exam->berat_badan ?? '-' }}</td>
                    <td>{{ $exam->tinggi_badan ?? '-' }}</td>
                    <td>
                        @if($exam->patient->kategori == 'balita')
                            LK: {{ $exam->lingkar_kepala ?? '-' }}cm, LILA: {{ $exam->lila ?? '-' }}cm
                        @elseif($exam->patient->kategori == 'ibu_hamil')
                            TFU: {{ $exam->tfu ?? '-' }}cm, DJJ: {{ $exam->djj ?? '-' }}bpm
                            @if($exam->umur_kehamilan), UK: {{ $exam->umur_kehamilan }} mg @endif
                            @if($exam->hpl), HPL: {{ $exam->hpl }} @endif
                        @else
                            TD: {{ $exam->tekanan_darah ?? '-' }}, Suhu: {{ $exam->suhu ?? '-' }}°C
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
