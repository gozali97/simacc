<!DOCTYPE html>
<html>

<head>
    <title>Laporan Aset</title>
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
    <h2 style="text-align:center;">Laporan Aset Desa Cibentang</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
        @php
        $hitungAset = \App\Models\DetailAset::query()
                        -> whereBetween('detail_aset.created_at', [$start, $end])
                        ->count();
        $hitungRusak = \App\Models\DetailAset::query()
                        -> where('detail_aset.kd_kondisi', '2')
                        -> whereBetween('detail_aset.created_at', [$start, $end])
                        ->count();
         $hitungBaik = \App\Models\DetailAset::query()
                        -> where('detail_aset.kd_kondisi', '1')
                        -> whereBetween('detail_aset.created_at', [$start, $end])
                        ->count();  
        $hitungPinjam= \App\Models\DetailAset::query()
                        -> where('detail_aset.status', 'out')
                        -> whereBetween('detail_aset.created_at', [$start, $end])
                        ->count();                    
        @endphp
        <p>Jumlah Seluruh Aset      : {{ $hitungAset }}</p>
        <p>Jumlah Aset Kondisi rusak: {{ $hitungRusak }}</p>
        <p>Jumlah Aset Kondisi Baik : {{ $hitungBaik }}</p>
        <p>Jumlah Aset Sedang Dipinjam : {{ $hitungPinjam }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Detail</th>
                <th>Nama Aset</th>
                <th>Ruang Aset</th>
                <th>Jenis Aset</th>
                <th>Kondisi Aset</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @php
                $no = 1;
                @endphp
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->kode_detail }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->nama_ruang }}</td>
                        <td>{{ $d->nama_jenis }}</td>
                        <td>{{ $d->kondisi_aset }}</td>
                        <td>{{ $d->tgl_masuk }}</td>
                        <td>
                            @if ($d->status == 'in')
                                <p>Aktif</p>
                            @elseif ($d->status == 'out')
                                <p>Dipinjam</p>
                            @else
                                <p>Dihapus</p>
                            @endif
                        </td>
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
