<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
use DeskInfo;
class SDGSCTRL extends Controller
{
    //

        public function index($tahun){
        $info=DeskInfo::getInfo('INDIKATOR',$tahun);

    	$data=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SDGS'
    		and jenis='TUJUAN GLOBAL'
    	")->get();

    	foreach ($data as $key => $t) {
    		$data[$key]->child=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
	    		jenis_data='SDGS'
	    		and jenis='SASARAN GLOBAL'
	    		and id_parent=".$t->id."
	    	")->get();

	    	foreach ($data[$key]->child as $keys => $s) {
	    		$data[$key]->child[$keys]->child=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
		    		jenis_data='SDGS'
		    		and jenis='SASARAN NASIONAL'
		    		and id_parent=".$s->id."
		    	")->get();

		    	foreach ($data[$key]->child[$keys]->child as $keyn => $n) {
		    		$data[$key]->child[$keys]->child[$keyn]->indikator=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data ,bridge.id as id_bridge from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bridge 
		    			join t_".$tahun."_indikator as i on (i.id=bridge.id_indikator and i.id_urusan=".session('main_urusan')->id.")
		    			where
			    		id_dukungan_pusat=".$n->id."
			    	")->get();
		    	}
	    	}
    	}
    	return view('sinkronisasi.pusat.sdgs.index')->with(['data'=>$data]);

    }

    public function add($tahun,$id){
    	$data=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SDGS'
    		and id=".$id."
    	")->get();

    	if($data){
    		 $data=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where i.id_urusan='.session('main_urusan')->id)->get();

    		return view('sinkronisasi.pusat.sdgs.partial.form_add')->with(['data'=>$data,'name_parent'=>'id_sdgs','parent'=>$id,'url_tagging'=>route('sink.pusat.sdgs.store',['tahun'=>$tahun,'id'=>$id])]);
    	}
    }


    public function store($tahun,$id,Request $request){
    	if($request->indikator){
	    	$data=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
	    		jenis_data='SDGS'
	    		and id=".$id."
	    	")->get();

	    	if($data){
	    		foreach ($request->indikator as $key => $value) {
	    			DB::table("sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge")
	    			->insert([
	    				'id_indikator'=>$value,
	    				'id_dukungan_pusat'=>$id,
	    				'tahun'=>$tahun
	    			]);
	    		}
	    	}
    	}

    	return back();
    }


    	
}
