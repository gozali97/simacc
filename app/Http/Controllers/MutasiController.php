<?php

namespace App\Http\Controllers;

use App\Models\Asal;
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
            // ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
            // ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
            // ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            // ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('mutasi.*', 'users.nama')
            ->get();

        return view('kaur.mutasi.index', compact('data'));
    }

    public function create()
    {
        $jenis = JenisAset::all();
        $ruang = Ruang::all();
        $kondisi = Kondisi::all();
        $asal = Asal::all();

        return view('kaur.mutasi.create', compact('jenis', 'ruang', 'kondisi' , 'asal'));
    }
}
