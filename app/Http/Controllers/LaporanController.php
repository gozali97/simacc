<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Peminjam;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{

    public function user()
    {
        $data = Peminjam::all();

        return view('kades.laporan.peminjam', compact('data'));
    }

    public function userPrint()
    {

        $data = Peminjam::all();

        $pdf = Pdf::loadView('kades.laporan.peminjam-pdf', compact('data'));
        return $pdf->download('laporan-data-peminjam.pdf');
    }

    public function kembali()
    {
        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.kd_kembali', 'pengembalian.kd_kembali')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_pengembalian.kd_det_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('pengembalian.tgl_kembali', 'aset.nama_aset', 'pengembalian.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        return view('kades.laporan.pengembalian', compact('data'));
    }

    public function kembaliPrint()
    {

        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.kd_kembali', 'pengembalian.kd_kembali')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_pengembalian.kd_det_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('pengembalian.tgl_kembali', 'aset.nama_aset', 'pengembalian.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        $pdf = Pdf::loadView('kades.laporan.pengembalian-pdf', compact('data'));
        return $pdf->download('laporan-data-pengembalian.pdf');
    }

    public function mutasi()
    {
        $data = Mutasi::query()
            ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_mutasi.id_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('detail_mutasi.tgl_mutasi', 'mutasi.nama_mutasi', 'aset.nama_aset', 'mutasi.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        return view('kades.laporan.mutasi', compact('data'));
    }

    public function mutasiPrint()
    {

        $data = Mutasi::query()
            ->join('detail_mutasi', 'detail_mutasi.kd_mutasi', 'mutasi.kd_mutasi')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_mutasi.kd_detail_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_mutasi.id_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('detail_mutasi.tgl_mutasi', 'mutasi.nama_mutasi', 'aset.nama_aset', 'mutasi.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        $pdf = Pdf::loadView('kades.laporan.mutasi-pdf', compact('data'));
        return $pdf->download('laporan-data-mutasi.pdf');
    }
}
