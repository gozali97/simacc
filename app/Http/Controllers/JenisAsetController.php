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

        return view('kaur.jenis.index', compact('jenis'));
    }

    public function create()
    {

        return view('kaur.ruang.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $jumlahData = JenisAset::count();

            if ($jumlahData > 0) {
                $nomorUrutan = $jumlahData + 1;
                $kode = 'J00' . $nomorUrutan;
            } else {
                $kode = 'J001';
            }

            JenisAset::create([
                'kd_jenis' => $kode,
                'nama_jenis' => $request->nama
            ]);

            return redirect()->route('jenis.index')->with('success', 'Data Jenis Aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, sebab :', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $data = JenisAset::where('kd_jenis', $id)->first();
   
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
        $jenis = JenisAset::where('kd_jenis', $id)->first();


        if (!$jenis) {
            return redirect()->back()->with('error', 'Data jenis Aset tidak ditemukan.');
        }

        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Data Jenis Aset berhasil dihapus.');
    }
}
