<?php

namespace App\Http\Controllers;

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
        return view('kades.index');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->first();

        return view('kades.profile', compact('data'));
    }
}
