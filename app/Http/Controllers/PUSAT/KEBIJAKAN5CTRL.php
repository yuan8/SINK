<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YT;
use YDB;
use DeskInfo;
use DB;

class KEBIJAKAN5CTRL extends Controller
{
    //


    public function edit($tahun,$id){
        $data=DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->first();
         $sub_urusan=[];
            $parent=static::nested($data);

        
        if($data){
            if($parent['context']=='ARAH KEBIJAKAN'){

            $sub_urusan=DB::table('public.master_sub_urusan')->where('id_urusan',session('main_urusan')->id)->get();
        }
            return view('sinkronisasi.pusat.kebijakan5.partial.form_edit')->with([
                'data'=>(array)$data,
                'item'=>$parent,
                'sub_urusan'=>$sub_urusan
            ]);
        }
    }

    public function update($tahun,$id,Request $request){
        $data=DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->first();
        if($data){
            DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->update([
                'uraian'=>$request->uraian,
                'keterangan'=>$request->keterangan,
                'id_sub_urusan'=>$request->sub_urusan,

                ]
            );
        }
        return back();
    }


    public function form_delete_indikator($tahun,$id,Request $request){
        $data=DB::table("sink_form.t_".$tahun."_indikator_rpjmn_bridge as bridge")
        ->selectRaw("bridge.*,(select concat('(',i.jenis,')',' ',i.tolokukur) from sink_form.t_".$tahun."_indikator as i where i.id=bridge.id_indikator) as nama_indikator")
        ->where('id',$id)->first();
        if($data){
            return view('sinkronisasi.pusat.kebijakan5.partial.form_hapus_indikator')->with([
                'data'=>(array)$data,
                
            ]);
        }
    }

     public function hapus_indikator($tahun,$id,Request $request){
        $data=DB::table("sink_form.t_".$tahun."_indikator_rpjmn_bridge")->where('id',$id)->first();
        
        if($data){
            DB::table("sink_form.t_".$tahun."_indikator_rpjmn_bridge")->where('id',$id)->delete();
        }

        return back();
    }


    public function delete($tahun,$id){
        $data=DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->first();
        if($data){
            DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->delete();
        }

        return back();
    }

    public function form_delete($tahun,$id){
        $data=DB::table("sink_form.t_".$tahun."_rpjmn")->where('id',$id)->where('id_urusan',session('main_urusan')->id)->first();
        if($data){
            $parent=static::nested($data);
            return view('sinkronisasi.pusat.kebijakan5.partial.form_hapus')->with([
                'data'=>(array)$data,
                'item'=>$parent
            ]);
        }
    }

    static function nested($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'KONDISI SAAT INI',
                'context'=>'KONDISI SAAT INI'
            ];

            if(!empty($jenis)){
                switch ($jenis['jenis']) {
                case 'KONDISI SAAT INI':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'ISU STRATEGIS',
                        'context'=>'KONDISI SAAT INI'

                    ];
                # code...
                break;
                case 'ISU STRATEGIS':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'ARAH KEBIJAKAN',
                        'context'=>'ISU STRATEGIS'

                    ];
                    # code...
                    break;
                 case 'ARAH KEBIJAKAN':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>null,
                        'context'=>'ARAH KEBIJAKAN'

                    ];
                    # code...
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        return $data;
        
    }


    public function index($tahun){
        $info=DeskInfo::getInfo('RPJMN',$tahun);

    	$data=YDB::query("select *,(select nama from public.master_sub_urusan  as  su where su.id = id_sub_urusan) as nama_sub_urusan from sink_form.t_".$tahun."_rpjmn where id_urusan=".session('main_urusan')->id." and jenis='KONDISI SAAT INI' "." order by id desc")->get();

    	foreach ($data as  $key=>$d) {
    		
    		$data[$key]->isu=YDB::query("select * from sink_form.t_".$tahun."_rpjmn where id_urusan=".session('main_urusan')->id." and jenis='ISU STRATEGIS' and id_parent=".$d->id." order by id desc")->get();

    		foreach ($data[$key]->isu as $keyisu=>$isu) {
    			$data[$key]->isu[$keyisu]->arah_kebijakan=YDB::query("select
                    (select su.nama from public.master_sub_urusan as su where su.id=rpjmn.id_sub_urusan) as nama_sub_urusan,rpjmn.*
                     from sink_form.t_".$tahun."_rpjmn as rpjmn where id_urusan=".session('main_urusan')->id." and jenis='ARAH KEBIJAKAN' and id_parent=".$isu->id." order by id desc")->get();

    			foreach ($data[$key]->isu[$keyisu]->arah_kebijakan as $keykebijakan=>$kb) {

    				$data[$key]->isu[$keyisu]->arah_kebijakan[$keykebijakan]->indikator=YDB::query("

                    select bridge.id as id_bridge,bridge.id_rpjmn as id_rpjmn, i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan, (select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rpjmn_bridge as bridge
                    join t_".$tahun."_indikator as i on  i.id_urusan=".session('main_urusan')->id." and  i.id=bridge.id_indikator
                      where  bridge.id_rpjmn=".$kb->id." order by i.id desc")->get();
    			}
    		}
    	}

    	return view('sinkronisasi.pusat.kebijakan5.index')->with(['data'=>$data]);
    	
    }


    public function tambah_indikator($tahun,Request $request){
        $id_rpjmn=$request->id_rpjmn;
        $rpjmn=YDB::query("select * from sink_form.t_".$tahun."_rpjmn where id=".$id_rpjmn)->first();
        if($rpjmn){

            $data=YDB::query("select i.* ,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from t_".$tahun."_indikator as i
                where i.id_sumber = 1 and i.id_urusan=".session('main_urusan')->id." and i.id not in (select bridge.id_indikator from t_".$tahun."_indikator_rpjmn_bridge as bridge )
            ")->get();


            $sub_urusan=YDB::query("select * from public.master_sub_urusan where id_urusan=".session('main_urusan')->id)->get();

             return view('sinkronisasi.master.indikator.form_tagging',[
                    'url_tagging'=>route('sink.pusat.kebijakan5.ind.tagging',['tahun'=>$GLOBALS['tahun_access']]),
                    'name_parent'=>'id_rpjmn',
                    'parent'=>$id_rpjmn,
                    'sub_urusan'=>$sub_urusan,
                    'data'=>$data,
                    'title'=>'TAMBAH INDIKATOR '.$rpjmn->jenis.' '.$rpjmn->uraian
                ]);
        }else{

        }
       
    }

    public function  store_item($tahun,$id=null,Request $request){
        $approve=false;

        if($id){
             $data=DB::table("sink_form.t_".$tahun."_rpjmn  as rpjmn")->where('id',$id)->first();
             if($data){
                $approve=true;
            }
        }else{
            $approve=true;
        }

        if($approve)
        {

            $id_data=DB::table("sink_form.t_".$tahun."_rpjmn")->insertGetId(
                [
                    'tahun'=>$tahun,
                    'uraian'=>$request->uraian,
                    'jenis'=>$request->jenis,
                    'kode'=>'dsjkdjks3he3uhd',
                    'id_parent'=>$id,
                    'id_urusan'=>session('main_urusan')->id,
                    'id_sub_urusan'=>$request->sub_urusan,

                    'keterangan'=>$request->keterangan
                ]
            );


            DB::table("sink_form.t_".$tahun."_rpjmn  as rpjmn")->where('id',$id_data)->update([
                'kode'=>DeskInfo::kodeCreate($id_data)
            ]);
            return back();

        }
    }


    public function store_indikator($tahun,Request $request){
        $id_rpjmn=$request->id_rpjmn;

        if($request->tagging_indikator){
            foreach ($request->indikator??[] as $key => $value) {
                YDB::table("t_".$tahun."_indikator_rpjmn_bridge as bridge")->insert([
                    'id_indikator'=>$value,
                    'id_rpjmn'=>$id_rpjmn,
                    'tahun'=>$tahun,
                ]);
            }
        }

        return back();
    }

    public function add_item($tahun,$id=null){
        $jenis=null;
        $data=[];
        if($id){
            $data=DB::table("sink_form.t_".$tahun."_rpjmn  as rpjmn")->where('id',$id)->first();
            if($data){
                $jenis=$data->jenis;
            }
        }

        $peta=static::nested($data);
        $sub_urusan=[];
        if($peta['child_context']=='ARAH KEBIJAKAN'){
            $sub_urusan=DB::table('public.master_sub_urusan')->where('id_urusan',session('main_urusan')->id)->get();
        }
        return view('sinkronisasi.pusat.kebijakan5.partial.form_add_item')->with(['item'=>$peta,'sub_urusan'=>$sub_urusan]);
        
    }
}
