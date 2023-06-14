<?php

namespace App\Http\Controllers;

use App\Models\Asal;
use App\Models\Aset;
use App\Models\DetailAset;
use App\Models\DetailMutasi;
use App\Models\DetailPenghapusan;
use App\Models\JenisAset;
use App\Models\Kondisi;
use App\Models\Mutasi;
use App\Models\Penghapusan;
use App\Models\Ruang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsetController extends Controller
{
    public function index()
    {

        $aset = Aset::query()
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->select('aset.*', 'jenis_asets.nama_jenis as jenis')
            ->get();

        return view('kaur.aset.index', compact('aset'));
    }

    public function create()
    {
        $jenis = JenisAset::all();
        $ruang = Ruang::all();
        $kondisi = Kondisi::all();
        $asal = Asal::all();

        return view('kaur.aset.create', compact('jenis', 'ruang', 'kondisi', 'asal'));
    }

    public function store(Request $request)
    {
        try {


            DB::beginTransaction();


            $aset = new Aset;
            $aset->nama_aset = $request->nama;
            $aset->id_user = Auth::user()->id;
            $aset->kd_jenis = $request->jenis;
            $aset->kd_asal = $request->asal;
            $aset->status = 'Pending';
            if ($aset->save()) {

                $asetDetails = [];
                foreach ($request->ruang as $key => $asetdetail) {
                    $gambar  = time() . 'aset' . $key . '.' . $request->gambar[$key]->extension();
                    $path = $request->file('gambar')[$key]->move('assets/img', $gambar);


                    $detail = [
                        'kode_detail' => $request->kode[$key],
                        'kd_aset' => $aset->kd_aset,
                        'kd_ruang' => $asetdetail,
                        'kd_kondisi' => $request->kondisi[$key],
                        'gambar' => $gambar,
                        'tgl_masuk' => date('Y-m-d'),
                        'status' => 'in',
                        'created_at' => date('Y-m-d')
                    ];
                    $asetDetails[] = $detail;
                }
                DetailAset::insert($asetDetails);

                DB::commit();

                return redirect()->route('aset.index')->with('success', 'Data Aset berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $data = Aset::where('kd_aset', $id)->first();
        $detail = DetailAset::where('kd_aset', $data->kd_aset)->get();
        $jenis = JenisAset::all();
        $ruang = Ruang::all();
        $kondisi = Kondisi::all();
        $asal = Asal::all();

        return view('kaur.aset.edit', compact('data', 'jenis', 'ruang', 'kondisi', 'asal', 'detail'));
    }

    public function view($id)
    {
        $data = Aset::where('kd_aset', $id)->first();
        $detail = DetailAset::query()
            ->join('aset', 'aset.kd_aset', 'detail_aset.kd_aset')
            ->join('ruangs', 'ruangs.kd_ruang', 'detail_aset.kd_ruang')
            ->join('kondisi', 'kondisi.id', 'detail_aset.kd_kondisi')
            ->select('detail_aset.*', 'aset.nama_aset', 'ruangs.nama_ruang', 'kondisi.kondisi_aset')
            ->where('detail_aset.kd_aset', $data->kd_aset)
            ->get();

        $jenis = JenisAset::all();
        $ruang = Ruang::all();
        $kondisi = Kondisi::all();
        $asal = Asal::all();

        return view('kaur.aset.view', compact('data', 'jenis', 'ruang', 'kondisi', 'asal', 'detail'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $mutasi = new Mutasi;
            $mutasi->nama_mutasi = $request->nama_mutasi;
            $mutasi->id_user = Auth::user()->id;
            $mutasi->status = 'Aktif';
            $mutasi->created_at = date('Y-m-d');

            if (!$mutasi->save()) {
                throw new Exception('Gagal menyimpan data mutasi');
            }

            $details = DetailAset::where('kd_aset', $request->kd_aset)->get();

            foreach ($details as $d) {
                $mutasiDetail = new DetailMutasi;
                $mutasiDetail->kd_mutasi = $mutasi->kd_mutasi;
                $mutasiDetail->kd_detail_aset = $d->kd_det_aset;
                $mutasiDetail->id_ruang = $d->kd_ruang;
                $mutasiDetail->tgl_mutasi = date('Y-m-d');
                $mutasiDetail->created_at = date('Y-m-d');

                if (!$mutasiDetail->save()) {
                    throw new Exception('Gagal menyimpan data detail mutasi');
                }
            }

            $data = Aset::where('kd_aset', $id)->first();

            $data->nama_aset = $request->nama;
            $data->id_user = Auth::user()->id;
            $data->kd_jenis = $request->jenis;
            $data->kd_asal = $request->asal;

            if (!$data->save()) {
                throw new Exception('Gagal menyimpan data aset');
            }

            $kd_aset = $request->kd_aset;
            $kd_detail = $request->kd_detail;
            $ruang = $request->ruang;
            $kondisi = $request->kondisi;

            for ($i = 0; $i < count($kd_detail); $i++) {
                $detail = DetailAset::where('kd_det_aset', $kd_detail[$i])->first();

                $detail->kd_det_aset = $kd_detail[$i];
                $detail->kd_aset = $kd_aset;
                $detail->kd_ruang = $ruang[$i];
                $detail->kd_kondisi = $kondisi[$i];
                $detail->status = "mut";

                if (!$detail->save()) {
                    throw new Exception('Gagal menyimpan data detail aset');
                }
            }

            DB::commit();

            return redirect()->route('aset.index')->with('success', 'Berhasil menyimpan mutasi Aset.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mutasi aset, ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {

        $data = Aset::query()
            ->join('detail_aset', 'detail_aset.kd_aset', 'aset.kd_aset')
            ->join('jenis_asets', 'jenis_asets.kd_jenis', 'aset.kd_jenis')
            ->where('aset.kd_aset', $id)
            //kondisi aset ready
             ->where('detail_aset.status', 'in')
            ->get();
        $kondisi = Kondisi::all();

        return view('kaur.aset.hapus-aset', compact('data', 'kondisi'));
    }

    public function destroyAset(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->has('kd_det_aset')) {
                return redirect()->back()->with('error', 'Kode detail aset tidak ditemukan dalam request.');
            }

            $hapusAset = new Penghapusan;
            $hapusAset->id_user = Auth::user()->id;
            $hapusAset->kd_aset = $request->kd_aset;
            $hapusAset->tgl_penghapusan = date('Y-m-d');
            $hapusAset->status = "Proses";

            if (!$hapusAset->save()) {
                throw new \Exception('Gagal menyimpan data Penghapusan.');
            }

            $kdDetAsetArray = $request->kd_det_aset;

            foreach ($kdDetAsetArray as $key => $detailAset) {
                $detailHapus = new DetailPenghapusan;
                $detailHapus->kd_penghapusan =  $hapusAset->kd_penghapusan;
                $detailHapus->tgl_penghapusan = date('Y-m-d');
                $detailHapus->kd_det_aset = $detailAset;
                $detailHapus->kondisi_akhir = $request->kondisi;

                if (!$detailHapus->save()) {
                    throw new \Exception('Gagal menyimpan data DetailPenghapusan.');
                }
            }

            foreach ($kdDetAsetArray as $kdDetAset) {
                // Temukan detail aset berdasarkan kd_det_aset
                $detail = DetailAset::where('kd_det_aset', $kdDetAset)->first();

                if (!$detail) {
                    return redirect()->back()->with('error', 'Detail aset tidak ditemukan.');
                }

                //$detail->status = "out";
                $detail->status = "del";

                if (!$detail->save()) {
                    throw new \Exception('Gagal mengubah status DetailAset.');
                }
            }

            DB::commit();
            return redirect()->route('aset.index')->with('success', 'Permohonan hapus aset berhasil.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat permohonan hapus aset, ' . $e->getMessage());
        }
    }
}
