<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
class SDGSCTRL extends Controller
{
    //


	static function nested($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'TUJUAN GLOBAL'
            ];

            if(!empty($jenis)){

                switch ($jenis['jenis']) {
                 case 'TUJUAN GLOBAL':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'SASARAN GLOBAL'
                    ];
                # code...
                break;
                case 'SASARAN GLOBAL':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'SASARAN NASIONAL'
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
    	$data=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SDGS'
    		and jenis='TUJUAN GLOBAL'
    	")->get();

    	foreach ($data as $key => $t) {
    		$data[$key]->child=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
	    		jenis_data='SDGS'
	    		and jenis='SASARAN GLOBAL'
	    		and id_parent=".$t->id."
	    	")->get();

	    	foreach ($data[$key]->child as $keys => $s) {
	    		$data[$key]->child[$keys]->child=YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
		    		jenis_data='SDGS'
		    		and jenis='SASARAN NASIONAL'
		    		and id_parent=".$s->id."
		    	")->get();

		    	// foreach ($data[$key]->child[$keys]->child as $keyn => $n) {
		    	// 	$data[$key]->child[$keys]->child[$keyn]->indikator=YDB::query("select (select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,*,(select uraian from sink_form.t_".$tahun."_sumber_data  as  sd where sd.id = i.id_sumber) as sumber_data ,bridge.id as id_bridge from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bridge 
		    	// 		join t_".$tahun."_indikator as i on i.id=bridge.id_indikator
		    	// 		where
			    // 		id_dukungan_pusat=".$n->id."
			    // 	")->get();
		    	// }
	    	}
    	}


    	return view('sinkronisasi.admin.sdgs.index')->with(['data'=>$data]);
    }

    public function add($tahun,$id=null){
    	$data=[];
    	$approve=false;

    	if($id){
    		$data=(array)YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SDGS'
    		and id=".$id)->first();
    		if($data){
    			$approve=true;
    		}
    	}else{
    		$approve=true;
    	}
    	$parent=static::nested($data);
    	if($approve){
    		return view('sinkronisasi.admin.sdgs.partial.form_add')->with(['parent'=>$parent]);
    	}

    }

    public function store($tahun,$id=null,Request $request){
    	$data=[];
    	$approve=false;

    	if($id){
    		$data=(array)YDB::query("select * from sink_form.t_".$tahun."_dukungan_pusat where
    		jenis_data='SDGS'
    		and id=".$id)->first();
    		if($data){
    			$approve=true;
    		}
    	}else{
    		$approve=true;
    	}
    	$parent=static::nested($data);
    	if($approve){
    		DB::table("sink_form.t_".$tahun."_dukungan_pusat")
    		->insert([
    			'uraian'=>$request->uraian,
    			'jenis'=>$parent['child_context'],
    			'jenis_data'=>'SDGS',
    			'tahun'=>$tahun,
    			'id_parent'=>$request->parent,
    			'pelaksana'=>$request->pelaksana
    		]);

    		return back();
    	}
    }
}
