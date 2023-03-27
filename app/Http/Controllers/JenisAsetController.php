<?php

namespace App\Http\Controllers;

use App\Models\JenisAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisAsetController extends Controller
{
    public function index()
    {

        $jenis = JenisAset::all();

        return view('sekretaris.jenis.index', compact('jenis'));
    }

    public function create()
    {

        return view('sekretaris.ruang.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            JenisAset::create([
                'nama_jenis' => $request->nama,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('jenis.index')->with('success', 'Data Jenis Aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, sebab :', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $data = JenisAset::find($id);

        $data->nama_jenis = $request->nama;
        $data->save();

        if ($data->save()) {
            return redirect()->route('jenis.index')->with('success', 'Data jenis aset berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate jenis aset');
        }
    }

    public function destroy($id)
    {
        $jenis = JenisAset::find($id);

        if (!$jenis) {
            return redirect()->back()->with('error', 'Data jenis Aset tidak ditemukan.');
        }

        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Data Jenis Aset berhasil dihapus.');
    }
}
