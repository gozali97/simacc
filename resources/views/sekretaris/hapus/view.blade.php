@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penghapusan /</span> Detail Penghapusan Aset</h4>
        <div class="col-md-12">
            <div class="card mb-4 p-4">
                <div class="card-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Detail Penghapusan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Kode Penghapusan</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ $data[0]->kd_penghapusan }}" placeholder="Nama Lengkap" readonly />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Nama Kaur</label>
                                <input type="text" name="nama" class="form-control" value="{{ $data[0]->nama }}"
                                    placeholder="Nama Lengkap" readonly />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Hapus Aset</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ date('d-m-Y', strtotime($data[0]->tgl_penghapusan)) }}"
                                    placeholder="Nama Lengkap" readonly />
                            </div>
                        </div>
                    </div>
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
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->kode_detail }}</td>
                                        <td>{{ $d->nama_aset }}</td>
                                        <td>{{ $d->nama_ruang }}</td>
                                        <td><img src="{{ url('assets/img/' . $d->gambar) }}"
                                                style="width:80px; height:80px;border-radius: 20%;" alt=""></td>
                                        <td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="/listhapus" type="button" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

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
