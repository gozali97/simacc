<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DetailAset;
use App\Models\DetailPenghapusan;
use App\Models\Penghapusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaPenghapusanController extends Controller
{
    public function index()
    {

        $data = Penghapusan::query()
            ->join('users', 'users.id', 'penghapusan.id_user')
            ->join('aset', 'aset.kd_aset', 'penghapusan.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('penghapusan.*', 'aset.nama_aset', 'users.nama', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('sekretaris.hapus.index', compact('data'));
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
        return view('sekretaris.hapus.view', compact('data'));
    }

    public function confirm(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $penghapusan = Penghapusan::where('kd_penghapusan', $id)->first();
            $penghapusan->status = "Disetujui";

            if (!$penghapusan->save()) {
                return redirect()->back()->with('error', 'gagal menyimpan penghapusan aset.');
            }

            $detailHapus = DetailPenghapusan::where('kd_penghapusan', $id)->get();


            foreach ($detailHapus as $detail) {

                $detail = DetailAset::where('kd_det_aset', $detail->kd_det_aset)
                    ->where('kd_aset', $request->kd_aset)
                    ->first();

                if (!$detail) {
                    return redirect()->back()->with('error', 'Detail aset tidak ditemukan.');
                }

                //$detail->status = 'deleted';
                $detail->status = 'del';

                // Hapus detail aset
                if (!$detail->save()) {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus detail aset.');
                }
            }

            // Periksa jumlah detail aset yang tersisa untuk aset yang sama
            // $remainingDetails = DetailAset::where('kd_aset', $request->kd_aset)->count();

            // Hapus aset jika tidak ada detail aset yang tersisa
            // if ($remainingDetails == 0) {
            //     // Temukan aset berdasarkan kd_aset
            //     $aset = Aset::where('kd_aset', $request->kd_aset)->first();

            //     if (!$aset) {
            //         return redirect()->back()->with('error', 'Aset tidak ditemukan.');
            //     }

            //     // Hapus aset
            //     if (!$aset->delete()) {
            //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus aset.');
            //     }
            // }
            DB::commit();
            return redirect()->route('listhapus.index')->with('success', 'Penghapusan aset berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mutasi aset, ' . $e->getMessage());
        }
    }

    public function decline(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $penghapusan = Penghapusan::where('kd_penghapusan', $id)->first();
            $penghapusan->status = "Ditolak";

            if (!$penghapusan->save()) {
                return redirect()->back()->with('error', 'gagal menyimpan penghapusan aset.');
            }

            $detailHapus = DetailPenghapusan::where('kd_penghapusan', $id)->get();

            foreach ($detailHapus as $detail) {

                $detail = DetailAset::where('kd_det_aset', $detail->kd_det_aset)
                    ->where('kd_aset', $request->kd_aset)
                    ->first();

                if (!$detail) {
                    return redirect()->back()->with('error', 'Detail aset tidak ditemukan.');
                }

                $detail->status = "in";

                if (!$detail->save()) {
                    throw new \Exception('Gagal mengubah status DetailAset.');
                }
            }

            DB::commit();
            return redirect()->route('listhapus.index')->with('success', 'Penghapusam aset berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mutasi aset, ' . $e->getMessage());
        }
    }
}
