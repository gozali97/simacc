<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelolaPeminjamanController extends Controller
{
    public function index()
    {

        $data = Peminjaman::query()
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('asets', 'asets.kd_aset', 'peminjaman.kd_aset')
            ->join('details_asets', 'details_asets.kd_aset', 'asets.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'asets.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'asets.kd_jenis')
            ->select('peminjaman.*', 'asets.nama_aset', 'details_asets.gambar', 'users.nama', 'ruangs.nama_ruang as ruang', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('sekretaris.listpinjaman.index', compact('data'));
    }

    public function confirm(Request $request, $id)
    {
       $id_pinjam = $request->id_pinjam;

        $data = Peminjaman::query()->where('id_peminjaman', $id_pinjam)->first();

        $data->status = "Aktif";
        $data->save();

        if ($data->save()) {
            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman berhasil dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kaur');
        }
    }

    public function decline(Request $request, $id)
    {
       $id_pinjam = $request->id_pinjam;

        $data = Peminjaman::query()->where('id_peminjaman', $id_pinjam)->first();

        $data->status = "Ditolak";
        $data->save();

        if ($data->save()) {
            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman ditolak.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kaur');
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'aset' => 'required',
                'tgl_pinjam' => 'required',
                'jumlah' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $aset = Aset::where('kd_aset', $request->aset)->first();
            // dd($request->jumlah > $aset->stok);

            if (!$aset || $aset->stok == 0 || $request->jumlah > $aset->stok) {
                return redirect()->back()->with('error', 'Aset tidak dapat dipinjam karena stoknya kosong atau jumlah yang dipinjam melebihi stok yang tersedia.');
            }

            Peminjaman::create([
                'id_user' => $request->id_user,
                'kd_aset' => $request->aset,
                'tgl_pinjam' => $request->tgl_pinjam,
                'jml_peminjaman' => $request->jumlah,
                'status' => "Proses",
            ]);

            // Kurangi stok aset sesuai jumlah yang dipinjam
            $aset->stok -= $request->jumlah;
            $aset->save();

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('kaurpinjam.index')->with('success', 'Data Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, ', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = Peminjaman::query()
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('asets', 'asets.kd_aset', 'peminjaman.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'asets.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'asets.kd_jenis')
            ->select('peminjaman.*', 'asets.nama_aset', 'ruangs.nama_ruang as ruang', 'jenis_asets.nama_jenis as jenis', 'users.nama')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        $aset = Aset::all();

        return view('kaur.pinjaman.edit', compact('data', 'aset'));
    }

    public function update(Request $request, $id)
    {

        $data = Peminjaman::find($id);

        $aset = Aset::where('kd_aset', $data->kd_aset)->first();

        $count = $data->jml_peminjaman;

        $countStok = $count += $aset->stok;
        // dd($countStok);

        if (!$aset || $countStok  < $request->jumlah) {
            return redirect()->back()->with('error', 'Aset tidak dapat dipinjam karena stoknya kosong atau jumlah yang dipinjam melebihi stok yang tersedia.');
        }

        $stok = $countStok - $request->jumlah;
        // dd($stok);

        if ($stok <= 0) {
            $aset->stok = $stok;
        } else {
            $aset->stok += $stok;
        }

        $data->kd_aset = $request->aset;
        $data->tgl_pinjam = $request->tgl_pinjam;
        $data->jml_peminjaman = $request->jumlah;

        if ($data->save() && $aset->save()) {
            return redirect()->route('kaurpinjam.index')->with('success', 'Data Aset berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate aset');
        }
    }
}
