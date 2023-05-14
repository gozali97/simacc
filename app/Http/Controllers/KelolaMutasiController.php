<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DetailAset;
use Illuminate\Http\Request;
use App\Models\Mutasi;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return view('sekretaris.mutasi.view', compact('old', 'new'));
    }

    public function confirm($id)
    {

        try {
            DB::beginTransaction();

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
                    ->where('aset.kd_aset', $data->kd_aset)
                    ->get();

                foreach ($new as $item) {
                    $item->status = "in";
                    $item->save();
                }
            }


            $mutasi = Mutasi::where('kd_mutasi', $id)->first();
            $mutasi->status = "Disetujui";
            $mutasi->save();

            DB::commit();

            return redirect()->route('listmutasi.index')->with('success', 'Mutasi aset berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mutasi aset, ' . $e->getMessage());
        }
    }

    public function decline($id)
    {

        try {
            DB::beginTransaction();

            $old = Mutasi::query()
                ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
                ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
                ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
                ->join('ruangs', 'ruangs.kd_ruang', 'detail_mutasi.id_ruang')
                ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
                ->select('mutasi.*', 'detail_mutasi.id_ruang', 'detail_aset.kode_detail', 'detail_aset.kd_det_aset', 'detail_aset.gambar', 'detail_aset.tgl_masuk', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset', 'aset.kd_aset')
                ->where('mutasi.kd_mutasi', $id)
                ->get();

            foreach ($old as $data) {
                $new = DetailAset::query()
                    ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
                    ->where('aset.kd_aset', $data->kd_aset)
                    ->get();

                foreach ($new as $item) {
                    $item->status = "in";
                    $item->kd_ruang = $data->id_ruang;
                    $item->save();
                }
            }


            $mutasi = Mutasi::where('kd_mutasi', $id)->first();
            $mutasi->status = "Ditolak";
            $mutasi->save();

            DB::commit();

            return redirect()->route('listmutasi.index')->with('success', 'Mutasi aset ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mutasi aset, ' . $e->getMessage());
        }
    }
}
