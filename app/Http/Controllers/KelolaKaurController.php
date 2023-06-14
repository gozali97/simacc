<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KelolaKaurController extends Controller
{
    public function index()
    {

        $kaur = User::where('role_id', 3)->get();

        return view('sekretaris.kaur.index', compact('kaur'));
    }

    public function create()
    {

        return view('sekretaris.kaur.create');
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

            $gambar  = time() . 'kaur' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

        $userexist = User::where('email', $request->email)->first();
            if ($userexist) {
                return redirect()->back()->with('error', 'Email sudah digunakan.');
            }
            
            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'gambar' => $gambar,
                'role_id' => 3,
                'password' => Hash::make('12345678')
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('kaurs.index')->with('success', 'Data Kaur berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data anggota.');
        }
    }

    public function edit($id)
    {
        $data = User::find($id);

        return view('sekretaris.kaur.edit', compact('data'));
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
            return redirect()->route('kaurs.index')->with('success', 'Data Kaur berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kaur');
        }
    }

    public function reset_password(Request $request, $id)
    {
        $kaur = User::find($id);

        if (!$kaur) {
            return redirect()->back()->with('error', 'Kaur tidak ditemukan.');
        }

        $kaur->password = Hash::make($request->password);
        $kaur->save();

        return redirect()->back()->with('success', 'Password kaur berhasil direset.');
    }

    public function destroy($id)
    {
        $kaur = User::find($id);

        if (!$kaur) {
            return redirect()->back()->with('error', 'Kaur tidak ditemukan.');
        }

        // Hapus gambar dari server
        $gambarPath = public_path('assets/img/' . $kaur->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $kaur->delete();

        return redirect()->route('kaurs.index')->with('success', 'Kaur berhasil dihapus.');
    }
}
