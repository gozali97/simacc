<?php

namespace App\Http\Controllers;

use App\Models\Perencanaan;
use Illuminate\Http\Request;

class KelolaPerencanaanController extends Controller
{
    public function index()
    {

        $data = Perencanaan::query()
            ->select('perencanaan.*')
            ->get();

        return view('sekretaris.listrencana.index', compact('data'));
    }
}
