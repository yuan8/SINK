<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use HPV;
use DB;

class KEBIJAKANCTRL extends Controller
{
    //
    public function implementasi_pemda($tahun,$id,Request $request){
      $mandat=YDB::query("
            select 
            (select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) as nama_sub_urusan,
            (select u.nama from public.master_urusan as u where u.id=mandat.id_urusan limit 1) 
            as nama_urusan,
            mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id=".$id." 
        ")->first();

      if($mandat){

        $mandat->uu=DB::select(DB::raw("
                select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$mandat->id." and jenis = 'UU'
                "));
        $mandat->pp=DB::select(DB::raw("
            select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$mandat->id." and jenis = 'PP'
            "));
        $mandat->perpres=DB::select(DB::raw("
            select * from sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$mandat->id." and jenis = 'PERPRES'
            "));
        $mandat->permen=DB::select(DB::raw("
            select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$mandat->id." and jenis = 'PERMEN'
        "));

       

        $query="select 
            (select count(distinct(dk.id)) from public.master_daerah as dk where left(dk.id,2)=d.id) as jumlah_pemda,
            d.id as id,
            d.nama as name,
            count(distinct(case when (left(k.kodepemda,2)=d.id and k.penilaian=1 ) then k.kodepemda else null end)) as jumlah_mandat_pemda_sesuai,
            count(distinct(case when (left(k.kodepemda,2)=d.id and k.penilaian in (0,2)) then k.kodepemda else null end)) as jumlah_mandat_pemda_tidak_sesuai,
            count(distinct(k.kodepemda)) as jumlah_pemda_implemented,
            count(distinct(case when k.kodepemda=d.id then k.kodepemda else null end)) as provinsi_implemented
            from public.master_daerah as d
            left join sink_form.td_".$tahun."_kb_penilaian as k on (
              left(k.kodepemda,2)=d.id  and k.id_mandat=".$id.")
            left join sink_form.t_".$tahun."_kb_mandat as m on (
             m.id=k.id_mandat)
            where 

            d.kode_daerah_parent is null
            group by d.id,d.nama
            order by d.id asc";

            $data=YDB::query($query)->get();
            $meta=[
                'jumlah_pemda_implemented_sesuai'=>0,
                'jumlah_pemda_implemented_tidak_sesuai'=>0,
                'jumlah_pemda_implemented'=>0,
                'jumlah_provinsi_implemented'=>0,
                'jumlah_pemda'=>0,
                'jumlah_pemda_provinsi'=>0


            ];

            $data_chart=['melapor'=>[],'tidak_melapor'=>[]];
            foreach ($data as $key => $d) {
                $meta['jumlah_pemda']+=$d->jumlah_pemda;
                $meta['jumlah_pemda_provinsi']+=1;


                $meta['jumlah_pemda_implemented']+=$d->jumlah_pemda_implemented;
                $meta['jumlah_pemda_implemented_tidak_sesuai']+=$d->jumlah_mandat_pemda_tidak_sesuai;
                $meta['jumlah_pemda_implemented_sesuai']+=$d->jumlah_mandat_pemda_sesuai;
                $meta['jumlah_provinsi_implemented']+=($d->provinsi_implemented?1:0);

                # code...
                $data_chart['sesuai'][]=[
                        'name'=>$d->name,
                        'y'=>$d->jumlah_mandat_pemda_sesuai
                    ];
                 $data_chart['tidak_sesuai'][]=[
                        'name'=>$d->name,
                        'y'=>($d->jumlah_mandat_pemda_tidak_sesuai)
                ];

            if($d->jumlah_mandat_pemda_sesuai){
                $data[$key]->value_sesuai=(float)(($d->jumlah_mandat_pemda_sesuai/$d->jumlah_pemda)*100);
            }else{
                 $data[$key]->value_sesuai=0;
            }
                    
            if($d->jumlah_pemda_implemented){
                $data[$key]->value=(float)(($d->jumlah_pemda_implemented/$d->jumlah_pemda)*100);

            }else{
                $data[$key]->value=0;
            }
                $data[$key]->color=HPV::percertase_color($data[$key]->value);
                 $data[$key]->color_sesuai=HPV::percertase_color($data[$key]->value_sesuai);
                $data[$key]->tooltip=view('sinkronisasi.dashboard.kebijakan.partial.mandat')->with('d',$data[$key])->render();

            }

            return view('sinkronisasi.dashboard.kebijakan.implement')->with([
                'data'=>$data,
                'data_chart'=>$data_chart,
                'mandat'=>$mandat,
                'req'=>$request,
                'meta'=>$meta
            ]);

      }else{
        return abort(404);
      }

    }

    public function index($tahun,Request $request){

    	$urusan=HPV::list_id_urusan();
    	$req=$request;
        if($request->urusan){
    		$urusan=$request->urusan;

    	}else{
            $req->urusan=[];
        }

    	$list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();
    

    	$query="select 
            
            (select count(distinct(dk.id)) from public.master_daerah as dk where left(dk.id,2)=d.id) as jumlah_pemda,
            d.id as id,
            d.nama as name,
            count(distinct(case when (k.kodepemda=d.id and m.jenis='REGULASI') then k.id else null end)) as jumlah_mandat_regulasi,

             count(distinct(case when (k.kodepemda=d.id and m.jenis='REGULASI' and k.penilaian=1) then k.id else null end)) as jumlah_mandat_regulasi_sesuai,

            count(distinct(case when (k.kodepemda=d.id and m.jenis='KEGIATAN') then k.id else null end)) as jumlah_mandat_kegiatan,
            count(distinct(case when (k.kodepemda=d.id and m.jenis='KEGIATAN' and k.penilaian=1) then k.id else null end)) as jumlah_mandat_kegiatan_sesuai,
            count(distinct(k.kodepemda)) as jumlah_pemda_implemented,
            count(distinct(case when k.kodepemda=d.id then k.kodepemda else null end)) as provinsi_implemented
            from public.master_daerah as d
            left join sink_form.td_".$tahun."_kb_penilaian as k on (
           	k.id_urusan in (".implode(',', $urusan).") and left(k.kodepemda,2)=d.id )

           	left join sink_form.t_".$tahun."_kb_mandat as m on (
           	k.id_urusan in (".implode(',', $urusan).") and m.id=k.id_mandat)

            where d.kode_daerah_parent is null
            group by d.id,d.nama
            order by d.id asc";

            $data=YDB::query($query)->get();

            $data_chart=['melapor'=>[],'tidak_melapor'=>[]];
	    	foreach ($data as $key => $d) {
	    		# code...
	    		$data_chart['melapor'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_pemda_implemented
	    			];
	    		$data_chart['tidak_melapor'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_pemda-$d->jumlah_pemda_implemented
	    		];
	    			
	    		$data[$key]->link=route('d.kebijakan.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan]);
	    		$data[$key]->value=(float)(($d->jumlah_pemda_implemented/$d->jumlah_pemda)*100);
	    		$data[$key]->color=HPV::percertase_color($data[$key]->value);

	    		$data[$key]->tooltip='';



	    	}


	    	return view('sinkronisasi.dashboard.kebijakan.index')->with(['data'=>$data,'data_chart'=>$data_chart,'list_urusan'=>$list_urusan,'req'=>$req]);



    }

    public function per_provinsi($tahun,$kodepemda,Request $request){

    	$urusan=HPV::list_id_urusan();
    	$req=$request;

        if($request->urusan){
    		$urusan=$request->urusan;

    	}else{
            $req->urusan=[];
        }

    	$list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();
    

    	$query="select 
            d.id as id,
            d.nama as name,
            count(distinct(case when (k.kodepemda=d.id and m.jenis='REGULASI' ) then k.id else null end)) as jumlah_mandat_regulasi,
            count(distinct(case when (k.kodepemda=d.id and m.jenis='REGULASI' and k.penilaian=1) then k.id else null end)) as jumlah_mandat_regulasi_sesuai,

            count(distinct(case when (k.kodepemda=d.id and m.jenis='KEGIATAN') then k.id else null end)) as jumlah_mandat_kegiatan,
            count(distinct(case when (k.kodepemda=d.id and m.jenis='KEGIATAN' and k.penilaian=1) then k.id else null end)) as jumlah_mandat_kegiatan_sesuai,
            count(distinct(case when (k.kodepemda=d.id and k.penilaian=1) then k.id else null end)) as jumlah_mandat_sesuai,

            count(distinct(k.id)) as jumlah_mandat_implemented,
            count(distinct(case when k.kodepemda=d.id then k.kodepemda else null end)) as pemda_implemented
            from public.master_daerah as d
            left join sink_form.td_".$tahun."_kb_penilaian as k on (
           	k.id_urusan in (".implode(',', $urusan).") and (k.kodepemda)=d.id )

           	left join sink_form.t_".$tahun."_kb_mandat as m on (
           	k.id_urusan in (".implode(',', $urusan).") and m.id=k.id_mandat)

            where left(d.id,2)='".$kodepemda."' 
            group by d.id,d.nama
            order by d.id asc";

            $data=YDB::query($query)->get();

            $data_chart=['regulasi'=>[],'kegiatan'=>[],'regulasi_sesuai'=>[],'kegiatan_sesuai'=>[]];
	    	foreach ($data as $key => $d) {
	    		# code...
	    		$data_chart['regulasi'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_mandat_regulasi
	    			];
	    		$data_chart['regulasi_sesuai'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_mandat_regulasi_sesuai
	    			];
	    		$data_chart['kegiatan'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_mandat_kegiatan
	    		];
	    		$data_chart['kegiatan_sesuai'][]=[
	    				'name'=>$d->name,
	    				'y'=>$d->jumlah_mandat_kegiatan_sesuai
	    		];
	    		
	    		$mandat=DB::table('sink_form.t_'.$tahun."_kb_mandat")->whereIn('id_urusan',$urusan)->selectRaw("count(id) as jumlah_mandat,
	    			count(case when jenis='REGULASI' then id else null end) jumlah_mandat_regulasi,
	    			count(case when jenis='KEGIATAN' then id else null end) jumlah_mandat_kegiatan
	    			")->first();

	    		$data[$key]->link=route('d.rkpd.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan]);
	    		if($mandat->jumlah_mandat and $d->jumlah_mandat_sesuai){
	    			$data[$key]->value=(float)((($d->jumlah_mandat_sesuai)/$mandat->jumlah_mandat)*100);
	    		}else{
	    			$data[$key]->value=0;
	    		}

                if($mandat->jumlah_mandat and $d->jumlah_mandat_implemented){
                    $data[$key]->implemented_count=(float)((($d->jumlah_mandat_implemented)/$mandat->jumlah_mandat)*100);
                }else{
                    $data[$key]->implemented_count=0;
                }
	    		$data[$key]->link=route('d.kebijakan.detail',['tahun'=>$tahun,'kodepemda'=>$kodepemda,'urusan'=>$urusan]);

	    		$data[$key]->color=HPV::percertase_color($data[$key]->value);
                $data[$key]->color_implemented=HPV::percertase_color($data[$key]->implemented_count);
	    		
                $data[$key]->tooltip=view('sinkronisasi.dashboard.kebijakan.partial.tooltip_pemda_persentase')->with(['mandat'=>$mandat,'d'=>$d])->render();




	    	}
        $pemda=DB::table('public.master_daerah')->find($kodepemda);



	    	return view('sinkronisasi.dashboard.kebijakan.per_provinsi')->with(['data'=>$data,'data_chart'=>$data_chart,'list_urusan'=>$list_urusan,'req'=>$req,'pemda'=>$pemda]);



    }

    public function detail($tahun,$kodepemda,Request $request){
    	$urusan=HPV::list_id_urusan();
    	$mandat=[];
    	$req=$request;

        if($request->urusan){
    		$urusan=$request->urusan;

    	}else{
            $req->urusan=[];
        }

    	$list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();


    	$data=DB::select(DB::raw("
    		select 
    		(select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) as nama_sub_urusan,
    		(select u.nama from public.master_urusan as u where u.id=mandat.id_urusan limit 1) 
    		as nama_urusan,
    		mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id_urusan in (".implode(',',$urusan).") and jenis='REGULASI'
    		order by mandat.id_urusan asc, mandat.id_sub_urusan asc , mandat.id desc
    	"));

    	foreach ($data as $key => $d) {
    		

    		$data[$key]->penilaian=YDB::query("
    			select * from  sink_form.td_".$tahun."_kb_penilaian as p where p.id_mandat=".$d->id." and p.kodepemda = '".$kodepemda."'  and p.id_urusan in (".implode(',',$urusan).") limit 1
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

        $pemda=DB::table('public.master_daerah')->find($kodepemda);

        $RE=['data'=>$data,'pemda'=>$pemda,'list_urusan'=>$list_urusan,'req'=>$req];
               
        

    	return view('sinkronisasi.dashboard.kebijakan.detail')->with($RE);
    }

    public function pusat($tahun,Request $request){
    	$urusan=HPV::list_id_urusan();
    	$mandat=[];
    	$req=$request;

        if($request->urusan){
    		$urusan=$request->urusan;

    	}else{
            $req->urusan=[];
        }

    	$list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();


    	$data=DB::select(DB::raw("
    		select 
    		(select su.nama from public.master_sub_urusan as su where su.id=mandat.id_sub_urusan limit 1) 
    		as nama_sub_urusan,
    		(select u.nama from public.master_urusan as u where u.id=mandat.id_urusan limit 1) 
    		as nama_urusan,
    		mandat.* from sink_form.t_".$tahun."_kb_mandat as mandat
            where mandat.id_urusan in (".implode(',', $urusan).")
    		order by mandat.id_urusan asc,mandat.id_sub_urusan asc , mandat.id desc
    	"));

    	$data_chart=['uu'=>[],'pp'=>[],'permen'=>[],'perpres'=>[]];

    	foreach ($data as $key => $d) {
    		
    		$data[$key]->uu=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'UU'
    			"));
    		$data_chart['uu'][]=[
    			'y'=>count($data[$key]->uu),
    			'name'=>$d->uraian,
                'link'=>route('d.kebijakan.implementasi_pemda',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data[$key]->id])

    		];
    		$data[$key]->pp=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PP'
    			"));
    		$data_chart['pp'][]=[
    			'y'=>count($data[$key]->pp),
    			'name'=>$d->uraian,
                'link'=>route('d.kebijakan.implementasi_pemda',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data[$key]->id])

    		];
    		$data[$key]->perpres=DB::select(DB::raw("
    			select * from sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERPRES'
    			"));
    		$data_chart['perpres'][]=[
    			'y'=>count($data[$key]->perpres),
    			'name'=>$d->uraian,
                'link'=>route('d.kebijakan.implementasi_pemda',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data[$key]->id])

    		];
    		$data[$key]->permen=DB::select(DB::raw("
    			select * from  sink_form.t_".$tahun."_kb as kb where kb.id_mandat=".$d->id." and jenis = 'PERMEN'
    		"));

    		$data_chart['permen'][]=[
    			'y'=>count($data[$key]->permen),
    			'name'=>$d->uraian,
                'link'=>route('d.kebijakan.implementasi_pemda',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data[$key]->id])

    		];




    		$data[$key]->child_count=max(count($data[$key]->uu),count($data[$key]->pp),count($data[$key]->perpres),count($data[$key]->permen));
    	}


    	return view('sinkronisasi.dashboard.kebijakan.pusat')->with(['data'=>$data,'list_urusan'=>$list_urusan,'req'=>$req,'data_chart'=>$data_chart]);

    }
}
