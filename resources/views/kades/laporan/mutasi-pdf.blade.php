<!DOCTYPE html>
<html>

<head>
    <title>Laporan Perencanaan</title>
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
    <h2 style="text-align:center;">Laporan Data Mutasi Aset</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mutasi</th>
                <th>Tanggal Mutasi</th>
                <th>Nama Aset</th>
                <th>Ruang Aset</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama_mutasi }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tgl_mutasi)) }}</td>
                    <td>{{ $d->nama_aset }}</td>
                    <td>{{ $d->nama_ruang }}</td>
                    <td>{{ $d->status }}</td>
                </tr>
            @endforeach
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
