<?php

namespace App\Http\Controllers;

use App\Models\JenisAset;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {

        $data = Peminjaman::query()
        ->join('asets', 'asets.kd_aset', 'peminjaman.kd_aset')
        ->join('ruangs', 'ruangs.kd_ruang', 'asets.kd_ruang')
        ->join('jenis_asets', 'jenis_asets.kd_jenis', 'asets.kd_jenis')
        ->select('asets.*', 'ruangs.nama_ruang as ruang', 'jenis_asets.nama_jenis as jenis')
        ->where('peminjaman.status', 1)
        ->get();

        return view('kaur.pinjaman.index', compact('data'));
    }

    public function create()
    {
        $jenis = JenisAset::all();
        $ruang = Ruang::all();

        return view('kaur.pinjaman.create', compact('jenis', 'ruang'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'jenis' => 'required|max:255',
                'ruang' => 'required|numeric',
                'tgl_masuk' => 'required|max:255',
                'gambar' => 'required|image',
                'kondisi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'aset' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            Aset::create([
                'nama_aset' => $request->nama,
                'kd_jenis' => $request->jenis,
                'kd_ruang' => $request->ruang,
                'tgl_masuk' => $request->tgl_masuk,
                'stok' => $request->jumlah,
                'kondisi' => $request->kondisi,
                'gambar' => $gambar,
                'status' => 1,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('aset.index')->with('success', 'Data Aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, ', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = Aset::find($id);
        $jenis = JenisAset::all();
        $ruang = Ruang::all();

        return view('kaur.aset.edit', compact('data', 'jenis', 'ruang'));
    }

    public function update(Request $request, $id)
    {

        $data = Aset::find($id);

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

        $data->nama_aset = $request->nama;
        $data->kd_jenis = $request->jenis;
        $data->kd_ruang = $request->ruang;
        $data->tgl_masuk = $request->tgl_masuk;
        $data->stok = $request->jumlah;
        $data->kondisi = $request->kondisi;
        $data->save();

        if ($data->save()) {
            return redirect()->route('aset.index')->with('success', 'Data Aset berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate aset');
        }
    }

    public function destroy($id)
    {
        $aset = Aset::find($id);

        if (!$aset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        // Hapus gambar dari server
        $gambarPath = public_path('assets/img/' . $aset->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $aset->delete();

        return redirect()->route('kaurs.index')->with('success', 'Aset berhasil dihapus.');
    }
}
