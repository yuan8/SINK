<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DeskInfo;
use DB;
use YDB;

class KEBIJAKANCTRL extends Controller
{
    //
    public function edit($tahun,$kodepemda,$kontect,$id){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            return view('sinkronisasi.daerah.kebijakan.partial.form_edit')->with([
                'data'=>$data,
            ]);
        }
    }

    


     public function penilaian($tahun,$kodepemda,$kontect,$id){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb_penilaian as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            return view('sinkronisasi.daerah.kebijakan.partial.form_penilaian')->with([
                'data'=>$data,
            ]);
        }
    }

     public static function hapus_penilaian($tahun,$kodepemda,$kontect,$id){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb_penilaian as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
           DB::table("sink_form.td_".$tahun."_kb_penilaian")->where('id',$id)->delete();
        }

        return back();
    }

    public function penilaian_update($tahun,$kodepemda,$kontect,$id,Request $request){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb_penilaian as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
              DB::table("sink_form.td_".$tahun."_kb_penilaian")->where('id',$id)->update([
                'penilaian'=>(int)$request->penilaian,
                'uraian_note'=>$request->uraian_note
              ]);
        }

        return back();
    }

    public function delete($tahun,$kodepemda,$kontect,$id){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            $id_penilaian=$data['id_penilaian'];

           DB::table("sink_form.td_".$tahun."_kb")->where('id',$id)->delete();

           $penilaian=YDB::query("
                select * from  sink_form.td_".$tahun."_kb as kb where kb.id_penilaian=".$id_penilaian."
            ")->get();

           if(empty($penilaian)){
                static::hapus_penilaian($tahun,$kodepemda,$kontect,$id_penilaian);
           }
        }
        return back();
    }

    public function form_delete($tahun,$kodepemda,$kontect,$id){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            return view('sinkronisasi.daerah.kebijakan.partial.form_hapus')->with([
                'data'=>$data,
            ]);
        }
    }

    public function update($tahun,$kodepemda,$kontect,$id,Request $request){
        $data=(array)YDB::query("
                select * from  sink_form.td_".$tahun."_kb as kb where kb.kodepemda='".$kodepemda."'  and kb.id=".$id."
            ")->first();
        if(!empty($data)){
            DB::table("sink_form.td_".$tahun."_kb")->where('id',$id)->update([
                'jenis'=>$request->jenis,
                'uraian'=>$request->uraian,
                'tahun_berlaku'=>$request->tahun_berlaku
            ]);
        }

        return back();
    }

    public function kegiatan($tahun,$kodepemda){

        $info=DeskInfo::getInfo('REKOMENDASI_RKPD_DAERAH',$tahun);
        $data=DB::select(DB::raw("
            select 
            (select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) 
            as nama_sub_urusan,
            mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id_urusan=".session('main_urusan')->id." and jenis='KEGIATAN'
            order by mandat.id_sub_urusan asc , mandat.id desc
        "));

        

        foreach ($data as $key => $d) {
            

            $data[$key]->penilaian=YDB::query("
                select * from  sink_form.td_".$tahun."_kb_penilaian as p where p.id_mandat=".$d->id." and p.kodepemda = '".$kodepemda."'  and p.id_urusan=".session('main_urusan')->id." limit 1
            ")->first();

            if(!empty($data[$key]->penilaian)){
            }else{
            }


            $data[$key]->uu=DB::select(DB::raw("
                select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'UU'
                "));
            $data[$key]->pp=DB::select(DB::raw("
                select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PP'
                "));
            $data[$key]->perpres=DB::select(DB::raw("
                select * from sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERPRES'
                "));
            $data[$key]->permen=DB::select(DB::raw("
                select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERMEN'
            "));

            

        }
            $RE=['data'=>$data];
        if($GLOBALS['menu_access']=='P'){
            $RE['back_link_pusat']=route('sink.pusat.kebijakandaerah.index',['tahun'=>$tahun]);
        }

        return view('sinkronisasi.daerah.kebijakan.kegiatan')->with($RE);
        
    }

    public function index($tahun,$kodepemda){
    	$info=DeskInfo::getInfo('KEBIJAKAN_DAERAH',$tahun);

    	$data=DB::select(DB::raw("
    		select 
    		(select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) 
    		as nama_sub_urusan,
    		mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id_urusan=".session('main_urusan')->id." and jenis='REGULASI'
    		order by mandat.id_sub_urusan asc , mandat.id desc
    	"));

    	foreach ($data as $key => $d) {
    		

    		$data[$key]->penilaian=YDB::query("
    			select * from  sink_form.td_".$tahun."_kb_penilaian as p where p.id_mandat=".$d->id." and p.kodepemda = '".$kodepemda."'  and p.id_urusan=".session('main_urusan')->id." limit 1
    		")->first();

    		if(!empty($data[$key]->penilaian)){
    			

	    		$data[$key]->penilaian->kb=YDB::query("
	    			select * from (select (case when jenis='PERDA' then 1 else (case when jenis='PERKADA' then 2 else 3 end) end) as index_kb ,*,".$d->id." as id_mandat from  sink_form.td_".$tahun."_kb as kb where kb.id_penilaian=".$data[$key]->penilaian->id.") as c order by c.index_kb asc, id desc
	    			")->get();

	    		

				
    		}else{
    			// $data[$key]->child_count=0;
    		}


    		$data[$key]->uu=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'UU'
    			"));
    		$data[$key]->pp=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PP'
    			"));
    		$data[$key]->perpres=DB::select(DB::raw("
    			select * from sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERPRES'
    			"));
    		$data[$key]->permen=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERMEN'
    		"));

    		    

    	}

        $RE=['data'=>$data];
                if($GLOBALS['menu_access']=='P'){
                    $RE['back_link_pusat']=route('sink.pusat.kebijakandaerah.index',['tahun'=>$tahun]);
        }

    	return view('sinkronisasi.daerah.kebijakan.index')->with($RE);
    	
    }


    public function add_item($tahun,$kodepemda,$context,$id,Request $request){

        $data=YDB::query("
                select * from  sink_form.t_".$tahun."_kb_mandat as p where p.id=".$id." and p.id_urusan=".session('main_urusan')->id." limit 1
        ")->first();
        if($data){
            return view('sinkronisasi.daerah.kebijakan.partial.form_add_item')->with(['parent'=>$data]);
        }
    }


    public function store($tahun,$kodepemda,$context,$id,Request $request){
        $penilaian=DB::table("sink_form.td_".$tahun."_kb_penilaian as p")->whereRaw(" p.id_mandat=".$id." and p.kodepemda='".$kodepemda."' ")->first();

        if(empty($penilaian)){
             $data=YDB::query("
                select * from  sink_form.t_".$tahun."_kb_mandat as p where p.id=".$id." and p.id_urusan=".session('main_urusan')->id." limit 1
            ")->first();
             if($data){
                $penilaian=DB::table("sink_form.td_".$tahun."_kb_penilaian")->insertGetId([
                    'kodepemda'=>$kodepemda,
                    'id_mandat'=>$id,
                    'id_urusan'=>session('main_urusan')->id,
                    'tahun'=>$tahun,
                    'uraian_note'=>'-'
                ]);
             }
        }else{
            $penilaian=$penilaian->id;
        }

        DB::table("sink_form.td_".$tahun."_kb")->insertOrIgnore([
                'kodepemda'=>$kodepemda,
                'id_penilaian'=>$penilaian,
                'uraian'=>$request->uraian,
                'tahun_berlaku'=>$request->tahun_berlaku,
                'tahun'=>$tahun,
                'jenis'=>$request->jenis,
                'id_urusan'=>session('main_urusan')->id
        ]);


        return back();
    }
}
