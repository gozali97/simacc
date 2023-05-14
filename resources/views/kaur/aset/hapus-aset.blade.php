@extends('layouts.app')

@section('content')
    <style>
        .data-list,
        .delete-list,
        .initial-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .data-list li,
        .delete-list li,
        .initial-list li {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .drag-handle {
            cursor: move;
            margin-right: 10px;
        }

        .item-data {
            flex-grow: 1;
            margin-right: 10px;
        }

        .badge {
            padding: 5px;
            border-radius: 4px;
        }

        .data-list li.selected,
        .delete-list li.selected {
            background-color: #e6f2ff;
            /* Ganti dengan warna latar belakang yang diinginkan */
        }

        .data-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .data-list li .item-data {
            margin-left: 10px !important;
        }

        .delete-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .delete-list li .item-data {
            margin-left: 10px !important;
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

        <!-- Basic Bootstrap Table -->
        <form action="{{ route('aset.destroy.aset') }}" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <ul id="datatable" class="data-list">
                                @foreach ($data as $d)
                                    <li data-kd-aset="{{ $d->kd_aset }}" data-kd-det-aset="{{ $d->kd_det_aset }}">
                                        <input type="checkbox" class="data-checkbox ml-3" />
                                        <input class="item-aset" type="hidden" name="aset" value="{{ $d->kd_aset }}">
                                        <input class="item-detail" type="hidden" name="detail"
                                            value="{{ $d->kd_det_aset }}">
                                        <span class="item-data">{{ $d->nama_aset }} - {{ $d->kode_detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <button id="remove" type="button" class="btn btn-icon btn-primary"
                                onclick="moveToDataTable()">
                                <span class="tf-icons bx bx-left-arrow-alt"></span>
                            </button>
                            <button id="add" type="button" class="btn btn-icon btn-primary"
                                onclick="moveToDeleteList()">
                                <span class="tf-icons bx bx-right-arrow-alt"></span>
                            </button>
                        </div>

                        <div class="col-md-5">
                            @csrf
                            <input type="hidden" name="kd_aset" value="{{ $data[0]->kd_aset }}">
                            <ul id="delete-list" class="delete-list">
                                <!-- Hapus <li> awal karena tidak dibutuhkan -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 p-3">
                <div class="row">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8 row">
                        <div class="col-md-8">
                            <label class="form-label">Kondisi Aset</label>
                            <select name="kondisi" class="form-select @error('jenis') is-invalid @enderror"
                                id="exampleFormControlSelect1" aria-label="Default select example" required>
                                <option value="">Pilih Kondisi Akhir Aset</option>
                                @foreach ($kondisi as $k)
                                    <option value="{{ $k->id }}">{{ $k->kondisi_aset }}</option>
                                @endforeach
                            </select>
                            @error('jenis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4 mt-4" style="margin-top: 30px!important">
                            <button id="submit" type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
            </div>
        </form>

        <script>
            function toggleSelection(element) {
                var listItem = element.parentNode;
                listItem.classList.toggle('selected');
            }

            function moveToDeleteList() {
                var dataTable = document.getElementById('datatable');
                var deleteList = document.getElementById('delete-list');
                var dataCheckboxes = dataTable.querySelectorAll('.data-checkbox:checked');

                var form = document.getElementById('delete-form');
                var kdDetAsetInputs = deleteList.querySelectorAll('input[name="kd_det_aset[]"]');

                var deletedItems = []; // Array untuk menyimpan nilai item yang dihapus

                for (var i = 0; i < dataCheckboxes.length; i++) {
                    var listItem = dataCheckboxes[i].parentNode;
                    listItem.classList.remove('selected');

                    var kdDetAset = listItem.getAttribute('data-kd-det-aset');
                    var itemData = listItem.querySelector('.item-data').textContent;

                    deletedItems.push(itemData); // Menambahkan nilai item ke dalam array

                    var newListItem = document.createElement('li');
                    newListItem.innerHTML = `
            <input type="checkbox" class="delete-checkbox">
            <input type="hidden" name="kd_det_aset[]" value="${kdDetAset}">
            <span class="item-data">${itemData}</span>
        `;
                    newListItem.addEventListener('click', function() {
                        toggleSelection(this);
                    });

                    // Tambahkan elemen baru ke delete-list
                    deleteList.appendChild(newListItem);

                    // Hapus item dari datatable
                    dataTable.removeChild(listItem);
                }

                // Mengatur nilai kd_aset pada form
                kdAsetInput.value = deletedItems.length > 0 ? deletedItems[0] : '';

                // Mengatur nilai kd_det_aset pada form
                for (var i = 0; i < kdDetAsetInputs.length; i++) {
                    kdDetAsetInputs[i].value = deletedItems[i + 1] || '';
                }
            }

            function moveToDataTable() {
                var dataTable = document.getElementById('datatable');
                var deleteList = document.getElementById('delete-list');
                var deleteCheckboxes = deleteList.querySelectorAll('.delete-checkbox:checked');

                for (var i = 0; i < deleteCheckboxes.length; i++) {
                    var listItem = deleteCheckboxes[i].parentNode;
                    var itemData = listItem.querySelector('.item-data').textContent;
                    var kdAset = listItem.getAttribute('data-kd-aset');
                    var kdDetAset = listItem.getAttribute('data-kd-det-aset');

                    // Create a new list item in the datatable
                    var newListItem = document.createElement('li');
                    newListItem.setAttribute('data-kd-aset', kdAset);
                    newListItem.setAttribute('data-kd-det-aset', kdDetAset);
                    newListItem.innerHTML = `
            <input type="checkbox" class="data-checkbox ml-3" />
            <input class="item-aset" type="hidden" name="aset" value="${kdAset}">
            <input class="item-detail" type="hidden" name="detail" value="${kdDetAset}">
            <span class="item-data">${itemData}</span>`;

                    // Append the new item to the datatable
                    dataTable.appendChild(newListItem);

                    // Remove the item from the delete-list
                    deleteList.removeChild(listItem);
                }
            }
        </script>
    @endsection
