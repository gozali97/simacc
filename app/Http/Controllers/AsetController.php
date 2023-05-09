<?php

namespace App\Http\Controllers;

use App\Models\Asal;
use App\Models\Aset;
use App\Models\DetailAset;
use App\Models\DetailMutasi;
use App\Models\JenisAset;
use App\Models\Kondisi;
use App\Models\Mutasi;
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

        return view('kaur.aset.create', compact('jenis', 'ruang', 'kondisi' , 'asal'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); // Memulai transaksi database

            $lastAset = Aset::orderBy('kd_aset', 'desc')->first();

            if ($lastAset) {
                $nomorUrutan = intval(substr($lastAset->kd_aset, 3)) + 1;
                $kode = 'A' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
            } else {
                $kode = 'A001';
            }

            $aset = new Aset;
            $aset->kd_aset = $kode;
            $aset->nama_aset = $request->nama;
            $aset->id_user = Auth::user()->id;
            $aset->kd_jenis = $request->jenis;
            $aset->kd_asal = $request->asal;
            $aset->status = 'Pending';
            if ($aset->save()) {

                $asetDetails = [];
                $nomor = 0;
                $jumlahDetail = DetailAset::max('kd_det_aset');

                    if ($jumlahDetail > 0) {
                        $nomor = intval(substr($jumlahDetail, 5));
                    } else {
                        $kodeDetail = 'INV001';
                    }

                foreach ($request->ruang as $key => $asetdetail){
                    $gambar  = time() . 'aset' . $key . '.' . $request->gambar[$key]->extension();
                    $path = $request->file('gambar')[$key]->move('assets/img', $gambar);

                    $nomor++;
                    $kodeDetail = 'INV' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

                    $detail = [
                        'kd_det_aset' => $kodeDetail,
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
            dd($e);
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
        $detail = DetailAset::where('kd_aset', $data->kd_aset)->get();
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
            $data = Aset::where('kd_aset', $id)->first();

            $data->nama_aset = $request->nama;
            $data->id_user = Auth::user()->id;
            $data->kd_jenis = $request->jenis;
            $data->kd_asal = $request->asal;

            if(!$data->save()){
                throw new Exception('Gagal menyimpan data aset');
            }

            $kd_aset = $request->kd_aset;
            $kd_detail = $request->kd_detail;
            $ruang = $request->ruang;
            $kondisi = $request->kondisi;

            for($i=0; $i<count($kd_detail); $i++) {
                $detail = DetailAset::where('kd_det_aset', $kd_detail[$i])->first();

                $detail->kd_det_aset = $kd_detail[$i];
                $detail->kd_aset = $kd_aset;
                $detail->kd_ruang = $ruang[$i];
                $detail->kd_kondisi = $kondisi[$i];

                if(!$detail->save()){
                    throw new Exception('Gagal menyimpan data detail aset');
                }
            }

            $mutasi = new Mutasi;
            $mutasi->nama_mutasi = $request->nama_mutasi;
            $mutasi->id_user = Auth::user()->id;
            $mutasi->status = 'Aktif';
            $mutasi->created_at = date('Y-m-d');

            if (!$mutasi->save()) {
                throw new Exception('Gagal menyimpan data mutasi');
            }

            $details = DetailAset::where('kd_aset', $request->kd_aset)->get();
            foreach($details as $d){
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

            DB::commit();

            return redirect()->route('aset.index')->with('success', 'Data Aset berhasil diperbarui.');

        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data, ' . $e->getMessage());
        }
    }

    public function updateDetail(Request $request, $id)
    {
        dd($request->all());
        $data = DetailAset::where('kd_det_aset', $id)->first();
        // dd($data);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }


            $gambar = time() . 'aset' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->kd_aset = $request->kd_aset;
        $data->kd_ruang = $request->ruang;
        $data->kd_kondisi = $request->kondisi;
        $data->updated_at = date('Y-m-d');
        $data->save();

        if ($data->save()) {
            return redirect()->route('aset.edit', $request->kd_aset)->with('success', 'Detail Aset berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate detail aset');
        }
    }

    public function destroy($id)
    {
        $aset = Aset::where('kd_aset',$id)->first();

        $detail = DetailAset::where('kd_aset', $id)->get();


        if (!$aset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        foreach($detail as $details){
            $gambarPath = public_path('assets/img/' . $details->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }

        $detail->each->delete();

        $aset->delete();

        return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus.');
    }
}
