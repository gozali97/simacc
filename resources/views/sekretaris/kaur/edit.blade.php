@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kaur /</span> Data Kaur</h4>

        <div class="col-md-12">
            <div class="card mb-4 p-4">
                <h5 class="card-header">Tambah Kaur</h5>
                <form action="{{ route('kaurs.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama kaur</label>
                            <input type="text" name="nama" class="form-control" value="{{ $data->nama }}"
                                placeholder="Nama Lengkap" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $data->email }}"
                                placeholder="Email@gmail.com" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Handphone</label>
                            <input type="number" name="no_hp" class="form-control" value="{{ $data->no_hp }}"
                                placeholder="08xxxxx" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}"
                                placeholder="Jl. xxx" />
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="formFile" class="form-label">Foto</label>
                                    <input class="form-control" type="file" name="gambar" id="formFile" />
                                </div>
                                <div class="col-md-6">
                                    <img id="preview" src="{{ url('assets/img/' . $data->gambar) }}" alt=""
                                        style="max-width: 100%; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a href="/kaurs" type="button" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
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
