@extends('layouts.app')

@section('content')
<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Aset /</span> Data Aset</h4>

    <div class="col-md-12">
        <div class="card mb-4 p-4">
            <h5 class="card-header">Tambah Aset</h5>
            <form action="{{ route('peminjam.update', $data->id_peminjam) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->nama_peminjam }}" placeholder="Nama Peminjam" />
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ $data->alamat }}" type="text" id="html5-date-input" placeholder="Alamat"/>
                            @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input name="nohp" class="form-control @error('nohp') is-invalid @enderror" value="{{ $data->no_hp }}" type="number" id="html5-date-input" placeholder="No telepone"/>
                            @error('nohp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option value="">pilih</option>
                            <option value="1" {{ $data->status == "1" ? 'selected' : ''}}>Aktif</option>
                            <option value="0" {{ $data->status == "0" ? 'selected' : ''}}>Tidak Aktif</option>
                        </select>
                        @error('status')
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
                                <img id="preview" src="{{ url('assets/img/'.$data->gambar) }}" alt="" style="max-width: 100%; max-height: 100px;">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="/aset" type="button" class="btn btn-secondary">Batal</a>
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
