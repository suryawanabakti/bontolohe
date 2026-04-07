<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pasien</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA PASIEN POSYANDU</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $index => $patient)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $patient->nama }}</td>
                    <td>{{ $patient->tanggal_lahir }}</td>
                    <td>{{ $patient->jenis_kelamin }}</td>
                    <td>{{ ucfirst($patient->kategori) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
