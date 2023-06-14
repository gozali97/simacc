@extends('layouts.app')

@section('content')

    @if (session('error'))
        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".bs-toast").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".bs-toast").alert('close');
                }, 5000);
            });
        </script>
    @endif

    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sekretaris /</span> Data Sekretaris</h4>

        <div class="col-md-12">
            <div class="card mb-4 p-4">
                <h5 class="card-header">Tambah Sekretaris</h5>
                <form action="{{ route('kades.sekretaris.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Sekretaris</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email@gmail.com" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Handphone</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="08xxxxx" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Jl. xxx" />
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="formFile" class="form-label">Foto</label>
                                    <input class="form-control" type="file" name="gambar" id="formFile" />
                                </div>
                                <div class="col-md-6">
                                    <img id="preview" src="" alt=""
                                        style="max-width: 100%; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a href="/kades/sekre" type="button" class="btn btn-secondary">Batal</a>
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
