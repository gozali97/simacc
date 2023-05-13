@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mutasi /</span> Detail Mutasi</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="card-header">
                        <h4>Data Mutasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode Inventory</th>
                                        <th>Nama Aset</th>
                                        <th>Ruang Aset</th>
                                        <th>Gambar Aset</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($old as $d)
                                        <tr>
                                            <td>{{ $d->kode_detail }}</td>
                                            <td>{{ $d->nama_aset }}</td>
                                            <td>{{ $d->nama_ruang }}</td>
                                            <td><img src="{{ url('assets/img/' . $d->gambar) }}"
                                                    style="width:80px; height:80px;border-radius: 20%;" alt="">
                                            </td>
                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="card-header">
                        <h4>Data Aset Baru</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode Inventory</th>
                                        <th>Nama Aset</th>
                                        <th>Ruang Aset</th>
                                        <th>Gambar Aset</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($new as $d)
                                        <tr>
                                            <td>{{ $d->kode_detail }}</td>
                                            <td>{{ $d->nama_aset }}</td>
                                            <td>{{ $d->nama_ruang }}</td>
                                            <td><img src="{{ url('assets/img/' . $d->gambar) }}"
                                                    style="width:80px; height:80px;border-radius: 20%;" alt="">
                                            </td>
                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <a href="/listmutasi" type="button" class="btn btn-secondary">Kembali</a>

    <script>
        // Membuat event listener change pada input file
        document.getElementById("formFile").addEventListener("change", function(event) {
            // Mendapatkan file yang diupload
            let file = event.target.files[0];

            // Membuat objek FileReader
            let reader = new FileReader();

            // Membuat event listener untuk ketika file selesai dibaca
            reader.addEventListener("load", function() {
                // Mengganti sumber gambar pada elemen img dengan gambar yang sudah dipilih
                document.getElementById("preview").src = reader.result;
            }, false);

            // Membaca file yang dipilih sebagai data URL
            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
