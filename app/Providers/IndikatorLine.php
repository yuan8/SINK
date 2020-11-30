<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use YDB;

class IndikatorLine
{


	static $data=[];
	

	public function __constract($data=null){
		if($data==null){
			static::data=DB::table('public.users')->where('id',-1)->first();
		}else{
			static::$data=$data;
		}
	}
	public static child($dx){
		foreach($dx as $i)
			YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where i.id_parent='.$i)->get();

		if($data){
			static::$data->child
		}
	}

}