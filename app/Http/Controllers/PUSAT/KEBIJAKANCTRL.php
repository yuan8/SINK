<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DeskInfo;
use DB;

class KEBIJAKANCTRL extends Controller
{
    //

    public function index($tahun){
    	$info=DeskInfo::getInfo('KEBIJAKAN_PUSAT',$tahun);

    	$data=DB::select(DB::raw("
    		select 
    		(select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) 
    		as nama_sub_urusan,
    		mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id_urusan=".session('main_urusan')->id."
    		order by mandat.id_sub_urusan asc , mandat.id desc
    	"));

    	foreach ($data as $key => $d) {
    		
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

    		$data[$key]->child_count=max(count($data[$key]->uu),count($data[$key]->pp),count($data[$key]->perpres),count($data[$key]->permen));
    	}

    	 $id_sub_urusan=DB::table('public.master_sub_urusan')->where('id_urusan',session('main_urusan')->id)->get();


    	if($info['active']){
    		return view('sinkronisasi.pusat.kebijakan.index')->with(['data'=>$data,'sub_urusan'=>$id_sub_urusan]);
    	}else{
    		return view('sinkronisasi.pusat.block')->with('content',$info['view_block']);
    	}


   
    }

     public function store($tahun,Request $request){

          $data=DB::table("sink_form.t_".$tahun."_kb_mandat")->insert([

            'uraian'=>$request->uraian,
            'jenis'=>strtoupper($request->jenis),
            'id_urusan'=>session('main_urusan')->id,
            'tahun'=>$tahun,
            'id_sub_urusan'=>$request->id_sub_urusan,


        ]);

        return back();

    }

    public function edit_kb($tahun,$id){
         $data=DB::select(DB::raw("
            select
            kb.* from sink_form.t_".$tahun."_kb as kb where kb.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
           

            return view('sinkronisasi.pusat.kebijakan.partial.form_edit_kb')->with(['kb'=>$data,'context'=>$data->jenis]);
        }else{

        }
    }


    public function update_kb($tahun,$id,Request $request){
         $data=DB::select(DB::raw("
            select
            kb.* from sink_form.t_".$tahun."_kb as kb where kb.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
               DB::table("sink_form.t_".$tahun."_kb")->where('id',$id)->update([
                'uraian'=>$request->uraian,
                'tahun'=>$request->tahun_berlaku
               ]);

            return back();
        }else{

        }

    }

    public function form_del_kb($tahun,$id){

        $data=DB::select(DB::raw("
            select
            mandat.* from sink_form.t_".$tahun."_kb as mandat where mandat.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
          
            return view('sinkronisasi.pusat.kebijakan.partial.form_hapus_kb')->with(['kb'=>$data]);
        }else{

        }

    }

    public function delete_kb($tahun,$id){
        $data=DB::select(DB::raw("
            select
            mandat.* from sink_form.t_".$tahun."_kb as mandat where mandat.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
            DB::table("sink_form.t_".$tahun."_kb")->where('id',$id)->delete();
          
            return back();
        }else{

        }

    }



    public function edit($tahun,$id){

        $data=DB::select(DB::raw("
            select
            mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat where mandat.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
            $id_sub_urusan=DB::table('public.master_sub_urusan')->where('id_urusan',session('main_urusan')->id)->get();
            return view('sinkronisasi.pusat.kebijakan.partial.form_edit_mandat')->with(['mandat'=>$data,'sub_urusan'=>$id_sub_urusan]);
        }else{

        }

    }


    public function form_del($tahun,$id){

        $data=DB::select(DB::raw("
            select
            mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat where mandat.id=".$id." limit 1"
        ));

        if(!empty($data)){
            $data=$data[0];
            return view('sinkronisasi.pusat.kebijakan.partial.form_hapus_mandat')->with(['mandat'=>$data]);
        }else{

        }

    }


    public function update($tahun,$id,Request $request){

        $data=DB::table("sink_form.t_".$tahun."_kb_mandat")->where('id',$id)->update([

            'uraian'=>$request->uraian,
            'jenis'=>strtoupper($request->jenis),
            'id_sub_urusan'=>$request->id_sub_urusan,

        ]);

        return back();

    }

      public function delete($tahun,$id,Request $request){


        $data=DB::table("sink_form.t_".$tahun."_kb_mandat")->where('id',$id)->delete();

        return back();

    }


    public function create_kb($tahun,$id,$context,Request $request){

         $data=DB::table("sink_form.t_".$tahun."_kb_mandat")->where('id',$id)->first();

        return view('sinkronisasi.pusat.kebijakan.partial.form_add_kb')->with(['mandat'=>$data,'context'=>$context]);
    }

    public function store_kb($tahun,$id,$context,Request $request){

         $data=DB::table("sink_form.t_".$tahun."_kb_mandat")->where('id',$id)->first();

        
         if($data){

         $data=DB::table("sink_form.t_".$tahun."_kb")->insert([
            'uraian'=>$request->uraian,
            'tahun'=>$tahun,
            'id_urusan'=>session('main_urusan')->id,
            'jenis'=>$request->jenis,
            'id_sub_urusan'=>$data->id_sub_urusan,
            'id_mandat'=>$data->id,
            'tahun_berlaku'=>$request->tahun_berlaku
         ]);
         }

        return back();
    }
}
