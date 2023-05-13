<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DetailAset;
use Illuminate\Http\Request;
use App\Models\Mutasi;
use Exception;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class KelolaMutasiController extends Controller
{
    public function index()
    {
        $data = Mutasi::query()
            ->join('users', 'users.id', 'mutasi.id_user')
            ->select('mutasi.*', 'users.nama')
            ->get();

        return view('sekretaris.mutasi.index', compact('data'));
    }

    public function view($id)
    {
        $old = Mutasi::query()
            ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_mutasi.id_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('mutasi.*', 'detail_aset.kode_detail', 'detail_aset.gambar', 'detail_aset.tgl_masuk', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset')
            ->where('mutasi.kd_mutasi', $id)
            ->get();

        $new = Aset::query()
            ->join('detail_aset', 'detail_aset.kd_aset', 'aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('aset.*', 'detail_aset.*', 'ruangs.nama_ruang', 'aset.nama_aset')
            ->get();

        return view('sekretaris.mutasi.view', compact('old', 'new'));
    }

    public function update(Request $request, $id)
    {
        $data = Aset::where('kd_aset', $id)->first();

        $data->nama_aset = $request->nama;
        $data->id_user = Auth::user()->id;
        $data->kd_jenis = $request->jenis;
        $data->kd_asal = $request->asal;

        if (!$data->save()) {
            throw new Exception('Gagal menyimpan data aset');
        }

        $kd_aset = $request->kd_aset;
        $kd_detail = $request->kd_detail;
        $ruang = $request->ruang;
        $kondisi = $request->kondisi;

        for ($i = 0; $i < count($kd_detail); $i++) {
            $detail = DetailAset::where('kd_det_aset', $kd_detail[$i])->first();

            $detail->kd_det_aset = $kd_detail[$i];
            $detail->kd_aset = $kd_aset;
            $detail->kd_ruang = $ruang[$i];
            $detail->kd_kondisi = $kondisi[$i];

            if (!$detail->save()) {
                throw new Exception('Gagal menyimpan data detail aset');
            }
        }
    }
}
