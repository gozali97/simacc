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
    <h2 style="text-align:center;">Laporan Data Peminjam</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Alamat</th>
                <th>No Handphone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nama_peminjam }}</td>
                    <td>{{ $d->alamat }}</td>
                    <td>{{ $d->no_hp }}</td>
                    <td>
                    @if ($d->status == '1')
                        <p>Aktif</p>
                     @else
                        <p>Tidak Aktif</p>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Brebes, {{ date('d F Y') }}</p>
        <p>Mengetahui, <br> Kepala Desa Cibentang</p>
        <br>
        <br>
        <p>Yatno</p>
    </div>
</body>

</html>
