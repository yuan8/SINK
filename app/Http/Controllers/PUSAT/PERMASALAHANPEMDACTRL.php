<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DeskInfo;
class PERMASALAHANPEMDACTRL extends Controller
{
    //


    public function index($tahun){
    	$info=DeskInfo::getInfo('PERMASALAHAN_DAERAH',$tahun);

    	$data=YDB::query("select
    		d.id as kodepemda,
    	(select count(id) from sink_form.td_".$tahun."_permasalahan as ms where ms.jenis='MASALAH' and ms.kodepemda=d.id) as count_ms,
    	 (case when length(d.id)<3 then nama else concat(d.nama,' - ',(select p.nama from public.master_daerah as p where p.id=d.kode_daerah_parent limit 1)) end ) as nama_pemda ,d.* from public.master_daerah as d order by id asc")->get();

    	return view('sinkronisasi.pusat.permasalahan.index')->with(['data'=>$data]);
    }
}
