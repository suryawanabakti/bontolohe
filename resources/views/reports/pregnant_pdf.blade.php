<!DOCTYPE html>
<html>
<head>
    <title>Laporan Ibu Hamil & Nifas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN CAKUPAN IBU HAMIL & IBU NIFAS</h2>
        <h3>Bulan: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Indikator</th>
                <th width="100">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Jumlah Sasaran Ibu Hamil sampai bulan ini</td>
                <td align="center">{{ $sasaranBumil }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jumlah Ibu hamil yang mendapatkan tablet tambah darah (FE 1) 30 tablet sampai bulan ini (TTD I BUMIL)</td>
                <td align="center">{{ $metrics['bumil_ttd_1'] }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Jumlah Ibu hamil yang mendapatkan tablet tambah darah (FE III) 90 tablet sampai bulan ini (TTD III BUMIL)</td>
                <td align="center">{{ $metrics['bumil_ttd_3'] }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Jumlah ibu hamil kekurangan energi kronik sampai bulan ini (Bumil KEK)</td>
                <td align="center">{{ $metrics['bumil_kek'] }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Jumlah ibu nifas yang mendapatkan tablet tambah darah (FE) 40 Tablet sampai bulan ini</td>
                <td align="center">{{ $metrics['nifas_fe_40'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        <br><br><br>
        <p>( ____________________ )</p>
        <p>Kader Posyandu / Admin</p>
    </div>
</body>
</html>
