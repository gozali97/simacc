<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
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
    <h2 style="text-align:center;">Laporan Data Peminjaman Aset</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
        @php
        $hitungsemua = \App\Models\DetailPeminjaman::query()
                        ->whereBetween('detail_peminjaman.created_at', [$start, $end])
                        ->count();
        $hitungaktif = \App\Models\DetailPeminjaman::query()
                        ->join('peminjaman', 'peminjaman.kd_peminjaman', 'detail_peminjaman.kd_peminjaman')
                        ->where('peminjaman.status', 'Aktif')
                        ->whereBetween('detail_peminjaman.created_at', [$start, $end])
                        ->count();
        $hitungselesai = \App\Models\DetailPeminjaman::query()
                        ->join('peminjaman', 'peminjaman.kd_peminjaman', 'detail_peminjaman.kd_peminjaman')
                        ->where('peminjaman.status', 'Selesai')
                        ->whereBetween('detail_peminjaman.created_at', [$start, $end])
                        ->count();
        $hitungproses = \App\Models\DetailPeminjaman::query()
                        ->join('peminjaman', 'peminjaman.kd_peminjaman', 'detail_peminjaman.kd_peminjaman')
                        ->where('peminjaman.status', 'Proses')
                        ->whereBetween('detail_peminjaman.created_at', [$start, $end])
                        ->count();
         @endphp
        <p>Jumlah Seluruh Peminjaman   : {{ $hitungsemua }}</p>
        <p>Jumlah Peminjaman Aktif     : {{ $hitungaktif }}</p>
        <p>Jumlah Peminjaman Selesai   : {{ $hitungselesai }}</p>
         <p>Jumlah Peminjaman Proses   : {{ $hitungproses }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Aset</th>
                <th>Kode Inventory</th>
                <th>Jenis</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="7" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama_peminjam }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->kode_detail }}</td>
                        <td>{{ $d->nama_jenis }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_pinjam)) }}</td>
                        <td>{{ $d->status }}</td>
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
        <p>Yatno</p>
    </div>
</body>

</html>
