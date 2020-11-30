<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DeskInfo;
class MASTERINDIKATORCTRL extends Controller
{
    //
    public function index($tahun,$kodepemda){
    	$info=DeskInfo::getInfo('INDIKATOR',$tahun);
    	
    	$data=YDB::query("select
            (select string_agg(concat('<b> RKP ',rkp.jenis,' : </b> ',rkp.uraian),'||') from sink_form.t_".$tahun."_indikator_rkp_bridge as bg 
                    join sink_form.t_".$tahun."_rkp as rkp on bg.id_indikator = i.id and rkp.id=bg.id_rkp
                 ) as dukungan_rkp,
         (select string_agg(concat('<b>',ps.jenis,'(',ps.jenis_data,')',' : </b> ',ps.uraian),'||') from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bgps 
                        join sink_form.t_".$tahun."_dukungan_pusat as ps on (bgps.id_indikator = i.id and ps.id=bgps.id_dukungan_pusat)
                     ) as dukungan_pusat_lainya,
    		(select count(distinct(ri.id_indikator)) from sink_form.td_".$tahun."_rekomendasi_indikator as ri where ri.kodepemda ='".$kodepemda."' and ri.id_indikator=i.id) as implement,
    		(CASE WHEN ((i.target_2 is null)) then (case when (i.satuan!='%') then ( (select sum(ri.target::numeric) from  sink_form.td_".$tahun."_rekomendasi_indikator as ri where ri.kodepemda ='".$kodepemda."' and ri.id_indikator=i.id )) else -1 end )  else -1 end ) aggregate_target,
    	 (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where i.id_urusan='.session('main_urusan')->id)->get();

    	return view('sinkronisasi.daerah.indikator.index')->with(['data'=>$data]);

    }
}
