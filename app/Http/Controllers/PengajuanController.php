<?php

namespace App\Http\Controllers;

use App\Models\Kebutuhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function index()
    {

        $data = Kebutuhan::all();

        return view('kaur.ajuan.index', compact('data'));
    }

    public function create()
    {

        return view('kaur.ajuan.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'jumlah' => 'required',
                'tanggal' => 'required',
                'gambar' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $lastAset = Kebutuhan::orderBy('kd_kebutuhan', 'desc')->first();

            if ($lastAset) {
                $nomorUrutan = intval(substr($lastAset->kd_kebutuhan, 3)) + 1;
                $kode = 'KB' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
            } else {
                $kode = 'KB001';
            }

            $gambar  = time() . 'kebutuhan'  . '.' .  $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);

            Kebutuhan::create([
                'kd_kebutuhan' => $kode,
                'nama_kebutuhan' => $request->nama,
                'tgl_kebutuhan' => $request->tanggal,
                'jumlah' => $request->jumlah,
                'gambar' => $gambar,
                'status' => 'Proses'
            ]);

            return redirect()->route('kaurajuan.index')->with('success', 'Data Pengajuan berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, sebab :', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = Kebutuhan::where('kd_kebutuhan', $id)->first();

        return view('kaur.ajuan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $data = Kebutuhan::where('kd_kebutuhan', $id)->first();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'kebutuhan' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->nama_kebutuhan = $request->nama;
        $data->tgl_kebutuhan = $request->tanggal;
        $data->jumlah = $request->jumlah;
        $data->save();

        if ($data->save()) {
            return redirect()->route('kaurajuan.index')->with('success', 'Data jenis aset berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate jenis aset');
        }
    }

    public function destroy($id)
    {
        $data = Kebutuhan::where('kd_kebutuhan', $id)->first();


        if (!$data) {
            return redirect()->back()->with('error', 'Data kebutuhan tidak ditemukan.');
        }

        $gambarPath = public_path('assets/img/' . $data->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $data->delete();

        return redirect()->route('kaurajuan.index')->with('success', 'Data kebutuhan berhasil dihapus.');
    }
}
