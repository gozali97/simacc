<?php

namespace App\Http\Controllers;

use App\Models\Asal;
use App\Models\DetailAset;
use App\Models\JenisAset;
use App\Models\Kondisi;
use App\Models\Mutasi;
use App\Models\Ruang;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index()
    {

        $data = Mutasi::query()
            ->join('users', 'users.id', 'mutasi.id_user')
            ->select('mutasi.*', 'users.nama')
            ->get();

        return view('kaur.mutasi.index', compact('data'));
    }

    public function view($id)
    {
        $old = Mutasi::query()
            ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_mutasi.id_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('mutasi.*', 'detail_aset.kode_detail', 'detail_aset.kd_det_aset', 'detail_aset.gambar', 'detail_aset.tgl_masuk', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset', 'aset.kd_aset')
            ->where('mutasi.kd_mutasi', $id)
            ->get();


        foreach ($old as $data) {
            $new = DetailAset::query()
                ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
                ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
                ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
                ->select('aset.*', 'detail_aset.*', 'ruangs.nama_ruang', 'aset.nama_aset')
                ->where('aset.kd_aset', $data->kd_aset)
                ->get();
        }

        return view('kaur.mutasi.view', compact('old', 'new'));
    }
}
