<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
use HPV;
class HomeCtrl extends Controller
{
    //

    public function index($tahun=null){

		$data=YDB::query("select * from sink_form.t_".$tahun."_scheduler_desk as sdesk  order by start asc")->get();

		return view('home')->with(['scheduler_desk'=>$data]);
    }


   public function jumlah_kebijakan($tahun){
   	$data=DB::table('sink_form.t_'.$tahun."_kb_mandat")->selectRaw("
   		sum(case when jenis='REGULASI' then 1 else 0 end) as mandat_regulasi,
   		sum(case when jenis='KEGIATAN' then 1 else 0 end) as mandat_kegiatan
   		")->first();

   	return view('sinkronisasi.dashboard.partial.box.kebijakan')->with(['data'=>$data]);
   }


   public function jumlah_kebijakan1($tahun){
   	$data=DB::table('sink_form.t_'.$tahun."_rkp_indikator_bridge")->selectRaw("
   		count(*) as qty
   		")->first();

   	return view('sinkronisasi.dashboard.partial.box.kebijakan')->with(['data'=>$data]);
   }

   public function jumlah_kebijakan5($tahun){
   	$data=DB::table('sink_form.t_'.$tahun."_rpjmn_indikator_bridge")->selectRaw("
   		count(*)
   		")->first();

   	return view('');
   }

   public function permasalahan($tahun){
   	$data=DB::table('sink_form.td_'.$tahun."_permasalahan")->selectRaw("
   		count(*) as qty,
   		count(distinct(kodepemda)) as jumlah_pemda
   		")->first();
   	return view('sinkronisasi.dashboard.partial.box.permasalahan')->with(['data'=>$data]);
   }

   public function indikator($tahun){
   	$data=DB::table('sink_form.t_'.$tahun."_indikator")->selectRaw("
   		count(*)
   		")->first();
   	return view('');
   }

   public function rekomendasi($tahun){
    	$data=DB::table('sink_form.td_'.$tahun."_rekomendasi")
   	->whereIn('id_urusan',HPV::list_id_urusan())
   	->selectRaw("
   		count(distinct(kodepemda)) as qty
   		")->first();
   	return view('sinkronisasi.dashboard.partial.box.rekomendasi')->with(['data'=>$data]);
   }

   public function rkpd($tahun){

   	$data=DB::table('rkpd.master_'.$tahun."_kegiatan")
   	->whereIn('id_urusan',HPV::list_id_urusan())
   	->selectRaw("
   		count(distinct(kodepemda)) as qty
   		")->first();


   	return view('sinkronisasi.dashboard.partial.box.rkpd')->with('data',$data);
   }
}
