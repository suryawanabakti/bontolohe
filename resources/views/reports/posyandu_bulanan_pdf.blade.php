<!DOCTYPE html>
<html>
<head>
    <title>Laporan SIP Bulanan Posyandu</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .info { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-left { text-align: left; }
        .bg-gray { background-color: #f9f9f9; }
        .footer { margin-top: 30px; width: 100%; }
        .footer table { border: none; }
        .footer td { border: none; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN BULANAN POSYANDU (SIP)</h2>
        <h3>DESA BONTOLOHE</h3>
        <p>Bulan: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kelompok Sasaran (Umur)</th>
                <th colspan="2">S</th>
                <th colspan="2">K</th>
                <th colspan="2">D</th>
                <th colspan="2">N</th>
                <th colspan="2">BGM</th>
                <th colspan="2">VIT A</th>
            </tr>
            <tr>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
                <th>L</th><th>P</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $totals = [
                    'L' => ['S' => 0, 'K' => 0, 'D' => 0, 'N' => 0, 'BGM' => 0, 'VitA' => 0],
                    'P' => ['S' => 0, 'K' => 0, 'D' => 0, 'N' => 0, 'BGM' => 0, 'VitA' => 0]
                ];
            @endphp
            @foreach($rows as $key => $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-left font-bold">{{ $row['label'] }}</td>
                    <td>{{ $row['L']['S'] }}</td><td>{{ $row['P']['S'] }}</td>
                    <td>{{ $row['L']['K'] }}</td><td>{{ $row['P']['K'] }}</td>
                    <td>{{ $row['L']['D'] }}</td><td>{{ $row['P']['D'] }}</td>
                    <td>{{ $row['L']['N'] }}</td><td>{{ $row['P']['N'] }}</td>
                    <td>{{ $row['L']['BGM'] }}</td><td>{{ $row['P']['BGM'] }}</td>
                    <td>{{ $row['L']['VitA'] }}</td><td>{{ $row['P']['VitA'] }}</td>
                </tr>
                @php
                    foreach(['L', 'P'] as $g) {
                        foreach(['S', 'K', 'D', 'N', 'BGM', 'VitA'] as $m) {
                            $totals[$g][$m] += $row[$g][$m];
                        }
                    }
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray font-bold">
                <td colspan="2">TOTAL</td>
                <td>{{ $totals['L']['S'] }}</td><td>{{ $totals['P']['S'] }}</td>
                <td>{{ $totals['L']['K'] }}</td><td>{{ $totals['P']['K'] }}</td>
                <td>{{ $totals['L']['D'] }}</td><td>{{ $totals['P']['D'] }}</td>
                <td>{{ $totals['L']['N'] }}</td><td>{{ $totals['P']['N'] }}</td>
                <td>{{ $totals['L']['BGM'] }}</td><td>{{ $totals['P']['BGM'] }}</td>
                <td>{{ $totals['L']['VitA'] }}</td><td>{{ $totals['P']['VitA'] }}</td>
            </tr>
            <tr class="bg-gray font-bold">
                <td colspan="2">TOTAL L+P</td>
                <td colspan="2">{{ $totals['L']['S'] + $totals['P']['S'] }}</td>
                <td colspan="2">{{ $totals['L']['K'] + $totals['P']['K'] }}</td>
                <td colspan="2">{{ $totals['L']['D'] + $totals['P']['D'] }}</td>
                <td colspan="2">{{ $totals['L']['N'] + $totals['P']['N'] }}</td>
                <td colspan="2">{{ $totals['L']['BGM'] + $totals['P']['BGM'] }}</td>
                <td colspan="2">{{ $totals['L']['VitA'] + $totals['P']['VitA'] }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; font-size: 10px;">
        <p><b>Keterangan:</b></p>
        <p>S: Jumlah Balita yang ada | K: Memiliki KMS | D: Timbang Berat Badan | N: Naik Berat Badan | BGM: Bawah Garis Merah | VIT A: Dapat Vitamin A</p>
    </div>

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;"> Mengetahui,<br>Kepala Desa Bontolohe </td>
                <td style="width: 50%;"> Bontolohe, {{ date('d F Y') }}<br>Kader Posyandu </td>
            </tr>
            <tr>
                <td style="height: 60px;"></td>
                <td style="height: 60px;"></td>
            </tr>
            <tr>
                <td> ( .................................... ) </td>
                <td> ( .................................... ) </td>
            </tr>
        </table>
    </div>
</body>
</html>
