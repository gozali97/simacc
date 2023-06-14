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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah</label>
                                            <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                                type="number" value="{{ $detail->count() }}" readonly />
                                            @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <div class="mt-4 mb-3" style="margin-top: 30px!important">
                                        <button type="submit" type="button"
                                            class="btn rounded-pill btn-primary">
                                            <i class="tf-icons bx bx-pencil" style="margin-right: 5px"></i>Ubah
                                        </button>
                                    </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Inventory</th>
                                <th>Nama Aset</th>
                                <th>Ruang Aset</th>
                                <th>Gambar Aset</th>
                                <th>Status Aset</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($detail as $details)
                                <tr>
                                    <td>{{ $details->kode_detail }}</td>
                                    <td>{{ $details->nama_aset }}</td>
                                    <td>{{ $details->nama_ruang }}</td>
                                    <td><img src="{{ url('assets/img/' . $details->gambar) }}"
                                            style="width:80px; height:80px;border-radius: 20%;" alt=""></td>
                                    <td>
                                        @if ($details->status == 'in')
                                            <span class="badge rounded-pill bg-label-success">Ready</span>
                                        @elseif ($details->status == 'out')
                                            <span class="badge rounded-pill bg-label-warning">Dipinjam</span>
                                        @elseif ($details->status == 'del')
                                            <span class="badge rounded-pill bg-label-danger">Dihapus</span>
                                        @else
                                            <span class="badge rounded-pill bg-label-warning">Dimutasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
