<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('kaur.index');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->first();

        return view('kaur.profile', compact('data'));
    }
}
