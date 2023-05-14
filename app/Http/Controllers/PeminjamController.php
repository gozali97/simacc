<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamController extends Controller
{
    public function index()
    {

        $data = Peminjam::all();

        return view('kaur.peminjam.index', compact('data'));
    }

    public function create()
    {

        return view('kaur.peminjam.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'alamat' => 'required|max:255',
                'nohp' => 'required',
                'gambar' => 'required|image',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'peminjam' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            Peminjam::create([
                'nama_peminjam' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->nohp,
                'status' => $request->status,
                'gambar' => $gambar,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('peminjam.index')->with('success', 'Data Peminjam berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, ', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = Peminjam::where('id_peminjam', $id)->first();


        return view('kaur.peminjam.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $data = Peminjam::where('id_peminjam', $id)->first();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'aset' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->nama_peminjam = $request->nama;
        $data->alamat = $request->alamat;
        $data->no_hp = $request->nohp;
        $data->status = $request->status;
        $data->save();

        if ($data->save()) {
            return redirect()->route('peminjam.index')->with('success', 'Data Peminjam berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate aset');
        }
    }

    public function destroy($id)
    {
        $aset = Peminjam::where('id_peminjam', $id)->first();

        if (!$aset) {
            return redirect()->back()->with('error', 'Data Peminjam tidak ditemukan.');
        }

        // Hapus gambar dari server
        $gambarPath = public_path('assets/img/' . $aset->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $aset->delete();

        return redirect()->route('peminjam.index')->with('success', 'Data Peminjam berhasil dihapus.');
    }
}
