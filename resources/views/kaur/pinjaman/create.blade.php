@extends('layouts.app')

@section('content')
<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kaur /</span> Data Kaur</h4>

    <div class="col-md-12">
        <div class="card mb-4 p-4">
            <h5 class="card-header">Tambah Kaur</h5>
            <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Aset</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Aset" />
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Aset</label>
                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option value="">Pilih Jenis Aset</option>
                            @foreach ($jenis as $j)
                            <option value="{{ $j->kd_jenis }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruang</label>
                        <select name="ruang" class="form-select @error('ruang') is-invalid @enderror" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option value="">Pilih Ruang</option>
                            @foreach ($ruang as $r)
                            <option value="{{ $r->kd_ruang }}">{{ $r->nama_ruang }}</option>
                            @endforeach
                        </select>
                        @error('ruang')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input name="tgl_masuk" class="form-control @error('tgl_masuk') is-invalid @enderror" type="date" value="2023-03-18"
                            id="html5-date-input" />
                            @error('tgl_masuk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" type="number" id="html5-date-input" />
                            @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option value="0">Baik</option>
                            <option value="1">Cukup</option>
                            <option value="2">Rusak</option>
                        </select>
                        @error('kondisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="formFile" class="form-label">Foto</label>
                                <input class="form-control @error('gambar') is-invalid @enderror" type="file" name="gambar" id="formFile" />
                            </div>
                            @error('gambar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="col-md-6">
                                <img id="preview" src="" alt="" style="max-width: 100%; max-height: 100px;">
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
