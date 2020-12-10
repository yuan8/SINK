<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use Storage;
use DB;
use Nahid\JsonQ\Jsonq;
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
        $data=[
            'name'=>'RKPD '.$tahun." ".$kodepemda,

        ];
        $data['kegiatan']=DB::table("rkpd.master_".$tahun."_kegiatan as k")->whereRaw("k.id_urusan in".session('main_urusan')->id."
                and k.kodepemda='".$kodepemda."'")
        ->selectRaw("k.* , 'KEGIATAN' as jenis ")
        ->get();

        $data['program']=DB::table("rkpd.master_".$tahun."_program as k")->whereRaw("k.kodepemda='".$kodepemda."' and k.id in (".implode(',',($data['kegiatan']->pluck('id_program')->toArray())).")" )
        ->selectRaw("k.*, 'PROGRAM' as jenis, 0 as  pagu")
        ->get();

         $data['capaian']=DB::table("rkpd.master_".$tahun."_program_capaian as k")->whereRaw("k.kodepemda='".$kodepemda."' and k.id_program in (".implode(',',($data['kegiatan']->pluck('id_program')->toArray())).")" )
        ->selectRaw("k.*,  'CAPAIAN' as jenis")
        ->get();

        $data['indikator']=DB::table("rkpd.master_".$tahun."_kegiatan_indikator as k")->whereRaw("k.kodepemda='".$kodepemda."' and k.id_kegiatan in (".implode(',',($data['kegiatan']->pluck('id')->toArray())).")" )
        ->selectRaw("k.*,  'INDIKATOR' as jenis")
        ->get();

        $data_map=json_encode($data);
        $kegiatan=new Jsonq(($data_map));
        foreach ($data['kegiatan'] as $key => $k) {
            $data['kegiatan'][$key]->output=$kegiatan->from('indikator')->where('id_kegiatan','=',$k->id)->get();

            # code...
        }

        $data_map=json_encode($data);


        foreach ($data['program'] as $key => $p) {
             $kegiatan=new Jsonq(($data_map));

            $data['program'][$key]->kegiatan=$kegiatan->from('kegiatan')->where('id_program','=',$p->id)->get();
        $kegiatan=new Jsonq(($data_map));

            $data['program'][$key]->outcome=$kegiatan->from('capaian')->where('id_program','=',$p->id)->get();
        }









    	return view('sinkronisasi.daerah.rkpd.index')->with(['data'=>$data['program']]);
    }
}
