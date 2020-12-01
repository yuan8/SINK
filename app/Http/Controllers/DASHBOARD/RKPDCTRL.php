<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
use DB;
use HPV;
class RKPDCTRL extends Controller
{
    //


    public static function percertase_color($value){
        $color='black';
        $value=$value;
        if($value==0){
        $color='black';

        }else if( $value<=20){
                $color='red';
                # code...
                }
        else if( $value<=40){
            $color='orange';
            # code...
         }
         else if( $value<=60){
            $color='yellow';
            # code...
            }
         else if( $value<=80){
            $color='green';
            # code...
            }
         else if( $value<=1000){
            $color='#45ff23';
            # code...
            }
        return $color;
    }


    public function pelaporan($tahun,Request $request){
        $urusan=HPV::list_id_urusan();
        $req=$request;
        $req_urusan=null;
        if(!empty($request->urusan)){
            if(!empty($request->urusan[0])){
                 $urusan=$request->urusan;
                 $req_urusan=YDB::query("select * from public.master_urusan as u where u.id=".$request->urusan[0])->first();

            }else{
                $req->urusan=null;
            }   

        }else{
            $req->urusan=[];
        }

        $provinsi=null;
        $list_provinsi=DB::table('public.master_daerah')->where('kode_daerah_parent',null)->get();
        if($request->provinsi){
            $provinsi=DB::table('public.master_daerah')->where('id',$request->provinsi)->first();
        }

        $meta=[
            'PROVINSI'=>[
                'jumlah_pemda'=>0,
                'jumlah_pemda_melapor'=>0,
                'jumlah_pemda_final'=>0,
                'jumlah_pemda_belum_final'=>0,
                'jumlah_pemda_terpetakan'=>0,
                'jumlah_pemda_terpetakan_lengkap'=>0
            ],
            'KOTA'=>[
                'jumlah_pemda'=>0,
                'jumlah_pemda_melapor'=>0,
                'jumlah_pemda_final'=>0,
                'jumlah_pemda_belum_final'=>0,
                'jumlah_pemda_terpetakan'=>0,
                'jumlah_pemda_terpetakan_lengkap'=>0
            ],
        ];
        

        $list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();

        $list_urusan_filter=DB::table('public.master_urusan')->whereIn('id',$urusan)->get();

        $query="select
        count(distinct(case when (dt.pagu >0 and  dt.status > 0) then d.id else null end )) as exist_data,
        count(distinct(case when (dt.pagu >0 and  dt.status =5) then d.id else null end )) as exist_data_final,
        count(distinct(k.id_urusan)) as jumlah_urusan,
        string_agg(distinct(u.nama),'|') as list_nama_urusan,
        d.id ,
        min(dt.perkada) as perkada,
        min(dt.nomenklatur) as nomenklatur,
        min(dt.nomenklatur) as nomenklatur,
        min(d.nama) as name,
        max(dt.status) as status,
        max(dt.last_date) as last_date,
        max(dt.last_date) as last_date,
        sum(case when dt.status=5 then k.pagu else null end ) as pagu_pemetaan,
        max(dt.pagu) as pagu_pelaporan,
        max(st.pagu) as pagu_data,
        count(distinct(case when dt.status=5 then k.id else null end )) as jumlah_kegiatan,
        count(distinct(case when dt.status=5 then k.id_program else null end )) as jumlah_program,
        (case when length(d.id) < 3 then 'PROVINSI' else 'KOTA' end) as jenis_pemda
        from public.master_daerah as d
        left join rkpd.master_".$tahun."_status_data as dt on dt.kodepemda=d.id
        left join rkpd.master_".$tahun."_status as st on st.kodepemda=d.id
        left join rkpd.master_".$tahun."_kegiatan as k on (k.kodepemda=d.id and k.id_urusan in (".implode(',',$urusan).") )
        left join public.master_urusan as u on u.id=k.id_urusan
        ".($provinsi?"where left(d.id,2) = '".$provinsi->id."' ":'')."
        group by d.id
        order by d.id asc
        ";

        $data=YDB::query($query)->get();

        $data_map=[
            'KOTA'=>[],
            'PROVINSI'=>[]
        ];

        
        foreach ($data as $key => $d) {
            $data_cache=$d;
            if($provinsi){
                $d->jenis_pemda='KOTA';
            }

            if($d->exist_data){
                $meta[$d->jenis_pemda]['jumlah_pemda_melapor']+=1;
                $data_cache->text='TERDAPAT DATA RKPD';

                if($d->exist_data_final){
                    $meta[$d->jenis_pemda]['jumlah_pemda_final']+=1;
                    $data_cache->text='RKPD BERSATUS FINAL';
                 if($d->jumlah_urusan==count($urusan)){
                    $data_cache->value=100;
                    $meta[$d->jenis_pemda]['jumlah_pemda_terpetakan_lengkap']+=1;
                    $data_cache->text='RKPD TERPETAKAN '.count($urusan).' URUSAN LENGKAP';

                 }else if($d->jumlah_urusan>0){
                    $data_cache->value=80;
                    $meta[$d->jenis_pemda]['jumlah_pemda_terpetakan']+=1;
                    $data_cache->text='RKPD TERPETAKAN HANYA '.$data_cache->jumlah_urusan.' URUSAN';

                 }else{
                    $data_cache->value=60;
                    $data_cache->text.='<br> URUSAN BELUM TERPETAKAN ';


                 }

                }else{
                    $data_cache->value=20;
                    $meta[$d->jenis_pemda]['jumlah_pemda_belum_final']+=1;
                    $data_cache->text='RKPD BERSATUS '.HPV::status_rkpd($data_cache->status);



                }
            }else{
                $data_cache->value=0;
                $data_cache->text='TIDAK TERDAPAT DATA RKPD';

            }

            // if($d->list_nama_urusan==''){
            //     $data_cache->list_nama_urusan='|';
            // }

            $meta[$d->jenis_pemda]['jumlah_pemda']+=1;
            $data_cache->tooltip='<p><b>'.$data_cache->name.'</b></p><br>'.$data_cache->text;

            $data_cache->color=static::percertase_color($data_cache->value);
            $data_map[$d->jenis_pemda][]=$data_cache;
            $data[$key]=$data_cache;

        }

        $data_chart=[];

       

        return view('sinkronisasi.dashboard.rkpd.pelaporan')->with([
            'data'=>$data_map,
            'table'=>$data,
            'req'=>$req,
            'list_urusan'=>$list_urusan,
            'data_chart'=>$data_chart,
            'meta'=>$meta,
            'urusan'=>$list_urusan_filter,
            'provinsi'=>$provinsi,
            'list_provinsi'=>$list_provinsi,
            'req_urusan'=>$req_urusan
        ]);



    }

    public function index($tahun, Request $request){
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
            count(distinct(case when (k.kodepemda=d.id) then k.id else null end)) as jumlah_kegiatan,
            count(distinct(case when (k.kodepemda=d.id) then k.id_program else null end)) as jumlah_program,
             sum(distinct(case when (k.kodepemda=d.id) then k.pagu else 0 end)) as jumlah_pagu,
            count(distinct(k.kodepemda)) as jumlah_pemda_melapor,
            count(distinct(case when k.kodepemda=d.id then k.kodepemda else null end)) as provinsi_melapor
            from public.master_daerah as d
            left join rkpd.master_".$tahun."_kegiatan as k on (
            k.status=5 and k.id_urusan in (".implode(',', $urusan).") and left(k.kodepemda,2)=d.id)
            where d.kode_daerah_parent is null
            group by d.id,d.nama
            order by d.id asc";

            

        $data=YDB::query($query)->get();

    	$data_chart=['melapor'=>[],'tidak_melapor'=>[]];
    	foreach ($data as $key => $d) {
    		# code...
    		$data_chart['melapor'][]=[
    				'name'=>$d->name,
    				'y'=>$d->jumlah_pemda_melapor
    			];
    		$data_chart['tidak_melapor'][]=[
    				'name'=>$d->name,
    				'y'=>$d->jumlah_pemda-$d->jumlah_pemda_melapor
    		];
    			
    		$data[$key]->link=route('d.rkpd.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan]);
    		$data[$key]->value=(float)(($d->jumlah_pemda_melapor/$d->jumlah_pemda)*100);
    		$data[$key]->color=static::percertase_color($data[$key]->value);


    		$data[$key]->tooltip='<p><b>'.$d->name.' ('.($d->provinsi_melapor?'MELAPOR':'TIDAK MELAPOR').')</b></p><br><p>PERSENTASE PELAPORAN:'.number_format($data[$key]->value,2).'% ('.$d->jumlah_pemda_melapor.'/'.$d->jumlah_pemda.' PEMDA)</p>';

    	}



    	return view('sinkronisasi.dashboard.rkpd.index')->with(['data'=>$data,'data_chart'=>$data_chart,'list_urusan'=>$list_urusan,'req'=>$req]);
    }

    public function per_provinsi($tahun,$kodepemda,Request $request){
        $pemda=DB::table('public.master_daerah')->find($kodepemda);
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
            count(distinct(k.id )) as jumlah_kegiatan,
            sum((k.pagu )) as jumlah_pagu,
            count(distinct(k.id_program)) as jumlah_program
            from public.master_daerah as d
            left join rkpd.master_".$tahun."_kegiatan as k on (
            k.status=5 and k.id_urusan in (".implode(',', $urusan).") and (k.kodepemda)=d.id)
            where left(d.id,2)='".$kodepemda."'
            group by d.id,d.nama
            order by d.id asc";

            

        $data=YDB::query($query)->get();

        $data_chart=['melapor'=>[],'jumlah_program'=>[]];
        foreach ($data as $key => $d) {
            # code...
            $data_chart['jumlah_program'][]=[
                    'name'=>$d->name,
                    'y'=>(int)$d->jumlah_program
                ];
            $data_chart['jumlah_kegiatan'][]=[
                    'name'=>$d->name,
                    'y'=>(int)$d->jumlah_kegiatan
            ];
            
            $data[$key]->link=route('d.rkpd.per_provinsi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$d->id,'urusan'=>$req->urusan]);
            
            $data[$key]->color=static::percertase_color($d->jumlah_kegiatan?100:0);


            $data[$key]->tooltip='<p><b>'.$d->name.' ('.($d->jumlah_kegiatan?'MELAPOR':'TIDAK MELAPOR').')</b></p><br><p>JUMLAH PROGRAM : '.number_format($d->jumlah_program).' Program</p><br><p>JUMLAH KEGIATAN : '.number_format($d->jumlah_kegiatan).' Kegiatan </p>';

        }



        return view('sinkronisasi.dashboard.rkpd.pemda_per_provinsi')->with(['data'=>$data,'data_chart'=>$data_chart,'list_urusan'=>$list_urusan,'req'=>$req,'pemda'=>$pemda]);
    }


    public function detail($tahun,$kodepemda,Request $request){

        $urusan=HPV::list_id_urusan();
        $req=$request;

        if($request->urusan){
            $urusan=$request->urusan;

        }else{
            $req->urusan=[];
        }

        $list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();
    

        $data_k=DB::table("rkpd.master_".$tahun."_kegiatan as k")->whereRaw("k.id_urusan in (".implode(',',$urusan).")
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
             k.kodepemda='".$kodepemda."' and k.id_urusan in (".implode(',',$urusan).")  and k.id_program=".$p->id."
            ")->get();
            # code...
        }


        foreach ($data as $keyp => $p) {
            $px=DB::table("rkpd.master_".$tahun."_kegiatan as k")->whereRaw("k.id_urusan in (".implode(',',$urusan).")
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
                 k.kodepemda='".$kodepemda."' and k.id_urusan in (".implode(',',$urusan).") and i.id_kegiatan=".$k->id."
                ")->get();
                # code...
            }
        }
        $pemda=DB::table('public.master_daerah')->find($kodepemda);
        $GLOBALS['pemda_access']=$pemda;


        return view('sinkronisasi.dashboard.rkpd.rkpd')->with(['list_urusan'=>$list_urusan,'data'=>$data,'pemda'=>$pemda,'req'=>$req]);
    }
}
