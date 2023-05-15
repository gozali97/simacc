<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Mutasi;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Penghapusan;
use App\Models\Perencanaan;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{

    public function aset()
    {
        $data = Aset::query()
            ->join('detail_aset', 'detail_aset.kd_aset', 'aset.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('aset.nama_aset', 'detail_aset.kode_detail', 'detail_aset.gambar', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang', 'kondisi.kondisi_aset')
            ->get();

        return view('kades.laporan.aset', compact('data'));
    }

    public function asetPrint()
    {

        $data = Aset::query()
            ->join('detail_aset', 'detail_aset.kd_aset', 'aset.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('aset.nama_aset', 'detail_aset.kode_detail', 'detail_aset.gambar', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang', 'kondisi.kondisi_aset')
            ->get();

        $pdf = Pdf::loadView('kades.laporan.aset-pdf', compact('data'));
        return $pdf->download('laporan-data-aset.pdf');
    }

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

    public function peminjaman()
    {
        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.kd_peminjaman', 'peminjaman.kd_peminjaman')
            ->join('peminjam', 'peminjam.id_peminjam', 'peminjaman.id_peminjam')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_peminjaman.kd_det_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('peminjaman.tgl_pinjam', 'detail_aset.kode_detail', 'aset.nama_aset', 'peminjam.nama_peminjam', 'peminjaman.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        return view('kades.laporan.peminjaman', compact('data'));
    }

    public function peminjamanPrint()
    {

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.kd_peminjaman', 'peminjaman.kd_peminjaman')
            ->join('peminjam', 'peminjam.id_peminjam', 'peminjaman.id_peminjam')
            ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_peminjaman.kd_det_aset')
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('peminjaman.tgl_pinjam', 'detail_aset.kode_detail', 'aset.nama_aset', 'peminjam.nama_peminjam', 'peminjaman.status', 'jenis_asets.nama_jenis', 'ruangs.nama_ruang')
            ->get();

        $pdf = Pdf::loadView('kades.laporan.peminjaman-pdf', compact('data'));
        return $pdf->download('laporan-data-peminjaman.pdf');
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

    public function hapus()
    {
        $data = Penghapusan::query()
            ->join('detail_penghapusan', 'detail_penghapusan.kd_penghapusan', 'penghapusan.kd_penghapusan')
            ->join('users', 'users.id', 'penghapusan.id_user')
            ->join('aset', 'aset.kd_aset', 'penghapusan.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('penghapusan.tgl_penghapusan', 'aset.nama_aset', 'users.nama', 'penghapusan.status', 'jenis_asets.nama_jenis',)
            ->get();

        return view('kades.laporan.penghapusan', compact('data'));
    }

    public function hapusPrint()
    {

        $data = Penghapusan::query()
            ->join('detail_penghapusan', 'detail_penghapusan.kd_penghapusan', 'penghapusan.kd_penghapusan')
            ->join('users', 'users.id', 'penghapusan.id_user')
            ->join('aset', 'aset.kd_aset', 'penghapusan.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('penghapusan.tgl_penghapusan', 'aset.nama_aset', 'users.nama', 'penghapusan.status', 'jenis_asets.nama_jenis',)
            ->get();

        $pdf = Pdf::loadView('kades.laporan.penghapusan-pdf', compact('data'));
        return $pdf->download('laporan-data-penghapusan.pdf');
    }

    public function rencana()
    {
        $data = Perencanaan::query()
            ->select('perencanaan.*')
            ->get();

        return view('kades.laporan.rencana', compact('data'));
    }

    public function rencanaPrint()
    {

        $data = Perencanaan::query()
            ->select('perencanaan.*')
            ->get();

        $pdf = Pdf::loadView('kades.laporan.rencana-pdf', compact('data'));
        return $pdf->download('laporan-data-perencanaan.pdf');
    }
}