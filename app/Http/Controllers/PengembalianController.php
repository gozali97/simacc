<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
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

        return view('kaur.kembali.index', compact('data'));
    }

    public function view($id) {
        $data = Pengembalian::query()
                    ->join('peminjaman', 'peminjaman.kd_peminjaman', 'pengembalian.kd_peminjaman')
                    ->join('detail_peminjaman', 'detail_peminjaman.kd_peminjaman', 'detail_peminjaman.kd_peminjaman')
                    ->join('detail_aset', 'detail_aset.kd_det_aset', 'detail_peminjaman.kd_det_aset')
                    ->join('peminjam', 'peminjam.id_peminjam', 'peminjaman.id_peminjam')
                    ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
                    ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
                    ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
                    ->select('detail_aset.*', 'kondisi.kondisi_aset', 'ruangs.nama_ruang', 'aset.nama_aset','peminjam.nama_peminjam', 'peminjaman.kd_peminjaman','peminjaman.tgl_pinjam')
                    ->where('detail_peminjaman.kd_peminjaman', $id)
                    ->get();
                    // dd($data);

        return view('kaur.kembali.view', compact('data'));
    }
}
