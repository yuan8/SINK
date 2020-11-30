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
        if($request->urusan){
            $urusan=$request->urusan;

        }else{
            $req->urusan=[];
        }

        $list_urusan=DB::table('public.master_urusan')->whereIn('id',HPV::list_id_urusan())->get();
        $data=YDB::query("select
            data.jumlah_urusan as jumlah_urusan,
            (case when length(d.id) < 3 then 'PROVINSI' else 'KOTA' end) as jenis_pemda,
            left(d.id,2) as kode_provinsi,
             data.jumlah_program,data.jumlah_kegiatan, (dt.id) as exist,st.pagu as pagu_laporan, dt.last_date,st.nomenklatur,st.method, d.nama as nama_pemda,d.id as kodepemda,dt.pagu,st.tipe_pengambilan, dt.matches,dt.status,st.perkada from
            public.master_daerah as d  
            left join rkpd.master_".$tahun."_status_data as dt on d.id = dt.kodepemda 
            left join rkpd.master_".$tahun."_status as st on st.kodepemda=dt.kodepemda
            left join ((select count(distinct(k.id_urusan)) as jumlah_urusan, k.kodepemda,count(distinct(k.id)) as jumlah_kegiatan, count(distinct(k.id_program)) jumlah_program  from  rkpd.master_".$tahun."_kegiatan as k where  k.id_urusan in (".implode(',',$urusan).") group by k.kodepemda )  ) as data on data.kodepemda = d.id order by d.id asc
        ")->get();
        $data_chart=['jumlah_program'=>[],'jumlah_kegiatan'=>[]];

        foreach ($data as $key => $value) {
            $data_chart['jumlah_kegiatan'][]=[
                'name'=>$value->nama_pemda,
                'y'=>$value->jumlah_kegiatan,
                'satuan'=>'KEGIATAN'
            ];

         $data_chart['jumlah_program'][]=[
                'name'=>$value->nama_pemda,
                'y'=>$value->jumlah_program,
                'satuan'=>'PROGRAM'

            ];
            if($value->jumlah_urusan){
                $data[$key]->value=($value->jumlah_urusan/7)*100;

            }else{
                $data[$key]->value=0;
            }

            $data[$key]->name=$value->nama_pemda;
            $data[$key]->id=$value->kodepemda;
             $data[$key]->link=route('d.rkpd.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$value->kodepemda,'urusan'=>$req->urusan]);
             
            $data[$key]->color=static::percertase_color($data[$key]->value);

            $data[$key]->tooltip='<p><b>'.$value->nama_pemda."</b></p><br><p>JUMLAH URUSAN :".$value->jumlah_urusan.'/7</p><br><p>JUMLAH PROGRAM :'.number_format($value->jumlah_program)."</p><br><p>JUMLAH KEGIATAN :".number_format($value->jumlah_kegiatan).'</p>';

        }

        return view('sinkronisasi.dashboard.rkpd.pelaporan')->with([
            'data'=>$data,
            'req'=>$req,
            'list_urusan'=>$list_urusan,
            'data_chart'=>$data_chart
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
