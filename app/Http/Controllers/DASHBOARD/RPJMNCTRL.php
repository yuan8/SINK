<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
use HPV;
class RPJMNCTRL extends Controller
{
    //

    public function pusat($tahun,Request $request){
    	$urusan=HPV::list_id_urusan();
    	$mandat=[];
    	$req=$request;

        if($request->urusan){
    		$urusan=$request->urusan;

    	}else{
            $req->urusan=[];
        }

        $data_chart=[];

    	$list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();

    	$data=YDB::query("select *,(select nama from public.master_sub_urusan  as  su where su.id = id_sub_urusan) as nama_sub_urusan,(select u.nama from public.master_urusan  as  u where u.id = id_urusan) as nama_urusan from sink_form.t_".$tahun."_rpjmn where id_urusan=".session('main_urusan')->id." and jenis='KONDISI SAAT INI' "." order by id_urusan asc,id desc")->get();

    	foreach ($data as  $key=>$d) {
    		
    		$data[$key]->isu=YDB::query("select * from sink_form.t_".$tahun."_rpjmn where id_urusan=".session('main_urusan')->id." and jenis='ISU STRATEGIS' and id_parent=".$d->id." order by id desc")->get();

    		foreach ($data[$key]->isu as $keyisu=>$isu) {
    			$data[$key]->isu[$keyisu]->arah_kebijakan=YDB::query("select * from sink_form.t_".$tahun."_rpjmn where id_urusan=".session('main_urusan')->id." and jenis='ARAH KEBIJAKAN' and id_parent=".$isu->id." order by id desc")->get();
    			foreach ($data[$key]->isu[$keyisu]->arah_kebijakan as $keykebijakan=>$kb) {

    				$data[$key]->isu[$keyisu]->arah_kebijakan[$keykebijakan]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rpjmn as id_rpjmn, i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan, (select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rpjmn_bridge as bridge
                    join t_".$tahun."_indikator as i on  i.id_urusan=".session('main_urusan')->id." and  i.id=bridge.id_indikator
                      where  bridge.id_rpjmn=".$kb->id." order by i.id desc")->get();
    			}
    			$data_chart[]=[
    				'name'=>$kb->uraian,
    				'y'=>count($data[$key]->isu[$keyisu]->arah_kebijakan[$keykebijakan]->indikator)
    			];

    		}
    	}

    	return view('sinkronisasi.dashboard.rpjmn.pusat')->with(['data'=>$data,'req'=>$req,'list_urusan'=>$list_urusan,'data_chart'=>$data_chart]);

    }
}
