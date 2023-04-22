<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    public function index()
    {

        $ruang = Ruang::all();

        return view('kaur.ruang.index', compact('ruang'));
    }

    public function create()
    {

        return view('kaur.ruang.create');
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

            $lastData = Ruang::orderBy('kd_ruang', 'desc')->first();

            if ($lastData) {
                $nomorUrutan = intval(substr($lastData->kd_ruang, 3)) + 1;
                $kode = 'R' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
            } else {
                $kode = 'R001';
            }

            Ruang::create([
                'kd_ruang' => $kode,
                'nama_ruang' => $request->nama
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('ruang.index')->with('success', 'Data Ruang berhasil ditambahkan.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, sebab :', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $data = Ruang::where('kd_ruang',$id)->first();

        $data->nama_ruang = $request->nama;
        $data->save();

        if ($data->save()) {
            return redirect()->route('ruang.index')->with('success', 'Data Ruang berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate ruang');
        }
    }

    public function destroy($id)
    {
        $ruang = Ruang::where('kd_ruang',$id)->first();

        if (!$ruang) {
            return redirect()->back()->with('error', 'Ruang tidak ditemukan.');
        }

        $ruang->delete();

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}
