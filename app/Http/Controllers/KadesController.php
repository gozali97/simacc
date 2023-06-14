<?php

namespace App\Http\Controllers;

use App\Models\DetailAset;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $peminjam = Peminjam::all();
        $peminjam = $peminjam->count();

        $kaur = User::where('role_id', 3)->get();
        $kaur = $kaur->count();

        $pinjam = Peminjaman::all();
        $pinjam = $pinjam->count();

        $aset = DetailAset::all();
        $aset = $aset->count();

        return view('kades.index', compact('peminjam', 'pinjam', 'kaur', 'aset'));
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->first();

        return view('kades.profile', compact('data'));
    }
}
