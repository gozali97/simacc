<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SekretarisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('sekretaris.index');
    }
}
