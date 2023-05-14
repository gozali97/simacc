<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KadesMasterController extends Controller
{
    public function index()
    {
        $data = User::where('role_id', 2)->get();

        return view('kades.sekretaris.index', compact('data'));
    }

    public function indexKaur()
    {
        $data = User::where('role_id', 3)->get();

        return view('kades.kaur.index', compact('data'));
    }

    public function indexPeminjam()
    {
        $data = Peminjam::all();

        return view('kades.peminjam.index', compact('data'));
    }


    public function create()
    {

        return view('kades.sekretaris.create');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required|max:255',
                'no_hp' => 'required|numeric',
                'alamat' => 'required|max:255',
                'gambar' => 'required|image',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'profil' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'gambar' => $gambar,
                'role_id' => 2,
                'password' => Hash::make('12345678')
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('kades.sekretaris')->with('success', 'Data Sekretaris berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data Sekretaris.' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = User::find($id);

        return view('kades.sekretaris.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $data = User::find($id);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'profil' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->alamat = $request->alamat;
        $data->save();

        if ($data->save()) {
            return redirect()->route('kades.sekretaris')->with('success', 'Data Sekretaris berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate Sekretaris');
        }
    }

    public function reset_password(Request $request, $id)
    {
        $kaur = User::find($id);

        if (!$kaur) {
            return redirect()->back()->with('error', 'Sekretaris tidak ditemukan.');
        }

        $kaur->password = Hash::make($request->password);
        $kaur->save();

        return redirect()->back()->with('success', 'Password Sekretaris berhasil direset.');
    }

    public function destroy($id)
    {
        $data = User::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Sekretaris tidak ditemukan.');
        }

        // Hapus gambar dari server
        $gambarPath = public_path('assets/img/' . $data->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $data->delete();

        return redirect()->route('kades.sekretaris')->with('success', 'Sekretaris berhasil dihapus.');
    }
}
