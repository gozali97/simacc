@extends('layouts.app')

@section('content')
    <style>
        img {
            border-radius: 50%;
            width: 50px;
        }
    </style>
    @if (session('success'))
        <div class="bs-toast toast fade show bg-success" role="alert" style="width: 100%!important;" aria-live="assertive"
            aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
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
    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Aset /</span> Data Aset</h4>
        <div class="row mb-2">
            <div class="col-1">
                <a href="/aset" type="button" class="btn btn-secondary">Kembali</a>
            </div>
        </div>


        <div class="col-md-12">
            <form action="{{ route('aset.update', $data->kd_aset) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 p-4">
                    <h5 class="card-header">Ubah Aset</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Aset</label>
                                    <input type="text" name="nama" value="{{ $data->nama_aset }}"
                                        class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Aset" />
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Asal Aset</label>
                                    <select name="asal" class="form-select @error('asal') is-invalid @enderror"
                                        id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">Pilih Asal Aset</option>
                                        @foreach ($asal as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $a->id == $data->kd_asal ? 'selected' : '' }}>{{ $a->asal_aset }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Aset</label>
                                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror"
                                        id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">Pilih Jenis Asett</option>
                                        @foreach ($jenis as $j)
                                            <option value="{{ $j->kd_jenis }}"
                                                {{ $j->kd_jenis == $data->kd_jenis ? 'selected' : '' }}>
                                                {{ $j->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-primary">Nama Mutasi</label>
                                    <input name="nama_mutasi"
                                        class="form-control @error('nama_mutasi') is-invalid @enderror" type="text"
                                        required>
                                    @error('nama_mutasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
        </div>
    </div>
    @foreach ($detail as $details)
        <input type="hidden" name="kd_aset" value="{{ $data->kd_aset }}">
        <div class="card mt-3">
            <div class="row">
                <div class="col-10">
                    <div class="card-header">Detail Aset</div>
                </div>
                {{-- <div class="col-2"> <button type="submit" class="btn rounded-pill btn-info mt-4">
                <i class="tf-icons bx bx-pencil" style="margin-right: 5px"></i>Ubah
        </div> --}}
            </div>
            <input type="hidden" name="kd_detail[]" value="{{ $details->kd_det_aset }}">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Ruang</label>
                        <select id="ruang" name="ruang[]" class="form-select @error('ruang') is-invalid @enderror"
                            id="exampleFormControlSelect1" aria-label="Default select example" required>
                            <option value="">Pilih Ruang</option>
                            @foreach ($ruang as $r)
                                <option value="{{ $r->kd_ruang }}"
                                    {{ $r->kd_ruang == $details->kd_ruang ? 'selected' : '' }}>
                                    {{ $r->nama_ruang }}</option>
                            @endforeach
                        </select> @error('ruang')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="form-label">Kondisi</label>
                        <select id="kondisi" name="kondisi[]"
                            class="form-select @error('kondisi') is-invalid @enderror" id="exampleFormControlSelect1"
                            aria-label="Default select example" required>
                            <option value="">Pilih kondisi</option>
                            @foreach ($kondisi as $k)
                                <option value="{{ $k->id }}"
                                    {{ $k->id == $details->kd_kondisi ? 'selected' : '' }}> {{ $k->kondisi_aset }}
                                </option>
                            @endforeach
                        </select>
                        @error('kondisi')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-9"> <label for="formFile" class="form-label">Foto</label>
                                <input class="form-control @error('gambar') is-invalid @enderror" type="file"
                                    id="gambar" name="gambar[]" id="formFile" accept=".jpg, .png" />
                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3 mx-auto">
                                <img class="mt-4" src="{{ url('/assets/img/' . $details->gambar) }}" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div id="detail">
        <div class="card mt-2">

        </div>
    </div>
    <center class="mt-4">
        <div class="mb-3">
            <a href="/aset" type="button" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </center>
    </form>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buatasetBtn = document.querySelector('#buat-aset');

            buatasetBtn.addEventListener('click', () => {

                const card = document.querySelector('#detail');
                buatasetBtn.setAttribute('disabled', true);

                const jumlah = parseInt(document.querySelector('input[name="jumlah"]').value);
                const cardBody = card.querySelector('.card');

                for (let i = 0; i < jumlah; i++) {
                    const newCard = document.createElement('div');
                    newCard.className = 'card mb-3';
                    newCard.innerHTML =
                        '<div class="card-header">Detail Aset</div><div class="card-body"><div class="row"><div class="col"><label class="form-label">Ruang</label><select id="ruang' +
                        (i + 1) +
                        '" name="ruang[]"class="form-select @error('ruang') is-invalid @enderror" id="exampleFormControlSelect1" aria-label="Default select example" required> <option value="">Pilih Ruang</option> @foreach ($ruang as $r) <option value="{{ $r->kd_ruang }}">{{ $r->nama_ruang }}</option> @endforeach </select> @error('ruang') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> <div class="col"> <label class="form-label">Kondisi</label> <select id="kondisi' +
                        (i + 1) +
                        '" name="kondisi[]" class="form-select @error('kondisi') is-invalid @enderror" id="exampleFormControlSelect1" aria-label="Default select example" required> <option value="">Pilih kondisi</option> @foreach ($kondisi as $k) <option value="{{ $k->id }}"> {{ $k->kondisi_aset }}</option> @endforeach </select> @error('kondisi') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div>  <div class="col"><label for="formFile" class="form-label">Foto</label> <input  class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar' +
                        (i + 1) +
                        '" name="gambar[]" id="formFile" required /> @error('gambar') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div> </div> </div>';
                    cardBody.appendChild(newCard);


                    document.addEventListener("DOMContentLoaded", function() {
                        // Kode Anda di sini
                        document.getElementById(`gambar${i+1}`).addEventListener("change", function(
                            event) {
                            if (document.getElementById(`gambar${i+1}`)) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById(`preview${i+1}`).src = e
                                        .target.result;
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        });
                    });


                }

            });
        });
    </script>
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
