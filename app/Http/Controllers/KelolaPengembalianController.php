<?php

namespace App\Http\Controllers;

use App\Models\DetailAset;
use App\Models\DetailPengembalian;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class KelolaPengembalianController extends Controller
{
    public function index()
    {

        $data = Pengembalian::query()
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->join('peminjaman', 'peminjaman.kd_peminjaman', 'pengembalian.kd_peminjaman')
            ->join('aset', 'aset.kd_aset', 'peminjaman.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('pengembalian.*', 'aset.nama_aset', 'users.nama', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('sekretaris.listkembali.index', compact('data'));
    }

    public function view($id)
    {
        $data = Pengembalian::query()
            ->join('peminjaman', 'peminjaman.kd_peminjaman', 'pengembalian.kd_peminjaman')
            ->join('detail_peminjaman', 'detail_peminjaman.kd_peminjaman', 'peminjaman.kd_peminjaman')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_peminjaman.kd_det_aset')
            ->join('peminjam', 'peminjam.id_peminjam', 'peminjaman.id_peminjam')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('detail_aset.*', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset', 'peminjam.nama_peminjam', 'peminjaman.kd_peminjaman', 'peminjaman.tgl_pinjam')
            ->where('detail_peminjaman.kd_peminjaman', $id)
            ->get();

        return view('sekretaris.listkembali.view', compact('data'));
    }

    public function confirm($id)
    {

        $data = Pengembalian::query()->where('kd_kembali', $id)->first();

        $data->status = "Selesai";
        $data->save();

        if ($data->save()) {

            $detail = Pengembalian::query()
                ->join('peminjaman', 'peminjaman.kd_peminjaman', 'pengembalian.kd_peminjaman')
                ->join('detail_peminjaman', 'detail_peminjaman.kd_peminjaman', 'peminjaman.kd_peminjaman')
                ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_peminjaman.kd_det_aset')
                ->where('peminjaman.kd_peminjaman', $data->kd_peminjaman)
                ->get();

            foreach ($detail as $det) {
                $detailAset = DetailAset::where('kd_det_aset', $det->kd_det_aset)->first();
                $detailAset->status = "in";
                $detailAset->save();
            }
            return redirect()->route('listkembali.index')->with('success', 'Data Pengembalian berhasil dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kaur');
        }
    }

    public function decline($id)
    {

        $data = Pengembalian::query()->where('kd_kembali', $id)->first();
        $data->status = "Ditolak";
        $data->save();

        if ($data->save()) {

            $pinjam =  Peminjaman::where('kd_peminjaman', $data->kd_peminjaman)->first();
            $pinjam->status = "Aktif";
            $pinjam->save();

            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman ditolak.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kaur');
        }
    }
}
