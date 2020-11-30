<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SPMCTRL extends Controller
{
    //

    public function index($tahun){
    	$data=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SPM'
    		and jenis='JENIS LAYANAN'
    	")->get();

    	foreach ($data[as $keyn => $n) {
    		$data[$key]->indikator=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data ,bridge.id as id_bridge from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bridge 
    			join t_".$tahun."_indikator as i on i.id=bridge.id_indikator
    			where
	    		id_dukungan_pusat=".$n->id."
	    	")->get();
		}


    	return view('sinkronisasi.pusat.spm.index')->with(['data'=>$data]);
    }
}
