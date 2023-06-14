<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penghapusan</title>
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
    <h2 style="text-align:center;">Laporan Data Penghapusan Aset</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
         @php
        $hitungsemua = \App\Models\DetailPenghapusan::query()
                       ->join('penghapusan', 'penghapusan.kd_penghapusan', 'detail_penghapusan.kd_penghapusan')
                        ->whereBetween('detail_penghapusan.tgl_penghapusan', [$start, $end])
                        ->count();
        $hitungproses = \App\Models\DetailPenghapusan::query()
                        ->join('penghapusan', 'penghapusan.kd_penghapusan', 'detail_penghapusan.kd_penghapusan')
                        ->where('penghapusan.status', 'Proses')
                        ->whereBetween('detail_penghapusan.tgl_penghapusan', [$start, $end])
                        ->count();
        $hitungdisetujui = \App\Models\DetailPenghapusan::query()
                        ->join('penghapusan', 'penghapusan.kd_penghapusan', 'detail_penghapusan.kd_penghapusan')
                        ->where('penghapusan.status', 'Disetujui')
                        ->whereBetween('detail_penghapusan.tgl_penghapusan', [$start, $end])
                        ->count();
        $hitungditolak = \App\Models\DetailPenghapusan::query()
                        ->join('penghapusan', 'penghapusan.kd_penghapusan', 'detail_penghapusan.kd_penghapusan')
                        ->where('penghapusan.status', 'Ditolak')
                        ->whereBetween('detail_penghapusan.tgl_penghapusan', [$start, $end])
                        ->count();
    @endphp
        <p>Jumlah Penghapusan Aset    : {{ $hitungsemua }}</p>
        <p>Jumlah Penghapusan Proses    : {{ $hitungproses }}</p>
        <p>Jumlah Penghapusan Disetujui: {{ $hitungdisetujui }}</p>
        <p>Jumlah Penghapusan Ditolak: {{ $hitungditolak }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kaur</th>
                <th>Nama Aset</th>
                <th>Jenis</th>
                <th>Tanggal Penghapusan</th>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->nama_jenis }}</td>
                        <!--<td>{{ date('d-m-Y', strtotime($d->tgl_penghapusan)) }}</td> !-->
                        <td>
                            {{ \Carbon\Carbon::parse($d->tgl_penghapusan)->format('d-m-y') }} </td>
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
