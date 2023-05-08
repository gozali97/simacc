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
        ->join('detail_penghapusan', 'detail_penghapusan.kd_penghapusan', 'penghapusan.kd_penghapusan')
        ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_penghapusan.kd_det_aset')
        ->join('aset', 'aset.kd_aset', 'aset.kd_aset')
        ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
        ->select('penghapusan.*', 'aset.nama_aset', 'users.nama', 'jenis_asets.nama_jenis as jenis')
        ->get();

        return view('kaur.hapus.index', compact('data'));
    }
}
