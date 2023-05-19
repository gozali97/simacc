<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #dddddd;
        }

        .footer {
            text-align: left;
            float: right;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Aset</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Kode Detail</th>
                <th>Nama Aset</th>
                <th>Ruang Aset</th>
                <th>Jenis Aset</th>
                <th>Kondisi Aset</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->kode_detail }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->nama_ruang }}</td>
                        <td>{{ $d->nama_jenis }}</td>
                        <td>{{ $d->kondisi_aset }}</td>
                        <td>Aktif</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="footer">
        <p>Brebes, {{ date('d F Y') }}</p>
        <p>Mengetahui, <br> Kepala Desa Cibentang</p>
        <br>
        <br>
        <p>Dr. Prunomo</p>
    </div>
</body>

</html>
