<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeCtrl extends Controller
{
    //
      public function index($tahun){
    	return view('sinkronisasi.admin.index');
    }
}
