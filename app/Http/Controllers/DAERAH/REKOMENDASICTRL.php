<?php

namespace App\Http\Controllers\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
class REKOMENDASICTRL extends Controller
{
    //

   //
    static function nested_permasalahan($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'MASALAH POKOK'
            ];

            if(!empty($jenis)){
                switch ($jenis['jenis']) {
                case 'MASALAH POKOK':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'MASALAH'
                    ];
                # code...
                break;
                case 'MASALAH':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'AKAR MASALAH'
                    ];
                    # code...
                    break;
                 case 'AKAR MASALAH':
                    $data=[
                        'parent'=>$jenis['id'],
                        'child_context'=>'DATA DUKUNG'
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

        static function nested_rkpd($jenis=[]){
            $jenis=(array)$jenis;
            $data=[
                'parent'=>null,
                'child_context'=>'PROGRAM',
                'context'=>'PROGRAM',

                'kode'=>'',
                'id_ms'=>isset($jenis['id_ms'])?$jenis['id_ms']:null
            ];

            if(isset($jenis['jenis'])){
                switch ($jenis['jenis']) {
                case 'PROGRAM':
                    $data=[
                        'parent'=>$jenis['id_bridge'],
                        'child_context'=>'KEGIATAN',
                        'ms'=>'MASALAH POKOK',
                        'kode'=>$jenis['kode'],
                        'nm'=>'PROGRAM'
                    ];
                # code...
                break;
                case 'KEGIATAN':
                    $data=[
                        'parent'=>$jenis['id_bridge'],
                        'child_context'=>'SUB KEGIATAN',
                        'kode'=>$jenis['kode'],
                        'ms'=>'MASALAH',
                        'nm'=>'KEGIATAN'

                    ];
                    # code...
                    break;
                 case 'SUB KEGIATAN':
                    $data=[
                        'parent'=>$jenis['id_bridge'],
                        'child_context'=>'',
                        'kode'=>$jenis['kode'],
                        'ms'=>'AKAR MASALAH',
                        'nm'=>'SUB KEGIATAN'
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


    public function form_hapus($tahun,$kodepemda,$context,$id,Request $request){
        $data=(array)YDB::query("
            select 
            nomen.*,rk.id_ms, rk.id as id_bridge, rk.keterangan, rk.pagu from sink_form.td_".$tahun."_rekomendasi as rk 
            join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
            where rk.kodepemda='".$kodepemda."' 
            and rk.id_urusan=".session('main_urusan')->id."
            and rk.id=".$id)->first();

        if($data){
            $parent=static::nested_rkpd($data);
            return view('sinkronisasi.daerah.rekomendasi.partial.form_hapus')->with([
                'data'=>$data,
                'item'=>$parent
            ]);
        }
    }

    public function hapus($tahun,$kodepemda,$context,$id,Request $request){
        $data=(array)YDB::query("
            select 
            rk.* from sink_form.td_".$tahun."_rekomendasi as rk 
            where rk.kodepemda='".$kodepemda."' 
            and rk.id_urusan=".session('main_urusan')->id."
            and rk.id=".$id)->first();

        if($data){
            DB::table("td_".$tahun."_rekomendasi as rk")->where('id',$id)->delete();
        }

        return back();
    }


    public function update($tahun,$kodepemda,$context,$id,Request $request){
        $clean_ms=false;

    	$data=(array)YDB::query("
    		select (select prk.id_ms from sink_form.td_".$tahun."_rekomendasi as prk where prk.id=rk.id_parent ) as id_ms_parent, nomen.*,rk.id_ms, rk.id as id_bridge, rk.keterangan, rk.pagu from sink_form.td_".$tahun."_rekomendasi as rk 
    		join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
    		where rk.kodepemda='".$kodepemda."' 
    		and rk.id_urusan=".session('main_urusan')->id."
    		and rk.id=".$id)->first();
    	if($data){
    		$data_up=[

    			'keterangan'=>$request->keterangan,
    		];

    		if($request->pagu){
    			$data_up['pagu']=$request->pagu;
    		}

    		if($request->ms){
    			$data_up['id_ms']=$request->ms;
                if(($request->id_ms!=$data['id_ms']) and ($data['id_ms']!=null)){
                    $clean_ms=[
                        'id_rekom'=>$data['id'],
                        'id_ms'=>$data['id_bridge'],

                    ];
                }
    		}

    		DB::table("sink_form.td_".$tahun."_rekomendasi")->where('id',$data['id_bridge'])
    		->update($data_up);

            if($clean_ms){
                $id_akar=DB::table("sink_form.td_".$tahun."_permasalahan")->where('id_parent',$clean_ms['id_ms'])
                ->get()->pluck('id');

                DB::table("sink_form.td_".$tahun."_rekomendasi")
                ->where('id_parent',$clean_ms['id_rekom'])
                ->whereIn('id_ms',$id_akar)
                ->update([
                    'id_ms'=>null

                ]);

            }

    	}

    	return back();
    }

    public function edit($tahun,$kodepemda,$context,$id){
    	$data=(array)YDB::query("
    		select (select prk.id_ms from sink_form.td_".$tahun."_rekomendasi as prk where prk.id=rk.id_parent ) as id_ms_parent, nomen.*,rk.id_ms, rk.id as id_bridge, rk.keterangan, rk.pagu from sink_form.td_".$tahun."_rekomendasi as rk 
    		join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
    		where rk.kodepemda='".$kodepemda."' 
    		and rk.id_urusan=".session('main_urusan')->id."
    		and rk.id=".$id)->first();
    	if($data){
    		$parent=static::nested_rkpd($data);
    		if($data['jenis']!='PROGRAM'){
    			$ms=YDB::query("select * from sink_form.td_".$tahun."_permasalahan as ms where 
    			ms.kodepemda='".$kodepemda."'
    			and ms.id_urusan=".session('main_urusan')->id." 
    			and ms.jenis='".$parent['ms']."'
    			".($data['id_ms_parent']?" and ms.id_parent=".$data['id_ms_parent']:'')."
    			")->get();
    			
    		}else{
    			$ms=[];
    		}
    		

    		return view('sinkronisasi.daerah.rekomendasi.nomenklatur.form_edit')->with([
    			'data_ms'=>$ms,
    			'data'=>$data,
    			'parent'=>$parent
    		]);
    	}
    }

    public function index($tahun,$kodepemda,$context){
    	$data=YDB::query("select *,(select nama from public.master_sub_urusan as su where su.id = ms.id_sub_urusan limit 1 ) as nama_sub_urusan from sink_form.td_".$tahun."_permasalahan as ms where jenis ='MASALAH POKOK' and kodepemda='".$kodepemda."' and id_urusan=".session('main_urusan')->id." order by ms.id desc")->get();
    	foreach ($data as $key => $msp) {
    		$data[$key]->nomenklatur=YDB::query("select 
    			rk.pagu,
    			rk.id as id_bridge,
    			rk.id_ms as id_ms_bridge,
    			rk.keterangan,
    			nomen.*,
    			(select sum(pagu) from sink_form.td_".$tahun."_rekomendasi as rkpagu where rkpagu.id_parent = rk.id) as pagu_cal
    			from sink_form.td_".$tahun."_rekomendasi as rk
    			join sink_form.t_".$tahun."_nomenklatur as nomen on (nomen.id=rk.id_nomenklatur and nomen.jenis='PROGRAM')
    			where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_ms=".$msp->id." order by rk.id desc")->get();

			foreach ($data[$key]->nomenklatur  as $keyP => $p) {
    			$data[$key]->nomenklatur[$keyP]->indikator=YDB::query("select 
    			rk.pagu,
    			rk.id as id_bridge,
    			rk.id_rekomendasi as id_parent_bridge,
    			rk.keterangan,
    			i.id as id,
    			i.positiv_value,
    			i.tolokukur,
    			i.satuan,
    			i.jenis,
    			rk.target,
    			rk.target_2,

    			i.target as target_pusat,
    			i.target_2 as target_pusat_2,

    			(select string_agg(concat('<b> RKP ',rkp.jenis,' : </b> ',rkp.uraian),'||') from sink_form.t_".$tahun."_indikator_rkp_bridge as bg 
    				join sink_form.t_".$tahun."_rkp as rkp on bg.id_indikator = i.id and rkp.id=bg.id_rkp
    			 ) as dukungan_rkp,
                 (select string_agg(concat('<b>',ps.jenis,'(',ps.jenis_data,')',' : </b> ',ps.uraian),'||') from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bgps 
                                join sink_form.t_".$tahun."_dukungan_pusat as ps on (bgps.id_indikator = i.id and ps.id=bgps.id_dukungan_pusat)
                             ) as dukungan_pusat_lainya,
    			(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,

    			(select uraian from sink_form.t_".$tahun."_sumber_data as sd  where sd.id=i.id_sumber) as sumber_data 
    			from sink_form.td_".$tahun."_rekomendasi_indikator as rk
    			join sink_form.t_".$tahun."_indikator as i on i.id=rk.id_indikator
    			where rk.kodepemda='".$kodepemda."'  and rk.id_rekomendasi=".$p->id_bridge." order by rk.id desc")->get();
    		}

    		foreach ($data[$key]->nomenklatur as $keyP => $p) {

    		$data[$key]->nomenklatur[$keyP]->kegiatan=YDB::query("select 
    			rk.pagu,
    			rk.id as id_bridge,
    			rk.id_parent as id_parent_bridge,
    			rk.id_ms as id_ms_bridge,
    			rk.keterangan,
    			ms.id as id_ms,
    			ms.kategori as ms_kategori,
    			ms.jenis as ms_jenis,
    			ms.uraian as ms_uraian,
    			nomen.*
    			from sink_form.td_".$tahun."_rekomendasi as rk
    			
    			join sink_form.t_".$tahun."_nomenklatur as nomen on (nomen.id=rk.id_nomenklatur and nomen.jenis='KEGIATAN')
                left join td_".$tahun."_permasalahan as ms on (ms.id = rk.id_ms and ms.id_parent=".($p->id_ms_bridge??0)." and ms.jenis='MASALAH')
    			where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_parent=".($p->id_bridge??0)." order by rk.id desc")->get();


			foreach ($data[$key]->nomenklatur[$keyP]->kegiatan  as $keyK => $k) {
    			$data[$key]->nomenklatur[$keyP]->kegiatan[$keyK]->indikator=YDB::query("select 
    			rk.pagu,
    			rk.id as id_bridge,
    			rk.id_rekomendasi as id_parent_bridge,
    			rk.keterangan,
    			i.id as id,
    			i.positiv_value,
    			i.tolokukur,
    			i.satuan,
    			i.jenis,
    			rk.target,
    			rk.target_2,
    			i.target as target_pusat,
    			i.target_2 as target_pusat_2,
    			(select string_agg(concat('<b> RKP ',rkp.jenis,' : </b> ',rkp.uraian),'||') from sink_form.t_".$tahun."_indikator_rkp_bridge as bg 
    				join sink_form.t_".$tahun."_rkp as rkp on bg.id_indikator = i.id and rkp.id=bg.id_rkp
    			 ) as dukungan_rkp,
                (select string_agg(concat('<b>',ps.jenis,'(',ps.jenis_data,')',' : </b> ',ps.uraian),'||') from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bgps 
                    join sink_form.t_".$tahun."_dukungan_pusat as ps on (bgps.id_indikator = i.id and ps.id=bgps.id_dukungan_pusat)
                 ) as dukungan_pusat_lainya,
    			(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,
    			(select uraian from sink_form.t_".$tahun."_sumber_data as sd  where sd.id=i.id_sumber) as sumber_data 
    			from sink_form.td_".$tahun."_rekomendasi_indikator as rk
    			join sink_form.t_".$tahun."_indikator as i on i.id=rk.id_indikator
    			where rk.kodepemda='".$kodepemda."'  and rk.id_rekomendasi=".$k->id_bridge." order by rk.id desc")->get();
    		}



	    		foreach ($data[$key]->nomenklatur[$keyP]->kegiatan as $keyK => $sk) {
		    		$data[$key]->nomenklatur[$keyP]->kegiatan[$keyK]->subkegiatan=YDB::query("select 
		    			rk.pagu,
		    			rk.id as id_bridge,
		    			rk.id_parent as id_parent_bridge,
		    			rk.id_ms as id_ms_bridge,
		    			rk.keterangan,
		    			ms.id as id_ms,
		    			ms.kategori as ms_kategori,
		    			ms.jenis as ms_jenis,
		    			ms.uraian as ms_uraian,
		    			nomen.*
		    			from sink_form.td_".$tahun."_rekomendasi as rk
		    			left join td_".$tahun."_permasalahan as ms on ms.id = rk.id_ms and ms.id_parent=".($k->id_ms??0)." and ms.jenis='AKAR MASALAH'
		    			join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur and nomen.jenis='SUB KEGIATAN'
		    			where rk.kodepemda='".$kodepemda."' and rk.id_urusan=".session('main_urusan')->id." and rk.id_parent=".$sk->id_bridge." order by rk.id desc")->get();

		    			foreach ($data[$key]->nomenklatur[$keyP]->kegiatan[$keyK]->subkegiatan  as $keySU => $su) {
			    			$data[$key]->nomenklatur[$keyP]->kegiatan[$keyK]->subkegiatan[$keySU]->indikator=YDB::query("select 
			    			rk.pagu,
			    			rk.id as id_bridge,
			    			rk.id_rekomendasi as id_parent_bridge,
			    			rk.keterangan,
			    			i.id as id,
			    			i.positiv_value,
			    			i.tolokukur,
			    			i.satuan,
			    			i.jenis,
			    			rk.target,
			    			rk.target_2,
			    			i.target as target_pusat,
			    			i.target_2 as target_pusat_2,
			    			(select string_agg(concat('<b> RKP ',rkp.jenis,' : </b> ',rkp.uraian),'||') from sink_form.t_".$tahun."_indikator_rkp_bridge as bg 
			    				join sink_form.t_".$tahun."_rkp as rkp on bg.id_indikator = i.id and rkp.id=bg.id_rkp
			    			 ) as dukungan_rkp,
                            (select string_agg(concat('<b>',ps.jenis,'(',ps.jenis_data,')',' : </b> ',ps.uraian),'||') from sink_form.t_".$tahun."_dukungan_pusat_indikator_bridge as bgps 
                                join sink_form.t_".$tahun."_dukungan_pusat as ps on (bgps.id_indikator = i.id and ps.id=bgps.id_dukungan_pusat)
                             ) as dukungan_pusat_lainya,
			    			(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,
			    			(select uraian from sink_form.t_".$tahun."_sumber_data as sd  where sd.id=i.id_sumber) as sumber_data 
			    			from sink_form.td_".$tahun."_rekomendasi_indikator as rk
			    			join sink_form.t_".$tahun."_indikator as i on i.id=rk.id_indikator
			    			where rk.kodepemda='".$kodepemda."'  and rk.id_rekomendasi=".$su->id_bridge." order by rk.id desc")->get();
			    		}
	    		}

    		}
    	}

    	return view('sinkronisasi.daerah.rekomendasi.index')->with(['data'=>$data]);
    }


    public function nomen_list_chose($tahun,$kodepemda,$context,$id=null,Request $request){
    	$data=[];
    	if($request->id_ms){
    		$data['id_ms']=$request->id_ms;

    	}
    	if($id){
    		$data=(array)YDB::query("
    		select nomen.*, rk.id as id_bridge from sink_form.td_".$tahun."_rekomendasi as rk 
    		join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
    		where rk.kodepemda='".$kodepemda."' 
    		and rk.id_urusan=".session('main_urusan')->id."
    		and rk.id=".$id)->first();

    		$parent=static::nested_rkpd($data);
    	}else{
    		$parent=static::nested_rkpd($data);

    	}

    	$nomen=YDB::query("select * from sink_form.t_".$tahun."_nomenklatur where 
    		jenis='".$parent['child_context']."'
    		and id_urusan=".session('main_urusan')->id."
    		and provinsi is ".(((int)$kodepemda<100)?'true':'false')." and kode ilike '".$parent['kode']."%'
    		")->get();




    	return view('sinkronisasi.daerah.rekomendasi.nomenklatur.list_chose')->with(['data'=>$nomen,'parent'=>$parent]);
    		
    }

    public function ind_store($tahun,$kodepemda,$context,$id,Request $request){
    	if($id){
    		$data=(array)YDB::query("
    		select nomen.*, rk.id as id_bridge from sink_form.td_".$tahun."_rekomendasi as rk 
    		join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
    		where rk.kodepemda='".$kodepemda."' 
    		and rk.id_urusan=".session('main_urusan')->id."
    		and rk.id=".$id)->first();

    		if($data){
    			foreach ($request->indikator as $key => $d) {

    				DB::table('sink_form.td_'.$tahun.'_rekomendasi_indikator as i')->insertOrIgnore(
    					[
    						'kodepemda'=>$kodepemda,
    						'tahun'=>$tahun,
    						'id_rekomendasi'=>$id,
    						'id_indikator'=>$d,
    						'keterangan'=>$request->keterangan,
    						'target'=>$request->target,
    						'target_2'=>$request->target_2
    					]
    				);
    				# code...
    			}
    		}

    		return back();


    	}
    }

    public function indikator_list_chose($tahun,$kodepemda,$context,$id,Request $request){


    	$data=[];
    	$tipe=['OUTPUT'];
    	if($request->tipe){
    		$tipe=$request->tipe;

    	}
    	if($id){
    		$p=(array)YDB::query("
    		select nomen.*, rk.id as id_bridge from sink_form.td_".$tahun."_rekomendasi as rk 
    		join sink_form.t_".$tahun."_nomenklatur as nomen on nomen.id=rk.id_nomenklatur 
    		where rk.kodepemda='".$kodepemda."' 
    		and rk.id_urusan=".session('main_urusan')->id."
    		and rk.id=".$id)->first();


    		if($p){
    			$data=DB::table("t_".$tahun."_indikator as i")->where(
    				[
    					'id_urusan'=>session('main_urusan')->id,
    				]
    			)->whereIn('jenis',$tipe)
    			->selectRaw("
    				i.*,
    				(select nama from public.master_sub_urusan  as  su where su.id = i.id_sub_urusan) as nama_sub_urusan,
    				(select uraian from sink_form.t_".$tahun."_sumber_data as sd  where sd.id=i.id_sumber) as sumber_data 
    				")
    			->get();

    			return view('sinkronisasi.daerah.rekomendasi.nomenklatur.ind_list')->with(['data'=>$data,'parent'=>$p]);
    		}else{
    			return 'DATA TIDAK TERSEDIA';
    		}
    	}

    	

    	

    	
    		
    }


    public function store_rekomendasi($tahun,$kodepemda,$context,$id=null,Request $request){

    		if($request->nomenklatur){
    				foreach ($request->nomenklatur as $key => $d) {

    					DB::table('sink_form.td_'.$tahun.'_rekomendasi')->insert(
    						[
    							'id_nomenklatur'=>$d,
    							'id_ms'=>(isset($request->id_ms)?$request->id_ms:null),
    							'id_parent'=>$request->parent,
    							'kodepemda'=>$kodepemda,
    							'tahun'=>$tahun,
    							'kode'=>$tahun.'.'.$kodepemda.'.'.session('main_urusan')->id.'.'.$key.'|('.rand(date('i'),10000).')',
    							'keterangan'=>$request->keterangan,
    							'id_urusan'=>session('main_urusan')->id
    						]
    					);
    				}
    		}

    		return back();
    	

    }

     public function permasalahan_list_chose($tahun,$kodepemda,$context,$id=null){
     	$perma=[];

     	if($id){
     		$perma=DB::table('sink_form.td_'.$tahun.'_permasalahan')->where(['kodepemda'=>$kodepemda,'jenis'=>'MASALAH POKOK','id'=>$id,'id_urusan'=>session('main_urusan')->id])->first();
     		if($perma){
     			$perma->masalah=YDB::query("select *,(select nama from public.master_sub_urusan as su where su.id = ms.id_sub_urusan limit 1 ) as nama_sub_urusan from sink_form.td_".$tahun."_permasalahan as ms where jenis ='MASALAH' and kodepemda='".$kodepemda."' and id_urusan=".session('main_urusan')->id." and id_parent=".$perma->id)->get();

     			foreach ($perma->masalah as $key => $m) {
     				# code...
     					$perma->masalah[$key]->data_dukung=YDB::query("select *,(select nama from public.master_sub_urusan as su where su.id = ms.id_sub_urusan limit 1 ) as nama_sub_urusan from sink_form.td_".$tahun."_permasalahan as ms where jenis ='DATA' and kodepemda='".$kodepemda."' and id_urusan=".session('main_urusan')->id." and id_parent=".$perma->id)->get();
     			}
     		}


     	}

     	

		return view('sinkronisasi.daerah.rekomendasi.permasalahan.list_chose')->with(['data'=>$perma]);
    }
}
