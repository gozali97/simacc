<?php

namespace App\Http\Controllers;

use App\Models\Penghapusan;
use Illuminate\Http\Request;

class PenghapusanController extends Controller
{
    public function index()
    {

        $data = Penghapusan::query()
            ->join('users', 'users.id', 'penghapusan.id_user')
            ->join('aset', 'aset.kd_aset', 'penghapusan.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('penghapusan.*', 'aset.nama_aset', 'users.nama', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('kaur.hapus.index', compact('data'));
    }

    public function view($id)
    {
        $data = Penghapusan::query()
            ->join('detail_penghapusan', 'detail_penghapusan.kd_penghapusan', 'penghapusan.kd_penghapusan')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_penghapusan.kd_det_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->join('users', 'users.id', 'penghapusan.id_user')
            ->select('penghapusan.*', 'detail_aset.*', 'users.nama', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset',)
            ->where('penghapusan.kd_penghapusan', $id)
            ->get();


        return view('kaur.hapus.view', compact('data'));
    }
}
