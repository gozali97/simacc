<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DetailAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelolaAsetController extends Controller
{
    public function index(Request $request)
    {
        $kd_aset = $request->kd_aset;

        $data = Aset::query()
            ->join('asal', 'asal.id', 'aset.kd_asal')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('aset.*', 'asal.asal_aset', 'jenis_asets.nama_jenis')
            ->get();

        return view('sekretaris.listaset.index', compact('data'));
    }

    public function view($id)
    {

        $data = DetailAset::query()
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('users', 'users.id', 'aset.id_user')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('aset.nama_aset', 'aset.kd_aset', 'aset.status as status_aset', 'detail_aset.*', 'users.nama', 'kondisi.kondisi_aset', 'ruangs.nama_ruang')
            ->where('detail_aset.kd_aset', $id)
            ->get();

        return view('sekretaris.listaset.view', compact('data'));
    }

    public function confirm($id)
    {

        $data = Aset::query()->where('kd_aset', $id)->first();

        $data->status = "Aktif";
        $data->save();
        if ($data->save()) {
            return redirect()->route('listaset.index')->with('success', 'Data Aset berhasil dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kebutuhan');
        }
    }

    public function decline($id)
    {

        $data = Aset::query()->where('kd_aset', $id)->first();

        $data->status = "Ditolak";
        $data->save();

        if ($data->save()) {
            return redirect()->route('listaset.index')->with('success', 'Data aset ditolak.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kebutuhan');
        }
    }
}
