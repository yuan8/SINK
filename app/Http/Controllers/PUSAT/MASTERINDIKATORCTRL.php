<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DeskInfo;
use DB;
class MASTERINDIKATORCTRL extends Controller
{
    //


    public function edit($tahun,$id){
         $data=(array)YDB::query("
                select *,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from  sink_form.t_".$tahun."_indikator as i where  i.id=".$id." and id_urusan=".session('main_urusan')->id."
            ")->first();
        if(!empty($data)){
              $id_sub_urusan=YDB::query("select * from public.master_sub_urusan where id_urusan=".session('main_urusan')->id)->get();
            return view('sinkronisasi.pusat.indikator.partial.form_edit')->with([
                'data'=>$data,
                'sub_urusan'=>$id_sub_urusan
            ]);
        }
    }

    public function form_delete($tahun,$id,Request $request){
        $datai=(array)YDB::query("
                select * from  sink_form.t_".$tahun."_indikator as i where  id_urusan=".session('main_urusan')->id." and i.id=".$id."
            ")->first();
        if(!empty($datai)){
            return view('sinkronisasi.pusat.indikator.partial.form_hapus')->with('data',$datai);
        }
    }

    public function delete($tahun,$id,Request $request){
        $datai=(array)YDB::query("
                select * from  sink_form.t_".$tahun."_indikator as i where  id_urusan=".session('main_urusan')->id." and i.id=".$id."
            ")->first();
        if(!empty($datai)){
            DB::table("sink_form.t_".$tahun."_indikator")->where('id',$id)->delete();
        }

        return back();
    }

    public function update($tahun,$id,Request $request){
        $datai=(array)YDB::query("
                select * from  sink_form.t_".$tahun."_indikator as i where  id_urusan=".session('main_urusan')->id." and i.id=".$id."
            ")->first();
        if(!empty($datai)){
            $data=(array)$request->all();

             DB::table("sink_form.t_".$tahun."_indikator")->where('id',$id)->update([
                'id_sumber'=>$data['id_sumber_data'],
                'id_sub_urusan'=>$data['id_sub_urusan'],
                'jenis'=>$data['jenis'],
                'satuan'=>strtoupper($data['satuan']),
                'target'=>$data['target'],
                'target_2'=>($data['jenis_nilai']=='SINGLE'?null:$data['target_2']),
                'positiv_value'=>$data['positiv_value'],
                'tolokukur'=>$data['uraian'],
             ]);
        }

        return back();
    }


    public function index($tahun){
        $info=DeskInfo::getInfo('INDIKATOR',$tahun);
        $data=YDB::query("select 
            (select string_agg(concat('<b> RKP ',rkp.jenis,' : </b> ',rkp.uraian),'||') from sink_form.t_".$tahun."_indikator_rkp_bridge as bg 
                    join sink_form.t_".$tahun."_rkp as rkp on bg.id_indikator = i.id and rkp.id=bg.id_rkp
                 ) as dukungan_rkp,
         (select string_agg(concat('<b>',ps.jenis,'(',ps.jenis_data,')',' : </b> ',ps.uraian),'||') from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bgps 
                        join sink_form.t_".$tahun."_dukungan_pusat as ps on (bgps.id_indikator = i.id and ps.id=bgps.id_dukungan_pusat)
                     ) as dukungan_pusat_lainya,
            (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where i.id_urusan='.session('main_urusan')->id)->get();

        return view('sinkronisasi.pusat.indikator.index')->with(['data'=>$data]);



    }


    public function detail($tahun,$id){

        $data=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator as i where i.id=".$id." and i.id_urusan=".session('main_urusan')->id." limit 1")->first();

        
        if($data){
            $data->kewenangan=YDB::query("
                select kw.* from sink_form.t_".$tahun."_kewenangan_bridge as bridge join t_".$tahun."_kewenangan as kw on kw.id = bridge.id_indikator")->get();

            $data->child=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where id_parent='.$id)->get();
        }

        return view('sinkronisasi.master.indikator.detail')->with(['data'=>$data]);
    }

    public function bridge($tahun,$id,Request $request){
        if($request->id){
            $data=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator as i where i.id=".$id." limit 1")->first();
            if($data){
                $data->child=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun.'_indikator as i where id_parent='.$id)->get();
            }
        }

        return view('sinkronisasi.pusat.indikator.child_line')->with(['data'=>$data]);
    }

    public function store($tahun,Request $request){
        $data=(array)$request->all();
        $data['id_urusan']=session('main_urusan')->id;
        $data['kode']='xzzzz'.rand(0,1000);

        $id_ind=DB::table('sink_form.t_'.$tahun.'_indikator as i')->insertGetId([
            'id_sumber'=>$data['id_sumber_data'],
            'id_sub_urusan'=>$data['id_sub_urusan'],
            'id_urusan'=>session('main_urusan')->id,
            'jenis'=>$data['jenis'],
            'satuan'=>strtoupper($data['satuan']),
            'target'=>$data['target'],
            'target_2'=>$data['target_2'],
            'positiv_value'=>$data['positiv_value'],
            'tahun'=>$tahun,
            'tolokukur'=>$data['uraian'],
            'kode'=>$data['kode']
        ]);

        if($id_ind){
            DB::table('sink_form.t_'.$tahun.'_indikator')->where('id',$id_ind)->update(['kode'=>DeskInfo::kodeCreate($id_ind)]);

        }

        return back();
        
    }

    public function create($tahun){
        $id_sub_urusan=YDB::query("select * from public.master_sub_urusan where id_urusan=".session('main_urusan')->id)->get();
        
        return view('sinkronisasi.master.indikator.form_add_new_indikator')->with(['sub_urusan'=>$id_sub_urusan,'url_tagging'=>route('sink.pusat.indikator.store',['tahun'=>$GLOBALS['tahun_access']]),'name_parent'=>'pusat','parent'=>'P']);
    }
}
