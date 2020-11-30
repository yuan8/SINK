<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
class SCHEDULEDESKCTRL extends Controller
{
    //
    public function index($tahun,$kodepemda=null,$context=null){
    	$where='';
    	if($kodepemda){
    		$where="and jenis in ('PERMASALAHAN_DAERAH','INDIKATOR','REKOMENDASI_RKPD_DAERAH')";
    		$GLOBALS['menu_access']='D';

    	}else{
    		$GLOBALS['menu_access']='P';
    	}
    	$data=YDB::query("select * from sink_form.t_".$tahun."_scheduler_desk as sdesk where id is not null ".$where.' order by start asc')->get();
    	return view('sinkronisasi.daerah.schedule.index')->with(['data'=>$data]);
    }
}
