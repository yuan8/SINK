<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use Storage;
use DB;
class RKPDCTRL extends Controller
{
    //

    public function update_progres($tahun,$kodepemda,$context,$id,Request $request){
         $data=DB::table("rkpd.master_".$tahun."_program as p")->where('kodedata',$id)->first();

        if($data){
          DB::table("rkpd.master_".$tahun."_program as p")->where('kodedata',$id)->update([
            'progress'=>$request->progress,
            'capaian'=>$request->capaian
          ]);
        }

        return back();
    }

    public function edit_progres($tahun,$kodepemda,$context,$id){
        $data=DB::table("rkpd.master_".$tahun."_program as p")->where('kodedata',$id)->first();

        if($data){
            return view('sinkronisasi.daerah.rkpd.partial.form_edit_progres')->with([
                'data'=>(array)$data,
            ]);
        }
    }

    public function index($tahun,$kodepemda){

        $data_k=DB::table("rkpd.master_".$tahun."_kegiatan as k")->whereRaw("k.id_urusan=".session('main_urusan')->id."
                and k.kodepemda='".$kodepemda."'")
        ->select("k.*")
        ->get()->pluck('id_program');


    	
        $data=DB::table("rkpd.master_".$tahun."_program as p")
        ->selectRaw("p.*,'PROGRAM' as jenis, 0 as pagu")
        ->whereIn('id',$data_k)->get();

    	foreach ($data as $key => $p) {
    		$data[$key]->outcome=YDB::query("select c.*,'CAPAIAN' as jenis from rkpd.master_".$tahun."_kegiatan as k
    		join rkpd.master_".$tahun."_program_capaian as c  on k.id_program=c.id_program and c.tolokukur is not null
    		where
    		 k.kodepemda='".$kodepemda."' and k.id_urusan=".session('main_urusan')->id."  and k.id_program=".$p->id."
    		")->get();
    		# code...
    	}


    	foreach ($data as $keyp => $p) {
                 $px=DB::table("rkpd.master_".$tahun."_kegiatan as k")->whereRaw("k.id_urusan=".session('main_urusan')->id."
                    and k.kodepemda='".$kodepemda."' and k.id_program=".$p->id)
            ->selectRaw("k.* ,'KEGIATAN' as jenis")
            ->get();

            
    		$data[$keyp]->kegiatan=$px;
            $pagu=$px->pluck('pagu')->toArray();
            $data[$keyp]->pagu=array_sum(($pagu));


    		
    		foreach ($data[$keyp]->kegiatan as $keyk => $k) {
	    		$data[$keyp]->kegiatan[$keyk]->output=YDB::query("select i.*,'INDIKATOR' as jenis from rkpd.master_".$tahun."_kegiatan as k 
	    		join rkpd.master_".$tahun."_kegiatan_indikator as i on k.id=i.id_kegiatan and i.tolokukur is not null
	    		where
	    		 k.kodepemda='".$kodepemda."' and k.id_urusan=".session('main_urusan')->id." and i.id_kegiatan=".$k->id."
	    		")->get();
	    		# code...
	    	}
    	}




    	return view('sinkronisasi.daerah.rkpd.index')->with(['data'=>$data]);
    }
}
