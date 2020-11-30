<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YDB;
class MASTERCTRL extends Controller
{
    //

    public function get_sumber_data($tahun,Request $request){
    	$where="";
    	if($request->q){
    		$where="where sd.uraian ilike '%".$request->q."%'";
    	}

    	$data=YDB::query("select sd.id as id ,sd.uraian as text from sink_form.t_".$tahun."_sumber_data as sd ".$where)->get();

    	return ['results'=>$data];
    }


    public function satuan_indikator($tahun,Request $request){
    	$where="";
    	if($request->q){
    		$where="where i.satuan ilike '%".$request->q."%'";
    	}

    	$data=YDB::query("select upper(i.satuan) as id, upper(i.satuan) as text from sink_form.t_".$tahun."_indikator as i ".$where." group by upper(i.satuan)")->get();

    	

    	return ['results'=>$data];
    }

}


