<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;

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
}
