@extends('layouts.app')

@section('content')
<style>
    img{
        border-radius: 5%;
        width: 70px;

    }
</style>
<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kebutuhan /</span> Buat Kebutuhan</h4>

    <div class="col-md-12">
        <form action="{{ route('kaurajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-4 p-4">
                <h5 class="card-header">Tambah Kebutuhan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Kebutuhan</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Nama kebutuhan" required />
                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                    type="number" id="html5-date-input" required />
                                @error('jumlah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kebutuhan</label>
                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror" placeholder=""
                                    required />
                                @error('tanggal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Gambar</label>
                                        <input id="formFile" class="form-control @error('gambar') is-invalid @enderror" type="file"
                                            id="gambar" name="gambar"/>
                                        @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img class="mt-4" id="preview" src="{{ url('/assets/img/illustrations/page-404.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <center class="mt-4">
                <div class="mb-3">
                    <a href="/kaurajuan" type="button" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </center>
        </form>
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
