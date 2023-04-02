@extends('layouts.app')

@section('content')

@if(session('error'))
<div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('error') }}
    </div>
</div>

<script>
    $(document).ready(function(){
            setTimeout(function(){
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
    $(document).ready(function(){
                setTimeout(function(){
                    $(".bs-toast").alert('close');
                }, 5000);
            });
</script>
@endif

<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kaur /</span> Data Kaur</h4>

    <div class="col-md-12">
        <div class="card mb-4 p-4">
            <h5 class="card-header">Tambah Peminjaman</h5>
            <form action="{{ route('kaurpinjam.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kaur</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $user->nama }}" disabled/>
                        <input type="hidden" name="id_user" class="form-control @error('nama') is-invalid @enderror" value="{{ $user->id }}"/>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Aset</label>
                        <select name="aset" class="form-select @error('aset') is-invalid @enderror" id="exampleFormControlSelect1"
                        aria-label="Default select example">
                        <option value="">Pilih Aset</option>
                        @foreach ($aset as $a)
                        <option value="{{ $a->kd_aset }}">{{ $a->nama_aset }}</option>
                        @endforeach
                    </select>
                        @error('aset')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input name="tgl_pinjam" class="form-control @error('tgl_pinjam') is-invalid @enderror" type="date" value="2023-03-18"
                            id="html5-date-input" />
                            @error('tgl_pinjam')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Dipinjam</label>
                        <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" type="number" id="html5-date-input" />
                            @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <a href="/kaurpinjam" type="button" class="btn btn-secondary">Batal</a>
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
