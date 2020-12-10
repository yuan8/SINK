<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DeskInfo;
use DB;
class PERMASALAHANPEMDACTRL extends Controller
{
    //
    static function nested($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'MASALAH POKOK'
            ];

            if(!empty($jenis)){
                switch ($jenis['jenis']) {
                case 'MASALAH POKOK':
                    $data=[
                        'context'=>'MASALAH POKOK',
                        'parent'=>$jenis['id'],
                        'child_context'=>'MASALAH'
                    ];
                # code...
                break;
                case 'MASALAH':
                    $data=[
                        'context'=>'MASALAH',
                        'parent'=>$jenis['id'],
                        'child_context'=>'AKAR MASALAH'
                    ];
                    # code...
                    break;
                 case 'AKAR MASALAH':
                    $data=[
                        'context'=>'AKAR MASALAH',
                        'parent'=>$jenis['id'],
                        'child_context'=>'DATA DUKUNG'
                    ];
                    # code...
                break;
                case 'DATA DUKUNG':
                    $data=[
                        'context'=>'DATA DUKUNG',
                        'parent'=>$jenis['id'],
                        'child_context'=>null
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

    public function edit($tahun,$kodepemda,$context,$id){
         $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_permasalahan as kb where kodepemda='".$kodepemda."' and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            $parent=static::nested($data);
            return view('sinkronisasi.daerah.permasalahan.partial.form_edit')->with([
                'data'=>$data,
                'item'=>$parent
            ]);
        }
    }

     public function form_delete($tahun,$kodepemda,$context,$id){
         $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_permasalahan as kb where kodepemda='".$kodepemda."' and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            $parent=static::nested($data);
            return view('sinkronisasi.daerah.permasalahan.partial.form_hapus')->with([
                'data'=>$data,
                'item'=>$parent
            ]);
        }
    }

    public function delete($tahun,$kodepemda,$context,$id){
         $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_permasalahan as kb where kodepemda='".$kodepemda."' and kb.id=".$id."
            ")->first();
        if(!empty($data)){
           if($data['jenis']=='MASALAH'){
            DB::table('sink_form.td_'.$tahun."_rekomendasi")->whereRaw("id_ms=".$id)->update([
                'id_ms'=>null
            ]);
           }

            DB::table("sink_form.td_".$tahun."_permasalahan")->where('id',$id)->delete();
        }

        return back();
    }

      public function update($tahun,$kodepemda,$context,$id,Request $request){
         $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_permasalahan as kb where kodepemda='".$kodepemda."' and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            $data_up=[
                'uraian'=>$request->uraian,
                'tindak_lanjut'=>$request->tindak_lanjut,
                'kategori'=>$request->kategori,
                'uraian_sumber_data'=>$request->uraian_sumber_data
            ];     

            DB::table("sink_form.td_".$tahun."_permasalahan")->where('id',$id)->update($data_up);    
        }

        return back();
    }

    public function index($tahun,$kodepemda){
        $info=DeskInfo::getInfo('PERMASALAHAN_DAERAH',$tahun);
    	

    	$data=YDB::query("select *,(select count(id) from sink_form.td_".$tahun."_rekomendasi as rk where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_ms=msd.id) as implement,(select nama from public.master_sub_urusan as su where su.id = msd.id_sub_urusan limit 1 ) as nama_sub_urusan from sink_form.td_".$tahun."_permasalahan as msd where msd.kodepemda='".$kodepemda."' and msd.id_urusan=".session('main_urusan')->id." and jenis='MASALAH POKOK' ")->get();

    
    	foreach($data as $key=>$ms){
    		$data[$key]->ms=YDB::query("select * ,(select count(id) from sink_form.td_".$tahun."_rekomendasi as rk where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_ms=msd.id) as implement from sink_form.td_".$tahun."_permasalahan as msd where msd.kodepemda='".$kodepemda."' and msd.id_urusan=".session('main_urusan')->id." and jenis='MASALAH' and msd.id_parent=".$ms->id)->get();

    		foreach($data[$key]->ms as $keyms=>$ak){

	    		$data[$key]->ms[$keyms]->akar=YDB::query("select *,(select count(id) from sink_form.td_".$tahun."_rekomendasi as rk where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_ms=msd.id) as implement from sink_form.td_".$tahun."_permasalahan as msd where msd.kodepemda='".$kodepemda."' and msd.id_urusan=".session('main_urusan')->id." and jenis='AKAR MASALAH' and msd.id_parent=".$ak->id)->get();
                
	    		foreach($data[$key]->ms[$keyms]->akar as $keyak=>$dt){
		    		$data[$key]->ms[$keyms]->akar[$keyak]->data=YDB::query("select *,(select count(id) from sink_form.td_".$tahun."_rekomendasi as rk where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_ms=msd.id) as implement from sink_form.td_".$tahun."_permasalahan as msd where msd.kodepemda='".$kodepemda."' and msd.id_urusan=".session('main_urusan')->id." and jenis='DATA DUKUNG' and msd.id_parent=".$dt->id)->get();
		    	}
	    	}
    	}
    	$RE=['data'=>$data];
    	if($GLOBALS['menu_access']=='P'){
    		$RE['back_link_pusat']=route('sink.pusat.permasalahan.index',['tahun'=>$tahun]);
    	}

    	return view('sinkronisasi.daerah.permasalahan.index')->with($RE);
    }


    public function add_item($tahun,$kodepemda,$context,$id=null){

        $jenis=null;
        $data=[];
        if($id){
            $data=DB::table("sink_form.td_".$tahun."_permasalahan  as m")->where('id',$id)->first();
            if($data){
                $jenis=$data->jenis;
            }
        }

        $peta=static::nested($data);
        return view('sinkronisasi.daerah.permasalahan.partial.form_add_item')->with(['item'=>$peta]);

    }

    public function  store_item($tahun,$kodepemda,$context,$id=null,Request $request){
        $approve=false;

        if($id){
             $data=DB::table("sink_form.td_".$tahun."_permasalahan")->where('id',$id)->first();
             if($data){
                $approve=true;
            }
        }else{
            $approve=true;
        }

        if($approve)
        {   

            $id_data=DB::table("sink_form.td_".$tahun."_permasalahan")->insertGetId(
                [
                    'tahun'=>$tahun,
                    'kodepemda'=>$kodepemda,
                    'uraian_sumber_data'=>'RPJMD BERLAKU PADA '.$tahun,
                    'uraian'=>$request->uraian,
                    'jenis'=>$request->jenis,
                    'kode'=>'dsjkdjks3he3uhd',
                    'id_parent'=>$id,
                    'id_urusan'=>session('main_urusan')->id,
                    'tindak_lanjut'=>$request->tindak_lanjut,
                    'kategori'=>$request->kategori,
                    'uraian_sumber_data'=>$request->uraian_sumber_data
                ]
            );


            DB::table("sink_form.td_".$tahun."_permasalahan")->where('id',$id_data)->update([
                'kode'=>DeskInfo::kodeCreate($id_data)
            ]);
            return back();

        }
    }

}
