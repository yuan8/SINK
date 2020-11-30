<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use YDB;
class HomeCtrl extends Controller
{
    //

    public function init($tahun){
    	if(in_array(Auth::User()->role,[1,2])){
    		$daerah=YDB::query("select *,(case when length(d.id)<3 then nama else (select concat(d.nama,' - ',p.nama) from public.master_daerah as p where p.id=left(d.id::text,2))end) as nama_pemda from public.master_daerah as d order by id asc")->get();
    	}else{
    		return redirect()->route('sink.daerah.index',['tahun'=>$tahun,'kodepemda'=>Auth::User()->kodepemda]);
    	}

    	return view('sinkronisasi.daerah.init')->with(['data'=>$daerah]);
    }


    public function index($tahun,$kodepemda){
    	$daerah=YDB::query("select *,(case when length(d.id)<3 then nama else (select concat(d.nama,' - ',p.nama) from public.master_daerah as p where p.id=left(d.id::text,2))end) as nama_pemda from public.master_daerah as d where d.id='".$kodepemda."' limit 1")->first();
    	if($daerah){
	    	$GLOBALS['pemda_access']=$daerah;
	    	return view('sinkronisasi.daerah.index');

    	}
    }


    public function update_pemda($tahun,Request $request){
    	return redirect()->route('sink.daerah.index',['tahun'=>$tahun,'kodepemda'=>$request->kodepemda,'menu_context'=>'D']);
    }
}
