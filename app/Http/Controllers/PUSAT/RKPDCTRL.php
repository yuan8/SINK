<?php

namespace App\Http\Controllers\PUSAT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use YDB;
class RKPDCTRL extends Controller
{
    //
    public function index($tahun){
    	$data=YDB::query("
    	select 
    	count(k.id) as jumlah_kegiatan,
    	count(distinct(k.id_program)) as jumlah_program,
    	d.id as kodepemda,
    	(case when (length(d.id)<3) then min(d.nama) else (select concat(min(d.nama),' - ',p.nama) from public.master_daerah as p where p.id=left(d.id,2)) end) as nama_pemda
    	from public.master_daerah as d 
    	left join rkpd.master_".$tahun."_kegiatan as k on (k.kodepemda=d.id and k.id_urusan=".session('main_urusan')->id." and k.status=5)
    	group by d.id
    	order by d.id asc
    	")->get();

    	return view('sinkronisasi.pusat.rkpd.index')->with('data',$data);
    	
    }

    public function rekomendasi($tahun){
    	$data=YDB::query("
    	select 
    	sum(case when k.jenis like 'KEGIATAN%' then 1 else 0 end) as jumlah_kegiatan,
    	sum(case when k.jenis like 'PROGRAM%' then 1 else 0 end) as jumlah_program,
    	d.id as kodepemda,
    	sum(k.j_ms) as jumlah_masalah,
    	(case when (length(d.id)<3) then min(d.nama) else (select concat(min(d.nama),' - ',p.nama) from public.master_daerah as p where p.id=left(d.id,2)) end) as nama_pemda
    	from public.master_daerah as d 
    	left join (
    	select concat(nm.jenis,nm.kode) as jenis ,rk.kodepemda,count(distinct(rk.id_ms)) as j_ms  from sink_form.td_".$tahun."_rekomendasi as rk 
    	join sink_form.t_".$tahun."_nomenklatur as nm on nm.id=rk.id_nomenklatur 
    	where  ( rk.id_urusan=".session('main_urusan')->id.")
    	group by rk.kodepemda, nm.kode,nm.jenis
    	) as k on k.kodepemda = d.id
    	group by d.id
    	order by d.id asc
    	")->get();

    	return view('sinkronisasi.pusat.rkpd.rekomendasi')->with('data',$data);
    	
    }
}
