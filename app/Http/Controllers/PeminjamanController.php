<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DetailAset;
use App\Models\DetailPeminjaman;
use App\Models\JenisAset;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {

        $data = Peminjaman::query()
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('aset', 'aset.kd_aset', 'peminjaman.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('peminjaman.*', 'aset.nama_aset', 'users.nama', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('kaur.pinjaman.index', compact('data'));
    }

    public function create()
    {
        $aset = Aset::query()->where('status', 'Aktif')->get();

        $user = Peminjam::all();

        return view('kaur.pinjaman.create', compact('aset', 'user'));
    }

    public function getDetailAset(Request $request)
    {
        $kd_aset = $request->input('kd_aset');
        $detail = DetailAset::query()->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')->where('detail_aset.kd_aset', $kd_aset)->where('detail_aset.status', 'in')->get();

        return response()->json($detail);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'aset' => 'required',
                'detail.*' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $detail = DetailAset::where('kd_det_aset', $request->detail)->first();

            $jumlahData = Peminjaman::count();

            if ($jumlahData > 0) {
                $nomorUrutan = $jumlahData + 1;
                $kode = 'PJ00' . $nomorUrutan;
            } else {
                $kode = 'PJ001';
            }

            $pinjam = new Peminjaman;
            $pinjam->kd_peminjaman = $kode;
            $pinjam->id_user = Auth::user()->id;
            $pinjam->id_peminjam = $request->nama;
            $pinjam->kd_aset = $request->aset;
            $pinjam->tgl_pinjam = date('Y-m-d');
            $pinjam->status = "Proses";

            if ($pinjam->save()) {

                $pinjamDetails = [];
                $nomor = 0;

                $jumlahDetail = DetailPeminjaman::max('kd_det_peminjaman');

                    if ($jumlahDetail > 0) {
                        $nomor = intval(substr($jumlahDetail, 5));
                    } else {
                        $kodeDetail = 'PNJ001';
                    }

                foreach ($request->detail as $key => $pinjamdetail){

                    $nomor++;
                    $kodeDetail = 'PNJ' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

                    $detailAset = DetailAset::where('kd_det_aset', $pinjamdetail)->first();

                    $detail = [
                        'kd_det_peminjaman' => $kodeDetail,
                        'kd_peminjaman' => $pinjam->kd_peminjaman,
                        'kd_det_aset' => $pinjamdetail,
                        'tgl_pinjam' => date('Y-m-d'),
                        'created_at' => date('Y-m-d')
                    ];

                    if ($detailAset) {
                        $detailAset->status = 'out';
                        $detailAset->save();
                    }

                    $pinjamDetails[] = $detail;
                }
                DetailPeminjaman::insert($pinjamDetails);
                DB::commit();
                return redirect()->route('kaurpinjam.index')->with('success', 'Data Peminjaman berhasil ditambahkan.');
            }
            // Redirect ke halaman index kategori dengan pesan sukses
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, '. $e->getMessage());
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

    public function destroy($id)
    {
        $data = Peminjaman::where('id_peminjaman', $id)->first();

        $aset = Aset::where('kd_aset', $data->kd_aset)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data Peminjaman tidak ditemukan.');
        }

        $data->delete();

        $aset->stok += $data->jml_peminjaman;
        $aset->save();

        return redirect()->route('kaurpinjam.index')->with('success', 'Data Peminjaman berhasil dihapus.');
    }
}
