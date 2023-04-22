<?php

namespace App\Http\Controllers;

use App\Models\Perencanaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KelolaPerencanaanController extends Controller
{
    public function index()
    {

        $data = Perencanaan::query()
            ->select('perencanaan.*')
            ->get();

        return view('sekretaris.listrencana.index', compact('data'));
    }

    public function print()
    {

        $data = Perencanaan::query()
        ->select('perencanaan.*')
        ->get();

    $pdf = Pdf::loadView('sekretaris.listrencana.perencanaan-pdf', compact('data'));
    return $pdf->download('laporan-perencanaan.pdf');
    }
}
