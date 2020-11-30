<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeCtrl extends Controller
{
    //
    public function index($tahun){
    	return view('sinkronisasi.pusat.index');
    }
}
