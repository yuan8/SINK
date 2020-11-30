<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DeskInfo;

use DB;
class KEBIJAKAN1CTRL extends Controller
{
    //

    public function form_hapus_indikator($tahun,$id){
         $data=DB::table("sink_form.t_".$tahun."_indikator_rkp_bridge as bridge")->where([
            'id'=>$id,
        ])
         ->selectRaw("bridge.id,(select concat('(',i.jenis,')',' ',i.tolokukur) from sink_form.t_".$tahun."_indikator as i where i.id=bridge.id_indikator ) as nama_indikator")
         ->first();

        if($data){
            return view('sinkronisasi.pusat.kebijakan1.partial.form_hapus_indikator')->with([
                'data'=>(array)$data,
            ]);
        }
    }


    public function hapus_indikator($tahun,$id){
         $data=DB::table("sink_form.t_".$tahun."_indikator_rkp_bridge as bridge")->where([
            'id'=>$id,
        ])
         ->first();

        if($data){
           DB::table("sink_form.t_".$tahun."_indikator_rkp_bridge as bridge")->where([
            'id'=>$id,
        ])
         ->delete();
        }

        return back();
    }

	static function nested($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'PN/MAJOR'
            ];

            if(!empty($jenis)){

                switch ($jenis['jenis']) {
                 case 'MAJOR':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>null,
                        'context'=>'MAJOR'
                    ];
                # code...
                break;
                 case 'PN':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'PP',
                        'context'=>'PN'
                    ];
                # code...
                break;
                case 'PP':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'KP',
                        'context'=>'PP'

                    ];
                # code...
                break;
                case 'KP':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'PROPN',
                        'context'=>'KP'

                    ];
                    # code...
                    break;
                 case 'PROPN':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'PROYEK',
                        'context'=>'PROPN'

                    ];
                    # code...
                    break;
                 case 'PROYEK':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>NULL,
                        'context'=>'PROYEK'

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
    	$info=DeskInfo::getInfo('RKP',$tahun);
    	$data=YDB::query("select * ,(select nama from public.master_sub_urusan  as  su where su.id = rkp.id_sub_urusan) as nama_sub_urusan from sink_form.t_".$tahun."_rkp as rkp where (jenis='PN' or jenis='MAJOR') and id_urusan=".session('main_urusan')->id." order by rkp.id desc")->get();
    	foreach($data as $key=>$m){
    		$data[$key]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rkp as id_rkp,i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rkp_bridge as bridge
    			join sink_form.t_".$tahun."_indikator as i on bridge.id_indikator=i.id where bridge.id_rkp=".$m->id)->get();

    		$data[$key]->pp=YDB::query("select * from sink_form.t_".$tahun."_rkp as rkp where jenis='PP' and id_urusan=".session('main_urusan')->id." and rkp.id_parent=".$m->id." order by rkp.id desc")->get();

    		foreach($data[$key]->pp as $keypp=>$pp){
    			$data[$key]->pp[$keypp]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rkp as id_rkp,i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rkp_bridge as bridge
    			join sink_form.t_".$tahun."_indikator as i on bridge.id_indikator=i.id where bridge.id_rkp=".$pp->id)->get();

	    		$data[$key]->pp[$keypp]->kp=YDB::query("select * from sink_form.t_".$tahun."_rkp as rkp where (jenis='KP') and id_urusan=".session('main_urusan')->id." and rkp.id_parent=".$pp->id." order by rkp.id desc")->get();

	    		foreach($data[$key]->pp[$keypp]->kp as $keykp=>$kp){

	    			$data[$key]->pp[$keypp]->kp[$keykp]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rkp as id_rkp,i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rkp_bridge as bridge
	    			join sink_form.t_".$tahun."_indikator as i on bridge.id_indikator=i.id where bridge.id_rkp=".$kp->id)->get();

		    		$data[$key]->pp[$keypp]->kp[$keykp]->propn=YDB::query("select * from sink_form.t_".$tahun."_rkp as rkp where (jenis='PROPN') and id_urusan=".session('main_urusan')->id." and rkp.id_parent=".$kp->id." order by rkp.id desc")->get();
		    		foreach($data[$key]->pp[$keypp]->kp[$keykp]->propn as $keypropn=>$propn){

		    			$data[$key]->pp[$keypp]->kp[$keykp]->propn[$keypropn]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rkp as id_rkp,i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rkp_bridge as bridge
		    			join sink_form.t_".$tahun."_indikator as i on bridge.id_indikator=i.id where bridge.id_rkp=".$propn->id)->get();

			    		$data[$key]->pp[$keypp]->kp[$keykp]->propn[$keypropn]->proyek=YDB::query("select * from sink_form.t_".$tahun."_rkp as rkp where (jenis='PROYEK') and id_urusan=".session('main_urusan')->id." and rkp.id_parent=".$propn->id." order by rkp.id desc")->get();

				    		foreach($data[$key]->pp[$keypp]->kp[$keykp]->propn[$keypropn]->proyek as $keyproyek=>$proyek){

			    			$data[$key]->pp[$keypp]->kp[$keykp]->propn[$keypropn]->proyek[$keyproyek]->indikator=YDB::query("select bridge.id as id_bridge,bridge.id_rkp as id_rkp,i.*,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from sink_form.t_".$tahun."_indikator_rkp_bridge as bridge
			    			join sink_form.t_".$tahun."_indikator as i on bridge.id_indikator=i.id where bridge.id_rkp=".$proyek->id)->get();
			    			}
			    			
			    	}

		    	}
	    	}

    	}


    	return view('sinkronisasi.pusat.kebijakan1.index')->with(['data'=>$data]);
    }

    public function edit($tahun,$id){
        $data=DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->first();

        if($data){
            $parent=static::nested($data);
            return view('sinkronisasi.pusat.kebijakan1.partial.form_edit')->with([
                'data'=>(array)$data,
                'item'=>$parent
            ]);
        }
    }

    public function form_hapus($tahun,$id){
        $data=DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->first();

        if($data){
            $parent=static::nested($data);
            return view('sinkronisasi.pusat.kebijakan1.partial.form_hapus')->with([
                'data'=>(array)$data,
                'item'=>$parent
            ]);
        }
    }

    public function update($tahun,$id,Request $request){
        $data=DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->first();

        if($data){

            DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->update([
            'uraian'=>$request->uraian,
            'keterangan'=>$request->keterangan
        ]);
           
        }

        return back();
    }

    public function delete($tahun,$id,Request $request){
        $data=DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->first();

        if($data){

            DB::table("sink_form.t_".$tahun."_rkp")->where([
            'id'=>$id,
            'id_urusan'=>session('main_urusan')->id
        ])->delete();
           
        }

        return back();
    }

    public function store_indikator($tahun,$id,Request $request){

        if($request->tagging_indikator){
            foreach ($request->indikator??[] as $key => $value) {
                DB::table("t_".$tahun."_indikator_rkp_bridge as bridge")->insertOrIgnore([
                    'id_indikator'=>$value,
                    'id_rkp'=>$id,
                    'tahun'=>$tahun,
                ]);
            }
        }

        return back();
    }

    public function tambah_indikator($tahun,$id,Request $request){
        
        $rkp=YDB::query("select * from sink_form.t_".$tahun."_rkp where id=".$id)->first();
        if($rkp){

            $data=YDB::query("select i.* ,(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data from t_".$tahun."_indikator as i
                where  i.id_urusan=".session('main_urusan')->id." and i.id not in (select bridge.id_indikator from t_".$tahun."_indikator_rkp_bridge as bridge )
            ")->get();


            $sub_urusan=YDB::query("select * from public.master_sub_urusan where id_urusan=".session('main_urusan')->id)->get();

             return view('sinkronisasi.master.indikator.form_tagging',[
                    'url_tagging'=>route('sink.pusat.kebijakan1.ind.tagging',['tahun'=>$GLOBALS['tahun_access'],'id'=>$id]),
                    'name_parent'=>'id_rkp',
                    'parent'=>$id,
                    'sub_urusan'=>$sub_urusan,
                    'data'=>$data,
                    'title'=>'TAMBAH INDIKATOR '.$rkp->jenis.' '.$rkp->uraian
                ]);
        }else{

        }
       
    }

    public function store($tahun,$id=null,Request $request){
    	$approve=false;
    	if($id){
    		$data=DB::table("sink_form.t_".$tahun."_rkp  as rkp")->where('id',$id)->first();
    		if($data){
            	$approve=true;

    		}
    	}else{
    		if(in_array($request->jenis,['PN','MAJOR'])){
    			$approve=true;
    		}
    	}

    	if($approve){

    		$id_data=DB::table("sink_form.t_".$tahun."_rkp  as rkp")->insertGetId([
    			'tahun'=>$request->tahun,
    			'uraian'=>$request->uraian,
    			'keterangan'=>$request->keterangan,
    			'jenis'=>$request->jenis,
    			'id_parent'=>$id,
    			'id_urusan'=>session('main_urusan')->id,
    			'kode'=>'dsjdslsjadljas'.rand(0,1000)
    		]);

    		if($id_data){
    			DB::table("sink_form.t_".$tahun."_rkp  as rkp")->where('id',$id_data)->update([
    				'kode'=>DeskInfo::kodeCreate($id_data)
    			]);

    			return back();
    		}
    	}
    }

    public function tambah($tahun,$id=null){
        $jenis=null;
        $data=[];
        if($id){
            $data=DB::table("sink_form.t_".$tahun."_rkp  as rkp")->where('id',$id)->first();
            if($data){
                $jenis=$data->jenis;
            }
        }

        $peta=static::nested($data);
        return view('sinkronisasi.pusat.kebijakan1.partial.form_add_item')->with(['item'=>$peta]);
        
    }
}
